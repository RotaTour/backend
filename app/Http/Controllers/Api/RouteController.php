<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use JWTAuth;
use App\Models\User;
use App\Models\Route;
use App\Models\Place;
use App\Models\Item;

class RouteController extends Controller
{
    /**
     * Display a listing of the resource.
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
     * Store a newly created resource in storage.
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
     *     @SWG\Response(
     *         response=200,
     *         description="Success - User found and will save the Route."
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="User not found.",
     *     )
     * )
     */
    public function store(Request $request)
    {
        $route = new Route($request->input());
        $userJWT = JWTAuth::parseToken()->authenticate();
        $user = User::find($userJWT->id);
        if (!$user){
            return response()->json(['error' => 'User not found'], 404);
        } else {
            $route->user_id = $user->id;
            $route->save();
            $info = "Route created!";
            return response()->json(compact('route', 'info'));
        }
    }

    /**
     * Display the specified resource.
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
        $route = Route::where('id', $id)->with(['itens.place'])->first();
        if(!$route) {
            return response()->json(['error' => 'Route not found.'], 404);
        } else {
            return response()->json(compact('route'));
        }

    }

    /**
     * Remove the specified resource from storage.
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
            return response()->json(['info' => 'The Route '.$name.' has deleted.']);
        } else {
            return response()->json(['error' => "The Route could not deleted."], 403);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * 
     * @SWG\Get(
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
     *          required=true,
     *          type="string",
     *          description="Google place - id",
     * 	   ),
     *     @SWG\Parameter(
     *          name="name",
     *          in="body",
     *          schema={"$ref": "#/definitions/NewPlace"},
     *          required=true,
     *          type="string",
     *          description="Google place - name",
     * 	   ),
     *     @SWG\Response(
     *         response=200,
     *         description="Success - Add to Route."
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
        
        $place = Place::where('google_place_id',$input['google_place_id'])->first();
        if (!$place){
            $place = Place::create($input);
        }

        $route = Route::where('id', $input['routeId'])->first();
        if (!$route ){
            return response()->json(['error' => 'Route not found.'], 404);
        }

        $item = new Item();
        $item->route_id = $route->id;
        $item->place_id = $place->id;
        $item->order = 1;
        $item->save();

        return response()->json(['info' => 'Item added to Route '.$route->name]);
        
    }
}
