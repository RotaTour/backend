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
     * @param  string  $email
     * @return \Illuminate\Http\Response
     * 
     * @SWG\Get(
     *     path="/api/users/{email}",
     *     description="Returns the user details.",
     *     operationId="api.users.show",
     *     produces={"application/json"},
     *     tags={"users"},
     *     @SWG\Parameter(
     *          name="email",
     *          in="path",
     *          required=true,
     *          type="string",
     *          description="Email used by user",
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
    public function show($email)
    {
        $user = User::where('email', $email)->first();
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Display the statuses of a specified user.
     *
     * @param  string  $email
     * @return \Illuminate\Http\Response
     * 
     * @SWG\Get(
     *     path="/api/users/{email}/status",
     *     description="Returns the statuses of a specified user.",
     *     operationId="api.users.getstatus",
     *     produces={"application/json"},
     *     tags={"users"},
     *     @SWG\Parameter(
     *          name="email",
     *          in="path",
     *          required=true,
     *          type="string",
     *          description="Email used by user",
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
    public function getStatus($email)
    {
        $user = User::where('email', $email)->first();
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
