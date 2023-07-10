<?php
namespace App\Http\Controllers\Auth;
 
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

use Cookie;
use App\LoginLog;
class AgentLoginController extends Controller
{
	use AuthenticatesUsers;
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/agent/dashboard';
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:agents')->except('logout');
    }
	
	protected function credentials(\Illuminate\Http\Request $request)
    {
        //return $request->only($this->username(), 'password');
         return [
        'email'     => $request->email,
        'password'  => $request->password,
        'status' => '1'
    ];
    }
	
    protected function guard()
	{
        return Auth::guard('agents');
    }
	
	public function showLoginForm(){
		return view('auth.agent-login');
	}
	
	public function authenticated(Request $request, $user)
    {		
		if(!empty($request->remember)) {
			\Cookie::queue(\Cookie::make('username', $request->email, 3600));
			\Cookie::queue(\Cookie::make('password', $request->password, 3600));
		} else {
			\Cookie::queue(\Cookie::forget('username'));
			\Cookie::queue(\Cookie::forget('password'));
		}
		$obj = new LoginLog;
		$obj->user_id = $user->id;
		$obj->ip = $_SERVER['REMOTE_ADDR'];
		$obj->date = date('Y-m-d h:i:s');
		$obj->save();
        return redirect()->intended($this->redirectPath());
    }
	
	public function logout(Request $request)
    {
		Auth::guard('agents')->logout();
        $request->session()->flush();
        $request->session()->regenerate();
		return redirect('/agent/login');
    }
}
