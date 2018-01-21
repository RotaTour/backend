<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AdminController extends Controller
{
    
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
}
