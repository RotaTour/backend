<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Route;
use App\Models\Place;
use App\Models\Item;
use GooglePlaces;
use Auth;

class RouteController extends Controller
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
        $user = Auth::user();
        $routes = $user->routes()->get();
        return view('route.index', compact('routes','user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('route.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);

        $route = new Route($request->input());
        $route->user_id = Auth::user()->id;
        $route->save();

        return redirect()->route('route.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = Auth::user();
        $route = Route::where('id', $id)->with('itens.place')->first();
        if(!$route) {
            return redirect()
            ->route('index')
            ->with('info', 'A rota selecionada não foi encontrada');
        }

        return view('route.show', compact('route','user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
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
        $this->validate($request, [
            'name' => 'required',
        ]);

        $route = Route::find($id);
        $input = $request->input();
        if (!$route){
            return redirect()
            ->back()
            ->with('error', 'A rota selecionada não foi encontrada');
        }
        $route->name = $input['name'];
        $route->body = $input['body'];
        $route->update();

        return redirect()->route('route.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $route = Route::find($id);
        if (!$route){
            return redirect()
            ->back()
            ->with('info', 'A rota selecionada não foi encontrada');
        }

        if (Auth::user()->id == $route->user()->first()->id){
            $name = $route->name;
            $route->delete();
            return redirect()
            ->back()
            ->with('info', 'A rota '.$name.' foi removida');
        } else {
            return redirect()
            ->back()
            ->with('info', 'A rota selecionada não pode ser removida');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addToRoute(Request $request)
    {
        $this->validate($request, [
            'routeId' => 'required',
            'google_place_id' =>'required',
        ]);

        $input = $request->input();
        
        $place = Place::where('google_place_id',$input['google_place_id'])->first();
        if (!$place){
            $place = new Place();
            $place->google_place_id = $input['google_place_id'];
            $place->google_json = GooglePlaces::placeDetails($place_id, ['language'=>'pt-BR']);
            $place->save();
        }

        $route = Route::where('id', $input['routeId'])->first();
        if (!$route ){
            // error
            $retorno = ['status'=>404, 'body'=>'Rota '.$input['routeId'].' não existe'];
            return response()->json($retorno);
        }

        $item = new Item();
        $item->route_id = $route->id;
        $item->place_id = $place->id;
        $item->order = 1;
        $item->save();

        $retorno = ['status'=>200, 'body'=>'Adicionado à Rota', 'name'=>$route->name];
        return response()->json($retorno);   
    }

    public function like($id)
    {
        $user = Auth::user();

        $response = array();
        $response['code'] = 400;

        $route = Route::find($id);
        if ($route){
            if($route->checkLike($user->id)) // Unlike
            {
                $deleted = $route->likes
                            ->where('user_id', $user->id)
                            ->first()
                            ->delete();
                if($deleted){
                    $response['code'] = 200;
                    $response['type'] = 'unlike';
                }
            } else {                        // Like
                $like = $route->likes()->create([
                    'user_id' => $user->id,
                ]);
                if($like){
                    $response['code'] = 200;
                    $response['type'] = 'like';
                }
            }
            if ($response['code'] == 200){
                $response['like_count'] = $route->getLikeCount();
            }
        }
        return response()->json($response);
    }

    /**
     * Check/uncheck a item
     *
     * @param  string $id
     * @return \Illuminate\Http\Response
     */
    public function checkItem($id)
    {
        $user = Auth::user();
        
        $response = array();
        $response['code'] = 400;
        $response['check'] = 0;
        $save = false;

        $item = Item::find($id);
        if(!$item){
            $response['code'] = 404;
            $response['error'] = "Item not found";
        } else {
            if($item->route->user->id == $user->id){
                $item->done = !($item->done);
                $save = $item->save();
            }
        }

        if($save){
            $response['code'] = 200;
            $response['check'] = $item->done;
        }

        return response()->json($response, $response['code']);
    }

    /**
     * Check/uncheck a item
     *
     
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function action(Request $request)
    {

    }
}
