<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

use App\Admin;
use App\Destination;
use App\Location;
use App\UserType;
 
use Auth;
use Config;

class ManagedestinationController extends Controller
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
			$query 		= Destination::where('id','!=','' )->with(['user', 'myloc']); 
		 }else{	
			$query 		= Destination::where('user_id', '=', Auth::user()->id)->with(['user', 'myloc']);
		 }	
		
		$totalData 	= $query->count();	//for all data
		if ($request->has('dest_id')) 
		{
			$dest_id 		= 	$request->input('dest_id'); 
			if(trim($dest_id) != '')
			{
				$query->where('id', '=', @$dest_id);
			}
		}
		if ($request->has('name')) 
		{
			$name 		= 	$request->input('name'); 
			if(trim($name) != '')
			{
				$query->whereHas('myloc', function ($q) use($name){
					$q->where('name', 'LIKE', '%'.@$name.'%');
				});
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
		$lists		= $query->orderby('id','desc')->get();
		
		return view('Admin.managedestination.index',compact(['lists', 'totalData'])); 	
		
	}
	
	public function create(Request $request) 
	{
		//check authorization start	
			$check = $this->checkAuthorizationAction('holiday_package', $request->route()->getActionMethod(), Auth::user()->role);
			if($check)
			{
				return Redirect::to('/admin/dashboard')->with('error',config('constants.unauthorized'));
			}	
		//check authorization end
		
		$usertype 		= UserType::all();		
		return view('Admin.managedestination.create');
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
										'dest_type' => 'required|max:255',
										'destination' => 'required',
										'description' => 'required',
										//'image' => 'required',
										
										
										'is_active' => 'required|max:255'
									  ]);
			 
			$requestData 		= 	$request->all();
			$destdeta 		= Destination::where('user_id', '=', Auth::user()->id)->where('dest_id',$requestData['destination'])->first();
			if($destdeta){
				return redirect()->back()->with('error', 'Destination is already exist');
			}
			$obj				= 	new Destination;
			$obj->user_id	=	Auth::user()->id; 
			$obj->dest_type		=	@$requestData['dest_type'];
			$obj->dest_id		=	@$requestData['destination'];
			$obj->description	=	@$requestData['description'];			
			$obj->image_alt		=	@$requestData['image_alt'];			
			$obj->tour_policy	=	@$requestData['tour_policy'];
			$obj->dest_image	=	@$requestData['package_image_m_id'];
			$obj->is_active	=	@$requestData['is_active'];
		//	$obj->slug	=	$this->createSlug(Auth::user()->id,'destinations',@$requestData['dest_name']);
			
			// Destination Image Upload Function Start 						  
					/* if($request->hasfile('image')) 
					{	
						$dest_image = $this->uploadFile($request->file('image'), Config::get('constants.destination_img'));
					}
					else
					{ 
						$dest_image = NULL;
					} */		
				// Destination Image Upload Function End 
				
			//$obj->image			=	@$dest_image;
			$saved				=	$obj->save();  
			
			if(!$saved)
			{
				return redirect()->back()->with('error', Config::get('constants.server_error'));
			}
			else
			{
				return Redirect::to('/admin/destination')->with('success', 'Destination added Successfully');
			}				
		}	

	
	}
	
	public function edit(Request $request, $id = NULL)
	{			
		//check authorization end
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
										'dest_type' => 'required|max:255',
										'destination' => 'required',
										'description' => 'required',
										
										'is_active' => 'required|max:255'
									  ]);
									  
				$destdeta 		= Destination::where('user_id', '=', Auth::user()->id)->where('dest_id',$requestData['destination'])->where('id','!=',$requestData['id'])->first();
			if($destdeta){
				return redirect()->back()->with('error', 'Destination is already exist');
			}					  
			$obj				= 	Destination::find($requestData['id']);
			$obj->dest_type		=	@$requestData['dest_type'];
			$obj->dest_id		=	@$requestData['destination'];
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
				return Redirect::to('/admin/destination')->with('success', 'Destination Edited Successfully');
			}				
		}
		else
		{	
			if(isset($id) && !empty($id)) 
			{
				$id = $this->decodeString($id);	
				if(Destination::where('id', '=', $id)->exists()) 
				{
					$fetchedData = Destination::find($id);
					
					return view('Admin.managedestination.edit', compact(['fetchedData']));
				}
				else
				{
					return Redirect::to('/admin/destination')->with('error', 'Destination Not Exist');
				}	
			}
			else
			{
				return Redirect::to('/admin/destination')->with('error', Config::get('constants.unauthorized'));
			}		
		}				
	}
	
	
}
