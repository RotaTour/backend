<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
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

    public function new(Request $request)
    {
        $data = $request->all();
        $input = json_decode($data['data'], true);
        unset($data['data']);
        foreach ($input as $key => $value) $data[$key] = $value;

        $response = array();
        $response['code'] = 400;
        
        if ($request->hasFile('image')){
            $validator_data['image'] = 'required|mimes:jpeg,jpg,png,gif|max:2048';
        }else{
            $validator_data['content'] = 'required';
        }

        $validator = Validator::make($data, $validator_data);
        
        if ($validator->fails()) {
            $response['code'] = 400;
            $response['message'] = implode(' ', $validator->errors()->all());
        }else{
            $post = new Status();
            $post->body = !empty($data['content'])?$data['content']:'';
            $post->user_id = Auth::user()->id;
            if($post->save()){
                $response['code'] = 200;
            } else {
                $response['code'] = 400;
                $response['message'] = "Something went wrong!";
                $post->delete();
            }
        }
        return response()->json($response);
    }

    public function single()
    {
        return "";
    }

    public function destroy(Request $request)
    {
        $response = array();
        $response['code'] = 400;

        $post = Status::find($request->input('id'));
        if ($post){
            if ($post->user_id == Auth::id()) {
                if ($post->delete()) {
                    $response['code'] = 200;
                }
            }
        }

        return response()->json($response);

    }

    public function like(Request $request)
    {
        $user = Auth::user();

        $response = array();
        $response['code'] = 400;

        $post = Status::find($request->input('id'));
        if ($post){
            if($user->hasLikedStatus($post)) // Unlike
            {
                $deleted = $post->likes
                            ->where('user_id', Auth::user()->id)
                            ->first()
                            ->delete();
                if($deleted){
                    $response['code'] = 200;
                    $response['type'] = 'unlike';
                }
                
            } else {                        // Like
                $like = $post->likes()->create([
                    'user_id' => $user->id,
                ]);
                if($like){
                    $response['code'] = 200;
                    $response['type'] = 'like';
                }
            }
            if ($response['code'] == 200){
                $response['like_count'] = $post->getLikeCount();
            }
        }
        return response()->json($response);
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
