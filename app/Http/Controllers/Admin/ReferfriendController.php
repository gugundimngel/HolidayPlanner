<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

use App\Admin;
use App\Referfriend;
 
use Auth; 
use Config;

class ReferfriendController extends Controller
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
			/* $check = $this->checkAuthorizationAction('holiday_package', $request->route()->getActionMethod(), Auth::user()->role);
			if($check)
			{
				return Redirect::to('/admin/dashboard')->with('error',config('constants.unauthorized'));
			}	
		//check authorization end
		
		 if(Auth::user()->role == 1){
			$query 		= Destination::where('id','!=','' )->with(['user']); 
		 }else{	
			$query 		= Destination::where('user_id', '=', Auth::user()->id);
		 }	
		
		$totalData 	= $query->count();	//for all data

		$lists		= $query->sortable(['id' => 'desc'])->paginate(config('constants.limit')); 
		
		return view('Admin.managedestination.index',compact(['lists', 'totalData'])); 	*/
		
		return view('Admin.referfriend.index'); 	
		
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
		return view('Admin.referfriend.create');
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
										'first_name' => 'required|max:255',
										'last_name' => 'required|max:255',
										'company_name' => 'required',
										'contact_display_name' => 'required',
										'contact_email' => 'required',
										'contact_phone' => 'required'
									  ]);
			
			$requestData 		= 	$request->all();
			 
			$obj				= 	new Referfriend; 
			//$obj->user_id	=	Auth::user()->id;   
			$obj->srname		=	@$requestData['srname'];
			$obj->first_name		=	@$requestData['first_name'];
			$obj->middle_name	=	@$requestData['middle_name'];			
			$obj->last_name		=	@$requestData['last_name'];			
			$obj->company_name	=	@$requestData['company_name'];
			$obj->contact_display_name	=	@$requestData['contact_display_name'];
			$obj->contact_email	=	@$requestData['contact_email'];
			$obj->contact_phone	=	@$requestData['contact_phone'];
			$obj->work_phone	=	@$requestData['work_phone'];
			$obj->website	=	@$requestData['website'];
			$obj->designation	=	@$requestData['designation'];
			$obj->department	=	@$requestData['department'];
			$obj->skype_name	=	@$requestData['skype_name'];
			$obj->facebook_name	=	@$requestData['facebook_name'];
			$obj->twitter_name	=	@$requestData['twitter_name'];
			$obj->linkedin_name	=	@$requestData['linkedin_name'];
			$obj->instagram_name	=	@$requestData['instagram_name'];
			$obj->youtube_name	=	@$requestData['youtube_name'];
			$obj->country	=	@$requestData['country'];
			$obj->address	=	@$requestData['address'];
			$obj->city	=	@$requestData['city'];
			$obj->zipcode	=	@$requestData['zipcode'];
			$obj->phone	=	@$requestData['phone'];
			//$obj->slug	=	$this->createSlug(Auth::user()->id,'destinations',@$requestData['dest_name']);
			
			$saved				=	$obj->save();  
			
			if(!$saved) 
			{
				return redirect()->back()->with('error', Config::get('constants.server_error'));
			}
			else
			{ 
				return Redirect::to('/admin/managecontact')->with('success', 'Contacts added Successfully');
			} 				
		}	
	} 
	
	/* public function edit(Request $request, $id = NULL)
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
										'dest_name' => 'required|max:255',
										'description' => 'required',
										
										'is_active' => 'required|max:255'
									  ]);
									  
									  
			$obj				= 	Destination::find($requestData['id']);
			$obj->dest_type		=	@$requestData['dest_type'];
			$obj->dest_name		=	@$requestData['dest_name'];
			$obj->description	=	@$requestData['description'];			
			$obj->image_alt		=	@$requestData['image_alt'];			
			$obj->tour_policy	=	@$requestData['tour_policy'];
			$obj->dest_image	=	@$requestData['package_image_m'];
			$obj->is_active	=	@$requestData['is_active'];		
			$obj->slug	=	$this->createSlug(Auth::user()->id,'destinations',@$requestData['dest_name'], $requestData['id']);			
			
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
	} */
	
	
}
