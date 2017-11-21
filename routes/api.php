<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
*/

Route::group(['middleware'=>'cors'], function(){
    Route::post('login', 'Api\AuthenticateController@authenticate')->name('api.auth');
    Route::get('getuser', 'Api\AuthenticateController@getUser')->name('api.getuser');

    Route::group(['middleware'=>'jwt.auth'], function(){
        Route::resource('users', 'Api\UserController');
        Route::get('users/{email}/status', 'Api\UserController@getStatus')->name('users.getstatus');
    });
});

