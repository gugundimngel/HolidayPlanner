<?php
namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\API\BaseController as BaseController;

use App\User;
use Validator;

class LoginController extends BaseController
{
    /**
     * login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
		$requestData = $request->all();
		
		$validator = Validator::make($requestData, [
														'email' => 'required|string|email|max:191|exists:users',
														'password' => 'required|string|min:6|max:12'
													], 
													[
														'email.required' => 'The email field is required.',
														'email.email' => 'The email must be a valid email address.',
														'password.required' => 'The password field is required.',
														'password.min' => 'The password must be at least 6 characters.',
														'password.max' => 'The password may not be greater than 10 characters.'
													]
									);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

		if (Auth::attempt(array('email' => @$requestData['email'], 'password' => @$requestData['password'])))
		{
			$userDetails = User::select('id', 'first_name', 'last_name', 'email', 'phone', 'course_level', 'first_time_msg', 'updated_at', 'created_at')->where('email', '=', @$requestData['email'])->first();	
			$success['user_data'] =  @$userDetails;
			return $this->sendResponse($success, 'Now you have login successfully.');
		}
		else
		{
			 return $this->sendError('Authentication Error.', array('email'=>array('These credentials do not match our records.'))); 	
		}	
    }
}