<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Faker\Factory as Faker;
use App\Models\User;
use App\Models\Status;

class AdminController extends Controller
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
        return "Admin Index";
    }

    public function users()
    {
        return "Admin Users";
    }

    public function posts()
    {
        return "Admin Posts";
    }

    public function checkUsernames()
    {
        $users = User::whereNull('username')->get();
        $updated_users = [];
        foreach($users as $u)
        {
            $username = explode("@", $u->email)[0];
            $tryAgain = true;
            $contagem = 1;
            while($tryAgain)
            {
                $user = User::where('username', $username)->first();
                if(!$user){
                    $tryAgain = false;
                } else {
                    $username = $username . "-" . ($contagem++);
                }
            }
            
            $u->username = $username;
            if( $u->update() ){
                array_push($updated_users, $u);
            }
        }
        
        return response()->json(compact('updated_users'));
    }

    public function checkAvatar()
    {
        $updated_users = [];
        $fulano = User::where('email', 'fulano@gmail.com')->first();
        $beltrano = User::where('email', 'beltrano@gmail.com')->first();
        $cicrano = User::where('email', 'sicrano@gmail.com')->first();
        if(!$cicrano){
            $cicrano = User::where('email', 'cicrano@gmail.com')->first();
        }

        if($fulano){
            $avatar = asset('images/profile/fulano.png');
            $fulano->avatar = $avatar;
            if( $fulano->update() ){
                array_push($updated_users, $fulano);
            }
        }
        if($beltrano){
            $avatar = asset('images/profile/beltrano.png');
            $beltrano->avatar = $avatar;
            if( $beltrano->update() ){
                array_push($updated_users, $beltrano);
            }
        }
        if($cicrano){
            $avatar = asset('images/profile/cicrano.png');
            $cicrano->avatar = $avatar;
            $cicrano->email = "cicrano@gmail.com";
            $cicrano->name = "Cicrano Moura";
            $cicrano->username = "cicrano";
            if( $cicrano->update() ){
                array_push($updated_users, $cicrano);
            }
        }

        return response()->json(compact('updated_users'));
    }

    public function postsFactory()
    {
        $posts_created = [];
        $users = [];
        $number = 5;

        $fulano = User::where('email', 'fulano@gmail.com')->first();
        $beltrano = User::where('email', 'beltrano@gmail.com')->first();
        $cicrano = User::where('email', 'sicrano@gmail.com')->first();
        if(!$cicrano){
            $cicrano = User::where('email', 'cicrano@gmail.com')->first();
        }

        $faker = Faker::create();
        
        if($fulano) array_push($users, $fulano);
        if($beltrano) array_push($users, $beltrano);
        if($cicrano) array_push($users, $cicrano);

        foreach($users as $u){
            for($i=0; $i<$number;$i++)
            {
                $post = new Status([
                    'body'=> $faker->text,
                    'user_id'=>$u->id
                    ]
                );
                if($post->save()) array_push($posts_created, $post);
            }
        }
        
        return response()->json(compact('posts_created'));
    }

    public function requestFriends()
    {
        $users = User::all();
        $pedidos = array();
        $fulano = User::where('email', 'fulano@gmail.com')->first();
        $beltrano = User::where('email', 'beltrano@gmail.com')->first();
        $cicrano = User::where('email', 'sicrano@gmail.com')->first();
        if(!$cicrano){
            $cicrano = User::where('email', 'cicrano@gmail.com')->first();
        }

        // fulano pede a amizade de todos
        $current = $fulano;
        foreach($users as $user)
        {
            if($current->hasFriendRequestPending($user)) continue;
            if($current->isFriendsWith($user)) continue;
            if($current->id == $user->id) continue;
            else {
                $current->addFriend($user);
                array_push($pedidos, "de ".$current->name." para ".$user->name);
            }
        }

        // beltrano pede a amizade de todos
        $current = $beltrano;
        foreach($users as $user)
        {
            if($current->hasFriendRequestPending($user)) continue;
            if($current->isFriendsWith($user)) continue;
            if($current->id == $user->id) continue;
            else {
                $current->addFriend($user);
                array_push($pedidos, "de ".$current->name." para ".$user->name);
            }
        }

        // fulano pede a amizade de todos
        $current = $cicrano;
        foreach($users as $user)
        {
            if($current->hasFriendRequestPending($user)) continue;
            if($current->isFriendsWith($user)) continue;
            if($current->id == $user->id) continue;
            else {
                $current->addFriend($user);
                array_push($pedidos, "de ".$current->name." para ".$user->name);
            }
        }

        return response()->json($pedidos);
    }
}
