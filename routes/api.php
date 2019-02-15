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
 * Users
 */
Route::resource('users','User\UserController',['except'=>['create','edit']]);
Route::name('verify')->get('users/verify/{token}','User\UserController@verify');
Route::name('resend')->get('users/{user}/resend','User\UserController@resend');

/*
*  Meses
*/
Route::resource('months','Month\MonthController',['except'=>['create','edit']]);

/*
*  Tipos de Reformas
*/
Route::resource('type-reforms','TypeReform\TypeReformController',['except'=>['create','edit']]);

/*
*  Tipos de Procedimientos
*/
Route::resource('type-procedures','TypeProcedure\TypeProcedureController',['except'=>['create','edit']]);

/*
*  Tipos de Compras
*/
Route::resource('type-purchases','TypePurchase\TypePurchaseController',['except'=>['create','edit']]);


/*
 * Areas
 */
Route::resource('areas','Area\AreaController',['except'=>['create','edit']]);
Route::resource('areas.departments','Area\AreaDepartmentController',['except'=>['create','show','edit']]);
Route::resource('areas.workers','Area\AreaWorkerController',['only'=>['index']]);

/*
 * Departments
 */
Route::resource('departments','Department\DepartmentController',['only'=>['index','show']]);
Route::resource('departments.workers','Department\DepartmentWorkerController',['only'=>['index']]);

/*
 * Workers
 */
Route::resource('workers','Worker\WorkerController',['except'=>['create','edit']]);

/*
 * Activity
 */
Route::resource('activities','Activity\ActivityController',['except'=>['create','edit']]);

/*
 * Programs
 */
Route::resource('programs','Program\ProgramController',['except'=>['create','edit']]);
Route::resource('programs.activities','Program\ProgramActivityController',['only'=>['index','update','destroy']]);

/*
 *  Item
 */
Route::resource('items','Item\ItemController',['except'=>['create','edit']]);

/*
 *  Partida
 */
Route::resource('partidas','Partida\PartidaController',['except'=>['create','edit']]);

/*
 * Process Planificacion
 */
Route::resource('processes','Process\ProcessController',['except'=>['create','edit']]);


/*
 * Ruta de Passport
 */
Route::post('oauth/token','\Laravel\Passport\Http\Controllers\AccessTokenController@issueToken');
