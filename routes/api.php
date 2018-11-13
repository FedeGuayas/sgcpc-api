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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

/*
 * Areas
 */
Route::resource('areas','AreaController',['except'=>['create','edit']]);

/*
 * Departments
 */
Route::resource('departments','DepartmentController',['except'=>['create','edit']]);

/*
 * Workers
 */
Route::resource('workers','WorkerController',['except'=>['create','edit']]);

/*
 * Users
 */
Route::resource('users','UserController',['except'=>['create','edit']]);