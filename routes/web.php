<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'HomeController@index')->name('index');

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

Route::get('/search', 'SearchController@results')->name('search.results');

Route::get('/user/edit', 'ProfileController@edit')->name('profile.edit');
Route::post('/user/store', 'ProfileController@store')->name('profile.store');
Route::get('/user/{email}', 'ProfileController@show')->name('profile.show');

Route::get('/friends', 'FriendController@index')->name('friend.index');
Route::get('/friends/add/{email}', 'FriendController@getAdd')->name('friend.add');
Route::get('/friends/accept/{email}', 'FriendController@getAccept')->name('friend.accept');
Route::post('/friends/leavefriendship/{email}', 'FriendController@leaveFriendship')->name('friend.leave');

Route::post('/status', 'StatusController@postStatus')->name('status.store');
Route::post('/status/{statusId}/reply', 'StatusController@postReply')->name('status.reply');
Route::get('/status/{statusId}/like', 'StatusController@getLike')->name('status.like');

Route::get('/places', 'PlaceController@index')->name('place.index');
Route::get('/places/categories', 'PlaceController@categories')->name('place.categories');
Route::get('/places/pointsofinterest', 'PlaceController@pointsOfInterest')->name('place.points');
Route::get('/places/show', 'PlaceController@show')->name('place.show');

Route::get('/routes', 'RouteController@index')->name('route.index');
Route::get('/routes/create', 'RouteController@create')->name('route.create');
Route::post('/routes/store', 'RouteController@store')->name('route.store');
Route::get('/routes/addToRoute', 'RouteController@addToRoute')->name('route.addToRoute');
Route::get('/routes/show/{id}', 'RouteController@show')->name('route.show');
Route::get('/routes/delete/{id}', 'RouteController@destroy')->name('route.delete');

Route::get('/itens/delete/{id}', 'ItemController@destroy')->name('item.delete');
Route::post('/comments', 'CommentController@add')->name('comment.add');
Route::get('/comments/delete/{commnet_id}', 'CommentController@delete')->name('comment.delete');

/* Socialite */
Route::get('social/redirect/{provider}', ['uses' => 'Auth\LoginController@redirectToProvider', 'as' => 'social.login']);
Route::get('social/callback/{provider}', 'Auth\LoginController@handleProviderCallback');

Route::group(['middleware' => ['role:superuser'], 'prefix'=>'admin'], function () {
    Route::get('/', function(){
        return "Admin Index";
    })->name('admin.index');

    Route::get('/users', function(){
        return "Admin Users";
    })->name('admin.users');

    Route::get('/posts', function(){
        return "Admin Posts";
    })->name('admin.posts');
});