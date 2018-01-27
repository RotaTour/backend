<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use App\Models\Status;


class ProfileController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show($username)
    {
        $user = User::getUser($username);
        if(!$user) abort(404);

        //$statuses = $user->statuses()->notReply()->orderBy('created_at', 'desc')->paginate(10);
        $authUserIsFriend = Auth::user()->isFriendsWith($user);
        $wall = [
            'new_post_group_id' => 0
        ];
        $can_see = true;
        

        return view('profile.index', 
            compact(
                'user', 
                'authUserIsFriend',
                'wall',
                'can_see'
                )
        );
    }

    public function friends($username)
    {
        $user = User::getUser($username);
        if(!$user) abort(404);

        $authUserIsFriend = Auth::user()->isFriendsWith($user);
        $wall = [
            'new_post_group_id' => 0
        ];
        $can_see = true;
        $friends = $user->friends();

        return view('profile.friends', 
            compact(
                'user', 
                'authUserIsFriend',
                'wall',
                'can_see',
                'friends'
                )
        );
    }

}
