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

        /* Settings */
        Route::get('settings', 'SettingsController@index')->name('api.settings.index');
        Route::post('settings', 'SettingsController@update')->name('api.settings.update');

        /* Users */
        Route::get('users/{username}', 'Api\UserController@show')->name('api.users.show');
        Route::get('users/{username}/status', 'Api\UserController@getStatus')->name('api.users.getstatus');
        Route::get('users/{username}/friends', 'Api\UserController@getFriends')->name('api.users.getfriends');
        Route::get('users/{username}/routes', 'Api\UserController@getRoutes')->name('api.users.getroutes');
        Route::get('myself', 'Api\UserController@myself')->name('api.myself');
        Route::delete('users/{username}', 'Api\UserController@destroy')->name('api.users.delete');

        /* Friends */
        Route::get('friends', 'Api\FriendController@index')->name('api.friends.index');
        Route::get('/friends/requests', 'Api\FriendController@getRequests')->name('api.friends.requests');
        Route::get('friends/add/{username}', 'Api\FriendController@getAdd')->name('api.friends.add');
        Route::get('friends/accept/{username}', 'Api\FriendController@getAdd')->name('api.friends.accept');
        Route::post('friends/leavefriendship/{username}', 'Api\FriendController@getAdd')->name('api.friends.leave');

        /* Posts & Statuses */
        Route::get('posts', 'Api\StatusController@list')->name('api.posts.index');
        Route::post('posts/new', 'Api\StatusController@new')->name('api.post.new');
        Route::delete('posts/delete/{id}', 'Api\StatusController@destroy')->name('api.post.delete');
        Route::post('posts/like', 'Api\StatusController@like')->name('api.post.like');
        Route::post('posts/likes', 'Api\StatusController@likes')->name('api.post.likes');
        Route::post('posts/comment', 'Api\StatusController@comment')->name('api.post.comment');
        Route::delete('posts/comments/delete/{id}', 'Api\StatusController@commentDelete')->name('api.post.comment.delete');
        Route::get('posts/show/{id}', 'Api\StatusController@single')->name('api.post.single');

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

