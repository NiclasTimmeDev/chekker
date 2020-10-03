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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Procecces.
Route::resource('process', 'ProcessController');

// Teams.
Route::get('team', "Api\TeamController@index");
Route::post('team', "Api\TeamController@store");
Route::post('team/join', "Api\TeamController@join");
Route::patch('team', "Api\TeamController@update");
Route::get('team/members/{team_id}', "Api\TeamController@getTeamMembers");