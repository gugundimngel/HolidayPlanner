<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use App\WebsiteSetting;
use App\Country;
use App\State;
use App\SeoPage;
use App\User;
use Hash;
use Auth;
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/user';
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
		$siteData = WebsiteSetting::where('id', '!=', '')->first();
		\View::share('siteData', $siteData);
        $this->middleware('guest')->except('logout');
    }
	
	protected function credentials(Request $request)
	{
		if(is_numeric($request->get('email')))
		{
			return ['email'=>$request->get('email'),'password'=>$request->get('password')];
		}
		return $request->only($this->username(), 'password');
	}
	
	public function authenticated(Request $request, $user)
    {		
		if(!empty($request->remember)) {
			\Cookie::queue(\Cookie::make('email', $request->email, 3600));
			\Cookie::queue(\Cookie::make('password', $request->password, 3600));
		} else {
			\Cookie::queue(\Cookie::forget('email'));
			\Cookie::queue(\Cookie::forget('password'));
		}
        return redirect()->intended($this->redirectPath());
    }
	
	public function showLoginForm()
	{
		/* Get all Select Data */	
			$country	= 	Country::select('id', 'name')->where('status', '=', 1)->first();
			$states	 	= 	State::select('id', 'country_id', 'name')->where('country_id', '=', @$country->id)->get();
			$seoDetails = SeoPage::where('page_slug', '=', 'login')->first();
		/* Get all Select Data */
		
		return view('auth.login', compact(['country', 'states', 'seoDetails']));
	}
	
	public function logout(Request $request)
    {
		Auth::guard('web')->logout();
        $request->session()->flush();
        $request->session()->regenerate();
		return redirect('/login');
    }
	
	public function customerLogin(Request $request)
    {
		 $credentials = $request->only('email', 'password');
   

        if (Auth::attempt(['email' => trim($request->email),
                    'password' => $request->password,
                        ], $request->has('remember'))) {


            return response()->json(['success' => true], 200);
        } else {
            $message = 'Invalid username or password';

            return response()->json(['success' => false, 'errors' =>$message], 200);
        }
   
    }
}
