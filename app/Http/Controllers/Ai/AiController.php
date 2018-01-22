<?php

namespace App\Http\Controllers\Ai;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\{Category, Comment, Item, Like, Place, Route, Status, Tag, User};

class AiController extends Controller
{
    /**
     * Return sample data for test.
     *
     * @return \Illuminate\Http\Response 
     * @SWG\Get(
     *     path="/ai/",
     *     description="Return sample data for test.",
     *     operationId="ai.index",
     *     produces={"application/json"},
     *     tags={"AI"},
     *     @SWG\Response(
     *         response=200,
     *         description="Success - Info data returned."
     *     )
     * )
     * 
     */
    public function index()
    {
        $data['ver'] = '1.0';
        $data['name'] = "RotaTour - UFRPE 2018.1";
        $data['message'] = "Api para uso da Inteligência artificial";
        return response()->json(compact('data'));
    }

    /**
     * Return all models collections
     *
     * @return \Illuminate\Http\Response
     * @SWG\Get(
     *     path="/ai/all",
     *     description="Return all data from Database.",
     *     operationId="ai.all",
     *     produces={"application/json"},
     *     tags={"AI"},
     *     @SWG\Response(
     *         response=200,
     *         description="Success - All data returned."
     *     )
     * )
     * 
     */
    public function all()
    {
        $categories = Category::all();
        $comments = Comment::all();
        $itens = Item::all();
        $likes = Like::all();
        $places = Place::all();
        $routes = Route::all();
        $statuses = Status::all();
        $tags = Tag::all();
        $users = User::all();
        
        return response()->json(
            compact(
                'categories',
                'comments',
                'itens',
                'likes',
                'places',
                'routes',
                'statuses',
                'tags',
                'users'
                )
        );
    }

    /**
     * Return all categories from database.
     * 
     * @return \Illuminate\Http\Response
     * @SWG\Get(
     *     path="/ai/categories",
     *     description="Return all categories data from Database.",
     *     operationId="ai.categories",
     *     produces={"application/json"},
     *     tags={"AI"},
     *     @SWG\Response(
     *         response=200,
     *         description="Success - All categories data returned."
     *     )
     * )
     */
    public function categories()
    {
        $categories = Category::all();
        return response()->json(compact('categories'));
    }

    /**
     * Return all categories from database.
     *
     * @return \Illuminate\Http\Response
     * @SWG\Get(
     *     path="/ai/comments",
     *     description="Return all comments data from Database.",
     *     operationId="ai.comments",
     *     produces={"application/json"},
     *     tags={"AI"},
     *     @SWG\Response(
     *         response=200,
     *         description="Success - All comments data returned."
     *     )
     * )
     */
    public function comments()
    {
        $comments = Comment::all();
        return response()->json(compact('comments'));
    }

    /**
     * Return all itens from database.
     *
     * @return \Illuminate\Http\Response
     * @SWG\Get(
     *     path="/ai/itens",
     *     description="Return all itens data from Database.",
     *     operationId="ai.itens",
     *     produces={"application/json"},
     *     tags={"AI"},
     *     @SWG\Response(
     *         response=200,
     *         description="Success - All itens data returned."
     *     )
     * )
     */
    public function itens()
    {
        $itens = Item::all();
        return response()->json(compact('itens'));
    }

    /**
     * Return all likes from database.
     *
     * @return \Illuminate\Http\Response
     * @SWG\Get(
     *     path="/ai/likes",
     *     description="Return all likes data from Database.",
     *     operationId="ai.likes",
     *     produces={"application/json"},
     *     tags={"AI"},
     *     @SWG\Response(
     *         response=200,
     *         description="Success - All likes data returned."
     *     )
     * )
     */
    public function likes()
    {
        $likes = Like::all();
        return response()->json(compact('likes'));
    }

    /**
     * Return all places from database.
     *
     * @return \Illuminate\Http\Response
     * @SWG\Get(
     *     path="/ai/places",
     *     description="Return all places data from Database.",
     *     operationId="ai.places",
     *     produces={"application/json"},
     *     tags={"AI"},
     *     @SWG\Response(
     *         response=200,
     *         description="Success - All places data returned."
     *     )
     * )
     */
    public function places()
    {
        $places = Place::all();
        return response()->json(compact('places'));
    }


