<?php
namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema; 
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Redirect;

use App\Lead;
use App\Admin;
use App\Agent;
use App\WebsiteSetting;
use App\SeoPage;
use App\Inclusion;
use App\Topinclusion;
use App\Exclusion;
use App\Holidaytype;
use App\City;
use App\Contact;
use App\Package;
use App\Hotel;
use App\Destination;
use App\TaxRate;

use Auth;
use Config;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:agents');
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {	

		/* Client data */
        return view('Agent.dashboard');
    }
	
	public function myProfile(Request $request){
		/* Get all Select Data */	
			$countries = array();		
		/* Get all Select Data */
		$id = Auth::user()->id;	
			$fetchedData = Agent::find($id);
		
			return view('Agent.profile', compact(['fetchedData', 'countries']));
	}
	public function editProfile(Request $request)
	{
		/* Get all Select Data */	
			$countries = array();		
		/* Get all Select Data */
		
		if ($request->isMethod('post')) 
		{	
			$requestData 		= 	$request->all();
			//echo '<pre>'; print_r($requestData); die;
			$this->validate($request, [
				'first_name' => 'required',
				'last_name' => 'nullable',
				//'country' => 'required',
				//'phone' => 'required',
				
			  ]);
									  
			/* Profile Image Upload Function Start */						  
				if($request->hasfile('profile_img')) 
				{	
					/* Unlink File Function Start */ 
						if($requestData['old_profile_img'] != '')
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

				if($request->hasfile('profile_logo')) 
				{	
					/* Unlink File Function Start */ 
						if($requestData['old_profile_logo'] != '')
							{
								$this->unlinkFile($requestData['old_profile_logo'], Config::get('constants.profile_imgs'));
							}
					/* Unlink File Function End */
					
					$profile_logo = $this->uploadFile($request->file('profile_logo'), Config::get('constants.profile_imgs'));
				}
				else
				{
					$profile_logo = @$requestData['old_profile_logo'];
				}	
			/* Profile Image Upload Function End */						  
									  
			if($request->hasfile('company_pancard')) 
			{	
				/* Unlink File Function Start */ 
				if($requestData['old_company_pancard'] != '')
					{
						$this->unlinkFile($requestData['old_company_pancard'], Config::get('constants.agentdoc'));
					}
			/* Unlink File Function End */
				$company_pancard = $this->uploadFile($request->file('company_pancard'), Config::get('constants.agentdoc'));
			}else
				{
					$company_pancard = @$requestData['old_company_pancard'];
				}
			if($request->hasfile('aadhaar_card')) 
			{	
				/* Unlink File Function Start */ 
				if($requestData['old_aadhaar_card'] != '')
					{
						$this->unlinkFile($requestData['old_aadhaar_card'], Config::get('constants.agentdoc'));
					}
			/* Unlink File Function End */
				$aadhaar_card = $this->uploadFile($request->file('aadhaar_card'), Config::get('constants.agentdoc'));
			}else
			{
				$aadhaar_card = @$requestData['old_company_pancard'];
			}
							  					  
			$obj							= 	Agent::find(Auth::user()->id);
			$obj->sur_name 					= 	@$requestData['salute_name'];
			$obj->first_name				=	@$requestData['first_name'];
			$obj->last_name					=	@$requestData['last_name'];
			if($requestData['password'] != ''){
			$obj->password					= 	Hash::make(@$requestData['password']);
			}
			$obj->decrypt_password 			= 	@$requestData['password'];
			$obj->mobile_no					= 	@$requestData['mobile_no'];
			$obj->phone						=  	@$requestData['phone'];
			$obj->country					=	@$requestData['country'];
			$obj->state						=	@$requestData['state'];
			$obj->city						=	@$requestData['city'];
			$obj->address					=	@$requestData['address'];
			$obj->address2					=	@$requestData['address2'];
			$obj->zip						=	@$requestData['zip'];
			$obj->company_name				=	@$requestData['company_name'];
			$obj->company_website			=	@$requestData['company_website'];
			$obj->logo						=	@$profile_logo;
			$obj->faxno 					= 	@$requestData['faxno'];
			$obj->profile_img				=	@$profile_img;
			$obj->contact_name 				= 	@$requestData['contact_name'];
			$obj->contact_no				= 	@$requestData['contact_no'];
			$obj->gst_no					= 	@$requestData['gst_no'];
			$obj->pan_no					= 	@$requestData['pan_no'];
			$obj->pan_name					= 	@$requestData['pan_name'];
			$obj->pan_address				= 	@$requestData['pan_address'];
			$obj->company_pancard 			= 	@$company_pancard;
			$obj->aadhaar_card 				= 	@$aadhaar_card;
			$saved							=	$obj->save();
			
			if(!$saved)
			{
				return redirect()->back()->with('error', Config::get('constants.server_error'));
			}
			else
			{
				return Redirect::to('/agent/profile')->with('success', 'Your Profile has been edited successfully.');
			}		
		}
		else
		{	
			$id = Auth::user()->id;	
			$fetchedData = Agent::find($id);
		
			return view('Agent.edit_profile', compact(['fetchedData', 'countries']));
		}	
	}	
	/**
     * Change password and Logout automatiaclly.
     *
     * @return \Illuminate\Http\Response
     */
	public function change_password(Request $request)
	{
		if ($request->isMethod('post')) 
		{
			$this->validate($request, [
										'old_password' => 'required|min:6',
										'password' => 'required|confirmed|min:6',
										'password_confirmation' => 'required|min:6'
									  ]);
			
			
			$requestData 	= 	$request->all();
			$admin_id = Auth::user()->id;
			
			$fetchedData = Agent::where('id', '=', $admin_id)->first();
			if(!empty($fetchedData))
				{
					if($admin_id == trim($requestData['admin_id']))
						{
							 if (!(Hash::check($request->get('old_password'), Auth::user()->password))) 
								{
									return redirect()->back()->with("error","Your current password does not matches with the password you provided. Please try again.");
								}
							else
								{
									$admin = Agent::find($requestData['admin_id']);
									$admin->password = Hash::make($requestData['password']);
									if($admin->save())
										{
											//Auth::guard('agents')->logout();
											//$request->session()->flush();
											
											return redirect('/agent/change_password')->with('success', 'Your Password has been changed successfully.');
										}
									else
										{
											return redirect()->back()->with('error', Config::get('constants.server_error'));
										}
								}	
						}
					else
						{
							return redirect()->back()->with('error', 'You can change the password only your account.');
						}	
				}	
			else
				{
					return redirect()->back()->with('error', 'User is not exist, so you can not change the password.');
				}	
		}
		return view('Agent.change_password');		
	}
	
	public function balance_refresh(){
		$balance = Agent::where('id', Auth::user()->id)->first();
		echo $balance->wallet;
		die;
	}
	public function credit_refresh(){
		$balance = Agent::where('id', Auth::user()->id)->first();
		echo $balance->credit_limit;
		die;
	}
	
	public function deleteAction(Request $request)
	{	
		$status 			= 	0;
		$method 			= 	$request->method();	
		if ($request->isMethod('post')) 
		{
			$requestData 	= 	$request->all();
			
			$requestData['id'] = trim($requestData['id']);
			$requestData['table'] = trim($requestData['table']);
			
			$role = Auth::user()->role;
				
				if(isset($requestData['id']) && !empty($requestData['id']) && isset($requestData['table']) && !empty($requestData['table'])) 
				{
					$tableExist = Schema::hasTable(trim($requestData['table']));
					
					if($tableExist)
					{
						$recordExist = DB::table($requestData['table'])->where('id', $requestData['id'])->exists();
						
						if($recordExist)
						{
							if($requestData['table'] == 'currencies'){
								$isexist	=	$recordExist = DB::table($requestData['table'])->where('id', $requestData['id'])->exists();
								if($isexist){
									$response	=	DB::table($requestData['table'])->where('id', @$requestData['id'])->delete();
								
									if($response) 
									{	
										$status = 1;	
										$message = 'Record has been deleted successfully.';
									} 
									else 
									{
										$message = Config::get('constants.server_error');
									}
								}else{
									$message = 'ID does not exist, please check it once again.';
								}
							}else{
								$response	=	DB::table($requestData['table'])->where('id', @$requestData['id'])->delete();
								
								if($response) 
								{	
									$status = 1;	
									$message = 'Record has been deleted successfully.';
								} 
								else 
								{
									$message = Config::get('constants.server_error');
								}
							}
						}
						else
						{
							$message = 'ID does not exist, please check it once again.';
						}		
					}
					else
					{
						$message = 'Table does not exist, please check it once again.';	
					}		
				} 
				else 
				{
					$message = 'Id OR Table does not exist, please check it once again.';		
				}
					
		} 
		else 
		{
			$message = Config::get('constants.post_method');
		}
		echo json_encode(array('status'=>$status, 'message'=>$message));
		die;
	}
	
	
}
