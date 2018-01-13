<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use JWTAuth;
use App\Models\User;
use App\Models\Route;
use App\Models\Place;
use App\Models\Item;
use App\Models\Tag;
use GooglePlaces;

class RouteController extends Controller
{
    /**
     * Display a listing of the routes.
     *
     * @return \Illuminate\Http\Response
     * 
     * @SWG\Get(
     *     path="/api/routes",
     *     description="Returns the user's routes.",
     *     operationId="api.routes.index",
     *     produces={"application/json"},
     *     tags={"routes"},
     *     @SWG\Response(
     *         response=200,
     *         description="Success - User found and return Routes."
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="User not found.",
     *     )
     * )
     */
    public function index()
    {
        $userJWT = JWTAuth::parseToken()->authenticate();
        $user = User::find($userJWT->id);
        if (!$user){
            return response()->json(['error' => 'User not found'], 404);
        } else {
            $routes = $user->routes()->get();
            return response()->json(compact('routes'));
        }
    }

    /**
     * Store a newly created route in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * 
     * @SWG\Post(
     *     path="/api/routes",
     *     description="Store a user's new route.",
     *     operationId="api.routes.store",
     *     produces={"application/json"},
     *     tags={"routes"},
     *     @SWG\Parameter(
     *          name="name",
     *          in="body",
     *          schema={"$ref": "#/definitions/NewRoute"},
     *          required=true,
     *          type="string",
     *          description="Name of the new Route",
     * 	   ),
     *     @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          schema={"$ref": "#/definitions/NewRoute"},
     *          required=false,
     *          type="string",
     *          description="The route description",
     * 	   ),
     *     @SWG\Parameter(
     *          name="tags",
     *          in="body",
     *          schema={"$ref": "#/definitions/NewRoute"},
     *          required=false,
     *          type="array",
     *          description="A tag list for the route",
     * 	   ),
     *     @SWG\Response(
     *         response=200,
     *         description="Success - User found and will save the Route."
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="User not found.",
     *     ),
     *     @SWG\Response(
     *         response=500,
     *         description="Route could not be saved.",
     *     )
     * )
     */
    public function store(Request $request)
    {
        $input = $request->input();
        $route = new Route($input);

        $userJWT = JWTAuth::parseToken()->authenticate();
        $user = User::find($userJWT->id);
        if (!$user){
            return response()->json(['error' => 'User not found'], 404);
        } 
        
        $route->user_id = $user->id;
        $info = "";
        if( $route->save() ){
            $info = "Route created!";
        } else {
            return response()->json(['error'=>'Route could not be saved'], 500);
        }
        
        if( isset($input['tags']) ){
            if( is_array($input['tags']) ){
                $this->syncTags($route, $input['tags']);
            }
        }

        return response()->json(compact('route', 'info'), 201);
        
    }

    /**
     * Display the specified route.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     *
     * @SWG\Get(
     *     path="/api/routes/show/{id}",
     *     description="Returns the route details.",
     *     operationId="api.routes.show",
     *     produces={"application/json"},
     *     tags={"routes"},
     *     @SWG\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          type="string",
     *          description="Route id in database",
     * 	   ),
     *     @SWG\Response(
     *         response=200,
     *         description="Success - Route found."
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="Route not found.",
     *     )
     * )
     */
    public function show($id)
    {
        $route = Route::where('id', $id)->with(['itens.place', 'tags'])->first();
        if(!$route) {
            return response()->json(['error' => 'Route not found.'], 404);
        } else {
            return response()->json(compact('route'));
        }

    }


    /**
     * Update the specified route in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     *
     * @SWG\Put(
     *     path="/api/routes/update/{id}",
     *     description="Update a user's route.",
     *     operationId="api.routes.update",
     *     produces={"application/json"},
     *     tags={"routes"},
     *     @SWG\Parameter(
     *          name="name",
     *          in="body",
     *          schema={"$ref": "#/definitions/NewRoute"},
     *          required=true,
     *          type="string",
     *          description="Name of the new Route",
     * 	   ),
     *     @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          schema={"$ref": "#/definitions/NewRoute"},
     *          required=false,
     *          type="string",
     *          description="The route description",
     * 	   ),
     *     @SWG\Parameter(
     *          name="tags",
     *          in="body",
     *          schema={"$ref": "#/definitions/NewRoute"},
     *          required=false,
     *          type="array",
     *          description="A tag list for the route",
     * 	   ),
     *     @SWG\Response(
     *         response=200,
     *         description="Success - User found and will update the Route."
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="User not found Or Route not found.",
     *     ),
     *     @SWG\Response(
     *         response=403,
     *         description="Forbbiden - You could not update the Route.",
     *     ),
     *     @SWG\Response(
     *         response=500,
     *         description="Route could not be updated.",
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $input = $request->input();

        $userJWT = JWTAuth::parseToken()->authenticate();
        $user = User::find($userJWT->id);
        if (!$user){
            return response()->json(['error' => 'User not found'], 404);
        }

        $route = Route::find($id);
        if (!$route){
            return response()->json(['error' => 'Route not found'], 404);
        }
        
        if ($user->id != $route->user()->first()->id){
            return response()->json(['error' => "Forbbiden - You could not update the Route."], 403);
        }

        $info = "";
        if( $route->update($input) ){
            $info = "Route updated!";
        } else {
            return response()->json(['error'=>'Route could not be updated'], 500);
        }
        
        if( isset($input['tags']) ){
            if( is_array($input['tags']) ){
                $this->syncTags($route, $input['tags']);
            }
        }

        return response()->json(compact('route', 'info'), 200);
    }

    /**
     * Remove the specified route from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * 
     * @SWG\Delete(
     *     path="/api/routes/delete/{id}",
     *     description="Delete the specified route.",
     *     operationId="api.routes.delete",
     *     produces={"application/json"},
     *     tags={"routes"},
     *     @SWG\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          type="string",
     *          description="Route id in database",
     * 	   ),
     *     @SWG\Response(
     *         response=200,
     *         description="Success - Route found."
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="Route not found.",
     *     )
     * )
     */
    public function destroy($id)
    {
        $route = Route::find($id);
        if (!$route){
            return response()->json(['error' => 'Route not found.'], 404);
        }

        $userJWT = JWTAuth::parseToken()->authenticate();
        $user = User::find($userJWT->id);

        if ($user->id == $route->user()->first()->id){
            $name = $route->name;
            $route->delete();
            return response()->json(['info' => 'The Route '.$name.' was deleted.']);
        } else {
            return response()->json(['error' => "The Route could not deleted."], 403);
        }
    }

