<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Route;
use DB;

class SearchController extends Controller
{
    /**
     * Display results of a search query
     *
     * @return \Illuminate\Http\Response
     * 
     * @SWG\Get(
     *     path="/api/search",
     *     description="Returns results of a search query.",
     *     operationId="api.search.results",
     *     produces={"application/json"},
     *     tags={"search"},
     *     @SWG\Parameter(
     *          name="query",
     *          in="body",
     *          schema={"$ref": "#/definitions/NewUser"},
     *          required=true,
     *          type="string",
     *          description="Name (or partial name) used by user",
     * 	   ),
     *     @SWG\Response(
     *         response=200,
     *         description="Result overview."
     *     ),
     *     @SWG\Response(
     *         response=400,
     *         description="no input query.",
     *     )
     * )
     */
    public function results(Request $request)
    {
        $query = $request->input('query');
        if (empty($query)){
            return response()->json(['error' => 'no input query'], 400);
        }

        $userJWT = JWTAuth::parseToken()->authenticate();
        $user = User::find($userJWT->id);
        if (!$user) return response()->json(['error' => 'User not found'], 404);

        // Tive que usar o ILIKE, fazer o LOWER('name') retorna erro
        $users = User::where(
            DB::raw("CONCAT(first_name, ' ', last_name)"),'ILIKE',"%{$query}%")
            ->orWhere('name','ILIKE', "%{$query}%")
            ->orWhere('username', 'ILIKE', "%{$query}%")
            ->get();

        $routes = Route::where('name', 'ILIKE', "%{$query}%")->get();

        return response()->json(compact('users', 'routes','user'));
    }
}
