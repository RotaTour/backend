<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use App\Models\User;

class SettingsController extends Controller
{
    /**
     * Display details of current user.
     *
     * @return \Illuminate\Http\Response
     * 
     * @SWG\Get(
     *     path="/api/settings",
     *     description="Display details of current user.",
     *     operationId="api.settings.index",
     *     produces={"application/json"},
     *     tags={"settings"},
     *     @SWG\Response(
     *         response=200,
     *         description="Success - User found and return details."
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="User not found.",
     *     )
     * )
     */
    public function index()
    {
        $userJWT = JWTAuth::parseToken()->authenticate();
        $user = User::find($userJWT->id);
        if (!$user){
            return response()->json(['error' => 'User not found'], 404);
        } else {
            return response()->json(compact('user'));
        }
    }

    /**
     * Save Settings of a user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * * 
     * @SWG\Post(
     *     path="/api/settings",
     *     description="Save Settings of a user.",
     *     operationId="api.settings.update",
     *     produces={"application/json"},
     *     tags={"settings"},
     *     @SWG\Parameter(
     *          name="type",
     *          in="body",
     *          schema={"$ref": "#/definitions/User"},
     *          required=true,
     *          type="string",
     *          description="Type of operation to proceed. Values are: 'password', 'username', 'avatar' & 'rest'"
     * 	   ),
     *     @SWG\Parameter(
     *          name="current_password",
     *          in="body",
     *          schema={"$ref": "#/definitions/User"},
     *          required=false,
     *          type="string",
     *          description="Current password of user"
     * 	   ),
     *     @SWG\Parameter(
     *          name="password",
     *          in="body",
     *          schema={"$ref": "#/definitions/User"},
     *          required=false,
     *          type="string",
     *          description="The new password"
     * 	   ),
     *     @SWG\Parameter(
     *          name="username",
     *          in="body",
     *          schema={"$ref": "#/definitions/User"},
     *          required=false,
     *          type="string",
     *          description="The new username for user"
     * 	   ),
     *     @SWG\Parameter(
     *          name="avatar",
     *          in="body",
     *          schema={"$ref": "#/definitions/User"},
     *          required=false,
     *          type="string",
     *          description="The new Avatar URL for user"
     * 	   ),
     *     @SWG\Parameter(
     *          name="name",
     *          in="body",
     *          schema={"$ref": "#/definitions/User"},
     *          required=false,
     *          type="string",
     *          description="The new full name for user"
     * 	   ),
     *     @SWG\Parameter(
     *          name="email",
     *          in="body",
     *          schema={"$ref": "#/definitions/User"},
     *          required=false,
     *          type="string",
     *          description="The new email for user"
     * 	   ),
     *     @SWG\Response(
     *         response=201,
     *         description="Success - User settings saved."
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="User not found.",
     *     ),
     *     @SWG\Response(
     *         response=400,
     *         description="Bad Request - some param are not present",
     *     )
     * )
     */
    public function update(Request $request)
    {
        $userJWT = JWTAuth::parseToken()->authenticate();
        $user = User::find($userJWT->id);
        if (!$user){
            return response()->json(['error' => 'User not found'], 404);
        }

        $response['code'] = 400;
        $response['msg'] = "";
        $response['additional_msg'] = false;
        $response['user'] = $user;
        $additional_msg = false;
        
        if ($request->input("type") == "password") {
            $validator = Validator::make($request->all(), [
                'current_password' => 'required|passcheck',
                'password' => 'required|min:6'
            ]);

            if ($validator->fails()) {
                $save = false;
            } else {
                $user->password = Hash::make($request->input("password"));
                $save = $user->save();
            }
        } elseif ($request->input("type") == "username"){
            $validator = Validator::make($request->all(), [
                'username' => 'required|max:191|unique:users,username,' . $user->id
            ]);

            $user_p = [
                'username' => $request->input("username"),
                'name' => $user->name,
                'email' => $user->email
            ];

            if ($validator->fails()) {
                $save = false;
            } else {
                $user->username = $user_p['username'];
                if ($user->validateUsername()) {
                    $save = $user->save();
                }else{
                    $save = false;
                    $additional_msg = "O username não pode conter caracteres especiais ou espaço";
                }
            }
        } elseif ($request->input("type") == "avatar"){
            $validator = Validator::make($request->all(), [
                'avatar' => 'required|max:255|url'
            ]);

            $user_p = [
                'avatar' => $request->input("avatar"),
                'name' => $user->name,
                'email' => $user->email
            ];

            if ($validator->fails()) {
                $save = false;
            } else {
                $user->avatar = $user_p['avatar'];
                if ( $user->save() ) {
                    $save = true;
                }else{
                    $save = false;
                    $additional_msg = "Não foi possível salvar";
                }
            }
        } else {
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:191',
                'email' => 'required|email|max:191|unique:users,email,' . Auth::user()->id
            ]);

            $user_p = [
                'name' => $request->input("name"),
                'email' => $request->input("email")
            ];
            
            if($request->has('location')){
                $user_p['location'] = $request->input("location");
            }

            if ($validator->fails()) {
                $save = false;
            }else {
                $user->name = $user['name'];
                $user->email = $user['email'];
                if( isset($user_p['location']) ) $user->location = $user_p['location'];
                
                $save = $user->save();
            }
        }

        if ($save){
            $response['msg'] = 'Suas configurações foram salvas com sucesso!';
            $resposne['code'] = 200;
        }else{
            $response['msg'] = 'Houve um problema ao salvar as configurações!';
            $resposne['code'] = 400;
        }

        if ($request->input("type") == "password") {
            if (!$save){
                $response['msg'] = 'A senha não passou na validação!';
                $resposne['code'] = 400;
            }
        }

        $reponse['user'] = $user;
        return response()->json($response, $response['code']);
    }
}
