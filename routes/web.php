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

Route::get('/', 'PagesController@index')->name('index');
Route::get('/trending', 'PagesController@trending')->name('trending');
Route::get('/search', 'PagesController@search')->name('search');
Route::get('/privacy', 'PagesController@privacy')->name('privacy');
Route::get('/support', 'PagesController@support')->name('support');
Route::get('/tos', 'PagesController@tos')->name('tos');
Route::get('/faq', 'PagesController@faq')->name('faq');
Route::get('/about', 'PagesController@about')->name('about');
Route::get('/users', 'PagesController@users')->name('users');
Route::get('/favorites', 'PagesController@favorites')->name('favorites');
Route::get('/followers', 'PagesController@followers')->name('followers');
Route::get('/random', 'PagesController@random')->name('random');

Auth::routes();

Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

Route::resource('projects', 'ProjectsController');

Route::get('/profile/{profile}', 'ProfilesController@show')->name('profile.show');
Route::get('/profile/{profile}/edit', 'ProfilesController@edit')->name('profile.edit');
Route::patch('/profile/{profile}', 'ProfilesController@update')->name('profile.update');

Route::post('/comment', 'CommentController@store')->name('comment.store');

Route::post('/like', 'LikesController@store')->name('like.store');
Route::delete('/like/{like}', 'LikesController@destroy')->name('like.destroy');

Route::post('/favorite', 'FavoritesController@store')->name('favorite.store');
Route::delete('/favorite/{favorite}', 'FavoritesController@destroy')->name('favorite.destroy');

Route::post('/follower', 'FollowersController@store')->name('follower.store');
Route::delete('/follower/{follower}', 'FollowersController@destroy')->name('follower.destroy');

Route::resource('messages', 'ConversationsController');

Route::post('/message', 'MessageController@store');
