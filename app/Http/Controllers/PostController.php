<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Status;
use App\Models\User;
use Auth;

class PostController extends Controller
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

    public function list(Request $request)
    {
        $wall_type = $request->input('wall_type'); // 0 => all posts, 1 => profile posts, 2 => group posts
        $list_type = $request->input('list_type'); // 0 => all, 1 => only text, 2 => only image
        $optional_id = $request->input('optional_id'); // Group ID, User ID, or empty
        $limit = intval($request->input('limit'));
        if (empty($limit)) $limit = 20;
        $post_min_id = intval($request->input('post_min_id')); // If not empty, post_id < post_min_id
        $post_max_id = intval($request->input('post_max_id')); // If not empty, post_id > post_max_id
        $div_location = $request->input('div_location');

        $user = Auth::user();
        $posts = Status::notReply()->with('user');

        if ($wall_type == 1){
            $posts = $posts->where('user_id', $optional_id);
        } else {
            $posts = Status::notReply()->where(function($query){
                return $query->where('user_id', Auth::user()->id)
                    ->orWhereIn('user_id', Auth::user()->friends()->pluck('id'));
            });
        }
        
        if ($post_min_id > -1){
            $posts = $posts->where('id', '<', $post_min_id);
        }else if ($post_max_id > -1){
            $posts = $posts->where('id', '>', $post_max_id);
        }

        $posts = $posts->limit($limit)->orderBy('id', 'DESC')->get();

        if ($div_location == 'initialize'){
            $div_location = ['top', 'bottom'];
        }else{
            $div_location = [$div_location];
            if (count($posts) == 0) return "";
        }

        $comment_count = 2;

        return view('widgets.wall_posts', compact(
            'posts', 'user', 'wall_type', 'list_type', 
            'optional_id', 'limit', 'div_location', 
            'comment_count')
        );

    }

    public function new()
    {
        return "";
    }

    public function single()
    {
        return "";
    }

    public function destroy()
    {
        return "";
    }

    public function like()
    {
        return "";
    }

    public function likes()
    {
        return "";
    }

    public function comment()
    {
        return "";
    }

    public function commentDelete()
    {
        return "";
    }

}
