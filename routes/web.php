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

/* Socialite */
Route::get('social/redirect/{provider}', ['uses' => 'Auth\LoginController@redirectToProvider', 'as' => 'social.login']);
Route::get('social/callback/{provider}', 'Auth\LoginController@handleProviderCallback');