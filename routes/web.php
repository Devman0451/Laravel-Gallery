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

Route::get('/', 'PagesController@index');
Route::get('/trending', 'PagesController@trending');
Route::get('/search', 'PagesController@search');
Route::get('/privacy', 'PagesController@privacy');
Route::get('/support', 'PagesController@support')->name('support');
Route::get('/tos', 'PagesController@tos');
Route::get('/faq', 'PagesController@faq');
Route::get('/about', 'PagesController@about');
Route::get('/users', 'PagesController@users');
Route::get('/favorites', 'PagesController@favorites')->name('favorites');
Route::get('/random', 'PagesController@random');

Auth::routes();

Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

Route::resource('projects', 'ProjectsController');

Route::get('/profile/{profile}', 'ProfilesController@show')->name('profile.show');
Route::get('/profile/{profile}/edit', 'ProfilesController@edit')->name('profile.edit');
Route::patch('/profile/{profile}', 'ProfilesController@update')->name('profile.update');

Route::post('/comment', 'CommentController@store')->name('comment.store');

Route::post('/like', 'LikesController@store')->name('like.store');
Route::delete('/like/{like}', 'LikesController@destroy')->name('like.destroy');

Route::post('/favorite', 'favoritesController@store')->name('favorite.store');
Route::delete('/favorite/{favorite}', 'favoritesController@destroy')->name('favorite.destroy');

Route::resource('messages', 'ConversationsController');

Route::post('/message', 'MessageController@store');
