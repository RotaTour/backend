<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Route;
use Auth;
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
        $query = $request->input('s');
        if ( empty($query)) return redirect()->route('index');
            
        $user = Auth::user();

        // Tive que usar o ILIKE, fazer o LOWER('name') retorna erro
        $users = User::where(
            DB::raw("CONCAT(first_name, ' ', last_name)"),'ILIKE',"%{$query}%")
            ->orWhere('name','ILIKE', "%{$query}%")
            ->orWhere('username', 'ILIKE', "%{$query}%")
            ->get();

        $routes = Route::where('name', 'ILIKE', "%{$query}%")->with('user')->get();
        if($routes) $routes->load('tags');

        return view('search.results', compact('user','users', 'routes') );
    }
}
