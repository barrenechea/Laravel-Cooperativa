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
	Route::get('init', 'HomeController@init');
	Route::post('init', 'HomeController@initsave');

	Route::group(['middleware' => ['init']], function () {
		Route::get('home', 'HomeController@index');

		Route::group(['prefix' => 'register'], function () {
	    	Route::get('partner', 'RegisterController@partner');
	    	Route::post('partner', 'RegisterController@registerpartner');
	    	Route::get('admin', 'RegisterController@admin');
	    	Route::post('admin', 'RegisterController@registeradmin');
		});

		Route::group(['prefix' => 'system'], function () {
			Route::get('base', 'SystemController@base');
	    	Route::post('addsector', 'SystemController@addsector');
	    	Route::post('addtype', 'SystemController@addtype');
	    	Route::post('addlocation', 'SystemController@addlocation');

	    	Route::get('group', 'SystemController@group');
	    	Route::post('addgroup', 'SystemController@addgroup');
	    	Route::get('grouppct', 'SystemController@grouppct');
	    	Route::post('addgrouppct', 'SystemController@addgrouppct');
		});

		Route::group(['prefix' => 'messages'], function () {
			Route::get('add', 'MessageController@addindex');
			Route::post('add', 'MessageController@add');
		});

		Route::get('fileentry', 'FileEntryController@index');
		Route::group(['prefix' => 'fileentry'], function () {
			Route::get('get/{filename}', ['as' => 'getentry', 'uses' => 'FileEntryController@get']);
			Route::post('add', ['as' => 'addentry', 'uses' => 'FileEntryController@add']);
		});

		Route::group(['prefix' => 'list'], function () {
			Route::get('sector', 'ListController@listsector');
	    	Route::get('type', 'ListController@listtype');
	    	Route::get('location', 'ListController@listlocation');
	    	Route::get('group', 'ListController@listgroup');
	    	Route::get('admin', 'ListController@listadmin');
		});
	    
	});
    
});

