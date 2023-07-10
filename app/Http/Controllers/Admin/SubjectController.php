<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

use App\Course;
use App\TestSeriesType;
use App\Group;
use App\Subject;
use App\VendorSubject;

use Auth;
use Config;

class SubjectController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
	/**
     * All Subjects.
     *
     * @return \Illuminate\Http\Response
     */
	public function index(Request $request)
	{
		//check authorization start	
			$check = $this->checkAuthorizationAction('Subject', $request->route()->getActionMethod(), Auth::user()->role);
			if($check)
			{
				return Redirect::to('/admin/dashboard')->with('error',config('constants.unauthorized'));
			}	
		//check authorization end
		
		$query 		= Subject::where('id', '!=', '')->with('course', 'test_series_type', 'group');
		
		$totalData 	= $query->count();	//for all data
		
		//searching start	
			if ($request->has('search_term')) 
			{
				$search_term 		= 	$request->input('search_term');
				if(trim($search_term) != '')	
				{
					$query->where('subject_name', 'LIKE', '%' . $search_term . '%');
				}
			}
			if ($request->has('search_term_course')) 
			{
				$search_term_course 		= 	$request->input('search_term_course');
				if(trim($search_term_course) != '')
				{
					$query->whereHas('course', function ($q) use($search_term_course){
						$q->where('course_name', 'LIKE', '%'.$search_term_course.'%');
					});
				}
			}
			if ($request->has('search_term_test_series_type')) 
			{
				$search_term_test_series_type 		= 	$request->input('search_term_test_series_type');
				if(trim($search_term_test_series_type) != '')
				{
					$query->whereHas('test_series_type', function ($q) use($search_term_test_series_type){
						$q->where('test_series_type', 'LIKE', '%'.$search_term_test_series_type.'%');
					});
				}
			}
			if ($request->has('search_term_group')) 
			{
				$search_term_group 		= 	$request->input('search_term_group');
				if(trim($search_term_group) != '')
				{
					$query->whereHas('group', function ($q) use($search_term_group){
						$q->where('group_name', 'LIKE', '%'.$search_term_group.'%');
					});
				}
			}
			if ($request->has('search_term_from')) 
			{
				$search_term_from 		= 	$request->input('search_term_from');
				if(trim($search_term_from) != '')
				{
					$query->whereDate('created_at', '>=', $search_term_from);
				}
			}
			if ($request->has('search_term_to')) 
			{	
				$search_term_to 		= 	$request->input('search_term_to');
				if(trim($search_term_to) != '')
				{
					$query->whereDate('created_at', '<=', $search_term_to);
				}	
			}
			
			if ($request->has('search_term') || $request->has('search_term_course') || $request->has('search_term_test_series_type') || $request->has('search_term_group') || $request->has('search_term_from') || $request->has('search_term_to')) 
			{
				$totalData 	= $query->count();//after search
			}
		//searching end	

		$lists		= $query->sortable(['id'=>'desc'])->paginate(config('constants.limit'));	

		return view('Admin.subject.index',compact(['lists', 'totalData']));	
	}
	/**
     * Add Subject.
     *
     * @return \Illuminate\Http\Response
     */
	public function addSubject(Request $request)
	{
		//check authorization start	
			$check = $this->checkAuthorizationAction('Subject', $request->route()->getActionMethod(), Auth::user()->role);
			if($check)
			{
				return Redirect::to('/admin/dashboard')->with('error',config('constants.unauthorized'));
			}	
		//check authorization end
		
		/* Get all Select Data */	
			$courses = Course::select('id', 'course_name')->where('status', '=', 1)->get();
			$test_series_types = TestSeriesType::select('id', 'test_series_type')->where('status', '=', 1)->get();
			$groups = Group::select('id', 'group_name')->get();
		/* Get all Select Data */	
		
		if ($request->isMethod('post')) 
		{
			$requestData 					= 	$request->all();
			
			$query	=	Subject::where('id', '!=', '')->where('subject_name', '=', $requestData['subject_name'])->where('which_course', '=', $requestData['which_course'])->where('which_group', '=', $requestData['which_group']);
			if(!empty(trim($requestData['which_test_series_type'])))
			{
				$query->where('which_test_series_type', '=',  $requestData['which_test_series_type']);
			}
			$count = $query->count();
			
			if($count  == 0)
			{	
				$this->validate($request, [
											'which_course' => 'required|exists:courses,id',
											'which_test_series_type' => 'nullable|exists:test_series_types,id',
											'subject_name' => 'required',
											'price' => 'required|max:40'
										  ], 
										  [
											'which_course.exists' => 'The selected course is invalid.',
											'which_test_series_type.exists' => 'The selected test series type is invalid.'
										  ]);

				$obj							= 	new Subject;
				$obj->which_course				=	@$requestData['which_course'];
				$obj->which_test_series_type	=	@$requestData['which_test_series_type'];
				$obj->which_group				=	@$requestData['which_group'];
				$obj->subject_name				=	@$requestData['subject_name'];
				$obj->price						=	@$requestData['price'];
				
				$saved							=	$obj->save();
				
				if(!$saved)
				{
					return redirect()->back()->with('error', Config::get('constants.server_error'));
				}
				else
				{
					return Redirect::to('/admin/subjects')->with('success', 'Subject'.Config::get('constants.added'));	
				}
			}
			else
			{
				return redirect()->back()->with('error', 'Subject is already exist, so please check everything in terms of Subject Name, Course, Test Series Type and Group.');
			}		
		}
		return view('Admin.subject.add_subject', compact(['courses', 'test_series_types', 'groups']));		
	}
	
	public function editSubject(Request $request, $id = NULL)
	{
		//check authorization start	
			$check = $this->checkAuthorizationAction('Subject', $request->route()->getActionMethod(), Auth::user()->role);
			if($check)
			{
				return Redirect::to('/admin/dashboard')->with('error',config('constants.unauthorized'));
			}	
		//check authorization end
		
		
		/* Get all Select Data */	
			$courses = Course::select('id', 'course_name')->where('status', '=', 1)->get();
			$test_series_types = TestSeriesType::select('id', 'test_series_type')->where('status', '=', 1)->get();
			$groups = Group::select('id', 'group_name')->get();
		/* Get all Select Data */
	
		if ($request->isMethod('post')) 
		{
			$requestData 		= 	$request->all();
			
			$query	=	Subject::where('id', '!=', $requestData['id'])->where('subject_name', '=', $requestData['subject_name'])->where('which_course', '=', $requestData['which_course'])->where('which_group', '=', $requestData['which_group']);
			if(!empty(trim($requestData['which_test_series_type'])))
			{
				$query->where('which_test_series_type', '=',  $requestData['which_test_series_type']);
			}
			$count = $query->count();
			
			if($count  == 0)
			{
				$this->validate($request, [
											'which_course' => 'required|exists:courses,id',
											'which_test_series_type' => 'nullable|exists:test_series_types,id',
											'subject_name' => 'required',
											'price' => 'required|max:40'
										  ], 
										  [
											'which_course.exists' => 'The selected course is invalid.',
											'which_test_series_type.exists' => 'The selected test series type is invalid.'
										  ]);						  
										  
										  
				$obj							= 	Subject::find($requestData['id']);
				$obj->which_course				=	@$requestData['which_course'];
				$obj->which_test_series_type	=	@$requestData['which_test_series_type'];
				$obj->which_group				=	@$requestData['which_group'];
				$obj->subject_name				=	@$requestData['subject_name'];
				$obj->price						=	@$requestData['price'];
				
				$saved				=	$obj->save();
				
				if(!$saved)
				{
					return redirect()->back()->with('error', Config::get('constants.server_error'));
				}
				else
				{
					return Redirect::to('/admin/subjects')->with('success', 'Subject'.Config::get('constants.edited'));
				}
			}
			else
			{
				return redirect()->back()->with('error', 'Subject is already exist, so please check everything in terms of Subject Name, Course, Test Series Type and Group.');
			}		
		}
		else
		{	
			if(isset($id) && !empty($id))
			{
				$id = $this->decodeString($id);	
				if(Subject::where('id', '=', $id)->exists())
				{
					$fetchedData = Subject::find($id);
					return view('Admin.subject.edit_subject', compact(['fetchedData', 'courses', 'test_series_types', 'groups']));
				}
				else
				{
					return Redirect::to('/admin/subjects')->with('error', 'Subject'.Config::get('constants.not_exist'));
				}	
			}
			else
			{
				return Redirect::to('/admin/subjects')->with('error', Config::get('constants.unauthorized'));
			}		
		}				
	}
	
	public function viewSubject(Request $request, $id)
	{
		if(isset($id) && !empty($id))
		{
			$id = $this->decodeString($id);	
			if(Subject::where('id', '=', $id)->exists()) 
			{
				$fetchedData = Subject::where('id', '=', $id)->with('course', 'test_series_type', 'group')->first();
				return view('Admin.subject.view_subject', compact(['fetchedData']));
			}
			else
			{
				if( Auth::user()->role == 1) //super Admin	
				{
					return Redirect::to('/admin/subjects')->with('error', 'Subject'.Config::get('constants.not_exist'));
				}
				else if(Auth::user()->role == 2) //for vendors
				{
					return Redirect::to('/admin/linked_subjects')->with('error', 'Subject'.Config::get('constants.not_exist'));
				}
				else
				{
					return Redirect::to('/admin/dashboard')->with('error', Config::get('constants.unauthorized'));
				}
			}	
		}
		else
		{
			if( Auth::user()->role == 1) //super Admin	
			{
				return Redirect::to('/admin/subjects')->with('error', Config::get('constants.unauthorized'));
			}
			else if(Auth::user()->role == 2) //for vendors
			{
				return Redirect::to('/admin/linked_subjects')->with('error', Config::get('constants.unauthorized'));
			}
			else
			{
				return Redirect::to('/admin/dashboard')->with('error', Config::get('constants.unauthorized'));
			}		
		}
	}
	
	public function getSubjectDetail(Request $request)
	{	
		$status 			= 	0;
		$data				=	array();
		$vendorData			=	array();
		$method 			= 	$request->method();	
		
		if ($request->isMethod('post')) 
		{
			$requestData 	= 	$request->all();
			
			$requestData['id'] = trim($requestData['id']);
			
			if(isset($requestData['id']) && !empty($requestData['id'])) 
			{
				$recordExist = Subject::where('id', $requestData['id'])->exists();
				
				if($recordExist)
				{
					$data 	= 	Subject::where('id', '=', $requestData['id'])->with('course', 'test_series_type', 'group')->first();
					
					if($data) 
					{
						$vendorData 	= 	VendorSubject::where('subject_id', '=', $requestData['id'])->with(['vendor'=>function($query){
							$query->select('id', 'first_name', 'email');
						}])->get();
						
						$status = 1;	
						$message = 'Record has been deleted successfully.';
					} 
					else 
					{
						$message = Config::get('constants.server_error');
					}
				}
				else
				{
					$message = 'ID does not exist, please check it once again.';
				}			
			} 
			else 
			{
				$message = 'Id does not exist, please check it once again.';		
			}
		} 
		else 
		{
			$message = Config::get('constants.post_method');
		}
		echo json_encode(array('status'=>$status, 'message'=>$message, 'data'=>$data, 'vendorData'=>$vendorData));
		die;
	}
	
}
