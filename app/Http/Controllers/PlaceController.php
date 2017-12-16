<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Place;
use App\Models\Route;
use App\Models\Category;
use GooglePlaces;
use Auth;

class PlaceController extends Controller
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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();
        return view('place.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $place_id = $request->input('place_id');
        $routes = Auth::user()->routes()->get();

        $place = Place::where('google_place_id', $place_id)->first();
        if(!$place){
            $place = new Place();
            $place->google_place_id = $place_id;
            $place->google_json = GooglePlaces::placeDetails($place_id, ['language'=>'pt-BR']);
            $place->save();
        } else {
            $place->google_json =  json_decode($place->google_json);
        }
        
        //dd($place);
        return view('place.show', compact('place', 'place_id', 'routes'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * show all categories
     *
     * @return \Illuminate\Http\Response
     */
    public function categories()
    {
        $categories = Category::all();
        return view('place.categories', compact('categories'));
    }

    /**
     * show all points of interest
     *
     * @return \Illuminate\Http\Response
     */
    public function pointsOfInterest()
    {
        return "points of intererest";
    }

}
