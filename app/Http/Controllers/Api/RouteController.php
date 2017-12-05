<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use JWTAuth;
use App\Models\User;
use App\Models\Route;

class RouteController extends Controller
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
        $routes = $user->routes()->get();
        return response()->json(compact('routes'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $route = Route::where('id', $id)->with(['itens.place'])->first();
        if(!$route) {
            return response()->json(['error' => 'A rota selecionada não foi encontrada'], 404);
        }

        return response()->json(compact('route'));
    }
}
