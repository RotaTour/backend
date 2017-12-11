<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Socialite;
use App\Models\User;

class AuthenticateController extends Controller
{
    public function authenticate(Request $request)
    {
        // grab credentials from the request
        $credentials = $request->only('email', 'password');

        try {
            // attempt to verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        // all good so return the token
        return response()->json(compact('token'));
    }

    /**
     * Get the user by token.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUser(Request $request)
    {
        JWTAuth::setToken($request->input('token'));
        $user = JWTAuth::toUser();
        return response()->json($user);
    }

    /**
     * Handle a registration request for the application.
     * ref.: https://laracasts.com/discuss/channels/general-discussion/rest-api-help
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $input = $request->all();
        
        // Validar
        $validator = $this->validator($input);
        if ($validator->fails()) {
            $this->throwValidationException($request, $validator);
        }
        
        // criar o user
        $user = User::query()->firstOrNew(['email' => $input['email']]);
        // Se não existir, cria o user
        if (!$user->exists) {
            $password = bcrypt($input['password']);
            $input['password'] = $password;
            $user = User::create($input);
        } else {
            // se o usuário já existe, retorna erro (Conflict)
            return response()->json(['error' => 'user_already_exists'], 409);
        }

        // criar o token JWT
        $token = JWTAuth::fromUser($user);
        $msg = "Cadastrado com sucesso";
        
        // resposta
        // all good so return the token
        return response()->json(compact('token', 'msg'));
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);
    }

    ////// Stateless Social login
    // ref.: https://isaacearl.com/blog/stateless-socialite
    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->stateless()->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return JsonResponse
     */
    public function handleProviderCallback($provider)
    {
        $providerUser = Socialite::driver($provider)->stateless()->user();

        $user = User::query()->firstOrNew(['email' => $providerUser->getEmail()]);

        // Se não existir, cria o user
        if (!$user->exists) {
            $user->name = $providerUser->getName();
            $user->email = $providerUser->getEmail();
            $user->avatar = $providerUser->getAvatar();
            $user->provider_id = $providerUser->getId();
            $user->provider = $provider;
            $user->save(); 
        }
        
        $token = JWTAuth::fromUser($user);

        // all good so return the token
        return response()->json(compact('token'));
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return JsonResponse
     */
    public function directProviderCallback(Request $request)
    {
        dd($request->input());

        /*
        $providerUser = Socialite::driver($provider)->stateless()->user();

        $user = User::query()->firstOrNew(['email' => $providerUser->getEmail()]);

        // Se não existir, cria o user
        if (!$user->exists) {
            $user->name = $providerUser->getName();
            $user->email = $providerUser->getEmail();
            $user->avatar = $providerUser->getAvatar();
            $user->provider_id = $providerUser->getId();
            $user->provider = $provider;
            $user->save(); 
        }
        
        $token = JWTAuth::fromUser($user);

        // all good so return the token
        return response()->json(compact('token'));
        */
    }


}
