<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use JWTAuth;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::orderBy('id')->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified user.
     *
     * @param  string  $username
     * @return \Illuminate\Http\Response
     * 
     * @SWG\Get(
     *     path="/api/users/{username}",
     *     description="Returns the user details.",
     *     operationId="api.users.show",
     *     produces={"application/json"},
     *     tags={"users"},
     *     @SWG\Parameter(
     *          name="username",
     *          in="path",
     *          required=true,
     *          type="string",
     *          description="Username used by user",
     * 	   ),
     *     @SWG\Response(
     *         response=200,
     *         description="Success - User found."
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="User not found.",
     *     )
     * )
     */
    public function show($username)
    {
        $user = User::getUser($username);
        // https://laracasts.com/discuss/channels/laravel/laravel-51-404-response-to-json
        /*
         * @todo implementar o ModelNotFound Exception Handler
         */
        if (!$user){
            return response()->json(['error' => 'User not found'], 404);
        } else {
            return response()->json($user, 200);
        }
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified user from storage.
     *
     * @param  int  $username
     * @return \Illuminate\Http\Response
     * 
     * @SWG\Delete(
     *     path="/api/users/{username}",
     *     description="Delete yourself from database",
     *     operationId="api.users.delete",
     *     produces={"application/json"},
     *     tags={"users"},
     *     @SWG\Parameter(
     *          name="username",
     *          in="path",
     *          required=true,
     *          type="string",
     *          description="Username used by user",
     * 	   ),
     *     @SWG\Response(
     *         response=200,
     *         description="Success - User deleted."
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="User not found.",
     *     ),
     *     @SWG\Response(
     *         response=403,
     *         description="User could not be deleted.",
     *     )
     * )
     */
    public function destroy($username)
    {
        $userJWT = JWTAuth::parseToken()->authenticate();
        $user = User::find($userJWT->id);
        if (!$user){
            return response()->json(['error' => 'User not found'], 404);
        }
        if ($user->username != $username){
            return response()->json(['error' => "User could not be deleted."], 403);
        }
        if ($user->delete()){
            return response()->json(['info' => 'User deleted.'], 200);
        } else {
            return response()->json(['error' => "User could not be deleted."], 500);
        }
        
    }

    /**
     * Returns the statuses of a specified user.
     *
     * @param  string  $username
     * @return \Illuminate\Http\Response
     * 
     * @SWG\Get(
     *     path="/api/users/{username}/status",
     *     description="Returns the statuses of a specified user.",
     *     operationId="api.users.getstatus",
     *     produces={"application/json"},
     *     tags={"users"},
     *     @SWG\Parameter(
     *          name="username",
     *          in="path",
     *          required=true,
     *          type="string",
     *          description="Username used by user",
     * 	   ),
     *     @SWG\Response(
     *         response=200,
     *         description="Success - User found."
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="User not found.",
     *     )
     * )
     */
    public function getStatus($username)
    {
        $user = User::getUser($username);
        if (!$user){
            return response()->json(['error' => 'User not found'], 404);
        } else {
            return $user->statuses()
            ->notReply()
            ->with('replies')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        }
        
    }

    /**
     * Returns a friends list of a specified user.
     *
     * @param  string  $username
     * @return \Illuminate\Http\Response
     * 
     * @SWG\Get(
     *     path="/api/users/{username}/friends",
     *     description="Returns a friends list of a specified user.",
     *     operationId="api.users.getfriends",
     *     produces={"application/json"},
     *     tags={"users"},
     *     @SWG\Parameter(
     *          name="username",
     *          in="path",
     *          required=true,
     *          type="string",
     *          description="Username used by user",
     * 	   ),
     *     @SWG\Response(
     *         response=200,
     *         description="Success - User found."
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="User not found.",
     *     )
     * )
     */
    public function getFriends($username)
    {
        $user = User::getUser($username);
        if (!$user){
            return response()->json(['error' => 'User not found'], 404);
        } else {
            $friends = $user->friends();
            return response()->json(compact('friends', 'user'));
        }

    }

    /**
     * Returns a routes list of a specified user.
     *
     * @param  string  $username
     * @return \Illuminate\Http\Response
     * 
     * @SWG\Get(
     *     path="/api/users/{username}/routes",
     *     description="Returns a routes list of a specified user.",
     *     operationId="api.users.getroutes",
     *     produces={"application/json"},
     *     tags={"users"},
     *     @SWG\Parameter(
     *          name="username",
     *          in="path",
     *          required=true,
     *          type="string",
     *          description="Username used by user",
     * 	   ),
     *     @SWG\Response(
     *         response=200,
     *         description="Success - User found."
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="User not found.",
     *     )
     * )
     */
    public function getRoutes($username)
    {
        $user = User::getUser($username);
        if (!$user){
            return response()->json(['error' => 'User not found'], 404);
        } else {
            $routes = $user->routes()->get();
            return response()->json(compact('routes', 'user'));
        }
    }

    /**
     * Display the user from JWT Token.
     *
     * @param  string  $JWTtoken
     * @return \Illuminate\Http\Response
     * 
     * @SWG\Get(
     *     path="/api/myself",
     *     description="Returns the user from JWT Token.",
     *     operationId="api.myself",
     *     produces={"application/json"},
     *     tags={"users"},
     *     @SWG\Response(
     *         response=200,
     *         description="Success - User found."
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="User not found.",
     *     )
     * )
     */
    public function myself()
    {
        $userJWT = JWTAuth::parseToken()->authenticate();
        $user = User::find($userJWT->id);
        if (!$user){
            return response()->json(['error' => 'User not found'], 404);
        } else {
            return response()->json(compact('user'));
        }
    }
}
