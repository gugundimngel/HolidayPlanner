<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;

use App\User;
use App\Country;
use App\PurchasedSubject;

use Auth;
use Config;

class StudentController extends Controller
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
     * All Students.
     *
     * @return \Illuminate\Http\Response
     */
	public function index(Request $request)
	{
		//check authorization start	
			$check = $this->checkAuthorizationAction('User', $request->route()->getActionMethod(), Auth::user()->role);
			if($check)
			{
				return Redirect::to('/admin/dashboard')->with('error',config('constants.unauthorized'));
			}	
		//check authorization end
		
		$query 		= User::where('id', '!=', '');
		
		$totalData 	= $query->count();	//for all data	
		
		//searching start
			if ($request->has('search_term_first')) 
			{
				$search_term_first 		= 	$request->input('search_term_first');
				if(trim($search_term_first) != '')
				{
					$query->where('first_name', 'LIKE', '%' . $search_term_first . '%');
				}
			}
			
			if ($request->has('search_term_last')) 
			{
				$search_term_last 		= 	$request->input('search_term_last');
				if(trim($search_term_last) != '')
				{
					$query->where('last_name', 'LIKE', '%' . $search_term_last . '%');
				}
			}
			
			if ($request->has('search_term_email')) 
			{
				$search_term_email 		= 	$request->input('search_term_email');
				if(trim($search_term_email) != '')
				{
					$query->where('email', 'LIKE', '%' . $search_term_email . '%');
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
		//searching end
		
		if ($request->has('search_term_first') || $request->has('search_term_last') || $request->has('search_term_email') || $request->has('search_term_from') || $request->has('search_term_to')) 
		{
			$totalData 	= $query->count();
		}
		
		$lists		= $query->sortable(['id'=>'desc'])->paginate(config('constants.limit'));	

		return view('Admin.student.index',compact(['lists', 'totalData']));	
	}

	public function viewStudent(Request $request, $id)
	{
		//check authorization start	
			$check = $this->checkAuthorizationAction('User', $request->route()->getActionMethod(), Auth::user()->role);
			if($check)
			{
				return Redirect::to('/admin/dashboard')->with('error',config('constants.unauthorized'));
			}	
		//check authorization end
		
		if(isset($id) && !empty($id))
		{
			$id = $this->decodeString($id);

			if(User::where('id', '=', $id)->exists()) 
			{
				$fetchedData 		= 	User::where('id', '=', $id)->with('countryData', 'stateData')->first();

				return view('Admin.student.view_student', compact(['fetchedData']));
			}
			else
			{
				return Redirect::to('/admin/students')->with('error', 'Student Id does not exist.');
			}
		}
		else
		{
			return Redirect::to('/admin/students')->with('error', Config::get('constants.unauthorized'));
		}
	}
	
	public function viewPurchasedSubject(Request $request, $id)
	{
		//check authorization start	
			$check = $this->checkAuthorizationAction('User', $request->route()->getActionMethod(), Auth::user()->role);
			if($check)
			{
				return Redirect::to('/admin/dashboard')->with('error',config('constants.unauthorized'));
			}	
		//check authorization end
		
		if(isset($id) && !empty($id))
		{
			$id = $this->decodeString($id);
			if(PurchasedSubject::where('id', '=', $id)->exists()) 
			{
				$query 				= PurchasedSubject::where('test_series_transaction_id', '=', $id);	
				$fetchedData 		= 	$query->with(['subject' => function($query){
					$query->select('id', 'which_course', 'which_test_series_type', 'which_group', 'subject_name', 'price');
					$query->with(['course' => function($subQuery){
						$subQuery->select('id', 'course_name');
					}, 'test_series_type' => function($subQuery){
						$subQuery->select('id', 'test_series_type');
					}, 'group' => function($subQuery){
						$subQuery->select('id', 'group_name');
					}]);
				}, 'student'=>function($query){
					$query->select('id', 'first_name', 'last_name', 'email', 'phone', 'country', 'state', 'city', 'address', 'zip');
					$query->with(['countryData', 'stateData']);	
				}])->get();
				
				return view('Admin.student.view_purchased_subject', compact(['fetchedData']));
			}
			else
			{
				return Redirect::to('/admin/students')->with('error', 'Student Id does not exist.');
			}
		}
		else
		{
			return Redirect::to('/admin/students')->with('error', Config::get('constants.unauthorized'));
		}
	}
	
	public function exportStudent(Request $request)
	{
		$headers = array(
							"Content-type" => "text/csv",
							"Content-Disposition" => "attachment; filename=Student Report.csv",
							"Pragma" => "no-cache",
							"Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
							"Expires" => "0"
						);
		$reports = User::select('id', 'first_name', 'last_name', 'email', 'phone')->where('id', '!=', '')->get();

		$columns = array('Name', 'Email', 'Phone');	
		
		$callback = function() use ($reports, $columns)
			{
				$file = fopen('php://output', 'w');
				fputcsv($file, $columns);

				foreach($reports as $reportData) 
				{
					fputcsv($file, array(@$reportData->first_name.' '.@$reportData->last_name, @$reportData->email, @$reportData->phone));
				}
				fclose($file);
			};
		return Response::stream($callback, 200, $headers);									
	}
}
