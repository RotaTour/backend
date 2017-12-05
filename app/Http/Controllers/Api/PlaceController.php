<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use JWTAuth;
use App\Models\User;
use GooglePlaces;

class PlaceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$response = GooglePlaces::placeAutocomplete('Recife');
        //$response = GooglePlaces::textSearch('Recife, Pernambuco, Brazil');
        //$response = GooglePlaces::placeDetails('ChIJ5UbEiG8ZqwcR1H9EIin1njw');
        $recife = GooglePlaces::placeDetails('ChIJVyuijGQZqwcREEzZ32LILvA');
        return response()->json(compact('recife'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        // the token is valid and we have find the user via the sub claim
        $userJWT = JWTAuth::parseToken()->authenticate();

        $user = User::find($userJWT->id);
        $routes = $user->routes()->get();
        $place = GooglePlaces::placeDetails( $request->input('place_id') );
        return response()->json(compact('routes', 'place'));
        
    }
}
