<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use DB;

class SearchController extends Controller
{
    public function results(Request $request)
    {
        $query = $request->input('query');
        if (!$query){
            return response()->json(['error' => 'no input query'], 409);
        }

        // Tive que usar o ILIKE, fazer o LOWER('name') retorna erro
        $users = User::where(
            DB::raw("CONCAT(first_name, ' ', last_name)"), 
            'ILIKE',
            "%{$query}%")
            ->orWhere('name',
            'ILIKE', 
            "%{$query}%")
            ->get();

        return response()->json(compact('users'));
    }
}
