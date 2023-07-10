<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

use App\Admin;
use App\Exclusion;
use App\City;
 
use Auth;
use Config;
 //use DataTables;
class ManagecityController extends Controller
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
     * All Vendors.
     *
     * @return \Illuminate\Http\Response
     */
	public function index(Request $request)
	{
		//check authorization start	
			$check = $this->checkAuthorizationAction('holiday_package', $request->route()->getActionMethod(), Auth::user()->role);
			if($check)
			{
				return Redirect::to('/admin/dashboard')->with('error',config('constants.unauthorized'));
			}	
		//check authorization end
		
		if(Auth::user()->role == 1){
			$query 		= City::where('id','!=','')->with(['user']);
		}else{
			$query 		= City::where('user_id', '=', Auth::user()->id);
		}
		
		$totalData 	= $query->count();	//for all data
if ($request->has('cityid')) 
		{
			$inc_id 		= 	$request->input('cityid'); 
			if(trim($inc_id) != '')
			{
				$query->where('id', '=', @$inc_id);
			}
		} 
		
		if ($request->has('name')) 
		{
			$name 		= 	$request->input('name'); 
			if(trim($name) != '')
			{
				$query->where('name', 'LIKE', '%'.@$name.'%');
			} 
		}
		$lists		= $query->orderby('id','desc')->get();
		
		return view('Admin.managecity.index',compact(['lists', 'totalData']));  
	}
	
	/* public function fetchCities(Request $request)
	{
		//check authorization start	
			$check = $this->checkAuthorizationAction('holiday_package', $request->route()->getActionMethod(), Auth::user()->role);
			if($check)
			{
				//return Redirect::to('/admin/dashboard')->with('error',config('constants.unauthorized'));
			}	
		//check authorization end
		$cities = City::select([
                    'cities.id', 'cities.name',
        ]);
		
		if(Auth::user()->role == 1){
			$cities->where('id','!=','')->with(['user']);
		}else{
			$cities->where('user_id', '=', Auth::user()->id);
		}
		return Datatables::of($cities)
			->filter(function ($query) use ($request) {
			})
			 ->addColumn('action', function ($cities) {
				 return '<div class="nav-item dropdown action_dropdown">
										<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
										<div class="dropdown-menu">
											<a href="'.URL::to('/admin/cities/edit/'.base64_encode(convert_uuencode(@$cities->id))).'"><i class="fa fa-edit"></i> Edit</a>
											<a href="javascript:;" onClick="deleteAction('.$cities->id.', "cities")"><i class="fa fa-trash"></i> Delete</a>
										</div>
									</div>';
			 })->rawColumns(['action', 'id', 'name'])
                        ->setRowId(function($cities) {
                            return 'jobDtRow' . $cities->id;
                        })
                        ->make(true);
	} */
	 
	public function create(Request $request)
	{
		//check authorization start	
			$check = $this->checkAuthorizationAction('holiday_package', $request->route()->getActionMethod(), Auth::user()->role);
			if($check)
			{
				return Redirect::to('/admin/dashboard')->with('error',config('constants.unauthorized'));
			}	
		//check authorization end
		return view('Admin.managecity.create');
	} 
	
	public function store(Request $request)
	{
		//check authorization start	
			$check = $this->checkAuthorizationAction('holiday_package', $request->route()->getActionMethod(), Auth::user()->role);
			if($check)
			{
				return Redirect::to('/admin/dashboard')->with('error',config('constants.unauthorized'));
			}	
		//check authorization end
		if ($request->isMethod('post')) 
		{
			$this->validate($request, [
										'name' => 'required|max:255'
									  ]);
			
			$requestData 		= 	$request->all();
			
			$obj				= 	new City;
			$obj->user_id	=	Auth::user()->id;
			$obj->name	=	@$requestData['name'];
			
			$saved				=	$obj->save();  
			
			if(!$saved)
			{
				return redirect()->back()->with('error', Config::get('constants.server_error'));
			}
			else
			{
				return Redirect::to('/admin/cities')->with('success', 'City added Successfully');
			}				
		}	
		
	}
	
	public function edit(Request $request, $id = NULL)
	{			
		//check authorization start	
			$check = $this->checkAuthorizationAction('holiday_package', $request->route()->getActionMethod(), Auth::user()->role);
			if($check)
			{
				return Redirect::to('/admin/dashboard')->with('error',config('constants.unauthorized'));
			}	
		//check authorization end
	
		if ($request->isMethod('post')) 
		{
			$requestData 		= 	$request->all();
			
			$this->validate($request, [
										'name' => 'required|max:255'
									  ]);
									  
									  
			$obj				= 	City::find($requestData['id']);
			
			$obj->name			=	@$requestData['name'];
						
			$saved				=	$obj->save();
			
			if(!$saved)
			{
				return redirect()->back()->with('error', Config::get('constants.server_error'));
			}
			else
			{
				return Redirect::to('/admin/cities')->with('success', 'City Edited Successfully');
			}				
		}
		else
		{	
			if(isset($id) && !empty($id))
			{
				$id = $this->decodeString($id);	
				if(City::where('id', '=', $id)->exists()) 
				{
					$fetchedData = City::find($id);
					
					return view('Admin.managecity.edit', compact(['fetchedData']));
				}
				else 
				{
					return Redirect::to('/admin/cities')->with('error', 'City Not Exist');
				}	
			}
			else
			{
				return Redirect::to('/admin/cities')->with('error', Config::get('constants.unauthorized'));
			}		
		}				
	}
	 
	
}
