<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;
use Hash;
use Session;

class SettingsController extends Controller
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
        return view('profile.settings', compact('user'));
    }

    public function update(Request $request)
    {
        $additional_msg = false;
        if ($request->input("type") == "password") {
            $validator = Validator::make($request->all(), [
                'current_password' => 'required|passcheck',
                'password' => 'required|min:6|confirmed'
            ]);

            if ($validator->fails()) {
                $save = false;
            } else {
                Auth::user()->password = Hash::make($request->input("password"));
                $save = Auth::user()->save();
            }
        } elseif ($request->input("type") == "username"){
            $validator = Validator::make($request->all(), [
                'username' => 'required|max:191|unique:users,username,' . Auth::user()->id
            ]);

            $user = [
                'username' => $request->input("username"),
                'name' => Auth::user()->name,
                'email' => Auth::user()->email
            ];

            if ($validator->fails()) {
                $save = false;
            } else {
                Auth::user()->username = $user['username'];
                if (Auth::user()->validateUsername()) {
                    $save = Auth::user()->save();
                }else{
                    $save = false;
                    $additional_msg = "O username não pode conter caracteres especiais ou espaço";
                }
            }
        } elseif ($request->input("type") == "avatar"){
            $validator = Validator::make($request->all(), [
                'avatar' => 'required|max:255|url'
            ]);

            $user = [
                'avatar' => $request->input("avatar"),
                'name' => Auth::user()->name,
                'email' => Auth::user()->email
            ];

            if ($validator->fails()) {
                $save = false;
            } else {
                Auth::user()->avatar = $user['avatar'];
                if ( Auth::user()->save() ) {
                    $save = true;
                }else{
                    $save = false;
                    $additional_msg = "Não foi possível salvar";
                }
            }
        } else {
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:191',
                'email' => 'required|email|max:191|unique:users,email,' . Auth::user()->id
            ]);

            $user = [
                'name' => $request->input("name"),
                'email' => $request->input("email")
            ];
            
            if($request->has('location')){
                $user['location'] = $request->input("location");
            }

            if ($validator->fails()) {
                $save = false;
            }else {
                Auth::user()->name = $user['name'];
                Auth::user()->email = $user['email'];
                if( isset($user['location']) ) Auth::user()->location = $user['location'];
                
                $save = Auth::user()->save();
            }
        }

        if ($save){
            $request->session()->flash('alert-success', 'Suas configurações foram salvas com sucesso!');
        }else{
            $request->session()->flash('alert-danger', ($additional_msg)?$additional_msg:'Houve um problema ao salvar as configurações!');
        }

        if ($request->input("type") == "password") {
            if ($save){
                return redirect()->route('settings.index');
            }else{
                return redirect()->route('settings.index')
                ->withErrors($validator);
            }
        }else{
            if ($save){
                return redirect()->route('settings.index');
            }else{
                $user = Auth::user();
                return redirect()->route('settings.index')
                ->withErrors($validator)
                ->with('user', $user);
            }
        }
    }
}
