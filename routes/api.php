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
    Route::post('social/register', 'Api\AuthenticateController@registerProviderCallback')->name('api.social.register');

    /* Rotas protegidas JWT */
    Route::group(['middleware'=>'jwt.auth'], function(){

        /* Search */
        Route::get('/search', 'Api\SearchController@results')->name('api.search.results');

        /* Users */
        //Route::resource('users', 'Api\UserController');
        Route::get('users/{email}', 'Api\UserController@show')->name('api.users.show');
        Route::get('users/{email}/status', 'Api\UserController@getStatus')->name('api.users.getstatus');
        Route::get('myself', 'Api\UserController@myself')->name('api.myself');
        Route::delete('users/{email}', 'Api\UserController@destroy')->name('api.users.delete');
        
        /* Friends */
        Route::get('friends', 'Api\FriendController@index')->name('api.friends.index');
        Route::get('friends/add/{email}', 'Api\FriendController@getAdd')->name('api.friends.add');
        Route::get('friends/accept/{email}', 'Api\FriendController@getAdd')->name('api.friends.accept');
        Route::post('friends/leavefriendship/{email}', 'Api\FriendController@getAdd')->name('api.friends.leave');

        /* Places */
        //Route::get('places', 'Api\PlaceController@index')->name('api.places.index');
        Route::get('/places/show', 'Api\PlaceController@show')->name('api.place.show');

        /* Routes */
        Route::get('routes', 'Api\RouteController@index')->name('api.routes.index');
        Route::post('routes', 'Api\RouteController@store')->name('api.routes.store');
        Route::put('routes/update/{id}', 'Api\RouteController@update')->name('api.routes.update');
        Route::get('/routes/show/{id}', 'Api\RouteController@show')->name('api.route.show');
        Route::delete('/routes/delete/{id}', 'Api\RouteController@destroy')->name('api.route.delete');
        Route::post('/routes/addToRoute', 'Api\RouteController@addToRoute')->name('api.route.addToRoute');

        /* Itens */
        Route::delete('/itens/delete/{id}', 'ItemController@destroy')->name('api.item.delete');

        /* Tags */
        Route::get('tags', 'Api\TagController@index')->name('api.tags');
        Route::post('/tags', 'Api\TagController@store')->name('api.tags.store');
        Route::get('/tags/show/{tag_name}', 'Api\TagController@show')->name('api.tags.show');
        Route::delete('/tags/delete/{id}', 'Api\TagController@destroy')->name('api.tags.delete');

    });

});

