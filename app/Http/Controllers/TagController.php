<?php

namespace App\Http\Controllers;

use App\Tag;
use Throwable;
use Illuminate\Http\Request;
use App\Helpers\ExceptionHelper;
use App\User;
use Illuminate\Support\Facades\Auth;

class TagController extends Controller
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
        try {
            // Get values from request
            $title = $request->title;
            $background = $request->background;
            $text = $request->text;
            $team_id = (int) $request->team_id;

            // Send error if values are missing.
            if (!$title || !$background || !$text || !$team_id) {
                return ExceptionHelper::customSingleError('Nicht alle Felder sind valide', 400);
            }

            // Strip title.
            $title =  filter_var($title, FILTER_SANITIZE_STRING);

            // Check if tag with the same name already exits.
            $existing_tag = Tag::where('team_id', $team_id)->where('title', $title)->first();
            if ($existing_tag) {
                return ExceptionHelper::customSingleError('Ein Tag mit diesem Namen existiert bereits.', 400);
            }

            // Check if team exists and user is a member of the team.
            $user = Auth::user();
            $is_member = $user->teams()->where('team_id', $team_id)->exists();
            if (!$is_member) {
                return ExceptionHelper::customSingleError('Entweder existiert das Team nicht oder Sie sind kein Mitglied', 401);
            }

            // Create new instance of Tag.
            $new_tag = new Tag([
                'title' => $title,
                'team_id' => $team_id,
                'background' => $background,
                'text' => $text
            ]);

            $new_tag->save();
            return $new_tag;
        } catch (Throwable $e) {
            return ExceptionHelper::customSingleError('Sorry, etwas ist schief gelaufen.', 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function show(Tag $tag)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function edit(Tag $tag)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tag $tag)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tag $tag)
    {
        //
    }
}