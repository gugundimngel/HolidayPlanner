<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Routing\Route;

use App\McqSubject;

use Auth;
use Config;

class McqSubjectController extends Controller
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
     * All MCQ Subjects.
     *
     * @return \Illuminate\Http\Response
     */
	public function index(Request $request)
	{
		//check authorization start	
			$check = $this->checkAuthorizationAction('McqSubject', $request->route()->getActionMethod(), Auth::user()->role);
			if($check)
			{
				return Redirect::to('/admin/dashboard')->with('error',config('constants.unauthorized'));
			}	
		//check authorization end
		
		$query 		= McqSubject::where('id', '!=', '');
		
		$totalData 	= $query->count();	//for all data
		
		if ($request->has('search_term')) 
		{
			$search_term 		= 	$request->input('search_term');
			if(trim($search_term) != '')
			{		
				$query->where('subject_name', 'LIKE', '%' . $search_term . '%');
			}
			$totalData 	= $query->count();//after search
		}	
		$lists		= $query->sortable(['id' => 'desc'])->paginate(config('constants.limit'));
		
		return view('Admin.mcq_subjects.index',compact(['lists', 'totalData']));	
	}
	/**
     * Add MCQ Subject.
     *
     * @return \Illuminate\Http\Response
     */
	public function addMcqSubject(Request $request)
	{
		//check authorization start	
			$check = $this->checkAuthorizationAction('McqSubject', $request->route()->getActionMethod(), Auth::user()->role);
			if($check)
			{
				return Redirect::to('/admin/dashboard')->with('error',config('constants.unauthorized'));
			}	
		//check authorization end
	
		if ($request->isMethod('post')) 
		{
			$this->validate($request, [
										'subject_name' => 'required|max:255|unique:mcq_subjects'
									  ]);
			
			
			$requestData 		= 	$request->all();
			
			$obj				= 	new McqSubject;
			$obj->subject_name	=	$requestData['subject_name'];
			
			$saved				=	$obj->save();
			
			if(!$saved)
			{
				return redirect()->back()->with('error', Config::get('constants.server_error'));
			}
			else
			{
				return Redirect::to('/admin/mcq_subjects')->with('success', 'MCQ Subject'.Config::get('constants.added'));
			}				
		}
		return view('Admin.mcq_subjects.add_mcq_subject');		
	}
	
	public function editMcqSubject(Request $request, $id = NULL)
	{	
		//check authorization start	
			$check = $this->checkAuthorizationAction('McqSubject', $request->route()->getActionMethod(), Auth::user()->role);
			if($check)
			{
				return Redirect::to('/admin/dashboard')->with('error',config('constants.unauthorized'));
			}	
		//check authorization end
	
		if ($request->isMethod('post')) 
		{
			$requestData 		= 	$request->all();
			
			$this->validate($request, [
										'subject_name' => 'required|max:255|unique:mcq_subjects,subject_name,'.$requestData['id']
									  ]);
			$obj				= 	McqSubject::find($requestData['id']);
			$obj->subject_name	=	$requestData['subject_name'];
			
			$saved				=	$obj->save();
			
			if(!$saved)
			{
				return redirect()->back()->with('error', Config::get('constants.server_error'));
			}
			else
			{
				return Redirect::to('/admin/mcq_subjects')->with('success', 'MCQ Subject'.Config::get('constants.edited'));
			}				
		}
		else
		{	
			if(isset($id) && !empty($id))
			{
				$id = $this->decodeString($id);	
				if(McqSubject::where('id', '=', $id)->exists()) 
				{
					$fetchedData = McqSubject::find($id);
					return view('Admin.mcq_subjects.edit_mcq_subject', compact(['fetchedData']));
				}
				else
				{
					return Redirect::to('/admin/mcq_subjects')->with('error', 'MCQ Subject'.Config::get('constants.not_exist'));
				}	
			}
			else
			{
				return Redirect::to('/admin/mcq_subjects')->with('error', Config::get('constants.unauthorized'));
			}		
		}				
	}
	
}
