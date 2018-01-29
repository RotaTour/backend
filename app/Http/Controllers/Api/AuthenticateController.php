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
    /**
     * get a JWT token for a user.
     *
     * @return \Illuminate\Http\Response
     * 
     * @SWG\Post(
     *     path="/api/login",
     *     description="get a JWT token for a user.",
     *     operationId="api.auth",
     *     produces={"application/json"},
     *     tags={"login"},
     *     @SWG\Parameter(
     *          name="email",
     *          in="body",
     *          schema={"$ref": "#/definitions/NewUser"},
     *          required=true,
     *          type="string",
     *          description="Email used by user",
     * 	   ),
     *     @SWG\Parameter(
     *          name="password",
     *          in="body",
     *          schema={"$ref": "#/definitions/NewUser"},
     *          required=true,
     *          type="string",
     *          description="Password used by user",
     * 	   ),
     *     @SWG\Response(
     *         response=200,
     *         description="Success - respond with a JWT Token"
     *     ),
     *     @SWG\Response(
     *         response=401,
     *         description="Invalid Credentials.",
     *     ),
     *     @SWG\Response(
     *         response=500,
     *         description="Could not create token",
     *     )
     * )
     */
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
     * Get the user by token - For Tests only.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     * 
     * @SWG\Get(
     *     path="/api/getuser",
     *     description="get a user by JWT Token - for tests only.",
     *     operationId="api.getuser",
     *     produces={"application/json"},
     *     tags={"login"},
     *     @SWG\Parameter(
     *          name="token",
     *          in="query",
     *          required=true,
     *          type="string",
     *          description="Email used by user",
     * 	   ),
     *     @SWG\Response(
     *         response=200,
     *         description="Success - respond with a JWT Token"
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="User not found.",
     *     )
     * )
     */
    public function getUser(Request $request)
    {
        JWTAuth::setToken($request->input('token'));
        $user = JWTAuth::toUser();
        if (!$user){
            return response()->json(['error' => 'User not found.'], 404);
        } else {
            return response()->json($user);
        }
        
    }

    /**
     * Handle a registration request for the application.
     * ref.: https://laracasts.com/discuss/channels/general-discussion/rest-api-help
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * * 
     * @SWG\Post(
     *     path="/api/register",
     *     description="Handle a registration request for the application",
     *     operationId="api.register",
     *     produces={"application/json"},
     *     tags={"login"},
     *     @SWG\Parameter(
     *          name="name",
     *          in="body",
     *          schema={"$ref": "#/definitions/NewUser"},
     *          required=true,
     *          type="string",
     *          description="Fullname used by user",
     * 	   ),
     *     @SWG\Parameter(
     *          name="email",
     *          in="body",
     *          schema={"$ref": "#/definitions/NewUser"},
     *          required=true,
     *          type="string",
     *          description="Email used by user",
     * 	   ),
     *     @SWG\Parameter(
     *          name="password",
     *          in="body",
     *          schema={"$ref": "#/definitions/NewUser"},
     *          required=true,
     *          type="string",
     *          description="Password used by user",
     * 	   ),
     *     @SWG\Response(
     *         response=200,
     *         description="Success - respond with a JWT Token"
     *     ),
     *     @SWG\Response(
     *         response=409,
     *         description="User already exists.",
     *     )
     * )
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
        $info = "User successful registered";
        
        // resposta
        // all good so return the token
        return response()->json(compact('token', 'info'));
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
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
        ]);
    }

    ////// Stateless Social login
    // ref.: https://isaacearl.com/blog/stateless-socialite
    /**
     * Redirect the user to the $provider authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->stateless()->redirect();
    }

    /**
     * Obtain the user information from $provider.
     *
     * @return JsonResponse
     * 
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
     * Register the user information from Social Provider and return a JWT Token.
     *
     * @param  \Illuminate\Http\Request $request
     * @return JsonResponse
     * @SWG\Post(
     *     path="/api/social/register",
     *     description="Register the user information from Social Provider and return a JWT Token.",
     *     operationId="api.social.register",
     *     produces={"application/json"},
     *     tags={"login"},
     *     @SWG\Parameter(
     *          name="name",
     *          in="body",
     *          schema={"$ref": "#/definitions/NewUser"},
     *          required=true,
     *          type="string",
     *          description="Fullname used by user",
     * 	   ),
     *     @SWG\Parameter(
     *          name="email",
     *          in="body",
     *          schema={"$ref": "#/definitions/NewUser"},
     *          required=true,
     *          type="string",
     *          description="Email used by user",
     * 	   ),
     *     @SWG\Parameter(
     *          name="avatar",
     *          in="body",
     *          schema={"$ref": "#/definitions/NewUser"},
     *          required=false,
     *          type="string",
     *          description="Avatar image Url",
     * 	   ),
     *     @SWG\Parameter(
     *          name="provider",
     *          in="body",
     *          schema={"$ref": "#/definitions/NewUser"},
     *          required=true,
     *          type="string",
     *          description="Provider Name Social Provider, all lowercase",
     * 	   ),
     *     @SWG\Parameter(
     *          name="provider_id",
     *          in="body",
     *          schema={"$ref": "#/definitions/NewUser"},
     *          required=true,
     *          type="string",
     *          description="Provider Id From Social Provider",
     * 	   ),
     *     @SWG\Response(
     *         response=200,
     *         description="Success - respond with a JWT Token"
     *     ),
     *     @SWG\Response(
     *         response=400,
     *         description="Email not provided",
     *     )
     * )
     */
    public function registerProviderCallback(Request $request)
    {
        $input = $request->input();

        // Only use E-mail
        if(!isset($input['email'])) return response()->json(['error'=>'Email not provided'], 400);
        $user = User::query()->firstOrNew([ 'email' => $input['email'] ]);

        // Se não existir, cria o user
        if (!$user->exists) {
            $user->name = $input['name'];
            $user->email = $input['email'];
            $user->avatar = $input['avatar'];
            $user->provider_id_mobile = $input['provider_id'];
            $user->provider = $input['provider'];

            $username = explode("@", $user->email)[0];
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
            $user->username = $username;
            $user->save();
        }
        
        $token = JWTAuth::fromUser($user);

        // all good so return the token
        return response()->json(compact('token'));
        
    }


}
