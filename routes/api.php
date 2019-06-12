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


Route::get('projects/{project}/comments', 'CommentController@index');

Route::middleware('auth:api')->group(function () {
    Route::post('projects/{project}/comment', 'CommentController@store');
});



Route::get('projects/{project}/likes', 'LikesController@index');

Route::middleware('auth:api')->group(function () {
    Route::post('projects/{project}/like', 'LikesController@store');
});

Route::middleware('auth:api')->group(function () {
    Route::delete('projects/{project}/like/{like}', 'LikesController@destroy');
});


Route::get('projects/{project}/favorites', 'FavoritesController@index');

Route::middleware('auth:api')->group(function () {
    Route::post('projects/{project}/favorite', 'FavoritesController@store');
});

Route::middleware('auth:api')->group(function () {
    Route::delete('projects/{project}/favorite/{favorite}', 'FavoritesController@destroy');
});


Route::get('profiles/{profile}/followers', 'FollowersController@index');

Route::middleware('auth:api')->group(function () {
    Route::post('profiles/{profile}/follower', 'FollowersController@store');
});

Route::middleware('auth:api')->group(function () {
    Route::delete('profiles/{profile}/follower/{follower}', 'FollowersController@destroy');
});