<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema; 
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Redirect;

//use App\Destination;
use App\Mail\CommonMail;
use Config;
use Cookie;

use Mail;
class ContactController extends Controller
{
	public function __construct(Request $request)
    {	
		/* $siteData = WebsiteSetting::where('id', '!=', '')->first();
		\View::share('siteData', $siteData); */
	}
	
	public function index(){
		
		return view('contact'); 
	}
	
	public function Contact(Request $request){
		$this->validate($request, [
                'name' => 'required',
                'email' => 'required',
                'g-recaptcha-response' => 'required|recaptcha'
              
            ]);
			$set = \App\Admin::where('id',1)->first();
			
			$mailmessage = '<b>Hi Admin,</b><br> You have a New Query<br><b>Name:</b> '.$request->name.'<br><b>Email:</b> '.$request->email.'<br><b>Phone:</b> '.$request->phone.'<br><b>Message:</b> '.$request->message;
		Mail::to($set->primary_email)->cc($set->primary_email)->send(new CommonMail($mailmessage, $request->subject, $set->primary_email));	
			 return back()->with('success', 'Thanks for sharing your interest. our team will respond to you with in 24 hours.');
	}
}
?>