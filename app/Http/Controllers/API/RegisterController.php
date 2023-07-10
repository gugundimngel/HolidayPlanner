<?php
namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\API\BaseController as BaseController;

use App\User;
use Validator;
use Config;

class RegisterController extends BaseController
{
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
		$requestData = $request->all();
		
		$validator = Validator::make($requestData, [
														'first_name' => 'required|string|max:255',
														'last_name' => 'required|string|max:255',
														'email' => 'required|string|email|max:191|unique:users,email',
														'password' => 'required|string|min:6|max:12',
														'phone' => 'required|string|min:10|unique:users,phone',
														'course_level' => 'nullable|max:255'
													], 
													[
														'email.required' => 'The email field is required.',
														'email.email' => 'The email must be a valid email address.',
														'password.required' => 'The password field is required.',
														'password.min' => 'The password must be at least 6 characters.',
														'password.max' => 'The password may not be greater than 10 characters.',
														'phone.required' => 'The phone field is required.',
														'phone.min' => 'The phone must be at least 12 characters.',
													]
									);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

		$user = User::create([
            'first_name' 	=> @$requestData['first_name'],
            'last_name' 	=> @$requestData['last_name'],
            'email' 		=> @$requestData['email'],
            'password' 		=> Hash::make($requestData['password']),
            'phone' 		=> @$requestData['phone'],
            'course_level' 	=> @$requestData['course_level'],
            'first_time_msg' 	=> 1 //always 1 for mobile application
        ]);
		
		if($user)
		{
			$replace = array('{logo}', '{first_name}', '{last_name}', '{year}');					
			$replace_with = array(\URL::to('/').Config::get('constants.logoImg'), @$requestData['first_name'], @$requestData['last_name'], date('Y'));
			
			$this->send_email_template($replace, $replace_with, 'signup', @$requestData['email']);
		
		}

        $success['user_data'] =  @$user;

        return $this->sendResponse($success, 'Congrats! You have successfully register into our system.');
    }
}