<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

// Login routes
Route::get('login', ['as' => 'login', 'uses' => 'Auth\LoginController@showLoginForm']);
Route::post('login', ['as' => 'login.post', 'uses' => 'Auth\LoginController@login']);
Route::get('logout', ['as' => 'logout', 'uses' => 'Auth\LoginController@logout']);

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('api', function () {
    return view('api');
});

// Auth required routes
Route::group(['middleware' => ['auth']], function () {
    Route::get('home', 'HomeController@index');

    Route::group(['prefix' => 'register'], function () {
    	Route::get('socio', 'RegisterController@socio');
    	Route::get('admin', 'RegisterController@admin');
	});
});