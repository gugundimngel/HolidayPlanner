<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema; 
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Redirect;

use App\WebsiteSetting;
use App\SeoPage;
use App\Destination;
use App\Location;
use App\CmsPage;
use App\Package;
use App\User;
use App\PasswordResetLink;

use Illuminate\Support\Facades\Session;
use Config;
use Cookie;
use Mail;
use App\Mail\CommonMail;
use Swift_SmtpTransport;
use Swift_Mailer;

class HomeController extends Controller
{
	public function __construct(Request $request)
    {	
		$siteData = WebsiteSetting::where('id', '!=', '')->first();
		\View::share('siteData', $siteData);
	}
	
    public function coming_soon()
    {
       $hotelcodes = DB::connection('mysql2')->select("SELECT * FROM `grn_hotel_facs` group by name");
			
			foreach($hotelcodes as $list){
				 if(!\App\GrnFac::where('name', '=', $list->name)->exists()){
					$obj = new \App\GrnFac;
					$obj->name = $list->name;
					$obj->save();
					
					echo $list->name.'<br>';
				 }
			}
        return view('coming_soon');
    }
	public function under_construction()
    {
        return view('under_construction'); 
    }
	public function success()
    {
        return view('success'); 
    }
	
	public function Thanks()
    {
        return view('thanksagent'); 
    }
	
	public function updateverifyemail(Request $request, $token)
    {
       if(isset($token) && !empty($token)) 
		{
			$isexist = User::where('token',$token)->where('email',$request->email)->where('email_verify_status',0)->exists();
			if($isexist){
				$ee = User::where('token',$token)->where('email',$request->email)->where('email_verify_status',0)->first();
				$rr = User::find($ee->id);
				$rr->token = '';
				$rr->email_verify_status = 1;
				$save = $rr->save();
				if($save){
					$message = 'Verified Succesfully';
				}else{
					$message = 'Please type again';
				}
			}else{
				$message = 'This Verification code not found';
			}
		}
		return view('verified', compact(['message'])); 
    }
	public function forgotPassword(Request $request)
	{
		if ($request->isMethod('post')) 
		{
			$this->validate($request, [
										'email' => 'required|string|email|max:191|exists:users,email',
									  ]);
			
			
			$requestData 		= 	$request->all();
			
			$existance = PasswordResetLink::where('email', '=', @$requestData['email'])->where('expire', '=', 0)->first();
			
			if(!empty($existance)){
				
					echo json_encode(array('success'=>false, 'message'=>"We have already sent reset link into your email-id, so please check your Inbox and spam folder too."));
			}	

			$token = $this->generateRandomString();//token
				
			$obj				= 	new PasswordResetLink;
			$obj->email			=	@$requestData['email'];
			$obj->token			=	$token;

			$saved				=	$obj->save();
			
			if(!$saved)
			{
				echo json_encode(array('success'=>false, 'message'=>Config::get('constants.server_error')));
			}
			else
			{
				$set = \App\Admin::where('id',1)->first();
				$userData = User::select('id', 'first_name', 'last_name')->where('email', '=', @$requestData['email'])->first();
				
				$link = \URL::to('/').'/reset_link/'.$token;
				
				$replace = array('{logo}', '{customer_name}', '{link}', '{year}');					
				$replace_with = array(\URL::to('/public/img/profile_imgs').'/'.@$set->logo, @$userData->first_name.' '.@$userData->last_name, $link, date('Y'));
		
				$this->send_email_template($replace, $replace_with, 'forgot-password', @$requestData['email'],'Reset Password Request',$set->primary_email);
				
				echo json_encode(array('success'=>true, 'message'=>"We have sent Reset link into your email-id, please check the same."));
			
			}				
		}
		die;
		//return view('forgot_password');		
	}
	
