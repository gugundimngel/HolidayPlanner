<?php
namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema; 
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Redirect;

use App\Agent;
use Illuminate\Support\Facades\Session;
use Config;
use Cookie;

class AgentController extends Controller
{
	public function __construct(Request $request)
    {	
		
	}
	
	public function signup(Request $request){
		$this->validate($request, [
					'company_name' => 'required|max:255|unique:agents,company_name',
					'aemail' => 'required|unique:agents,email',
					'apassword' => 'required|string|min:6|max:12|same:password_confirmation',
			],[
			'aemail.required' => 'Email is required',
			'aemail.unique' => 'Email is already exists',
			'apassword.required' => 'The password must be at least 6 characters.',
		  'apassword.min' => 'The password must be at least 6 characters.',
		  'apassword.max' => 'The password must be at least 12 characters.',
		  'apassword.confirmed' => 'The password confirmation does not match',
			]);
			$data = $request->all();
			
			if($request->hasfile('logo')) 
			{	
				$logo = $this->uploadFile($request->file('logo'), Config::get('constants.profile_imgs'));
			}
			if($request->hasfile('company_pancard')) 
			{	
				$company_pancard = $this->uploadFile($request->file('company_pancard'), Config::get('constants.agentdoc'));
			}if($request->hasfile('aadhaar_card')) 
			{	
				$aadhaar_card = $this->uploadFile($request->file('aadhaar_card'), Config::get('constants.agentdoc'));
			}
			$obj = new Agent;
			$obj->role = 2;
			$obj->first_name = @$data['first_name'];
			$obj->last_name = @$data['last_name'];
			$obj->email = @$data['aemail'];
			$obj->password = Hash::make(@$data['apassword']);
			$obj->decrypt_password = @$data['apassword'];
			$obj->phone = @$data['phone'];
			$obj->mobile_no = @$data['mobile_no'];
			$obj->country = @$data['country'];
			$obj->state = @$data['state'];
			$obj->city = @$data['city'];	
			$obj->address = @$data['address'];
			$obj->address2 = @$data['address2'];
			$obj->zip = @$data['zip'];
			$obj->company_name = @$data['company_name'];
			$obj->status = 0;
			$obj->logo = @$logo;
			$obj->faxno = @$data['faxno'];
			$obj->sur_name = @$data['salute_name'];
			$obj->contact_name = @$data['contact_name'];
			$obj->contact_no = @$data['contact_no'];
			$obj->company_pancard = @$company_pancard;
			$obj->aadhaar_card = @$aadhaar_card;
			
			$saved							=	$obj->save();
			//$result = substr($data['city'], 0, 3);
			$od = Agent::find($obj->id);
			/* if($result != ''){
				$od->username = strtoupper($result).str_pad(@$obj->id, 5, '0', STR_PAD_LEFT);
				$od->username = strtoupper($result).str_pad(@$obj->id, 5, '0', STR_PAD_LEFT);
			}else{ */
				//$od->username = strtoupper($data['city']).str_pad(@$obj->id, 5, '0', STR_PAD_LEFT);
				$od->username = 'ZAP'.$obj->id.date('mY');
			//}
			$saved							=	$od->save();
			/*Welecome Email to customer*/
				$set = \App\Admin::where('id',1)->first();
				$userData = \App\Agent::select('id', 'decrypt_password', 'username', 'first_name', 'last_name','email')->where('id', '=', @$obj->id)->first();
				
					 $replace = array('{logo}', '{customer_name}', '{support_mail}', '{company_name}');					
					$replace_with = array(\URL::to('/public/img/profile_imgs').'/'.@$set->logo, @$userData->first_name.' '.@$userData->last_name, @$set->b2b_email, @$set->company_name); 
		
					$this->send_email_template($replace, $replace_with, 'welcome-mail-agent', @$userData->email,'Welcome to Holiday Planner Family!',$set->primary_email);
				/*Welecome Email to customer*/
				/*Welecome Email to admin*/
				
				
					 $replace = array('{logo}', '{customer_name}', '{username}', '{email}', '{phone}', '{company_name}');					
					$replace_with = array(\URL::to('/public/img/profile_imgs').'/'.@$set->logo, @$userData->first_name.' '.@$userData->last_name, @$userData->username, @$userData->email, @$userData->phone, @$set->company_name); 
		
					$this->send_email_template($replace, $replace_with, 'welcome-mail-agent', @$set->primary_email,'Welcome to Holiday Planner Family!',$set->primary_email);
				
				/*Welecome Email to admin*/
			if(!$saved)
			{
				return redirect()->back()->with('error', Config::get('constants.server_error'));
			}
			else
			{
				return Redirect::to('/agent/thanks')->with('success', 'Your Profile has been submitted successfully.');
			}	
	}
	
	
}
?>