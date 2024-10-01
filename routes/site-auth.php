<?php

use Illuminate\Support\Facades\Route;

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

Route::resource('/tasks', 'Task\TaskController');
Route::post('/assign/task','Task\TaskController@assign');
Route::post('/status/task','Task\TaskController@changeStatus');
