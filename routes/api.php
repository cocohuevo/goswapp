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
	Route::get('/tasks/cicle/{cicleNumber}', 'API\TaskController@tasksByCicle');
	Route::put('/tasks/{taskId}/assign-cicle/{cicleId}', 'API\TaskController@assignCicleToTask');
	Route::put('/tasks/{taskId}/rate', 'API\TaskController@rateTask');
});

Route::middleware('auth:api')->group( function () {
	Route::resource('users', 'API\UserController');
});


	Route::resource('students', 'API\StudentController');

Route::middleware('auth:api')->group( function () {
	Route::resource('teachers', 'API\TeacherController');
});

Route::middleware('auth:api')->group( function () {
	Route::resource('taskAssignments', 'API\TaskAssignmentController');
	Route::get('/assign-task/{userId}/{taskId}', 'API\TaskAssignmentController@assignTaskToStudent');
});

Route::resource('cicles', 'API\CicleController');

