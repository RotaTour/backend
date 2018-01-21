<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| AI Routes
|--------------------------------------------------------------------------
|
| Here is where you can register AI-API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware'=>'cors'], function(){
    Route::get('test', 'Ai\AiController@index')->name('ai.test');

    Route::get('all', 'Ai\AiController@all')->name('ai.all');
    Route::get('users', 'Ai\AiController@users')->name('ai.users');
    Route::get('routes', 'Ai\AiController@routes')->name('ai.routes');

    Route::get('/', 'Ai\AiController@index')->name('ai.index');
});

