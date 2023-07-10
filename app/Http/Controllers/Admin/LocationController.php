<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

use App\Admin;
use App\Location;
 
use Auth;  
use Config;

class LocationController extends Controller
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
		$query 		= Location::where('id','!=','' );
		
		$totalData 	= $query->count();	//for all data
		if ($request->has('id')) 
		{
			$inc_id 		= 	$request->input('id'); 
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
		
		if ($request->has('dest_type')) 
		{
			$dest_type 		= 	$request->input('dest_type'); 
			if(trim($dest_type) != '')
			{
				$query->where('dest_type', '=', @$dest_type);
			} 
		}

		$lists		= $query->sortable(['id' => 'desc'])->paginate(config('constants.limit')); 
		
		return view('Admin.location.index',compact(['lists', 'totalData'])); 
		
		//return view('Admin.managecontact.index'); 	
		
	}
	
	public function create(Request $request) 
	{
		//check authorization start	
			/* $check = $this->checkAuthorizationAction('holiday_package', $request->route()->getActionMethod(), Auth::user()->role);
			if($check)
			{
				return Redirect::to('/admin/dashboard')->with('error',config('constants.unauthorized'));
			}	 
		//check authorization end
		
		$managecontact 		=  Managecontact::all();	 */	
		return view('Admin.location.create');
	}
	
	 public function store(Request $request)
	{
		//check authorization start	
			/* $check = $this->checkAuthorizationAction('holiday_package', $request->route()->getActionMethod(), Auth::user()->role);
			if($check)
			{
				return Redirect::to('/admin/dashboard')->with('error',config('constants.unauthorized'));
			}	 */
		//check authorization end
		if ($request->isMethod('post')) 
		{
			$this->validate($request, [
										'name' => 'required|max:255|unique:locations',
										'dest_type' => 'required|max:255',
										'description' => 'required',
									  ]);
			
			$requestData 		= 	$request->all();
			 
			$obj				= 	new Location; 
			//$obj->user_id	=	Auth::user()->id;   
			$obj->name		=	@$requestData['name'];
			$obj->dest_type		=	@$requestData['dest_type'];
			$obj->slug	=	$this->createlocSlug('locations',@$requestData['name']);
			$obj->description	=	@$requestData['description'];			
			$obj->image_alt		=	@$requestData['image_alt'];			
			$obj->tour_policy	=	@$requestData['tour_policy'];
			$obj->dest_image	=	@$requestData['package_image_m_id'];
			$obj->is_active	=	@$requestData['is_active'];
			$saved				=	$obj->save();  
			
			if(!$saved) 
			{
				return redirect()->back()->with('error', Config::get('constants.server_error'));
			}
			else
			{ 
				return Redirect::to('/admin/locations')->with('success', 'location added Successfully');
			} 				
		}	 
	} 
	
	 public function edit(Request $request, $id = NULL)
	{			
		//check authorization end
	//check authorization start	
			/* $check = $this->checkAuthorizationAction('holiday_package', $request->route()->getActionMethod(), Auth::user()->role);
			if($check)
			{
				return Redirect::to('/admin/dashboard')->with('error',config('constants.unauthorized'));
			} */	
		//check authorization end
		if ($request->isMethod('post')) 
		{
			$requestData 		= 	$request->all();
			
			$this->validate($request, [
										'name' => 'required|max:255|unique:locations,name,'.$requestData['id'],
										'dest_type' => 'required|max:255',
										'description' => 'required',
									  ]);
									  
									  
			$obj				= 	Location::find($requestData['id']);
			$obj->name		=	@$requestData['name'];
			$obj->dest_type		=	@$requestData['dest_type'];
			$obj->slug	=	$this->createlocSlug('locations',@$requestData['name'], $requestData['id']);
$obj->description	=	@$requestData['description'];			
			$obj->image_alt		=	@$requestData['image_alt'];			
			$obj->tour_policy	=	@$requestData['tour_policy'];
			$obj->dest_image	=	@$requestData['package_image_m_id'];
			$obj->is_active	=	@$requestData['is_active'];			
			$saved				=	$obj->save();
			
			if(!$saved)
			{
				return redirect()->back()->with('error', Config::get('constants.server_error'));
			}
			else
			{
				return Redirect::to('/admin/locations')->with('success', 'location Edited Successfully');
			}				
		}
		else
		{	 
			if(isset($id) && !empty($id)) 
			{
				$id = $this->decodeString($id);	 
				if(Location::where('id', '=', $id)->exists()) 
				{
					$fetchedData = Location::find($id);
					return view('Admin.location.edit', compact(['fetchedData']));
				}
				else
				{
					return Redirect::to('/admin/locations')->with('error', 'location Not Exist');
				}	
			}
			else
			{
				return Redirect::to('/admin/locations')->with('error', Config::get('constants.unauthorized'));
			}		
		}				
	} 
	
	
}
