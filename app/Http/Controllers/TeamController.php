<?php

namespace App\Http\Controllers;

use App\Team;
use Throwable;
use Illuminate\Http\Request;

class TeamController extends Controller
{
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
        $request->validate([
            'name' => 'required'
        ]);

        // Generate Acces code.
        $acces_code = $this->generateAccessCode($request->name);
        // $user = $request->user;

        // Create random string 
        $new_team = new Team([
            'name' => $request->name,
            'access_code' => $acces_code
        ]);

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