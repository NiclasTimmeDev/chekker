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

//===============
// TAG
//===============
// Get all tags of a team.
Route::get('tag/{team_id}', 'tag', 'TagController@index');
// Create a new tag.
Route::post('tag', 'TagController@store');