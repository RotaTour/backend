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