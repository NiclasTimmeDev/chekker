<?php

namespace App\Http\Controllers\Api;

use App\Team;
use Throwable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
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
     * Display the specified resource.
     *
     * @param  \App\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function show(Team $team)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function edit(Team $team)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Team $team)
    {
        //
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
                return response()->json(["error" => "Bitte geben Sie einen Zugangscode ein"], 400);
            }

            // Get current user.
            $user = Auth::user();

            // Check if there is a team with the given access code.
            $team = DB::table('teams')->where('access_code', $access_code)->get();

            return $team->id;

            // Return 404 if no team exists
            if (!$team) {
                return response()->json(
                    [
                        "error" => "Es konnte kein Team mit diesem Zugangscode gefunden werden."
                    ],
                    404
                );
            }

            // Attach team to user.
            $user->teams()->attach($team);
            return $team;
        } catch (Throwable $e) {
            report($e);
            return false;
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