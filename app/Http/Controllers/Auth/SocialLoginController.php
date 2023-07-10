<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\User;
use Hash;
use Auth;
use Socialite;
class SocialLoginController extends Controller
{
	public function redirectToProvider($provider)
    {
		//echo 'sdsdds'; die;
        return Socialite::driver($provider)->redirect();
    }
	
	 public function handleProviderCallback($provider)
    {
        $user = Socialite::driver($provider)->stateless()->user();
        $authUser = $this->findOrCreateUser($user, $provider);
        Auth::login($authUser, true);
        return redirect('/');
    }

    /**
     * If a user has registered before using social auth, return the user
     * else, create a new user object.
     * @param  $user Socialite user object
     * @param $provider Social auth provider
     * @return  User
     */
    public function findOrCreateUser($user, $provider)
    {
        $authUser = User::where('email', $user->email)->first();
        if ($authUser) {
            return $authUser;
        }
        else{
            $name=explode(' ', $user->name);
            $data = User::create([
                'first_name'     => @$name[0],
                'last_name'     => @$name[1],
                'email'    => !empty($user->email)? $user->email : '' ,
                 'password'    =>   Hash::make($user->id),
                'provider' => $provider,
                'provider_id' => $user->id
            ]);
            return $data;
        }
    }
}