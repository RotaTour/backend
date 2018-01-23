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

    public function getRequests()
    {
        $response = array();
        $response['code'] = 200;
        $response['requests'] = Auth::user()->friendRequests();
        return response()->json($response);
    }

    public function getAdd($id)
    {
        $response = array();
        $response['code'] = 400;

        $user = User::find($id);

        if (!$user) {
            $response['code'] = 404;
            $response['message'] = "404 - Usuário não encontrado";
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

    public function getAccept($id)
    {
        $response = array();
        $response['code'] = 400;

        $user = User::find($id);
        
        if (!$user) {
            $response['code'] = 404;
            $response['message'] = "404 - Usuário não encontrado";
            return response()->json($response);
        }

        if (!Auth::user()->hasFriendRequestReceived($user)){
            $response['code'] = 400;
            $response['message'] = "400 - Não há requisição recebida";
            return response()->json($response);
        }

        Auth::user()->acceptFriendRequest($user);
        if(Auth::user()->isFriendsWith($user) || $user->isFriendsWith(Auth::user())  ){
            $response['message'] = "Pedido de amizade aceito!";
            $response['html'] = "<a href=\"javascript:;\"".
            "onclick=\"friends(".$user->id.", '#people-listed-".$user->id."', 'leavefriendship')\"".
            "class=\"btn btn-primary\">".
            "Deixar a amizade</a>";
            $response['code'] = 200;
        }
        
        return response()->json($response);
    }

    public function leaveFriendship($id)
    {
        $response = array();
        $response['code'] = 400;

        $user = User::find($id);
        
        if (!$user) {
            $response['code'] = 404;
            $response['message'] = "404 - Usuário não encontrado";
            return response()->json($response);
        }

        if (Auth::user()->isFriendsWith($user)){

            Auth::user()->deleteFriend($user);
            if(!Auth::user()->isFriendsWith($user)){
                $response['message'] = "Pedido de amizade aceito!";
                $response['html'] = "<a href=\"javascript:;\"".
                "onclick=\"friends(".$user->id.", '#people-listed-".$user->id."', 'add')\"".
                "class=\"btn btn-primary\">".
                "Adicionar como amigo</a>";
                $response['code'] = 200;
            }
        } else {
            $response['message'] = "400 - O usuário não é seu amigo(a)";
        }

        return response()->json($response);
    }
}
