<?php

namespace App\Http\Controllers\Api;

use App\Team;
use Throwable;
use Illuminate\Http\Request;
use App\Helpers\ExceptionHelper;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;

class TeamController extends Controller
{
    private $contentType = "json";

    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Get all teams of the current user.
     *
     * @return \Illuminate\Http\Response
     *   The teams of the user.
     */
    public function index()
    {
        // Get current user.
        $user = Auth::user();

        // Get the teams of the user.
        $teams = $user->teams;

        // Return all teams.
        return $teams;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Check if name is provided.
        $request->validate([
            'name' => 'required'
        ]);

        // Generate Acces code.
        $acces_code = $this->generateAccessCode($request->name);

        // Get user from middlware.
        $user = Auth::user();

        $new_team = new Team([
            'name' => $request->name,
            'user_id' => $user->id,
            'access_code' => $acces_code
        ]);

        // Save user.
        try {
            $new_team->save();
            $user->teams()->attach($new_team);
            return $new_team;
        } catch (Throwable $e) {
            report($e);
            return false;
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        try {
            // Check if request is valid.
            if (!$request->team_id) {
                return ExceptionHelper::customSingleError("Für welches Team wollen Sie den Namen ändern?.", 400);
            }
            if (!$request->name) {
                return ExceptionHelper::customSingleError("Bitte geben Sie einen neuen Namen ein.", 400);
            }

            $team_id = $request->team_id;
            $new_name = $request->name;

            // Generate new access code.
            $new_access_code = $this->generateAccessCode($new_name);

            // Get current user.
            $user = Auth::user();
            if (!$user) {
                return ExceptionHelper::customSingleError("Es konnte leider kein User gefunden werden.", 404);
            }

            // Get the team.
            $team = Team::find($team_id);
            if (!$team) {
                return ExceptionHelper::customSingleError("Das Team konnte leider nicht gefunden werden.", 404);
            }

            // Return if user is not creator (admin) of the team.
            if ((int) $team->user_id !== (int) $user->id) {
                return ExceptionHelper::customSingleError("Sie besitzen nicht die passenden Rechte für diese Aktion.", 404);
            }

            // Update team.
            $team->name = $new_name;
            $team->access_code = $new_access_code;

            $team->save();
            return $team;
        } catch (Throwable $e) {
            return ExceptionHelper::customSingleError("Sorry, etwas ist schief gelaufen.", 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function destroy(Team $team)
    {
        //
    }

    /**
     * Get all team members.
     * 
     * @param \Illuminate\Http\Request  $request
     *   The request object.
     * @param int $team_id
     *   The team id.
     */
    public function getTeamMembers(Request $request, $team_id)
    {
        try {
            // Get Team id from req.
            if (!$team_id) {
                return ExceptionHelper::customSingleError("Bitte geben Sie ein Team an.", 400);
            }

            // Get current user.
            $user = Auth::user();
            if (!$user) {
                return ExceptionHelper::customSingleError("User nicht gefunden.", 404);
            }

            // Get members of the team.
            $members = User::whereHas("teams", function ($q) use ($team_id) {
                $q->where("team_id", $team_id);
            })->get();

            // Return if no members found.
            if (!$members) {
                return ExceptionHelper::customSingleError("Keine Mitglieder gefunden.", 404);
            }

            return $members;
        } catch (Throwable $e) {
            return ExceptionHelper::customSingleError("Sorry, etwas ist schief gelaufen.", 500);
        }
    }

    /**
     * Join a team by entering the access code.
     * 
     * @param \Illuminate\Http\Request  $request
     *   The request object.
     */
    public function join(Request $request)
    {
        // Validate request.
        $request->validate([
            'code' => 'required'
        ]);

        try {
            // Retrieve access code from req.
            $access_code = $request->code;

            if (!$access_code) {
                return ExceptionHelper::customSingleError("Bitte geben Sie einen Zugangscode ein.", 400);
            }

            // Get current user.
            $user = Auth::user();

            // Return if user not found.
            if (!$user) {
                return ExceptionHelper::customSingleError("Es konnte leider kein User gefunden werden.", 404);
            }

            // Check if there is a team with the given access code.
            $team = Team::where('access_code', "=", $access_code)->first();

            // Return 404 if no team exists
            if (!$team) {
                return ExceptionHelper::customSingleError("Es konnte kein Team mit diesem Zugangscode gefunden werden.", 404);
            }

            // Return if user is creator of the team.
            if ($user->id === $team->user_id) {
                return ExceptionHelper::customSingleError("Sie haben dieses Team selbst erstellt.", 400);
            }

            // Attach team to user.
            $user->teams()->attach($team);
            return $team;
        } catch (Throwable $e) {
            return ExceptionHelper::customSingleError("Sorry, etwas ist schief gelaufen.", 500);
        }
    }

    /**
     * Generate access token for inviting other members.
     * 
     * @param string $string
     *   The name of the team. Will be part of the access token.
     * @return string $access_token
     *   The access token.
     */
    private function generateAccessCode($string)
    {
        // Delete special characters etc.
        $sanitized = filter_var($string, FILTER_SANITIZE_URL);

        // Generate random string.
        $randomString = '';
        $allowed_characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $length = 6;
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $allowed_characters[rand(0, $length - 1)];
        }

        $acces_code = $sanitized . '-' . $randomString;
        return $acces_code;
    }
}