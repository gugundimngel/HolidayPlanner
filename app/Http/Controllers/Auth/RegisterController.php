<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

use Config;
use DB;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
		
        return Validator::make($data, [
            'jaName' => 'required|string|max:255',
            'registerEmail' => 'required|string|email|max:191|unique:users,email',
			'password' => 'required|confirmed|string|min:6|max:12',
			'password_confirmation' => 'required',
			'cc' => 'required',
        ], [
				'cc.required' => 'The field is required.',
				'jaName.required' => 'The Name field is required.',
				'registerEmail.required' => 'The email field is required.',
				'registerEmail.email' => 'The email must be a valid email address.',
				'password.required' => 'The password field is required.',
				'password.min' => 'The password must be at least 6 characters.',
				'password.max' => 'The password may not be greater than 10 characters.',
			]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    public function register(Request $request)
    {
		$this->validate($request, [
			   'jaName' => 'required|string|max:255',
            'registerEmail' => 'required|string|email|max:191|unique:users,email',
			'password' => 'required|confirmed|string|min:6|max:12',
			'password_confirmation' => 'required',
			'cc' => 'required',
									  ],[
				'cc.required' => 'The field is required.',
				'jaName.required' => 'The Name field is required.',
				'registerEmail.required' => 'The email field is required.',
				'registerEmail.email' => 'The email must be a valid email address.',
				'password.required' => 'The password field is required.',
				'password.min' => 'The password must be at least 6 characters.',
				'password.max' => 'The password may not be greater than 10 characters.',
			]);
		try {
$data = $request->all();
			 $user = new User();
			 $user->first_name = @$data['jaName'];
			 $user->last_name = @$data['jaName'];
			$user->email =  @$data['registerEmail'];
			$user->password = Hash::make($data['password']);
			$user->token = str_random(60);
			$user->save();
			$this->guard()->login($user);
			
		$set = Admin::where('id',1)->first();
		$link = \URL::to('/') . '/verify/email/' . $user->token . '?email=' . urlencode($user->email);
		$replaceav = array('{logo}','{customer_name}','{email_id}','{link}','{company_name}');
				$replace_withav = array(\URL::to('/').'/public/img/profile_imgs/'.@$set->logo, @$user->first_name.' '.@$user->last_name, $user->email, $link, @$set->company_name);			
				$emailtemplate	= 	DB::table('email_templates')->where('alias', 'email-verify')->first();
				
				$subContent 	= 	$emailtemplate->subject;
				
				$issuccess = $this->send_email_template($replaceav, $replace_withav, 'email-verify', $user->email,$subContent,$set->primary_email); 
			return response()->json(['success' => true], 200);
		}catch (Exception $e) {
			return response()->json(['error' => trans('form.whoops')], 500);
		}	
		/* if($result)
		{
			 $replace = array('{logo}', '{first_name}', '{last_name}', '{year}');					
			$replace_with = array(\URL::to('/').Config::get('constants.logoImg'), @$data['first_name'], @$data['last_name'], date('Y'));
			
			$this->send_email_template($replace, $replace_with, 'signup', @$data['email_register']); 
			
			return response()->json(['success' => true], 200);
		}else{
			return response()->json(['error' => trans('form.whoops')], 500);
		} */
    }
}
