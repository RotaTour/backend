<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Place;
use Auth;

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
        $input = $request->input();
        $resposta = false;

        switch ($input['localClass']) {
            case 'place':
                $resposta = $this->addPlaceComment($input);
                break;
            case 'route':
                $respostas = false;
                break;
            case 'anything':
                $resposta = false;
                break;
        }

        if($resposta){
            return redirect()
            ->back()
            ->with('info', 'Comentário salvo');
        } else {
            return redirect()
            ->back()
            ->with('info', 'Não foi possível salvar o comentário');
        }
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
        if ($place->comments()->save($c)) return true;
        else return false;
    }
    
    public function delete($comment_id)
    {
        $comment = Comment::find($comment_id);
        if(!$comment){
            return redirect()
            ->back()
            ->with('info', 'Não foi possível encontrar o comentário');
        }

        if( $comment->user_id !==  Auth::user()->id){
            return redirect()
            ->back()
            ->with('info', 'Não foi possível excluir o comentário, você não é o dono');
        }

        if($comment->delete()){
            return redirect()
            ->back()
            ->with('info', 'O comentário foi excluido com sucesso.');
        }
        
    }
}
