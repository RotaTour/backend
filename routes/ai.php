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
    Route::get('categories', 'Ai\AiController@categories')->name('ai.categories');
    Route::get('comments', 'Ai\AiController@comments')->name('ai.comments');
    Route::get('itens', 'Ai\AiController@itens')->name('ai.itens');
    Route::get('likes', 'Ai\AiController@likes')->name('ai.likes');
    Route::get('places', 'Ai\AiController@places')->name('ai.places');
    Route::get('routes', 'Ai\AiController@routes')->name('ai.routes');
    Route::get('statuses', 'Ai\AiController@statuses')->name('ai.statuses');
    Route::get('tags', 'Ai\AiController@tags')->name('ai.tags');
    Route::get('users', 'Ai\AiController@users')->name('ai.users');
    Route::get('users/{username}/friends', 'Ai\AiController@friends')->name('ai.users.friends');

    Route::get('/', 'Ai\AiController@index')->name('ai.index');
});

