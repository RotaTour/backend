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
    Route::post('register', 'Api\AuthenticateController@register')->name('api.register');

    /* Socialite */
    Route::get('social/redirect/{provider}', ['uses' => 'Api\AuthenticateController@redirectToProvider', 'as' => 'api.social.login']);
    Route::get('social/callback/{provider}', 'Api\AuthenticateController@handleProviderCallback');

    /* Rotas protegidas JWT */
    Route::group(['middleware'=>'jwt.auth'], function(){
        Route::get('myself', 'Api\UserController@myself');

        Route::get('/search', 'Api\SearchController@results')->name('api.search.results');

        Route::resource('users', 'Api\UserController');
        Route::get('users/{email}/status', 'Api\UserController@getStatus')->name('api.users.getstatus');

        Route::get('friends', 'Api\FriendController@index')->name('api.friends.index');

        Route::get('places', 'Api\PlaceController@index')->name('api.places.index');
        Route::get('/places/show', 'Api\PlaceController@show')->name('api.place.show');

        Route::get('routes', 'Api\RouteController@index')->name('api.routes.index');
        Route::get('/routes/show/{id}', 'Api\RouteController@show')->name('api.route.show');

    });

});

