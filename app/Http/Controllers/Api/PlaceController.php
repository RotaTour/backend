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
     * 
     * @SWG\Get(
     *     path="/api/places/show",
     *     description="Returns place details.",
     *     operationId="api.places.show",
     *     produces={"application/json"},
     *     tags={"places"},
     *     @SWG\Parameter(
     *          name="google_place_id",
     *          in="body",
     *          schema={"$ref": "#/definitions/NewPlace"},
     *          required=true,
     *          type="string",
     *          description="UUID From Google Places API",
     * 	   ),
     *     @SWG\Response(
     *         response=200,
     *         description="Place detail based on Google-place-id."
     *     ),
     *     @SWG\Response(
     *         response=401,
     *         description="Unauthorized action.",
     *     )
     * )
     */
    public function show(Request $request)
    {
        // the token is valid and we have find the user via the sub claim
        $userJWT = JWTAuth::parseToken()->authenticate();

        $user = User::find($userJWT->id);
        $routes = $user->routes()->get();
        $place = GooglePlaces::placeDetails( $request->input('google_place_id') );
        return response()->json(compact('routes', 'place'));
        
    }
}
