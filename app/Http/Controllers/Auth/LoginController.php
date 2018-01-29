<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Socialite;
use App\Models\User;
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
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback($provider)
    {
        $user = Socialite::driver($provider)->user();

        // $user->token;
        // stroing data to our use table and logging them in
        $data = [
            'name' => $user->getName(),
            'email' => $user->getEmail(),
            'avatar' => $user->getAvatar(),
            'provider_id' => $user->getId(),
            'provider' => $provider
        ];

        $username = explode("@", $user->getEmail)[0];
        $tryAgain = true;
        $contagem = 1;
        while($tryAgain)
        {
            $user = User::where('username', $username)->first();
            if(!$user){
                $tryAgain = false;
            } else {
                $username = $username . "-" . ($contagem++);
            }
        }    
        $data['username'] = $username;
    
        $userLocal = User::query()->firstOrNew([ 'email' => $user->getEmail() ]);
        // Se não existir, cria o user
        if (!$userLocal->exists) {
            $userLocal = User::create($data);
        }

        Auth::login( $userLocal );

        //after login redirecting to home page
        return redirect($this->redirectPath());
    }
}
