<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use JWTAuth;
use App\Models\Item;
use App\Models\Route;
use App\Models\User;

class ItemController extends Controller
{
    /**
     * Remove the specified Item from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * 
     * @SWG\Delete(
     *     path="/api/itens/delete/{id}",
     *     description="Delete the specified item.",
     *     operationId="api.item.delete",
     *     produces={"application/json"},
     *     tags={"itens"},
     *     @SWG\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          type="string",
     *          description="Item id in database",
     * 	   ),
     *     @SWG\Response(
     *         response=200,
     *         description="Success - Item deleted."
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="Item not found.",
     *     ),
     *     @SWG\Response(
     *         response=403,
     *         description="Item can't be deleted.",
     *     )
     * )
     */
    public function destroy($id)
    {
        $item = Item::find($id);
        if (!$item){
            return response()->json(['error' => 'Item not found.'], 404);
        }

        $userJWT = JWTAuth::parseToken()->authenticate();
        $user = User::find($userJWT->id);

        $route = $item->route()->first();
        if ($user->id == $route->user()->first()->id){
            $item->delete();
            return response()->json(['info' => 'Item deleted.']);
        } else {
            return response()->json(['error' => "Item can't be deleted."], 403);
        }
    }
}
