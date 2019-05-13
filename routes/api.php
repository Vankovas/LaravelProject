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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


//List posts
Route::get('posts', 'ApiController@index');

//List single post
Route::get('post/{id}', 'ApiController@show');

//Create new post
Route::post('post', 'ApiController@store');

//Update post
Route::put('post/{id}', 'ApiController@store');

//Delete post 
Route::delete('post/{id}', 'ApiController@destroy');

