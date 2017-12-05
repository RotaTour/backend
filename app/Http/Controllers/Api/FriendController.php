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
     */
    public function index()
    {
        $userJWT = JWTAuth::parseToken()->authenticate();
        $user = User::find($userJWT->id);
        $friends = $user->friends();
        return response()->json(compact('friends'));
    }


}
