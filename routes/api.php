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

//===============
// Team
//===============
// Get teams of the user.
Route::get('team', "Api\TeamController@index");
// Create a new team.
Route::post('team', "Api\TeamController@store");
// Join a team.
Route::post('team/join', "Api\TeamController@join");
// Update a team.
Route::patch('team', "Api\TeamController@update");
// Get team members of one team.
Route::get('team/members/{team_id}', "Api\TeamController@getTeamMembers");

//===============
// PROCESS
//===============
// Create a new process.
Route::post('process', "ProcessController@store");
// Get all processes of the users current team.
Route::get('process/all/{team_id}', "ProcessController@index");
// Get a single processes.
Route::get('process/single/{process_id}', "ProcessController@single");

//===============
// TAG
//===============
// Get all tags of a team.
Route::get('tag/{team_id}', 'TagController@index');
// Create a new tag.
Route::post('tag', 'TagController@store');
