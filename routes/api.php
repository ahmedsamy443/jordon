<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('login','Auth\AuthController@login');
Route::post('register','Auth\AuthController@register');
Route::middleware('auth:sanctum')->group(function () {
    // Authenticated Routes in api.php
    Route::resource('/tasks', 'Task\TaskController');
    Route::post('task/status','Task\TaskController@changeStatus');


  });
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
