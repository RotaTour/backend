<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use JWTAuth;
use App\Models\User;

class FriendController extends Controller
{
    /**
     * Display a listing of friends.
     *
     * @return \Illuminate\Http\Response
     * 
     * @SWG\Get(
     *     path="/api/friends",
     *     description="Returns friends.",
     *     operationId="api.friends.index",
     *     produces={"application/json"},
     *     tags={"friends"},
     *     @SWG\Response(
     *         response=200,
     *         description="Friends overview."
     *     ),
     *     @SWG\Response(
     *         response=401,
     *         description="Unauthorized action.",
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="User not Found.",
     *     )
     * )
     */
    public function index()
    {
        $userJWT = JWTAuth::parseToken()->authenticate();
        $user = User::find($userJWT->id);
        if(!$user) return response()->json(['error' => 'User not be found'], 404);

        $friends = $user->friends();
        return response()->json(compact('friends'));
    }
    
    /**
     * Display a listing of friendship requests.
     *
     * @return \Illuminate\Http\Response
     * 
     * @SWG\Get(
     *     path="/api/friends/requests",
     *     description="Returns friends.",
     *     operationId="api.friends.index",
     *     produces={"application/json"},
     *     tags={"friends"},
     *     @SWG\Response(
     *         response=200,
     *         description="Friends overview."
     *     ),
     *     @SWG\Response(
     *         response=401,
     *         description="Unauthorized action.",
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="User not Found.",
     *     )
     * )
     */
    public function getRequests()
    {
        $userJWT = JWTAuth::parseToken()->authenticate();
        $user = User::find($userJWT->id);
        if(!$user) return response()->json(['error' => 'User not be found'], 404);

        $response = array();
        $response['code'] = 200;
        $response['requests'] = $user->friendRequests();
        return response()->json($response);
    }


    /**
     * Send a friendship request.
     *
     * @return \Illuminate\Http\Response
     * 
     * @SWG\Get(
     *     path="/api/friends/add/{email}",
     *     description="Send a friendship request.",
     *     operationId="api.friends.add",
     *     produces={"application/json"},
     *     tags={"friends"},
     *     @SWG\Parameter(
     *          name="email",
     *          in="path",
     *          required=true,
     *          type="string",
     *          description="Email used by user",
     * 	   ),
     *     @SWG\Response(
     *         response=200,
     *         description="Success - Friend request sent"
     *     ),
     *     @SWG\Response(
     *         response=401,
     *         description="Unauthorized action.",
     *     ),
     *     @SWG\Response(
     *         response=400,
     *         description="That user could not be found.",
     *     ),
     *     @SWG\Response(
     *         response=403,
     *         description="You are already friends.",
     *     ),
     *     @SWG\Response(
     *         response=406,
     *         description="Friend request already pending.",
     *     ),
     *     @SWG\Response(
     *         response=409,
     *         description="Yourself can't be in your friends list.",
     *     )
     * )
     */
    public function getAdd($email)
    {
        $user = User::where('email', $email)->first();
        if (!$user) {
            return response()->json(['error' => 'That user could not be found'], 400);
        }

        $userJWT = JWTAuth::parseToken()->authenticate();
        $myself = User::find($userJWT->id);
        if ($myself->id == $user->id ){
            return response()->json(['error' => 'Yourself can\'t be in your friends list'], 409);
        }

        if ($myself->hasFriendRequestPending($user) || 
        $user->hasFriendRequestPending($myself) ){
            return response()->json(['error' => 'Friend request already pending.'], 406);
        }

        if ($myself->isFriendsWith($user)){
            return response()->json(['error' => 'You are already friends.'], 403);
        }

        $myself->addFriend($user);
        return response()->json(['info' => 'Friend request sent'], 200);
    }

    /**
     * Accept a friendship request.
     *
     * @return \Illuminate\Http\Response
     * 
     * @SWG\Get(
     *     path="/api/friends/accept/{email}",
     *     description="Accept a friendship request.",
     *     operationId="api.friends.accept",
     *     produces={"application/json"},
     *     tags={"friends"},
     *     @SWG\Parameter(
     *          name="email",
     *          in="path",
     *          required=true,
     *          type="string",
     *          description="Email used by user",
     * 	   ),
     *     @SWG\Response(
     *         response=200,
     *         description="Success - Friend request accepted"
     *     ),
     *     @SWG\Response(
     *         response=401,
     *         description="Unauthorized action.",
     *     ),
     *     @SWG\Response(
     *         response=400,
     *         description="That user could not be found.",
     *     ),
     *     @SWG\Response(
     *         response=406,
     *         description="There is no Request Received.",
     *     )
     * )
     */
    public function getAccept($email)
    {
        $user = User::where('email', $email)->first();
        if (!$user) {
            return response()->json(['error' => 'That user could not be found'], 400);
        }

        $userJWT = JWTAuth::parseToken()->authenticate();
        $myself = User::find($userJWT->id);

        if (!$myself->hasFriendRequestReceived($user)){
            return response()->json(['error' => 'There is no Request Received.'], 406);
        }

        $myself->acceptFriendRequest($user);
        return response()->json(['info' => 'Friend request accepted.'], 200);

    }

    /**
     * Leave a Friendship.
     *
     * @return \Illuminate\Http\Response
     * 
     * @SWG\Post(
     *     path="/api/friends/leavefriendship/{email}",
     *     description="Leave a friendship.",
     *     operationId="api.friends.leave",
     *     produces={"application/json"},
     *     tags={"friends"},
     *     @SWG\Parameter(
     *          name="email",
     *          in="path",
     *          required=true,
     *          type="string",
     *          description="Email used by user",
     * 	   ),
     *     @SWG\Response(
     *         response=200,
     *         description="Success - Leave a Friendship"
     *     ),
     *     @SWG\Response(
     *         response=400,
     *         description="That user could not be found.",
     *     ),
     *     @SWG\Response(
     *         response=406,
     *         description="You aren't friend of ...",
     *     )
     * )
     */
    public function leaveFriendship($email)
    {
        $user = User::where('email', $email)->first();
        if (!$user) {
            return response()->json(['error' => 'That user could not be found'], 400);
        }

        $userJWT = JWTAuth::parseToken()->authenticate();
        $myself = User::find($userJWT->id);

        if ($myself->isFriendsWith($user)){
            
            $myself->deleteFriend($user);
            
            return response()->json(['info' => "You leave the friendship with {$user->getFirstNameOrUsername()}."], 200);
        } else {
            return response()->json(['error' => "You aren't friend of {$user->getFirstNameOrUsername()}."], 406);
        }
    }

}
