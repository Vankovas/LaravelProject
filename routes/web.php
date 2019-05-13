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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/about', 'PagesController@about');
Route::get('/master', 'PagesController@master');
Route::resource('posts','PostsController');
Auth::routes();
Route::get('/home', 'HomeController@index');
Route::post('/', 'UsersController@store');
Route::get('/pdf', 'PDFMaker@index');
Route::get('/export',"ExcelController@export");


