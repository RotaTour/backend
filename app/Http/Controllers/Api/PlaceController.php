<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use GooglePlaces;

class PlaceController extends Controller
{
    public function index()
    {
        //$response = GooglePlaces::placeAutocomplete('Recife');
        //$response = GooglePlaces::textSearch('Recife, Pernambuco, Brazil');
        //$response = GooglePlaces::placeDetails('ChIJ5UbEiG8ZqwcR1H9EIin1njw');
        $response = GooglePlaces::placeDetails('ChIJVyuijGQZqwcREEzZ32LILvA');
        dd($response);
    }
}
