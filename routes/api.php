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

Route::post('register', 'API\RegisterController@register');

Route::post('login', 'API\RegisterController@login');

Route::middleware('auth:api')->group( function () {
	Route::resource('tasks', 'API\TaskController');
});

Route::middleware('auth:api')->group( function () {
	Route::resource('users', 'API\UserController');
});

Route::middleware('auth:api')->group( function () {
	Route::resource('profiles', 'API\ProfileController');
});

Route::middleware('auth:api')->group( function () {
	Route::resource('cicles', 'API\CicleController');
});

Route::get('/cicles/{id}/tasks', 'API\TaskController@getTasks');