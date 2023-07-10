<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;

use App\Subject;
use App\Test;
use App\ScheduledTest;
use App\Admin;

use Auth;
use Config;

class TestController extends Controller
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
     * All Tests.
     *
     * @return \Illuminate\Http\Response
     */
	public function index(Request $request)
	{
		//check authorization start	
			$check = $this->checkAuthorizationAction('Test', $request->route()->getActionMethod(), Auth::user()->role);
			if($check)
			{
				return Redirect::to('/admin/dashboard')->with('error',config('constants.unauthorized'));
			}	
		//check authorization end
		
		$query 		= Test::where('id', '!=', '');
		
		$totalData 	= $query->count();	//for all data
		
		if ($request->has('search_term')) 
		{
			$search_term 		= 	$request->input('search_term');
			if(trim($search_term) != '')	
			{	
				$query->where('test_name', 'LIKE', '%' . $search_term . '%');
			}
			$totalData 	= $query->count();//after search
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
		
		if ($request->has('search_term') || $request->has('search_term_from') || $request->has('search_term_to')) 
		{
			$totalData 	= $query->count();//after search
		}

		$lists 	= 	$query->with(['subject' => function($query)
					{
						$query->select('id', 'which_course', 'which_test_series_type', 'which_group', 'subject_name');
						$query->with(['course' => function($subQuery){
							$subQuery->select('id', 'course_name');
						}, 'test_series_type' => function($subQuery){
							$subQuery->select('id', 'test_series_type');
						}, 'group' => function($subQuery){
							$subQuery->select('id', 'group_name');
						}]);
					}, 'vendor'=>function($query){
						$query->select('id', 'first_name', 'last_name');
					}])->sortable(['id'=>'desc'])->paginate(config('constants.limit'));					
		
		return view('Admin.test.index',compact(['lists', 'totalData']));	
	}
	/**
     * Add Test.
     *
     * @return \Illuminate\Http\Response
     */
	public function addTest(Request $request)
	{
		//check authorization start	
			$check = $this->checkAuthorizationAction('Test', $request->route()->getActionMethod(), Auth::user()->role);
			if($check)
			{
				return Redirect::to('/admin/dashboard')->with('error',config('constants.unauthorized'));
			}	
		//check authorization end
		
		/* Get all Select Data */	
			$subjects = Subject::select('id', 'subject_name')->where('status', '=', 1)->get();
		/* Get all Select Data */	
		
		if ($request->isMethod('post')) 
		{
			$requestData 					= 	$request->all();
			
			$this->validate($request, [
										'test_number' => 'required|max:40',
										'test_name' => 'required|max:255',
										'which_subject' => 'required',
										'which_vendor' => 'required',
										'from_date' => 'required',
										'to_date' => 'required|after_or_equal:from_date',
										'estimated_time' => 'required|max:40',
										'marks' => 'required|max:5',
										'test_pdf' => 'required',
										'test_suggestion_pdf' => 'required'
									  ]);	
									  
			/* Test PDF Upload Function Start */						  
				if($request->hasfile('test_pdf')) 
				{
					$test_pdf_name = $this->uploadFile($request->file('test_pdf'), Config::get('constants.test_pdfs'));
				}
			/* Test PDF Upload Function End */

			/* Test Suggestion PDF Upload Function Start */						  
				if($request->hasfile('test_suggestion_pdf')) 
				{
					$test_suggestion_pdf_name = $this->uploadFile($request->file('test_suggestion_pdf'), Config::get('constants.test_suggestion_pdfs'));
				}
			/* Test Suggestion PDF Upload Function End */			

			$obj							= 	new Test;
			$obj->test_number				=	@$requestData['test_number'];
			$obj->test_name					=	@$requestData['test_name'];
			$obj->which_subject				=	@$requestData['which_subject'];
			$obj->which_vendor				=	@$requestData['which_vendor'];
			$obj->from_date					=	@$requestData['from_date'];
			$obj->to_date					=	@$requestData['to_date'];
			$obj->estimated_time			=	@$requestData['estimated_time'];
			$obj->marks						=	@$requestData['marks'];
			$obj->test_pdf					=	@$test_pdf_name;
			$obj->test_suggestion_pdf		=	@$test_suggestion_pdf_name;
			
			$saved							=	$obj->save();
			
			if(!$saved)
			{
				return redirect()->back()->with('error', Config::get('constants.server_error'));
			}
			else
			{
				return Redirect::to('/admin/tests')->with('success', 'Test'.Config::get('constants.added'));
			}
		}
		return view('Admin.test.add_test', compact(['subjects']));		
	}
	
	public function editTest(Request $request, $id = NULL)
	{
		//check authorization start	
			$check = $this->checkAuthorizationAction('Test', $request->route()->getActionMethod(), Auth::user()->role);
			if($check)
			{
				return Redirect::to('/admin/dashboard')->with('error',config('constants.unauthorized'));
			}	
		//check authorization end
		
		/* Get all Select Data */	
			$subjects = Subject::select('id', 'subject_name')->where('status', '=', 1)->get();
		/* Get all Select Data */
	
		if ($request->isMethod('post')) 
		{
			$requestData 		= 	$request->all();

			$this->validate($request, [
										'test_number' => 'required|max:40',
										'test_name' => 'required|max:255',
										'which_subject' => 'required',
										'which_vendor' => 'required',
										'from_date' => 'required',
										'to_date' => 'required|after_or_equal:from_date',
										'estimated_time' => 'required|max:40',
										'marks' => 'required|max:5',
										'old_test_pdf' => 'required',
										'old_test_suggestion_pdf' => 'required'
									  ]);
			/* File Upload Function Start */						  
				if($request->hasfile('test_pdf')) 
				{
					/* Unlink File Function Start */ 
						if(@$requestData['test_pdf'] != '')
							{
								$this->unlinkFile(@$requestData['old_test_pdf'], Config::get('constants.test_pdfs'));
							}
					/* Unlink File Function End */
					
					$test_pdf_name = $this->uploadFile($request->file('test_pdf'), Config::get('constants.test_pdfs'));
				}
			else
				{
					$test_pdf_name = @$requestData['old_test_pdf'];
				}		
			/* File Upload Function End */
			
			/* File Upload Suggested Answer Function Start */						  
				if($request->hasfile('test_suggestion_pdf')) 
				{
					/* Unlink File Function Start */ 
						if(@$requestData['old_test_suggestion_pdf'] != '')
							{
								$this->unlinkFile(@$requestData['old_test_suggestion_pdf'], Config::get('constants.test_suggestion_pdfs'));
							}
					/* Unlink File Function End */
					
					$test_suggestion_pdf_name = $this->uploadFile($request->file('test_suggestion_pdf'), Config::get('constants.test_suggestion_pdfs'));
				}
			else
				{
					$test_suggestion_pdf_name = @$requestData['old_test_suggestion_pdf'];
				}		
			/* File Upload Suggested Answer Function End */
			
								  					  
			$obj							= 	Test::find(@$requestData['id']);
			$obj->test_number				=	@$requestData['test_number'];
			$obj->test_name					=	@$requestData['test_name'];
			$obj->which_subject				=	@$requestData['which_subject'];
			$obj->which_vendor				=	@$requestData['which_vendor'];
			$obj->from_date					=	@$requestData['from_date'];
			$obj->to_date					=	@$requestData['to_date'];
			$obj->estimated_time			=	@$requestData['estimated_time'];
			$obj->marks						=	@$requestData['marks'];
			$obj->test_pdf					=	@$test_pdf_name;	
			$obj->test_suggestion_pdf		=	@$test_suggestion_pdf_name;	
			
			$saved				=	$obj->save();
			
			if(!$saved)
			{
				return redirect()->back()->with('error', Config::get('constants.server_error'));
			}
			else
			{
				return Redirect::to('/admin/tests')->with('success', 'Your Test has been edited successfully.');
			}		
		}
		else
		{	
			if(isset($id) && !empty($id))
			{
				$id = $this->decodeString($id);	
				if(Test::where('id', '=', $id)->exists())
				{
					$fetchedData = Test::find($id);
					return view('Admin.test.edit_test', compact(['fetchedData', 'subjects']));
				}
				else
				{
					return Redirect::to('/admin/tests')->with('error', 'Test Id does not exist.');
				}	
			}
			else
			{
				return Redirect::to('/admin/tests')->with('error', Config::get('constants.unauthorized'));
			}		
		}				
	}
	
	public function viewTest(Request $request, $id)
	{
		if(isset($id) && !empty($id))
		{
			$id = $this->decodeString($id);	
			if(Test::where('id', '=', $id)->exists()) 
			{
				$fetchedData 		= 	Test::where('id', '=', $id)->with(['subject' => function($query)
					{
						$query->select('id', 'which_course', 'which_test_series_type', 'which_group', 'subject_name');
						$query->with(['course' => function($subQuery){
							$subQuery->select('id', 'course_name');
						}, 'test_series_type' => function($subQuery){
							$subQuery->select('id', 'test_series_type');
						}, 'group' => function($subQuery){
							$subQuery->select('id', 'group_name');
						}]);
					}, 'vendor'=>function($query){
								$query->select('id', 'first_name', 'last_name', 'email');
							}])->first();		
				return view('Admin.test.view_test', compact(['fetchedData']));
			}
			else
			{
				if( Auth::user()->role == 1) //super Admin	
				{
					return Redirect::to('/admin/tests')->with('error', 'Test'.Config::get('constants.not_exist'));
				}
				else if(Auth::user()->role == 2) //for vendors
				{
					return Redirect::to('/admin/assigned_tests')->with('error', 'Test'.Config::get('constants.not_exist'));
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
				return Redirect::to('/admin/tests')->with('error', Config::get('constants.unauthorized'));
			}
			else if(Auth::user()->role == 2) //for vendors
			{
				return Redirect::to('/admin/assigned_tests')->with('error', Config::get('constants.unauthorized'));
			}
			else
			{
				return Redirect::to('/admin/dashboard')->with('error', Config::get('constants.unauthorized'));
			}
		}
	}
	
	public function getPDFAccess(Request $request, $id = NULL, $type = NULL)
	{
		if(isset($id) && !empty($id))
		{
			$id = $this->decodeString($id);	
			
			if($type == 'test_submitted_copy' || $type == 'test_reviewed_copy')
			{
				if(ScheduledTest::where('id', '=', $id)->exists()) 
				{
					$role = Auth::user()->role;
					if($role == 1 || $role == 2) //for superadmin and vendor
					{
						$headers = array(
							'Content-Type: application/pdf',
						);

						$pdfFile = ScheduledTest::select('test_submitted_copy', 'test_reviewed_copy')->where('id', '=', $id)->first();
						if($type == 'test_submitted_copy')
						{
							if(!empty($pdfFile->test_submitted_copy))
							{
								$pdfFilePath = 	Config::get('constants.test_submitted_copies').'/'.$pdfFile->test_submitted_copy;
								return Response::download($pdfFilePath, 'Answer Given By Student.pdf', $headers);
							}
							else
							{
								return Redirect::to('/admin/dashboard')->with('error', 'PDF'.Config::get('constants.not_exist'));
							}		
						}
						elseif($type == 'test_reviewed_copy')
						{
							if(!empty($pdfFile->test_reviewed_copy))
							{
								$pdfFilePath = 	Config::get('constants.test_reviewed_copies').'/'.$pdfFile->test_reviewed_copy;
								return Response::download($pdfFilePath, 'Test Reviewed.pdf', $headers);
							}
							else
							{
								return Redirect::to('/admin/dashboard')->with('error', 'PDF'.Config::get('constants.not_exist'));
							}
						}
						else
						{
							return redirect('/admin/dashboard')->with('error', Config::get('constants.unauthorized'));
						}	
					}
					else
					{
						return redirect('/admin/dashboard')->with('error', Config::get('constants.unauthorized'));
					}		
				}
				else
				{
					return Redirect::to('/admin/dashboard')->with('error', 'PDF'.Config::get('constants.not_exist'));
				}
			}
			else
			{	
				if(Test::where('id', '=', $id)->exists()) 
				{
					$role = Auth::user()->role;
					if($role == 1 || $role == 2) //for superadmin and vendor
					{
						$headers = array(
							'Content-Type: application/pdf',
						);

						$pdfFile = Test::select('test_pdf', 'test_suggestion_pdf')->where('id', '=', $id)->first();
						
						if($type == 'test_pdf')
						{
							if(!empty($pdfFile->test_pdf))
							{
								$pdfFilePath = 	Config::get('constants.test_pdfs').'/'.$pdfFile->test_pdf;
								return Response::download($pdfFilePath, 'Test Paper.pdf', $headers);
							}
							else
							{
								return Redirect::to('/admin/dashboard')->with('error', 'PDF'.Config::get('constants.not_exist'));
							}		
						}
						elseif($type == 'test_suggestion_pdf')
						{
							if(!empty($pdfFile->test_suggestion_pdf))
							{
								$pdfFilePath = 	Config::get('constants.test_suggestion_pdfs').'/'.$pdfFile->test_suggestion_pdf;
								return Response::download($pdfFilePath, 'Test Answer Suggestion.pdf', $headers);
							}
							else
							{
								return Redirect::to('/admin/dashboard')->with('error', 'PDF'.Config::get('constants.not_exist'));
							}
						}
						else
						{
							return redirect('/admin/dashboard')->with('error', Config::get('constants.unauthorized'));
						}	
					}
					else
					{
						return redirect('/admin/dashboard')->with('error', Config::get('constants.unauthorized'));
					}		
				}
				else
				{
					return Redirect::to('/admin/dashboard')->with('error', 'PDF'.Config::get('constants.not_exist'));
				}
			}	
		}
		else
		{
			return Redirect::to('/admin/dashboard')->with('error', 'PDF'.Config::get('constants.not_exist'));	
		}	
	}

	public function scheduledTests(Request $request)
	{
		//check authorization start	
			$check = $this->checkAuthorizationAction('Test', $request->route()->getActionMethod(), Auth::user()->role);
			if($check)
			{
				return Redirect::to('/admin/dashboard')->with('error',config('constants.unauthorized'));
			}	
		//check authorization end
		
		$vendors  = Admin::select('id', 'first_name', 'last_name')->where('role', '=', 2)->get(); //only for test series vendors
			
		$query 				= ScheduledTest::where('id', '!=', '');
	
		if ($request->has('search_term_vendor')) 
		{
			$search_term_vendor 		= 	$request->input('search_term_vendor');	
			if(trim($search_term_vendor) != '')
			{
				
			}		
		}
		if ($request->has('search_term_first_name')) 
		{
			$search_term_first_name 		= 	$request->input('search_term_first_name');	
			if(trim($search_term_first_name) != '')
			{
				$query->whereHas('student', function ($q) use($search_term_first_name){
					$q->where('first_name',$search_term_first_name);
				});
			}		
		}
		if ($request->has('search_term_last_name')) 
		{	
			$search_term_last_name 		= 	$request->input('search_term_last_name');	
			if(trim($search_term_last_name) != '')
			{
				$query->whereHas('student', function ($q) use($search_term_last_name){
					$q->where('last_name',$search_term_last_name);
				});
			}		
		}
		if ($request->has('search_term_email')) 
		{
			$search_term_email 		= 	$request->input('search_term_email');	
			if(trim($search_term_email) != '')
			{
				$query->whereHas('student', function ($q) use($search_term_email){
					$q->where('email',$search_term_email);
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
		
		if ($request->has('search_schedule')) 
		{	
			$search_schedule 		= 	$request->input('search_schedule');
			
			if(trim($search_schedule) != '')
			{
				$query->whereDate('scheduled_date', '=', $search_schedule);
			}	
		}
		
		$query->with(['student'=>function($q){
			$q->select('id', 'first_name', 'last_name', 'email');
		}, 'test'=>function($q){
			$q->select('id', 'test_name', 'test_number');
		}]);
		
		$lists = $query->sortable(['id'=>'desc'])->paginate(config('constants.limit'));
		
		if ($request->has('search_term_first_name') || $request->has('search_term_last_name') || $request->has('search_term_email') || $request->has('search_term_from') || $request->has('search_term_to') || $request->has('search_schedule')) 
		{
			$totalData 	= $query->count();
		}
		else
		{
			$totalData 	= ScheduledTest::where('id', '!=', '')->count();
		}
		
		return view('Admin.test.scheduled_tests',compact(['lists', 'totalData', 'vendors']));	
	}

	public function viewScheduledTest(Request $request, $id)
	{
		//check authorization start	
			$check = $this->checkAuthorizationAction('Test', $request->route()->getActionMethod(), Auth::user()->role);
			if($check)
			{
				return Redirect::to('/admin/dashboard')->with('error',config('constants.unauthorized'));
			}	
		//check authorization end
		
		if(isset($id) && !empty($id))
		{
			$id = $this->decodeString($id);
			
			if(ScheduledTest::where('id', '=', $id)->exists()) 
			{
				$fetchedData 		= 	ScheduledTest::where('id', '=', $id)->with(['test' => function($query)
					{
						$query->select('id', 'test_number', 'test_name', 'which_subject', 'from_date', 'to_date', 'estimated_time', 'marks', 'test_pdf', 'test_suggestion_pdf', 'which_vendor');
						$query->with(['subject' => function($subQuery){
							$subQuery->select('id', 'which_course', 'which_test_series_type', 'which_group', 'subject_name', 'price');
							$subQuery->with(['course' => function($subQuery1){
								$subQuery1->select('id', 'course_name');
							}, 'test_series_type' => function($subQuery1){
								$subQuery1->select('id', 'test_series_type');
							}, 'group' => function($subQuery1){
								$subQuery1->select('id', 'group_name');
							}]);
						}]);
					}, 'student'=>function($query){
						$query->select('id', 'first_name', 'last_name', 'email', 'phone', 'country', 'state', 'city', 'address', 'zip');
					}])->first();
				
				//get vendor information start
					$vendorId = $fetchedData->test->which_vendor;
					$allVendorInfo = Admin::where('id', '=', $vendorId)->select('id', 'first_name', 'last_name', 'email', 'phone')->first();
				//get vendor information end

				return view('Admin.test.view_scheduled_test', compact(['fetchedData', 'allVendorInfo']));
			}
			else
			{
				return Redirect::to('/admin/scheduled_tests')->with('error', 'Test Id does not exist.');
			}
		}
		else
		{
			return Redirect::to('/admin/scheduled_tests')->with('error', Config::get('constants.unauthorized'));
		}
	}
	
}