    /**
     * Return all routes from database.
     *
     * @return \Illuminate\Http\Response
     * @SWG\Get(
     *     path="/ai/routes",
     *     description="Return all routes data from Database.",
     *     operationId="ai.routes",
     *     produces={"application/json"},
     *     tags={"AI"},
     *     @SWG\Response(
     *         response=200,
     *         description="Success - All routes data returned."
     *     )
     * )
     */
    public function routes()
    {
        $routes = Route::all();
        return response()->json(compact('routes'));
    }

    /**
     * Return a route with relationships
     *
     * @return \Illuminate\Http\Response
     * @SWG\Get(
     *     path="/ai/routes/{id}",
     *     description="Return a route with relationships",
     *     operationId="ai.routes.detail",
     *     produces={"application/json"},
     *     tags={"AI"},
     *     @SWG\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          type="string",
     *          description="Route id in database",
     * 	   ),
     *     @SWG\Response(
     *         response=200,
     *         description="Success - Route and relationships returned."
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="Error - Route not found."
     *     )
     * )
     */
    public function routeDetail($id)
    {
        $route = Route::find($id);
        if(!$route){
            return response()->json(['error'=>'Route not found'], 404);
        }
        $user = $route->user;
        $tags = $route->tags;
        $itens = $route->itens;
        $comments = $route->comments;
        $likes = $route->likes;
        
        return response()->json(
            compact(
                'route',
                'user',
                'tags',
                'itens',
                'comments',
                'likes'
            ));
    }

    /**
     * Return all statuses from database.
     *
     * @return \Illuminate\Http\Response
     * @SWG\Get(
     *     path="/ai/statuses",
     *     description="Return all statuses data from Database.",
     *     operationId="ai.statuses",
     *     produces={"application/json"},
     *     tags={"AI"},
     *     @SWG\Response(
     *         response=200,
     *         description="Success - All statuses data returned."
     *     )
     * )
     */
    public function statuses()
    {
        $statuses = Status::all();
        return response()->json(compact('statuses'));
    }

    /**
     * Return all routes from database.
     *
     * @return \Illuminate\Http\Response
     * @SWG\Get(
     *     path="/ai/tags",
     *     description="Return all tags data from Database.",
     *     operationId="ai.tags",
     *     produces={"application/json"},
     *     tags={"AI"},
     *     @SWG\Response(
     *         response=200,
     *         description="Success - All tags data returned."
     *     )
     * )
     */
    public function tags()
    {
        $tags = Tag::all();
        return response()->json(compact('tags'));
    }

    /**
     * Return all users from database.
     *
     * @return \Illuminate\Http\Response
     * @SWG\Get(
     *     path="/ai/users",
     *     description="Return all users data from Database.",
     *     operationId="ai.users",
     *     produces={"application/json"},
     *     tags={"AI"},
     *     @SWG\Response(
     *         response=200,
     *         description="Success - All users data returned."
     *     )
     * )
     */
    public function users()
    {
        $users = User::all();
        return response()->json(compact('users'));
    }

    /**
     * Return all user's friends.
     *
     * @return \Illuminate\Http\Response
     * @SWG\Get(
     *     path="/ai/users/{username}/friends",
     *     description="Return all user's friends",
     *     operationId="ai.users.friends",
     *     produces={"application/json"},
     *     tags={"AI"},
     *     @SWG\Parameter(
     *          name="username",
     *          in="path",
     *          required=true,
     *          type="string",
     *          description="Username to get the friends list",
     * 	   ),
     *     @SWG\Response(
     *         response=200,
     *         description="Success - All friends data returned."
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="Error - User not found."
     *     )
     * )
     */
    public function friends($username)
    {
        $user = User::getUser($username);
        if(!$user){
            return response()->json(['error'=>'User not found'], 404);
        }
        $friends = $user->friends();
        return response()->json(compact('friends'));
    }

    

}
