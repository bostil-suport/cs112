<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\User;
use App\Provider;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;

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
    protected $redirectTo = '/home';


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information from social.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback($provider)
    {
        $user = Socialite::driver($provider)->user();

        $authUser = $this->findOrCreateUser($user, $provider);
        Auth::login($authUser, true);


//        echo $user->token;
//        die();
        return redirect($this->redirectTo);
        // $user->token;
    }



    /**
     * If a user has registered uses social auth, return the user
     * else, create a new user object or add registered info from social.
     * @param  $user Socialite user object
     * @param $provider Social auth provider
     * @return  User
     */
    public function findOrCreateUser($user, $provider)
    {

//new version
//        $authUser = Provider::where('provider_id', $user->getId())->first();
//        if ($authUser) {
//            return $authUser;
//        }
//        $authUserByEmail = User::where('email', $user->getEmail())->first();
//        if ($authUserByEmail) {
////            echo '<pre>';
////            print_r($authUserByEmail);
////            echo '</pre>';
//
//            $authUser->provider = $provider;
//            $authUser->provider_id = $user->getId();
//            $authUser->save();
//
//            return $authUserByEmail;
//        }
//
//


//        $authUser = User::where('email', $user->getEmail())->first();
//        if ($authUser) {
//            return $authUser;
//        }


        //user already exist
        $authProvider = Provider::where('provider_id', $user->getId())->first();

        if ($authProvider) {

            $authUser = $authProvider->user;
            return $authUser;
        }
        //user already exist .end.

        $authUserByEmail = User::where('email', $user->getEmail())->first();
        if ($authUserByEmail) {
//            echo '<pre>';
//            print_r($authUserByEmail);
//            echo '</pre>';

            $authUserByEmail->providers()->create([
                'provider' =>  $provider,
                'provider_id' => $user->getId(),
                'user_id' => $authUserByEmail->id,
            ]);

            return $authUserByEmail;
        }






        //add new user
        $newUser = User::create([
            'name'     => $user->getName(),
            'email'    => $user->getEmail(),
        ]);

        $newUser->providers()->create([
            'provider' =>  $provider,
            'provider_id' => $user->getId(),
            'user_id' => $newUser->id,
        ]);

        return $newUser;
      //add new user .end.






//old version
//        $authUser = User::where('provider_id', $user->getId())->first();
//        if ($authUser) {
//            return $authUser;
//        }
//
//        $authUserByEmail = User::where('email', $user->getEmail())->first();
//        if ($authUserByEmail) {
////            echo '<pre>';
////            print_r($authUserByEmail);
////            echo '</pre>';
//
//                $authUserByEmail->provider = $provider;
//                $authUserByEmail->provider_id = $user->getId();
//                $authUserByEmail->save();
//
//                return $authUserByEmail;
//            }
//
//
//        return User::create([
//            'name'     => $user->getName(),
//            'email'    => $user->getEmail(),
//            'provider' => $provider,
//            'provider_id' => $user->getId()
//        ]);
//end old version


    }
}
