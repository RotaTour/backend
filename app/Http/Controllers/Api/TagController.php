<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Tag;
use JWTAuth;
use App\Models\User;

class TagController extends Controller
{
    /**
     * Display a listing of the tags.
     *
     * @return \Illuminate\Http\Response
     * 
     * @SWG\Get(
     *     path="/api/tags",
     *     description="Returns all tags",
     *     operationId="api.tags.index",
     *     produces={"application/json"},
     *     tags={"tags"},
     *     @SWG\Response(
     *         response=200,
     *         description="Success - return all tags."
     *     )
     * )
     */
    public function index()
    {
        $tags = Tag::all();
        return response()->json(compact('tags'));
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
     * Store a newly created route in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * 
     * @SWG\Post(
     *     path="/api/tags",
     *     description="Store a new tag.",
     *     operationId="api.tags.store",
     *     produces={"application/json"},
     *     tags={"tags"},
     *     @SWG\Parameter(
     *          name="name",
     *          in="body",
     *          schema={"$ref": "#/definitions/NewTag"},
     *          required=true,
     *          type="string",
     *          description="Name of the new Tag",
     * 	   ),
     *     @SWG\Response(
     *         response=201,
     *         description="Success - Tag created."
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="User not found.",
     *     ),
     *     @SWG\Response(
     *         response=400,
     *         description="name not provided.",
     *     )
     * )
     */
    public function store(Request $request)
    {
        $input = $request->input();
        if( !isset($input['name']) ){
            return response()->json(['error' => 'name not provided'], 400);
        }
        
        $userJWT = JWTAuth::parseToken()->authenticate();
        $user = User::find($userJWT->id);
        if (!$user){
            return response()->json(['error' => 'User not found'], 404);
        } else {
            $tag = new Tag($input);
            $tag->user_id = $user->id;
            $tag->save();
            $info = "Tag created!";
            return response()->json(compact('tag', 'info'), 201);
        }
    }

    /**
     * Display the specified tag.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     *
     * @SWG\Get(
     *     path="/api/tags/show/{tag_name}",
     *     description="Returns the tag details.",
     *     operationId="api.tags.show",
     *     produces={"application/json"},
     *     tags={"tags"},
     *     @SWG\Parameter(
     *          name="tag_name",
     *          in="path",
     *          required=true,
     *          type="string",
     *          description="Tag name in database",
     * 	   ),
     *     @SWG\Response(
     *         response=200,
     *         description="Success - Tag found."
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="Tag not found.",
     *     )
     * )
     */
    public function show($tag_name)
    {
        $tag = Tag::where('name', $tag_name)->with(['routes'])->first();
        if(!$tag){
            return response()->json(['error'=>'Tag not found'], 404);
        }
        return response()->json(compact('tag'));
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
     * 
     * @SWG\Delete(
     *     path="/api/tags/delete/{id}",
     *     description="Delete the tag especified",
     *     operationId="api.tags.delete",
     *     produces={"application/json"},
     *     tags={"tags"},
     *     @SWG\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          type="string",
     *          description="Tag id in database",
     * 	   ),
     *     @SWG\Response(
     *         response=200,
     *         description="Success - Tag found."
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="Tag not found.",
     *     )
     * )
     */
    public function destroy($id)
    {
        $tag = Tag::find($id);
        if (!$tag){
            return response()->json(['error' => 'Tag not found.'], 404);
        }

        $userJWT = JWTAuth::parseToken()->authenticate();
        $user = User::find($userJWT->id);

        if ($user->id == $tag->user()->first()->id){
            $name = $tag->name;
            $tag->delete();
            return response()->json(['info' => 'The Tag '.$name.' was deleted.']);
        } else {
            return response()->json(['error' => "The Tag could not deleted."], 403);
        }
    }
}
