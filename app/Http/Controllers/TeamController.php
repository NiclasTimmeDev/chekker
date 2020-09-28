<?php

namespace App\Http\Controllers;

use App\Team;
use Throwable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeamController extends Controller
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
        //
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
        $user_id = Auth::id();

        $new_team = new Team([
            'name' => $request->name,
            'user_id' => $user_id,
            'access_code' => $acces_code
        ]);

        // Save user.
        try {
            $new_team->save();
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