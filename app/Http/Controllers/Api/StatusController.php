<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use App\Models\Status;
use App\Models\User;

class StatusController extends Controller
{
    protected $user;
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Return a list of Statuses based on params
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * 
     * @SWG\Get(
     *     path="/api/posts",
     *     description="Return a list of Statuses based on params.",
     *     operationId="api.posts.index",
     *     produces={"application/json"},
     *     tags={"posts"},
     *     @SWG\Parameter(
     *          name="wall_type",
     *          in="path",
     *          required=true,
     *          type="string",
     *          description="0 => all posts, 1 => profile posts, 2 => group posts",
     * 	   ),
     *     @SWG\Parameter(
     *          name="optional_id",
     *          in="path",
     *          required=true,
     *          type="string",
     *          description="If wall_type == 1: Group ID, User ID, or empty",
     * 	   ),
     *     @SWG\Parameter(
     *          name="limit",
     *          in="path",
     *          required=false,
     *          type="number",
     *          description="The max limit of itens",
     * 	   ),
     *     @SWG\Parameter(
     *          name="post_min_id",
     *          in="path",
     *          required=true,
     *          type="number",
     *          description="If not empty, post_id < post_min_id",
     * 	   ),
     *     @SWG\Parameter(
     *          name="post_max_id",
     *          in="path",
     *          required=true,
     *          type="number",
     *          description="If not empty, post_id > post_max_id",
     * 	   ),
     *     @SWG\Response(
     *         response=200,
     *         description="Success - User found and will return Statuses/Posts."
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="User not found.",
     *     )
     * )
     */
    public function list(Request $request)
    {
        $wall_type = $request->input('wall_type'); // 0 => all posts, 1 => profile posts, 2 => group posts
        //$list_type = $request->input('list_type'); // 0 => all, 1 => only text, 2 => only image
        $optional_id = $request->input('optional_id'); // Group ID, User ID, or empty
        $limit = intval($request->input('limit'));
        if (empty($limit)) $limit = 20;
        $post_min_id = intval($request->input('post_min_id')); // If not empty, post_id < post_min_id
        $post_max_id = intval($request->input('post_max_id')); // If not empty, post_id > post_max_id
        //$div_location = $request->input('div_location');

        $userJWT = JWTAuth::parseToken()->authenticate();
        $user = User::find($userJWT->id);
        if (!$user){
            return response()->json(['error' => 'User not found'], 404);
        }

        $posts = Status::notReply()->with('user');

        if ($wall_type == 1){
            $posts = $posts->where('user_id', $optional_id);
        } else {
            $this->user = $user;
            $posts = Status::notReply()->where(function($query){
                return $query->where('user_id', $this->user->id)
                    ->orWhereIn('user_id', $this->user->friends()->pluck('id'));
            })->with('user');
        }

        if ($post_min_id > -1){
            $posts = $posts->where('id', '<', $post_min_id);
        }else if ($post_max_id > -1){
            $posts = $posts->where('id', '>', $post_max_id);
        }

        $posts = $posts->limit($limit)->orderBy('id', 'DESC')->get();
        foreach($posts as $p)
        {
            $p->liked = $p->checkLike($user->id);
        }

        $comment_count = 2;
        return response()->json(
            compact(
            'posts', 'user', 'wall_type', 'list_type', 
            'optional_id', 'limit','comment_count')
        );
    }

    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * * 
     * @SWG\Post(
     *     path="/api/posts/new",
     *     description="Return a list of Statuses based on params.",
     *     operationId="api.posts.new",
     *     produces={"application/json"},
     *     tags={"posts"},
     *     @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          schema={"$ref": "#/definitions/NewStatus"},
     *          required=true,
     *          type="string",
     *          description="Status/Post body content",
     * 	   ),
     *     @SWG\Response(
     *         response=201,
     *         description="Success - Status/Post Post saved."
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="User not found.",
     *     ),
     *     @SWG\Response(
     *         response=400,
     *         description="Bad Request - some param are not present",
     *     )
     * )
     */
    public function new(Request $request)
    {
        $input = $request->all();

        $userJWT = JWTAuth::parseToken()->authenticate();
        $user = User::find($userJWT->id);
        if (!$user){
            return response()->json(['error' => 'User not found'], 404);
        } else {
            $this->user = $user;
        }

        $response = array();
        $response['code'] = 400;

        $validator_data['body'] = 'required'; // $input['body']

        $validator = Validator::make($input, $validator_data);
        if ($validator->fails()) {
            $response['code'] = 400;
            $response['message'] = implode(' ', $validator->errors()->all());

        }else{
            $post = new Status();
            $post->body = !empty($input['body'])?$input['body']:'';
            $post->user_id = $this->user->id;
            if($post->save()){
                $response['code'] = 201;
                $response['message'] = "Post saved";
                $response['obj'] = $post;
            } else {
                $response['code'] = 400;
                $response['message'] = "Something went wrong!";
            }
        }

        return response()->json($response, $response['code']);
    }

    /**
     * Return a status/post specified
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * 
     * @SWG\Get(
     *     path="/api/posts/show/{id}",
     *     description="Return a status/post specified",
     *     operationId="api.posts.single",
     *     produces={"application/json"},
     *     tags={"posts"},
     *     @SWG\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          type="integer",
     *          description="Status/Post id in database",
     * 	   ),
     *     @SWG\Response(
     *         response=201,
     *         description="Success - Status/Post Post returned."
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="Status/Post/User not found.",
     *     )
     * )
     */
    public function single($id)
    {
        $post = Status::find($id);
        if (!$post) return response()->json(['error' => 'Status/Post not found'], 404);
        
        $userJWT = JWTAuth::parseToken()->authenticate();
        $user = User::find($userJWT->id);
        if (!$user) return response()->json(['error' => 'User not found'], 404);

        $post->load('user','replies.user', 'likes.user');
        $post->likesCount = $post->getLikeCount();
        return response()->json( compact('post') );
    }

    /**
     * Delete a status/post specified.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * 
     *  @SWG\Delete(
     *     path="/api/posts/delete/{id}",
     *     description="Delete a status/post specified",
     *     operationId="api.posts.delete",
     *     produces={"application/json"},
     *     tags={"posts"},
     *     @SWG\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          type="integer",
     *          description="Status/Post id in database",
     * 	   ),
     *     @SWG\Response(
     *         response=201,
     *         description="Success - Status/Post Post deleted."
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="Status/Post/User not found.",
     *     )
     * )
     */
    public function destroy($id)
    {
        $response = array();
        $response['code'] = 400;

        $userJWT = JWTAuth::parseToken()->authenticate();
        $user = User::find($userJWT->id);
        if (!$user) return response()->json(['error' => 'User not found'], 404);

        $post = Status::find($id);
        if ($post){
            if ($post->user_id == $user->id) {
                $response['obj'] = $post;
                if ($post->delete()) {
                    $response['code'] = 200;
                }
            }
        } else {
            return response()->json(['error' => 'Status/Post not found'], 404);
        }

        return response()->json($response);
    }


    /**
     * Like or unlike a Status/Post.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * * 
     * @SWG\Post(
     *     path="/api/posts/like",
     *     description="Like or unlike a Status/Post.",
     *     operationId="api.posts.like",
     *     produces={"application/json"},
     *     tags={"posts"},
     *     @SWG\Parameter(
     *          name="id",
     *          in="body",
     *          schema={"$ref": "#/definitions/Status"},
     *          required=true,
     *          type="integer",
     *          description="Status/Post id in batabase",
     * 	   ),
     *     @SWG\Response(
     *         response=201,
     *         description="Success - Status/Post liked/unliked."
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="Status/Post/User not found.",
     *     ),
     *     @SWG\Response(
     *         response=400,
     *         description="Bad Request - some param are not present",
     *     )
     * )
     */
    public function like(Request $request)
    {
        $userJWT = JWTAuth::parseToken()->authenticate();
        $user = User::find($userJWT->id);
        if (!$user) return response()->json(['error' => 'User not found'], 404);

        $response = array();
        $response['code'] = 400;

        $post = Status::find($request->input('id'));
        if ($post){
            if($user->hasLikedStatus($post)) // Unlike
            {
                $deleted = $post->likes
                            ->where('user_id', $user->id)
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
        } else {
            return response()->json(['error' => 'Status/Post not found'], 404);
        }
        return response()->json($response);
    }

    /**
     * Get a list of Likes from a Status/Post.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * * 
     * @SWG\Post(
     *     path="/api/posts/likes",
     *     description="Get a list of Likes from a Status/Post.",
     *     operationId="api.posts.like",
     *     produces={"application/json"},
     *     tags={"posts"},
     *     @SWG\Parameter(
     *          name="id",
     *          in="body",
     *          schema={"$ref": "#/definitions/Status"},
     *          required=true,
     *          type="integer",
     *          description="Status/Post id in batabase",
     * 	   ),
     *     @SWG\Response(
     *         response=201,
     *         description="Success - Status/Post liked/unliked."
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="Status/Post/User not found.",
     *     ),
     *     @SWG\Response(
     *         response=400,
     *         description="Bad Request - some param are not present",
     *     )
     * )
     */
    public function likes(Request $request)
    {
        $userJWT = JWTAuth::parseToken()->authenticate();
        $user = User::find($userJWT->id);
        if (!$user) return response()->json(['error' => 'User not found'], 404);

        $response = array();
        $response['code'] = 400;

        $post = Status::find($request->input('id'));
        
        if ($post){
            $post->load('likes.user');
            $post->likesCount = $post->getLikeCount();
            $response['code'] = 200;
            return response()->json(compact('post'));
        }

        return response()->json($response);
    }


    /**
     * Add a comment to a Status/Post.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * * 
     * @SWG\Post(
     *     path="/api/posts/comment",
     *     description="Add a comment to a Status/Post.",
     *     operationId="api.posts.comment",
     *     produces={"application/json"},
     *     tags={"posts"},
     *     @SWG\Parameter(
     *          name="id",
     *          in="body",
     *          schema={"$ref": "#/definitions/Status"},
     *          required=true,
     *          type="integer",
     *          description="Status/Post id in batabase",
     * 	   ),
     *     @SWG\Parameter(
     *          name="comment",
     *          in="body",
     *          schema={"$ref": "#/definitions/Status"},
     *          required=true,
     *          type="string",
     *          description="The body of comment content",
     * 	   ),
     *     @SWG\Response(
     *         response=201,
     *         description="Success - Status/Post commented."
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="Status/Post/User not found.",
     *     ),
     *     @SWG\Response(
     *         response=400,
     *         description="Bad Request - some param are not present",
     *     )
     * )
     */
    public function comment(Request $request)
    {
        $userJWT = JWTAuth::parseToken()->authenticate();
        $user = User::find($userJWT->id);
        if (!$user) return response()->json(['error' => 'User not found'], 404);

        $response = array();
        $response['code'] = 400;

        $post = Status::find($request->input('id'));
        $text = $request->input('comment');

        if ($post && !empty($text)){
            $comment = new Status();
            $comment->parent_id = $post->id;
            $comment->user_id = $user->id;
            $comment->body = $text;
            if ($comment->save()){
                $response['code'] = 200;
                $response['post'] = $post;
                $response['comment'] = $comment;
                return response()->json($response);
            }
        }

        return response()->json($response, $response['code']);
    }

    /**
     * Delete a comment specified.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * 
     *  @SWG\Delete(
     *     path="/api/posts/comments/delete/{id}",
     *     description="Delete a comment specified.",
     *     operationId="api.posts.comments.delete",
     *     produces={"application/json"},
     *     tags={"posts"},
     *     @SWG\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          type="integer",
     *          description="Status/Post id in database",
     * 	   ),
     *     @SWG\Response(
     *         response=201,
     *         description="Success - Comment deleted."
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="Status/Post/User not found.",
     *     ),
     *     @SWG\Response(
     *         response=400,
     *         description="Bad Request - some param are not present",
     *     )
     * )
     */
    public function commentDelete($id)
    {
        $userJWT = JWTAuth::parseToken()->authenticate();
        $user = User::find($userJWT->id);
        if (!$user) return response()->json(['error' => 'User not found'], 404);

        $response = array();
        $response['code'] = 400;

        $post_comment = Status::find($id);

        if ($post_comment){
            $post = $post_comment->parent();
            if ($post_comment->user_id == $user->id || $post->user_id == $user->id ) {
                if ($post_comment->delete()) {
                    $response['code'] = 200;
                    $response['deleted_comment'] = $post_comment;
                }
            }
        }

        return response()->json($response, $response['code']);
    }
}
