<?php

namespace App\Http\Controllers;

use App\Task;
use Throwable;
use App\TextWidget;
use App\Helpers\UserHelper;
use Illuminate\Http\Request;
use App\Helpers\ExceptionHelper;
use Illuminate\Support\Facades\Auth;

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
     * Create a new Teyt Widget.
     *
     * @param  Request  $request
     *   The request object.
     * 
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $task_id = $request->task_id;
            $process_id = $request->process_id;
            $widget = $request->widget;

            // Check if user has access to the process.
            $user = Auth::user();
            $has_permission = UserHelper::hasProcessPermission($user, $process_id);
            if (!$has_permission) {
                return ExceptionHelper::customSingleError('Sie haben keinen Zugriff auf diesen Prozess.', 401);
            }

            // Check if task belongs to process.
            $task_belongs_to_process = Task::find($task_id)->where('process_id', $process_id)->exists();
            if (!$task_belongs_to_process) {
                return ExceptionHelper::customSingleError('Der Task gehört nicht zu diesem Prozess', 401);
            }

            // TODO: Sanitize values of widget and then store it and send it to client.
            if (!isset($widget['value'])) {
                return ExceptionHelper::customSingleError('Das Textfeld ist nicht gesetzt.', 400);
            }

            if (!isset($widget['rank']) || (empty($widget['rank']) && $widget['rank'] !== 0)) {
                return ExceptionHelper::customSingleError('Es ist kein Rank angegeben.', 400);
            }

            // Get necessary data.
            $value = $widget['value'];
            $rank = $widget['rank'];

            // Create new widget.
            $new_text_widget = new TextWidget([
                'task_id' => $task_id,
                'process_id' => $process_id,
                'value' => $value,
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
     * Update the value (text) of a text widget.
     * 
     * @param Request $request
     *   The request object.
     * 
     * @return Response
     */
    public function update(Request $request)
    {
        try {
            $widget_id = $request->widget_id;
            $new_value = $request->new_value;
            $new_rank = $request->new_rank;
            $process_id = $request->process_id;


            // Check if user has access to the process.
            $user = Auth::user();
            $has_permission = UserHelper::hasProcessPermission($user, $process_id);
            if (!$has_permission) {
                return ExceptionHelper::customSingleError('Sie haben keinen Zugriff auf diesen Prozess.', 401);
            }

            // Load the widget by id.
            $widget = TextWidget::find($widget_id);
            if (!$widget) {
                return ExceptionHelper::customSingleError('Widget nicht gefunden.', 404);
            }

            // Check if widget belongs to process.
            if ((int) $widget->process_id !== (int) $process_id) {
                return ExceptionHelper::customSingleError('Das TextWidget gehört nicht zum Prozess.', 400);
            }

            // Check that there is a rank given.
            if (!$new_rank && $new_rank !== 0) {
                return ExceptionHelper::customSingleError('Es wurde kein Ranking angegeben.', 400);
            }

            // Update values.
            $widget->value = $new_value;
            $widget->rank = $new_rank;
            $widget->save();

            return $widget;
        } catch (Throwable $e) {
            return ExceptionHelper::customSingleError('Sorry, etwas ist schief gelaufen.', 500);
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