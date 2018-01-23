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
        $user = Auth::user();
        $friends = Auth::user()->friends();
        $requests = Auth::user()->friendRequests();
        return view('friends.index', compact('user', 'friends', 'requests') );
    }

    public function getAdd($id)
    {
        $response = array();
        $response['code'] = 400;

        $user = User::find($id);

        if (!$user) {
            $response['code'] = 404;
            $response['message'] = "404 - Uusuário não encontrado";
            return response()->json($response);
        }

        if (Auth::user()->id == $user->id ){
            $response['message'] = "400 - Você não pode ser amigo de você mesmo(a)";
            return response()->json($response);
        }

        if (Auth::user()->hasFriendRequestPending($user) || 
        $user->hasFriendRequestPending(Auth::user()) ){
            $response['message'] = "400 - Já existe um pedido em espera";
            return response()->json($response);
        }

        if (Auth::user()->isFriendsWith($user)){
            $response['message'] = "400 - Vocês já são amigos(as)";
            return response()->json($response);
        }

        Auth::user()->addFriend($user);
        if ( Auth::user()->hasFriendRequestPending($user) || 
        $user->hasFriendRequestPending(Auth::user()) ){
            $response['message'] = "Pedido de amizade enviado com sucesso!";
            $response['html'] = "<p>Esperando por @".$user->getNameOrUsername()." aceitar a sua solicitação de amizade</p>";
            $response['code'] = 200;
        }
        
        return response()->json($response); 
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
