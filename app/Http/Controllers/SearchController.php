<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use DB;

class SearchController extends Controller
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

    public function results(Request $request)
    {
        $query = $request->input('query');
        if (!$query){
            return redirect()->route('index');
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

        return view('search.results', compact('users') );
    }
}
