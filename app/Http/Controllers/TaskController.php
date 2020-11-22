<?php

namespace App\Http\Controllers;

use App\Task;
use Throwable;
use App\Process;
use App\Helpers\UserHelper;
use Illuminate\Http\Request;
use App\Helpers\ExceptionHelper;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\TextWidgetController;
use App\Http\Controllers\EmailWidgetController;

class TaskController extends Controller
{
    /**
     * The Email Widget Controller.
     * 
     * \App\Http\Controllers\EmailWidgetController
     */
    protected $emailWidget;

    /**
     * The Text Widget Controller.
     * 
     * \App\Http\Controllers\TextWidgetController
     */
    protected $textWidget;
    public function __construct(EmailWidgetController $email_widget, TextWidgetController $text_widget)
    {
        $this->middleware('auth');
        $this->emailWidget = $email_widget;
        $this->textWidget = $text_widget;
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
     * Store (multiple) newly created tasks in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            // Extract values from request.
            $process_id = $request->process_id;
            $tasks = $request->tasks;
            // Return if no process id given.
            if (!$process_id) {
                return ExceptionHelper::customSingleError('Kein Prozess angegeben.', 400);
            }

            // Return if tasks are badly formatted or not present.
            if (!is_array($tasks) || empty($tasks)) {
                return ExceptionHelper::customSingleError('Keine Tasks angegeben.', 400);
            }

            // Get current user.
            $user = Auth::user();

            // Check if user has permission to the given process.
            $has_process_permission = UserHelper::hasProcessPermission($user, $process_id);
            if (!$has_process_permission) {
                ExceptionHelper::customSingleError('Sie haben keinen Zugriff auf diesen Prozess.', 401);
            }

            // The tasks that will be returned to the user in the end.
            $return_values = [];

            // Iterate over every given task.
            foreach ($tasks as $task) {
                /**
                 * Check if task already has an id,
                 * which indicates that it alredy exists.
                 * If so, load the task and edit it.
                 */
                if (array_key_exists('task_id', $task)) {
                    $existing_task = Task::find($task['task_id']);

                    /**
                     * If the task couldn't be found,
                     * create a new one anyways.
                     */
                    if (!$existing_task) {
                        // Create new task and store it.
                        $new_task = $this->createNewTaskObject($task, $process_id);
                        // Throw error if smth. went wrong.
                        if (!$new_task) {
                            return ExceptionHelper::customSingleError('Sorry, beim speichern einer der Tasks ist etwas schief gelaufenn.', 500);
                        }
                        $return_values[] = $new_task;
                        continue;
                    }

                    // Udate values and store to DB.
                    $existing_task->title = $task['title'];
                    $existing_task->rank = $task['rank'];
                    $existing_task->save();
                    $return_values[] = $existing_task;
                    continue;
                }

                // Create a new task if there didn't exist one before.
                $new_task = $this->createNewTaskObject($task, $process_id);
                if (!$new_task) {
                    return ExceptionHelper::customSingleError('Sorry, beim speichern einer der Tasks ist etwas schief gelaufenn.', 500);
                }

                $return_values[] = $new_task;

                // Check if Widgets are attached to the task.
                if (!array_key_exists('steps', $task)) {
                    continue;
                }
                $steps = [];
                foreach ($task['steps'] as $key => $value) {
                    // Put the index of the step in the array as its rank.
                    $value['rank'] = $key;
                    $new_widget = $this->storeTask($new_task['id'], $value);
                    if (!$new_widget) {
                        continue;
                    }
                    $steps[]  = $new_widget;
                }
                // Iterate over steps and save them.
            }

            // Send all tasks back to the client.
            return $return_values;
        } catch (Throwable $e) {
            ExceptionHelper::customSingleError('Sorry, etwas ist schief gelaufen', 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        //
    }

    /**
     * Create and save a new task
     * @param array $task
     *   The task that shall be stored.
     * @param string $process_id
     *   The id of the process the task belongs to.
     * @return object|boolean 
     *   object if the new task is created, false if error.
     */
    private function createNewTaskObject($task, $process_id)
    {
        $new_task = new Task([
            'title' => $task['title'],
            'process_id' => $process_id,
            'rank' => $task['rank'],
        ]);

        try {
            $new_task->save();

            return $new_task;
        } catch (Throwable $e) {
            return false;
        }
    }

    /**
     * Store a new widget in the database.
     * 
     * @param array $step
     *   The step that should be created as a widget.
     * 
     * @return boolean|array
     *   False if creation went wrong. Assoc. array if it was created.
     */
    private function storeTask($task_id, $step)
    {
        // Check if the widget has a type.
        $type = $step['widgetType'];
        if (!$type) {
            return false;
        }

        // Store new widget depending on the type.
        switch ($type) {
            case 'text':
                if (array_key_exists('step_id', $step)) {
                    return $this->textWidget->update($task_id, $step);
                } else {
                    return $this->textWidget->store($task_id, $step);
                }
                break;
            case 'email':
                return $this->emailWidget($step);
                break;
        }
    }
}