	public function resetLink(Request $request, $token = NULL)
	{
		if ($request->isMethod('post')) 
		{
			$this->validate($request, [
										'email' => 'required|string|email|max:191',
										'fpassword' => 'required|string|min:6|max:12|confirmed',
										'fpassword_confirmation' => 'required|string|min:6|max:12'
									  ],[
									  'fpassword.required'=>'Password is required',
									  'fpassword.min'=>'The password must be at least 6 characters.',
									  'fpassword.max'=>'The password must be at least 12 characters.',
									  'fpassword_confirmation.required'=>'Password is required',
									  'fpassword_confirmation.min'=>'The password must be at least 6 characters.',
									  'fpassword_confirmation.max'=>'The password must be at least 12 characters.',
									  'fpassword.confirmed'=>'The password confirmation does not match.',
									  ]);
			
			
			$requestData 		= 	$request->all();
			
			$userData = User::select('id')->where('email', '=', trim(@$requestData['email']))->first();
			
			$obj				= 	User::find(@$userData->id);
			$obj->password		=	Hash::make(trim($requestData['fpassword']));

			$saved				=	$obj->save();	
			
			if(!$saved)
			{
				return redirect()->back()->with('error', Config::get('constants.server_error'));
			}
			else
			{
				$objReset				= 	PasswordResetLink::find(@$requestData['id']);
				$objReset->expire		=	1; //expired
				
				$savedReset				=	$objReset->save();
				
				return Redirect::to('/login')->with('success', 'Your Password has been changed successfully.');
			}					
		}
		else
		{	
			$data = PasswordResetLink::where('token', '=', trim(@$token))->where('expire', '=', 0)->first();
			
			if(empty($data)){
				return Redirect::to('/login')->with('error', 'Reset Link has been expired, so you can not proceed further.');
			} 
			else 
			{
				if($data->count() == 0)
				{
					return Redirect::to('/login')->with('error', 'Reset Link has been expired, so you can not proceed further.');
				}
			}		
		}
		return view('reset_link',compact(['data']));		
	}
	public function sicaptcha(Request $request)
    {
		 $code=$request->code;
		
		$im = imagecreatetruecolor(50, 24);
		$bg = imagecolorallocate($im, 37, 37, 37); //background color blue
		$fg = imagecolorallocate($im, 255, 241, 70);//text color white
		imagefill($im, 0, 0, $bg);
		imagestring($im, 5, 5, 5,  $code, $fg);
		header("Cache-Control: no-cache, must-revalidate");
		header('Content-type: image/png');
		imagepng($im);
		imagedestroy($im);
	
    }
	
		public static function hextorgb ($hexstring){ 
			$integar = hexdec($hexstring); 
						return array( "red" => 0xFF & ($integar >> 0x10),
			"green" => 0xFF & ($integar >> 0x8),
			"blue" => 0xFF & $integar
			);
		}
	
	 public function Searchtour(Request $request)
    {
		$client_id = env('TRAVEL_CLIENT_ID', '');
	    $durl = env('TRAVEL_API_URL', '')."searchtour?term=".$request->term."&client_id=".$client_id; 
		$searcdata = $this->curlRequest($durl,'GET','');
		echo $searcdata; 
		die;
    } 
	
	public function Page(Request $request, $slug= null)
    {
		$pagedata = CmsPage::where('slug',$slug)->first();
		
		 return view('Frontend.cms.index', compact(['pagedata']));
    } 
	
	public function index(Request $request)
    {
        
		//$auth = $this->GetAuthenticate();
		return view('index');
    }
	
	public function package(Request $request){
	    
		$client_id = env('TRAVEL_CLIENT_ID', '');
		$seoDetails = SeoPage::where('page_slug', '=', 'home')->first();
		/*Domestic Tour*/
		$query = Location::where('dest_type', '=', 'domestic')->where('is_active', '=', '1');
				
		$domesticresponse 	= 	$query->with(['mypackage','desmedia'])->sortable(['id'=>'DESC'])->paginate(10);

		/*Domestic Tour*/
	
		/*International Tour*/
		
		$query = Location::where('dest_type', '=', 'international')->where('is_active', '=', '1');
				
		$internationalesponse 	= 	$query->with(['mypackage','desmedia'])->sortable(['id'=>'DESC'])->paginate(10);
		
		/*International Tour*/
		
		/*Popular Tour*/
		$query = $Packages = Package::where('is_popular', '=', 1)->with(['media','packloc']);
// 		$query = $Packages = Package::where('is_popular', '=', 1)->get();
// 		dd($query);
		$co = $query->count();
		$populartours = $query->paginate(12);	
		/*Popular Tour*/
		
		/*holidaytype Tour*/
		$hurl = env('TRAVEL_API_URL', '')."holidaytype?client_id=".$client_id; 
		$holidaytypetours = $this->GetcurlRequest($hurl,'GET','');
		/*holidaytype Tour*/
        return view('package', compact(['seoDetails','domesticresponse','internationalesponse','populartours','holidaytypetours', 'co']));
	} 

	public function singlepack(Request $request)
    {
		return view('singlepackage');
    }	 
	
	public function packdetails(Request $request)
    {
		return view('packdetails'); 
    }
	
	public function myprofile(Request $request)
    {
		return view('profile');    
    }	
}
