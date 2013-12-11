<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/users', 'UserController@index');
Route::get('/users/{id}', 'UserController@show');

Route::get('/places', 'PlaceController@index');
Route::get('/places/{id}', 'PlaceController@show');