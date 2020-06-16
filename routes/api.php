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

Route::get('/totalrevenue','Api\GraphController@getTotalRevenue');
Route::get('/totalproject','Api\GraphController@getTotalProject');
Route::get('/totalprojectrevenue','Api\GraphController@getTotalProjectRevenue');
Route::get('/data/export','Api\DatabaseController@export');
Route::get('/maintenance/check','Api\MaintenanceController@check');