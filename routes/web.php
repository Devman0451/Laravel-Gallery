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
Route::get('/privacy', 'PagesController@privacy');
Route::get('/support', 'PagesController@support');
Route::get('/tos', 'PagesController@tos');
Route::get('/faq', 'PagesController@faq');
Route::get('/about', 'PagesController@about');
Route::get('/users', 'PagesController@users');
Route::get('/random', 'PagesController@random');

Auth::routes();

Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

Route::resource('projects', 'ProjectsController');

Route::get('/profile/{profile}', 'ProfilesController@show');
Route::get('/profile/{profile}/edit', 'ProfilesController@edit');
Route::patch('/profile/{profile}', 'ProfilesController@update');

Route::post('/comment', 'CommentController@store');

Route::post('/like', 'LikesController@store');
Route::delete('/like/{like}', 'LikesController@destroy');

Route::resource('messages', 'ConversationsController');

Route::post('/message', 'MessageController@store');
