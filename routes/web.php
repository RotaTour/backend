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

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

/* Search */
Route::get('/search', 'SearchController@results')->name('search.results');

/* Settings */
Route::get('/settings', 'SettingsController@index')->name('settings.index');
Route::post('/settings', 'SettingsController@update')->name('settings.update');

/* Friends */
Route::get('/friends', 'FriendController@index')->name('friend.index');
Route::get('/friends/requests', 'FriendController@getRequests')->name('friend.requests');
Route::get('/friends/add/{id}', 'FriendController@getAdd')->name('friend.add');
Route::get('/friends/accept/{id}', 'FriendController@getAccept')->name('friend.accept');
Route::get('/friends/leavefriendship/{id}', 'FriendController@leaveFriendship')->name('friend.leave');

/* Status & Posts */
Route::post('/status', 'StatusController@postStatus')->name('status.store');
Route::post('/status/{statusId}/reply', 'StatusController@postReply')->name('status.reply');
Route::get('/status/{statusId}/like', 'StatusController@getLike')->name('status.like');
Route::get('/posts/list', 'PostController@list')->name('post.list');
Route::post('/posts/new', 'PostController@new')->name('post.new');
Route::post('/posts/delete', 'PostController@destroy')->name('post.delete');
Route::post('/posts/like', 'PostController@like')->name('post.like');
Route::post('/posts/comment', 'PostController@comment')->name('post.comment');
Route::post('/posts/comments/delete', 'PostController@commentDelete')->name('post.comment.delete');
Route::post('/posts/likes', 'PostController@likes')->name('post.likes');
Route::get('/post/{id}', 'PostController@single')->name('post.single');

/* Places */
Route::get('/places', 'PlaceController@index')->name('place.index');
Route::get('/places/categories', 'PlaceController@categories')->name('place.categories');
Route::get('/places/pointsofinterest', 'PlaceController@pointsOfInterest')->name('place.points');
Route::get('/places/show', 'PlaceController@show')->name('place.show');
Route::get('/places/getdetails', 'PlaceController@getdetails')->name('place.getdetails');

/* Routes */
Route::get('/routes', 'RouteController@index')->name('route.index');
Route::get('/routes/create', 'RouteController@create')->name('route.create');
Route::post('/routes/store', 'RouteController@store')->name('route.store');
Route::post('/routes/update/{id}', 'RouteController@update')->name('route.update');
Route::get('/routes/addToRoute', 'RouteController@addToRoute')->name('route.addToRoute');
Route::get('/routes/checkItem/{id}', 'RouteController@checkItem')->name('route.checkItem');

Route::get('/routes/show/{id}', 'RouteController@show')->name('route.show');
Route::get('/routes/delete/{id}', 'RouteController@destroy')->name('route.delete');

Route::get('/itens/delete/{id}', 'ItemController@destroy')->name('item.delete');
Route::post('comments', 'CommentController@add')->name('comment.add');
Route::get('comments/delete/{commnet_id}', 'CommentController@delete')->name('comment.delete');

/* Socialite */
Route::get('social/redirect/{provider}', ['uses' => 'Auth\LoginController@redirectToProvider', 'as' => 'social.login']);
Route::get('social/callback/{provider}', 'Auth\LoginController@handleProviderCallback');

/* Admin */
Route::group(['middleware' => ['role:superuser'], 'prefix'=>'admin'], function () {
    Route::get('/', 'AdminController@index')->name('admin.index');
    Route::get('/users', 'AdminController@users')->name('admin.users');
    Route::get('/posts', 'AdminController@posts')->name('admin.posts');
    Route::get('/checkusernames', 'AdminController@checkUsernames')->name('admin.checkusernames');
    Route::get('/checkavatar', 'AdminController@checkAvatar')->name('admin.checkavatar');
    Route::get('/postsfactory', 'AdminController@postsFactory')->name('admin.postsfactory');
    Route::get('/requestFriends', 'AdminController@requestFriends')->name('admin.requestfriends');
});

/* User Profile */
Route::get('/{username}/friends', 'ProfileController@friends')->name('profile.friends');
Route::get('/{username}/routes', 'ProfileController@routes')->name('profile.routes');
Route::get('/{username}', 'ProfileController@show')->name('profile.show');

/* Index */
Route::get('/', 'HomeController@index')->name('index');