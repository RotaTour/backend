<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Route;
use App\Models\Item;
use Auth;

class ItemController extends Controller
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Item::find($id);
        if (!$item){
            return redirect()
            ->back()
            ->with('info', 'O item selecionado não foi encontrado');
        }

        $route = $item->route()->first();        
        if (Auth::user()->id == $route->user()->first()->id){
            $item->delete();
            return redirect()
            ->back()
            ->with('info', 'O item selecionado foi removido');
        } else {
            return redirect()
            ->back()
            ->with('info', 'O item selecionado não pode ser removido');
        }
    }

}
