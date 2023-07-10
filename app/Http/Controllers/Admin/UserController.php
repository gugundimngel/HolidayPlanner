<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

use App\Admin;
use App\User;
use App\UserRole;
use App\UserType;
 
use Auth;
use Config;
use Carbon\Carbon;

class UserController extends Controller
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
			$check = $this->checkAuthorizationAction('user_management', $request->route()->getActionMethod(), Auth::user()->role);
			if($check)
			{
				return Redirect::to('/admin/dashboard')->with('error',config('constants.unauthorized'));
			}	
		//check authorization end
	
		$query 		= User::where('id', '!=', ''); 
		  
		$totalData 	= $query->count();	//for all data
if ($request->has('first_name')) 
		{
			$first_name 		= 	$request->input('first_name'); 
			if(trim($first_name) != '')
			{
				$query->where('first_name', '=', @$first_name);
			}
		}
		if ($request->has('last_name')) 
		{
			$last_name 		= 	$request->input('last_name'); 
			if(trim($last_name) != '')
			{
				$query->where('last_name', '=', @$last_name);
			}
		}
		if ($request->has('from')) 
		{
			$from 		= 	$request->input('from'); 
			if(trim($from) != '')
			{
				$query->whereDate('created_at', '>=', date('Y-m-d',strtotime(@$from)));
			}
		}if ($request->has('to')) 
		{
			$to 		= 	$request->input('to'); 
			if(trim($to) != '')
			{
				$query->whereDate('created_at', '<=', date('Y-m-d',strtotime(@$to)));
			}
		}if ($request->has('email')) 
		{
			$email 		= 	$request->input('email'); 
			if(trim($email) != '')
			{
				$query->where('email', '=', @$email);
			}
		}
		if ($request->has('status')) 
		{
			$status 		= 	$request->input('status'); 
			if(trim($email) != '')
			{
				$query->where('status', '=', @$status);
			}
		}
		if ($request->has('status') || $request->has('email')|| $request->has('to')|| $request->has('from')|| $request->has('last_name')|| $request->has('first_name')) 
		{
			$totalData 	= $query->count();//after search
		}
		$lists		= $query->get();
		
		return view('Admin.users.index',compact(['lists', 'totalData']));	

		//return view('Admin.users.index');	 
	}
	
	public function sendPassword(Request $request, $id = Null){
		$id = $this->decodeString($id);
		if(User::where('id', '=', $id)->exists()) 
		{
			
			$customer = User::where('id', '=', $id)->first();
				DB::table('password_resets')->insert([
					'email' => $customer->email,
					'token' => str_random(60),
					'created_at' => Carbon::now()
				]);
				//Get the token just created above
				$tokenData = DB::table('password_resets')
					->where('email', $customer->email)->first();

				if ($this->sendResetEmail($customer->email, $tokenData->token)) {
					return redirect()->back()->with('success', trans('A reset link has been sent to your email address.'));
				} else {
					return redirect()->back()->with('error', 'A Network Error occurred. Please try again.');
					
				}
		}
	}
	
	public function create(Request $request)
	{
			//check authorization start	
			$check = $this->checkAuthorizationAction('user_management', $request->route()->getActionMethod(), Auth::user()->role);
			if($check)
			{
				return Redirect::to('/admin/dashboard')->with('error',config('constants.unauthorized'));
			}	
		//check authorization end
		$usertype 		= UserType::all();
		return view('Admin.users.create',compact(['usertype']));	
	}
	
	public function store(Request $request)
	{
		//check authorization start	
			$check = $this->checkAuthorizationAction('user_management', $request->route()->getActionMethod(), Auth::user()->role);
			if($check)
			{
				return Redirect::to('/admin/dashboard')->with('error',config('constants.unauthorized'));
			}	
		//check authorization end
		if ($request->isMethod('post')) 
		{
			$this->validate($request, [
										'first_name' => 'required|max:255',
										'last_name' => 'required|max:255',
										'email' => 'required|max:255|unique:admins',
										'password' => 'required|max:255',
										'phone' => 'required|max:255',
										'role' => 'required|max:255',
										'profile_img' => 'required|max:255'
									  ]);
			
			$requestData 		= 	$request->all();
			
			$obj				= 	new Admin;
			$obj->first_name	=	@$requestData['first_name'];
			$obj->last_name		=	@$requestData['last_name'];
			$obj->email			=	@$requestData['email'];
			$obj->password	=	Hash::make(@$requestData['password']);
			$obj->role	=	@$requestData['role'];
			$obj->phone	=	@$requestData['phone'];
			/* Profile Image Upload Function Start */						  
					if($request->hasfile('profile_img')) 
					{	
						$profile_img = $this->uploadFile($request->file('profile_img'), Config::get('constants.profile_imgs'));
					}
					else
					{
						$profile_img = NULL;
					}		
				/* Profile Image Upload Function End */	
			$obj->profile_img			=	@$profile_img;
			$saved				=	$obj->save();  
			
			if(!$saved)
			{
				return redirect()->back()->with('error', Config::get('constants.server_error'));
			}
			else
			{
				return Redirect::to('/admin/users')->with('success', 'User added Successfully');
			}				
		}	

		return view('Admin.users.create');	
	}
	
	public function edit(Request $request, $id = NULL)
	{
		//check authorization start	
			$check = $this->checkAuthorizationAction('user_management', $request->route()->getActionMethod(), Auth::user()->role);
			if($check)
			{
				return Redirect::to('/admin/dashboard')->with('error',config('constants.unauthorized'));
			}	
		//check authorization end
		$usertype 		= UserType::all();
		if ($request->isMethod('post')) 
		{
			$requestData 		= 	$request->all();
			
			$this->validate($request, [										
										'first_name' => 'required|max:255',
										'last_name' => 'required|max:255',
							
										'email' => 'required|max:255|unique:admins,email,'.$requestData['id'],
										'phone' => 'required|max:255',
						
										
									  ]);
								  					  
			$obj							= 	User::find(@$requestData['id']);
						
			$obj->first_name				=	@$requestData['first_name'];
			$obj->last_name					=	@$requestData['last_name'];
			$obj->email						=	@$requestData['email'];
			if(!empty(@$requestData['password']))
				{		
					$obj->password				=	Hash::make(@$requestData['password']);
					//$objAdmin->decrypt_password		=	@$requestData['password'];
				}
			$obj->role						=	@$requestData['role'];
			$obj->phone						=	@$requestData['phone'];
			
			/* Profile Image Upload Function Start */						  
			if($request->hasfile('profile_img')) 
			{	
				/* Unlink File Function Start */ 
					if($requestData['profile_img'] != '')
						{
							$this->unlinkFile($requestData['old_profile_img'], Config::get('constants.profile_imgs'));
						}
				/* Unlink File Function End */
				
				$profile_img = $this->uploadFile($request->file('profile_img'), Config::get('constants.profile_imgs'));
			}
			else
			{
				$profile_img = @$requestData['old_profile_img'];
			}		
		/* Profile Image Upload Function End */
			$obj->profile_img			=	@$profile_img;
			$saved							=	$obj->save();
			
			if(!$saved)
			{
				return redirect()->back()->with('error', Config::get('constants.server_error'));
			}
			
			else
			{
				return Redirect::to('/admin/users')->with('success', 'User Edited Successfully');
			}				
		}

		else
		{	
			if(isset($id) && !empty($id))
			{
				
				$id = $this->decodeString($id);	
				if(User::where('id', '=', $id)->exists()) 
				{
					$fetchedData = User::find($id);
					return view('Admin.users.edit', compact(['fetchedData', 'usertype']));
				}
				else
				{
					return Redirect::to('/admin/users')->with('error', 'User Not Exist');
				}	
			}
			else
			{
				return Redirect::to('/admin/users')->with('error', Config::get('constants.unauthorized'));
			}		
		}	
		
	}
	
	
	public function show(Request $request,$id = Null)
	{
		if(isset($id) && !empty($id))
			{
				
				$id = $this->decodeString($id);	
				if(User::where('id', '=', $id)->exists()) 
				{
					$fetchedData = User::find($id);
					return view('Admin.users.view', compact(['fetchedData']));
				}
				else
				{
					return Redirect::to('/admin/users')->with('error', 'User Not Exist');
				}	
			}
			else
			{
				return Redirect::to('/admin/users')->with('error', Config::get('constants.unauthorized'));
			}			
	}
	public function clientlist(Request $request)
	{
		//check authorization start	
			$check = $this->checkAuthorizationAction('user_management', $request->route()->getActionMethod(), Auth::user()->role);
			if($check)
			{
				return Redirect::to('/admin/dashboard')->with('error',config('constants.unauthorized'));
			}	
		//check authorization end
		$query 		= Admin::where('role', '=', '7');
		
		$totalData 	= $query->count();	//for all data

		$lists		= $query->sortable(['id' => 'desc'])->paginate(config('constants.limit'));
		
		return view('Admin.users.clientlist',compact(['lists', 'totalData']));	

		//return view('Admin.users.index');	  
	}
	public function createclient(Request $request) 
	{
		//check authorization start	
			$check = $this->checkAuthorizationAction('user_management', $request->route()->getActionMethod(), Auth::user()->role);
			if($check)
			{
				return Redirect::to('/admin/dashboard')->with('error',config('constants.unauthorized'));
			}	
		//check authorization end
		return view('Admin.users.createclient');	
	}
	
	public function storeclient(Request $request)
	{
		//check authorization start	
			$check = $this->checkAuthorizationAction('user_management', $request->route()->getActionMethod(), Auth::user()->role);
			if($check)
			{
				return Redirect::to('/admin/dashboard')->with('error',config('constants.unauthorized'));
			}	
		//check authorization end
		if ($request->isMethod('post')) 
		{
			$this->validate($request, [
										'company_name' => 'required|max:255',
										'first_name' => 'required|max:255',
										'last_name' => 'required|max:255',
										'company_website' => 'required|max:255',
										'email' => 'required|max:255|unique:admins',
										'password' => 'required|max:255',
										'phone' => 'required|max:255',
										'profile_img' => 'required|max:255'
									  ]);
			
			$requestData 		= 	$request->all();
			
			$obj				= 	new Admin;
			$obj->company_name	=	@$requestData['company_name'];
			$obj->first_name	=	@$requestData['first_name'];
			$obj->last_name		=	@$requestData['last_name'];
			$obj->company_website		=	@$requestData['company_website'];
			$obj->email			=	@$requestData['email'];
			$obj->password	=	Hash::make(@$requestData['password']);	
			$obj->phone	=	@$requestData['phone'];
			$obj->country	=	@$requestData['country'];
			$obj->city	=	@$requestData['city'];
			$obj->gst_no	=	@$requestData['gst_no']; 
			$obj->role	=	7;
			/* Profile Image Upload Function Start */						  
					if($request->hasfile('profile_img')) 
					{	
						$profile_img = $this->uploadFile($request->file('profile_img'), Config::get('constants.profile_imgs'));
					}
					else
					{
						$profile_img = NULL;
					}		
				/* Profile Image Upload Function End */	
			$obj->profile_img			=	@$profile_img;
			$saved				=	$obj->save();  
			
			if(!$saved)
			{
				return redirect()->back()->with('error', Config::get('constants.server_error'));
			}
			else
			{
				return Redirect::to('/admin/users/clientlist')->with('success', 'Client Added Successfully');
			}				
		}	

		return view('Admin.users.createclient');	
	}
	
	public function editclient(Request $request, $id = NULL)
	{
		//check authorization start	
			$check = $this->checkAuthorizationAction('user_management', $request->route()->getActionMethod(), Auth::user()->role);
			if($check)
			{
				return Redirect::to('/admin/dashboard')->with('error',config('constants.unauthorized'));
			}	
		//check authorization end
		$usertype 		= UserType::all();
		if ($request->isMethod('post')) 
		{
			$requestData 		= 	$request->all();
			
			$this->validate($request, [	
										'company_name' => 'required|max:255',
										'first_name' => 'required|max:255',
										'last_name' => 'required|max:255',
										'company_website' => 'required|max:255',
										'email' => 'required|max:255|unique:admins,email,'.$requestData['id'],
										'password' => 'required|max:255',
										'phone' => 'required|max:255'
									  ]);
								  					  
			$obj							= 	Admin::find(@$requestData['id']);
			
			$obj->company_name	=	@$requestData['company_name']; 
			$obj->first_name	=	@$requestData['first_name'];
			$obj->last_name		=	@$requestData['last_name'];
			$obj->company_website		=	@$requestData['company_website'];
			$obj->email			=	@$requestData['email'];
			$obj->password	=	Hash::make(@$requestData['password']);				
						
			if(!empty(@$requestData['password']))
				{		
					$obj->password				=	Hash::make(@$requestData['password']);
					//$objAdmin->decrypt_password		=	@$requestData['password'];
				}
			$obj->phone	=	@$requestData['phone'];
			$obj->country	=	@$requestData['country'];
			$obj->city	=	@$requestData['city'];
			$obj->gst_no	=	@$requestData['gst_no']; 
			$obj->role	=	7;
			
			/* Profile Image Upload Function Start */						  
			if($request->hasfile('profile_img')) 
			{	
				/* Unlink File Function Start */ 
					if($requestData['profile_img'] != '')
						{
							$this->unlinkFile($requestData['old_profile_img'], Config::get('constants.profile_imgs'));
						}
				/* Unlink File Function End */
				
				$profile_img = $this->uploadFile($request->file('profile_img'), Config::get('constants.profile_imgs'));
			}
			else
			{
				$profile_img = @$requestData['old_profile_img'];
			}		
		/* Profile Image Upload Function End */
			$obj->profile_img			=	@$profile_img;
			$saved							=	$obj->save();
			
			if(!$saved)
			{
				return redirect()->back()->with('error', Config::get('constants.server_error'));
			}
			
			else
			{
				return Redirect::to('/admin/users/clientlist')->with('success', 'Client Edited Successfully');
			}				
		}

		else
		{	
			if(isset($id) && !empty($id))
			{
				
				$id = $this->decodeString($id);	
				if(Admin::where('id', '=', $id)->exists()) 
				{
					$fetchedData = Admin::find($id);
					return view('Admin.users.editclient', compact(['fetchedData', 'usertype']));
				}
				else
				{
					return Redirect::to('/admin/users/clientlist')->with('error', 'Client Not Exist');
				}	
			}
			else
			{
				return Redirect::to('/admin/users/clientlist')->with('error', Config::get('constants.unauthorized'));
			}		
		}	 
		 
	}
	
	
	public function excelReport(Request $request){
		$where = '';
		
		$query 		= User::where('id', '!=', ''); 
		  
		$totalData 	= $query->count();	//for all data

		if ($request->has('first_name')) 
		{
			$first_name 		= 	$request->input('first_name'); 
			if(trim($first_name) != '')
			{
				$query->where('first_name', '=', @$first_name);
			}
		}
		if ($request->has('last_name')) 
		{
			$last_name 		= 	$request->input('last_name'); 
			if(trim($last_name) != '')
			{
				$query->where('last_name', '=', @$last_name);
			}
		}
		if ($request->has('from')) 
		{
			$from 		= 	$request->input('from'); 
			if(trim($from) != '')
			{
				$query->whereDate('created_at', '>=', date('Y-m-d',strtotime(@$from)));
			}
		}if ($request->has('to')) 
		{
			$to 		= 	$request->input('to'); 
			if(trim($to) != '')
			{
				$query->whereDate('created_at', '<=', date('Y-m-d',strtotime(@$to)));
			}
		}if ($request->has('email')) 
		{
			$email 		= 	$request->input('email'); 
			if(trim($email) != '')
			{
				$query->where('email', '=', @$email);
			}
		}
		if ($request->has('status')) 
		{
			$status 		= 	$request->input('status'); 
			if(trim($email) != '')
			{
				$query->where('status', '=', @$status);
			}
		}
		if ($request->has('status') || $request->has('email')|| $request->has('to')|| $request->has('from')|| $request->has('last_name')|| $request->has('first_name')) 
		{
			$totalData 	= $query->count();//after search
		}
		$lists		= $query->get();
		
		$finalexcel = array();
			$firstheading = array('First Name','Last Name','Email','Mobile','GST Number','Address','City','State','Country','Pincode','Status','Entry Date');
			array_push($finalexcel,$firstheading);
		if(isset($lists)){
			foreach($lists as $lis){
				$status = 'Inactive';
			if($lis->status == 1){
				$status = 'Active';
			}
				$exceldata = array($lis->first_name,$lis->last_name,$lis->email,$lis->phone,$lis->gst_no,$lis->address,$lis->city,$lis->state,$lis->country,$lis->zip,$lis->status,date('h:i A, d m Y', strtotime($lis->created_at)));
				array_push($finalexcel,$exceldata);
			}
			$this->exports_data($finalexcel,date('Y-m-d')."_Users_Report");
		}
		//return view('Agent.transactionlog.index',compact(['lists'])); 
	}
}
