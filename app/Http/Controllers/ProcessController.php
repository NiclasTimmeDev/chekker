<?php

namespace App\Http\Controllers;

use App\User;
use Throwable;
use App\Process;
use Illuminate\Http\Request;
use App\Helpers\ExceptionHelper;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProcessController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Process::all();
    }

    /**
     * Store a newly created Process.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            // Get current user.
            $user = Auth::user();
            if (!$user) {
                return ExceptionHelper::customSingleError('User nicht gefunden.', 404);
            }

            // Extract vars from req.
            $team_id = $request->team_id;
            $name = $request->name;
            $description = $request->description;
            $permission = $request->permission;
            $allowed_members = $request->allowed_members;

            // Early return if one param is not given in request (except allowed users).
            if (
                !$team_id ||
                !$name ||
                !$description ||
                !$permission
            ) {
                return ExceptionHelper::customSingleError('Nicht alle Parameter befüllt.', 400);
            }

            // Check if user is member of the team.
            $user_is_team_member = $user->teams()->where('team_id', $team_id)->exists();
            if (!$user_is_team_member) {
                return ExceptionHelper::customSingleError('Sie haben nicht die Berechtigung für dieses Team.', 401);
            }

            // Instatiate new process obj.
            $new_process = new Process([
                "title" => $name,
                "team_id" => $team_id,
                "user_id" => $user->id,
                "permission" => $permission
            ]);

            $new_process->save();

            // Do no more if permission is not set to advanced.
            if ($permission !== 'advanced') {
                return $new_process;
            }

            // If permission is advanced fill pivot table with users where permission is granted.
            if (count($allowed_members) === 0) {
                return ExceptionHelper::customSingleError('Bitte geben Sie bei erweiterten Rechten Teammitglieder an.', 400);
            }

            // For every user granted with access create new entry in pivot table.
            foreach ($allowed_members as $member_id) {
                User::find($member_id)->processes()->attach($new_process);
            }
            return $new_process;
        } catch (Throwable $e) {
            return ExceptionHelper::customSingleError('Sorry, etwas ist schief gelaufen.', 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Process  $process
     * @return \Illuminate\Http\Response
     */
    public function show(Process $process)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Process  $process
     * @return \Illuminate\Http\Response
     */
    public function edit(Process $process)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Process  $process
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Process $process)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Process  $process
     * @return \Illuminate\Http\Response
     */
    public function destroy(Process $process)
    {
        //
    }
}