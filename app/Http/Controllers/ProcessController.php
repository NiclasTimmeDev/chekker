<?php

namespace App\Http\Controllers;

use App\User;
use Throwable;
use App\Process;
use Illuminate\Http\Request;
use App\Helpers\ExceptionHelper;
use App\Http\Controllers\Controller;
use App\Team;
use Illuminate\Support\Facades\Auth;

class ProcessController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Get all teams of the current team of the user.
     * 
     * @param string $team_id
     *   The id of the team
     * @return \Illuminate\Http\Response
     */
    public function index($team_id)
    {
        try {
            // Get current user.
            $user = Auth::user();
            if (!$user) {
                return ExceptionHelper::customSingleError("User nicht gefunden.", 404);
            }

            // Get all proceses of the current team of the user.
            $processes = $user->processes()->where("team_id", $team_id)->get();

            // Get all tags for each process.
            if (empty($processes)) {
                return $processes;
            }

            // Get all tags for each process.
            foreach ($processes as $process) {
                $tags = $process->tags()->get();
                $process['tags'] = $tags;
            }
            return $processes;
        } catch (Throwable $e) {
            return ExceptionHelper::customSingleError('Sorry, etwas ist schief gelaufen.', 500);
        }
    }

    /**
     * Get a single process and its related data.
     * 
     * @param string $process_id
     *   The id of the process of interest
     * 
     * @return \Illuminate\Http\Response
     */
    public function single($process_id)
    {
        try {
            // Get current user
            $user = Auth::user();
            if (!$user) {
                return ExceptionHelper::customSingleError("User nicht gefunden.", 404);
            }

            // Check if user has permission to the process.
            if (!$user->processes($process_id)->exists()) {
                return ExceptionHelper::customSingleError('Sie haben keinen Zugriff auf diesen Prozess.', 401);
            }

            // Get the process.
            $process = Process::find($process_id);
            if (!$process) {
                return ExceptionHelper::customSingleError('Prozess nicht gefunden.', 401);
            }

            // Get all related data of the process.
            $process['related_data'] = $this->loadSingleProcessData($process);

            return $process;
        } catch (Throwable $e) {
            return ExceptionHelper::customSingleError('Sorry, etwas ist schief gelaufen.', 500);
        }
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

            // Early return if one param is not given in request (except allowed users).
            if (
                !$team_id ||
                !$name
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
                "permission" => "only-me"
            ]);

            $new_process->save();

            // Create relation between user and process in pivot table.
            $user->processes()->attach($new_process);

            // If tags are given, check if they belong to the team.
            // $team = Team::find($team_id);
            // $tag_error = false;
            // if ($tags) {
            //     foreach ($tags as $tag) {
            //         // Check if tag belongs to the team.
            //         if (!$team->tags($tag)->exists()) {
            //             $tag_error = true;
            //             exit;
            //         }
            //         // Attach tag to process via pivot table.
            //         $new_process->tags()->attach($tag);
            //     }

            //     // Exit if error detected.
            //     if ($tag_error) {
            //         return ExceptionHelper::customSingleError('Sie haben für ein oder mehrere Tags nicht die Berechtigung.', 401);
            //     }
            // }

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

    /**
     * Get all data related to a process.
     * This includes tags, tasks and involved people.
     * 
     * @param  \App\Process  $process
     *   The process of interest.
     * 
     * @return array $results
     *   All data related to the process.
     */
    private function loadSingleProcessData($process)
    {
        $results = [];

        // Get tags.
        $tags = $process->tags()->get();
        $results['tags'] = $tags;

        // TODO: Get tasks.
        // TODO: Get Involved people.

        return $results;
    }
}