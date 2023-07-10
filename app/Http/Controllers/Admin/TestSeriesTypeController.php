<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

use App\TestSeriesType;

use Auth;
use Config;

class TestSeriesTypeController extends Controller
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
     * All Test Series Types.
     *
     * @return \Illuminate\Http\Response
     */
	public function index(Request $request)
	{
		//check authorization start	
			$check = $this->checkAuthorizationAction('TestSeriesType', $request->route()->getActionMethod(), Auth::user()->role);
			if($check)
			{
				return Redirect::to('/admin/dashboard')->with('error',config('constants.unauthorized'));
			}	
		//check authorization end
		
		$query 		= TestSeriesType::where('id', '!=', '');
		
		$totalData 	= $query->count();	//for all data
		
		if ($request->has('search_term')) 
		{
			$search_term 		= 	$request->input('search_term');
			if(trim($search_term) != '')
			{
				$query->where('test_series_type', 'LIKE', '%' . $search_term . '%');
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

		if ($request->has('search_term') || $request->has('search_term_from') || $request->has('search_term_to')) 
		{
			$totalData 	= $query->count();//after search
		}
		$lists		= $query->sortable(['id'=>'desc'])->paginate(config('constants.limit'));

		return view('Admin.test_series_type.index',compact(['lists', 'totalData']));	
	}
	/**
     * Add Test Series Type.
     *
     * @return \Illuminate\Http\Response
     */
	public function addTestSeriesType(Request $request)
	{
		//check authorization start	
			$check = $this->checkAuthorizationAction('TestSeriesType', $request->route()->getActionMethod(), Auth::user()->role);
			if($check)
			{
				return Redirect::to('/admin/dashboard')->with('error',config('constants.unauthorized'));
			}	
		//check authorization end
	
		if ($request->isMethod('post')) 
		{
			$requestData 			= 	$request->all();
			
			$this->validate($request, [
										'test_series_type' => 'required|max:255|unique:test_series_types'
									  ]);
			
			$obj					= 	new TestSeriesType;
			$obj->test_series_type	=	@$requestData['test_series_type'];
			$obj->description		=	@$requestData['description'];
			
			$saved					=	$obj->save();
			
			if(!$saved)
			{
				return redirect()->back()->with('error', Config::get('constants.server_error'));
			}
			else
			{
				return Redirect::to('/admin/test_series_types')->with('success', 'Test Series Type'.Config::get('constants.added'));
			}				
		}
		return view('Admin.test_series_type.add_test_series_type');		
	}
	
	public function editTestSeriesType(Request $request, $id = NULL)
	{
		//check authorization start	
			$check = $this->checkAuthorizationAction('TestSeriesType', $request->route()->getActionMethod(), Auth::user()->role);
			if($check)
			{
				return Redirect::to('/admin/dashboard')->with('error',config('constants.unauthorized'));
			}	
		//check authorization end	

	
		if ($request->isMethod('post')) 
		{
			$requestData 		= 	$request->all();
			
			$this->validate($request, [
										'test_series_type' => 'required|max:255|unique:test_series_types,test_series_type,'.$requestData['id']
									  ]);
					  
			$obj					= 	TestSeriesType::find($requestData['id']);
			$obj->test_series_type	=	@$requestData['test_series_type'];
			$obj->description		=	@$requestData['description'];
			
			$saved					=	$obj->save();
			
			if(!$saved)
			{
				return redirect()->back()->with('error', Config::get('constants.server_error'));
			}
			else
			{
				return Redirect::to('/admin/test_series_types')->with('success', 'Test Series Type'.Config::get('constants.edited'));
			}				
		}
		else
		{	
			if(isset($id) && !empty($id))
			{
				$id = $this->decodeString($id);	
				if(TestSeriesType::where('id', '=', $id)->exists()) 
				{
					$fetchedData = TestSeriesType::find($id);
					return view('Admin.test_series_type.edit_test_series_type', compact(['fetchedData']));
				}
				else
				{
					return Redirect::to('/admin/test_series_types')->with('error', 'Test Series Type'.Config::get('constants.not_exist'));
				}	
			}
			else
			{
				return Redirect::to('/admin/test_series_types')->with('error', Config::get('constants.unauthorized'));
			}		
		}				
	}	
}
