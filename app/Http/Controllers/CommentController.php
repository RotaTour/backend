<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Place;
use App\Models\Route;
use Auth;
use View;

class CommentController extends Controller
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

    public function add(Request $request)
    {
        $data = $request->all();
        $input = json_decode($data['data'], true);
        unset($data['data']);
        foreach ($input as $key => $value) $data[$key] = $value;

        $response['code'] = 400;
        $response['comment'] = false;

        switch ($data['localClass']) {
            case 'place':
                $response['comment'] = $this->addPlaceComment($data);
                break;
            case 'route':
                $response['comment'] = $this->addRouteComment($data);
                break;
            case 'anything':
                $response['comment'] = false;
                break;
        }

        if($response['comment']){
            $response['code'] = 200;
            $comment = $response['comment'];
            $html = View::make('comment.partials.comment', compact('comment'));
            $response['html'] = $html->render();
        }
        
        return response()->json($response, $response['code']);
    }

    protected function addPlaceComment($input)
    {
        $place = Place::find($input['localId']);
        if(!$place){
            return false;
        }
        $c = new Comment();
        $c->body = $input['body'];
        $c->user_id = Auth::user()->id;
        if ($place->comments()->save($c)) return $c;
        else return false;
    }

    protected function addRouteComment($input)
    {
        $route = Route::find($input['localId']);
        if(!$route){
            return false;
        }
        $c = new Comment();
        $c->body = $input['body'];
        $c->user_id = Auth::user()->id;
        if ($route->comments()->save($c)) return $c;
        else return false;
    }
    
    public function delete($comment_id)
    {
        
        $response['code'] = 400;
        $response['msg'] = "";
        $comment = Comment::find($comment_id);

        if(!$comment){
            $response['code'] = 404;
            $response['msg'] = "Comentário not found";
            return response()->json($response, $response['code']);
        }

        if( $comment->user_id !=  Auth::user()->id){
            $response['code'] = 403;
            $response['msg'] = "Você não é o dono do comentário";
            return response()->json($response, $response['code']);
        }

        if($comment->delete()){
            $response['code'] = 200;
            $response['msg'] = "Comentário deletado com sucesso";
            return response()->json($response, $response['code']);
        }
    }
}
