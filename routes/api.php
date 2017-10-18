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

Route::resource('maecue', 'API\MaeCueController', ['only' => ['index', 'store', 'update', 'destroy', 'show']]);
Route::resource('sesion', 'API\SesionController', ['only' => ['index', 'store', 'update', 'destroy', 'show']]);
Route::resource('tabanco', 'API\TabancoController', ['only' => ['index', 'store', 'update', 'destroy', 'show']]);
Route::resource('tabaux10', 'API\Tabaux10Controller', ['only' => ['index', 'store', 'update', 'destroy', 'show']]);

Route::group(['prefix' => 'v2'], function () {
    Route::resource('user', 'API\v2\UserController', ['only' => ['index', 'show']]);
});