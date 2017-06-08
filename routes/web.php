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

Route::get('/', 'UserController@index');
Route::get('/{user_id?}', 'UserController@show');
Route::post('/', 'UserController@store');
Route::put('/{user_id?}', 'UserController@update');
Route::delete('/{user_id?}', 'UserController@destroy');
