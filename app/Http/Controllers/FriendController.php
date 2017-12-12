<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;

class FriendController extends Controller
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

    public function index()
    {
        $friends = Auth::user()->friends();
        $requests = Auth::user()->friendRequests();
        return view('friends.index', compact('friends', 'requests') );
    }

    public function getAdd($email)
    {
        $user = User::where('email', $email)->first();
        if (!$user) {
            return redirect()
            ->route('index')
            ->with('info', 'That user could not be found');
        }

        if (Auth::user()->id == $user->id ){
            return redirect()
            ->route('index');
        }

        if (Auth::user()->hasFriendRequestPending($user) || 
        $user->hasFriendRequestPending(Auth::user()) ){
            return redirect()
            ->route('profile.show', ['email'=>$email])
            ->with('info', 'Friend request already pending.');
        }

        if (Auth::user()->isFriendsWith($user)){
            return redirect()
            ->route('profile.show', ['email'=>$user->email])
            ->with('info', 'You are already friends.');
        }

        Auth::user()->addFriend($user);
        return redirect()
        ->route('profile.show', ['email'=>$email])
        ->with('info','Friend request sent.');
    }

    public function getAccept($email)
    {
        $user = User::where('email', $email)->first();
        if (!$user) {
            return redirect()
            ->route('index')
            ->with('info', 'That user could not be found');
        }

        if (!Auth::user()->hasFriendRequestReceived($user)){
            return redirect()
            ->route('index')
            ->with('info', 'There is no Request Received.');
        }

        Auth::user()->acceptFriendRequest($user);
        return redirect()
        ->route('profile.show', ['email'=>$email])
        ->with('info','Friend request accepted.');
    }

    public function leaveFriendship($email)
    {
        $user = User::where('email', $email)->first();
        if (!$user) {
            return redirect()
            ->route('index')
            ->with('info', 'That user could not be found');
        }

        if (Auth::user()->isFriendsWith($user)){
            
            Auth::user()->deleteFriend($user);
            
            return redirect()->back()
            ->with('info', "You leave the friendship with {$user->getFirstNameOrUsername()}.");
        } else {
            return redirect()->back()
            ->with('info', "You aren't friend of {$user->getFirstNameOrUsername()}.");
        }
    }
}
