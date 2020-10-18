<?php

namespace App\Http\Controllers;

use App\Team;
use Throwable;
use App\ExternalPerson;
use App\Helpers\UserHelper;
use Illuminate\Http\Request;
use App\Helpers\ExceptionHelper;
use Illuminate\Support\Facades\Auth;

class ExternalPersonController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Get all external team members of a team.
     * @param string $team_id
     *   The id of the team of interest.
     * 
     * @return \Illuminate\Http\Response
     */
    public function index($team_id)
    {
        try {
            // Get current user.
            $user = Auth::user();
            if (!$user) {
                return ExceptionHelper::customSingleError('Sie sind nicht eingeloggt.', 401);
            }

            // Get current team and check if user is member.
            if (!UserHelper::isTeamMember($user, $team_id)) {
                return ExceptionHelper::customSingleError('Sie sind nicht Mitglied dieses Teams.', 401);
            }

            // Get all external persons of the team.
            $external_users = Team::find($team_id)->externalPersons();

            return $external_users;
        } catch (Throwable $e) {
            return ExceptionHelper::customSingleError($e, 500);
        }
    }

    /**
     * Store a newly created external Person in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            // Check if request has all required data.
            $team_id = $request->team_id;
            $name = $request->name;
            $email = $request->email;
            $organization = $request->organization;

            // Return error of data is insufficient (organization is optional).
            if (
                !$team_id ||
                !$name ||
                !$email ||
                !filter_var($email, FILTER_VALIDATE_EMAIL)
            ) {
                return ExceptionHelper::customSingleError('Nicht alle Angaben sind vollständig.', 401);
            }

            // Get current user.
            $user = Auth::user();
            if ($user) {
                return ExceptionHelper::customSingleError('Sie sind nicht eingeloggt.', 401);
            }

            // Create new instance of ExternalPerson class.
            $new_person = new ExternalPerson([
                'team_id' => $team_id,
                'name' => $name,
                'email' => $email,
                'organization' => $organization
            ]);

            // Attach external person to team.
            Team::find($team_id)->attach($new_person);

            // Return new person as response.
            return $new_person;
        } catch (Throwable $e) {
            return ExceptionHelper::customSingleError('Sorry, etwas ist schief gelaufen.', 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ExternalPerson  $externalPerson
     * @return \Illuminate\Http\Response
     */
    public function show(ExternalPerson $externalPerson)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ExternalPerson  $externalPerson
     * @return \Illuminate\Http\Response
     */
    public function edit(ExternalPerson $externalPerson)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ExternalPerson  $externalPerson
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ExternalPerson $externalPerson)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ExternalPerson  $externalPerson
     * @return \Illuminate\Http\Response
     */
    public function destroy(ExternalPerson $externalPerson)
    {
        //
    }
}