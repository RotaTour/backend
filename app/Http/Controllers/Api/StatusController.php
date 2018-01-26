<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
     * @SWG\Post(
     *     path="/api/posts",
     *     description="Return a list of Statuses based on params.",
     *     operationId="api.posts.index",
     *     produces={"application/json"},
     *     tags={"Posts"},
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
            });
        }

        if ($post_min_id > -1){
            $posts = $posts->where('id', '<', $post_min_id);
        }else if ($post_max_id > -1){
            $posts = $posts->where('id', '>', $post_max_id);
        }

        $posts = $posts->limit($limit)->orderBy('id', 'DESC')->get();

        /*
        if ($div_location == 'initialize'){
            $div_location = ['top', 'bottom'];
        }else{
            $div_location = [$div_location];
            if (count($posts) == 0) return "";
        }
        */

        $comment_count = 2;
        return response()->json(
            compact(
            'posts', 'user', 'wall_type', 'list_type', 
            'optional_id', 'limit','comment_count')
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
