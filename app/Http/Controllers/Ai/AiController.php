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
     */
    public function routes()
    {
        $routes = Route::all();
        return response()->json(compact('routes'));
    }

    /**
     * Return all statuses from database.
     *
     * @return \Illuminate\Http\Response
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
     */
    public function users()
    {
        $users = User::all();
        return response()->json(compact('users'));
    }

    

}
