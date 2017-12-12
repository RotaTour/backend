<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use JWTAuth;
use App\Models\User;

class FriendController extends Controller
{
    /**
     * Display a listing of the resource.
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
     *     )
     * )
     */
   
    public function index()
    {
        $userJWT = JWTAuth::parseToken()->authenticate();
        $user = User::find($userJWT->id);
        $friends = $user->friends();
        return response()->json(compact('friends'));
    }


}
