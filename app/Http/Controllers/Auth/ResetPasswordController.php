<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Redirect;
use DB;
use App\User;
use App\Agent; 
class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/success';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }
	
	public function showPasswordResetForm($token)
	 {
		 $tokenData = DB::table('password_resets')
		 ->where('token', $token)->first();

		 if ( !$tokenData ) return redirect()->to('/'); //redirect them anywhere you want if the token does not exist.
		 return view('auth.passwords.reset',compact(['token']));
	 }
 
	public function resetPassword(Request $request)
	{
			$this->validate($request, [
										'email' => 'required|string|email|max:191',
										'password' => 'required|string|min:6|max:12|confirmed',
										'password_confirmation' => 'required|string|min:6|max:12'
									  ]);

		$password = $request->password;
		$tokenData = DB::table('password_resets')
		->where('token', $request->token)->first();

		$user = User::where('email', $tokenData->email)->first();
		if ( !$user ) return redirect()->to('home'); //or wherever you want

		$user->password = Hash::make($password);
		$user->update(); //or $user->save();

		//do we log the user directly or let them login and try their password for the first time ? if yes 
		//Auth::login($user);

		// If the user shouldn't reuse the token later, delete the token 
		DB::table('password_resets')->where('email', $user->email)->delete();

		return Redirect::to('/success'); 
	}
	
	public function showagentPasswordResetForm($token)
	 {
		 $tokenData = DB::table('password_resets')
		 ->where('token', $token)->first();

		 if ( !$tokenData ) return redirect()->to('/'); //redirect them anywhere you want if the token does not exist.
		 return view('auth.passwords.agentreset',compact(['token']));
	 }
 
	public function resetagentPassword(Request $request)
	{
			$this->validate($request, [
										'email' => 'required|string|email|max:191',
										'password' => 'required|string|min:6|max:12|confirmed',
										'password_confirmation' => 'required|string|min:6|max:12'
									  ]);

		$password = $request->password;
		$tokenData = DB::table('password_resets')
		->where('token', $request->token)->first();

		$user = Agent::where('email', $tokenData->email)->first();
		if ( !$user ) return redirect()->to('home'); //or wherever you want

		$user->password = Hash::make($password);
		$user->update(); //or $user->save();

		//do we log the user directly or let them login and try their password for the first time ? if yes 
		//Auth::login($user);

		// If the user shouldn't reuse the token later, delete the token 
		DB::table('password_resets')->where('email', $user->email)->delete();

		return Redirect::to('/success'); 
	}
}
