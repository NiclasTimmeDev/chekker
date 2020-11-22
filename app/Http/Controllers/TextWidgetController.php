<?php

namespace App\Http\Controllers;

use Throwable;
use App\TextWidget;
use Illuminate\Http\Request;

class TextWidgetController extends Controller
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
        // Check 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  array  $step
     *   An array with the meta data.
     * @return \Illuminate\Http\Response
     */
    public function store($task_id, $step)
    {
        try {
            // Return empty array if not all necessary data is given.
            if (!array_key_exists('value', $step) || empty($step['value'])) {
                return [];
            }
            if (!array_key_exists('rank', $step) || (empty($step['rank']) && $step['rank'] !== 0)) {
                return [];
            }

            // Get necessary data.
            $content = $step['value'];
            $rank = $step['rank'];

            // Create new widget.
            $new_text_widget = new TextWidget([
                'task_id' => $task_id,
                'content' => $content,
                'rank' => $rank
            ]);

            // Save it to the databse.
            $new_text_widget->save();

            return $new_text_widget;
        } catch (Throwable $e) {
            return [];
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\TextWidget  $textWidget
     * @return \Illuminate\Http\Response
     */
    public function show(TextWidget $textWidget)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\TextWidget  $textWidget
     * @return \Illuminate\Http\Response
     */
    public function edit(TextWidget $textWidget)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  array  $request
     * @return \Illuminate\Http\Response
     */
    public function update($step)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TextWidget  $textWidget
     * @return \Illuminate\Http\Response
     */
    public function destroy(TextWidget $textWidget)
    {
        //
    }
}