    /**
     * Add a item into a route.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * 
     * @SWG\Post(
     *     path="/api/routes/addToRoute",
     *     description="Adds an Item to specified route.",
     *     operationId="api.routes.addToRoute",
     *     produces={"application/json"},
     *     tags={"routes"},
     *     @SWG\Parameter(
     *          name="routeId",
     *          in="body",
     *          schema={"$ref": "#/definitions/NewRoute"},
     *          required=true,
     *          type="string",
     *          description="Route id in database",
     * 	   ),
     *     @SWG\Parameter(
     *          name="google_place_id",
     *          in="body",
     *          schema={"$ref": "#/definitions/NewPlace"},
     *          required=false,
     *          type="string",
     *          description="Google place - id",
     * 	   ),
     *     @SWG\Parameter(
     *          name="google_places",
     *          in="body",
     *          schema={"$ref": "#/definitions/NewPlace"},
     *          required=false,
     *          type="array",
     *          description="List (Array) of Google Places Ids to include in the Especified Route"
     * 	   ),
     *     @SWG\Response(
     *         response=201,
     *         description="Success - Add to Route."
     *     ),
     *     @SWG\Response(
     *         response=401,
     *         description="Param google_place_id OR google_places not provided",
     *     ),
     *     @SWG\Response(
     *         response=403,
     *         description="Forbbiden - You are not the owner",
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="Route not found.",
     *     )
     * )
     */
    public function addToRoute(Request $request)
    {
        $input = $request->input();

        $route = Route::where('id', $input['routeId'])->first();
        if (!$route ){
            return response()->json(['error' => 'Route not found.'], 404);
        }

        $userJWT = JWTAuth::parseToken()->authenticate();
        $user = User::find($userJWT->id);
        if ($user->id != $route->user()->first()->id){
            return response()->json(['error' => 'Forbbiden - You are not the owner'], 403);
        }

        if( isset($input['google_places']) ){

            if( is_array($input['google_places']) ){
                $google_places = $input['google_places'];
                foreach($google_places as $google_place)
                {
                    $place = Place::where('google_place_id',$google_place)->first();
                    if (!$place){
                        $place = new Place();
                        $place->google_place_id = $google_place;
                        $place->google_json = GooglePlaces::placeDetails($google_place, ['language'=>'pt-BR']);
                        $place->save();
                    }

                    $item = new Item();
                    $item->route_id = $route->id;
                    $item->place_id = $place->id;
                    $item->order = 1;
                    $item->save();
                }
            }

        } else if( isset($input['google_place_id']) ) {
            $place = Place::where('google_place_id',$input['google_place_id'])->first();
            if (!$place){
                $place = new Place();
                $place->google_place_id = $input['google_place_id'];
                $place->google_json = GooglePlaces::placeDetails($input['google_place_id'], ['language'=>'pt-BR']);
                $place->save();
            }
            $item = new Item();
                    $item->route_id = $route->id;
                    $item->place_id = $place->id;
                    $item->order = 1;
                    $item->save();
        } else {
            return response()->json(['error' => 'Param google_place_id OR google_places not provided'], 400);
        }

        return response()->json(['info' => 'Item(s) added to Route '.$route->name], 201);
    }

    /*
     * Function to Synchronize Tags in Route
     */
    protected function syncTag(Route $route, $tags)
    {
        if(is_array($tags)){
            // Collection to Synchronize
            $collection = collection();

            foreach($tags as $tagName){
                $tag = Tag::where('name', $tagName)->first();
                if(!$tag){
                    $tag = Tag::create(['name'=>$tagName, 'user_id'=>$route->user_id]);
                }
                $collection->push($tag);
            }
            $route->tags()->sync($collection);
        }
        
    }
}
