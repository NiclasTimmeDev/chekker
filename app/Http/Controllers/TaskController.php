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
     * Get all tasks of a process.
     *
     * @param string process_id
     *   The process the tasks belong to.
     * 
     * @return \Illuminate\Http\Response
     */
    public function index(string $process_id)
    {
        try {
            // Check for user.
            $user = Auth::user();
            if (!$user) {
                return ExceptionHelper::customSingleError('Sie sind nicht eingeloggt.', 401);
            }

            // Check if process id is given.
            if (!$process_id) {
                return ExceptionHelper::customSingleError('Kein Prozess angegeben.', 400);
            }

            // Check if user has access to this process.
            $user_has_permission = UserHelper::hasProcessPermission($user, $process_id);
            if (!$user_has_permission) {
                return ExceptionHelper::customSingleError('Sie haben keine Berechtigungen für diesen Prozess.', 401);
            }

            // Load all tasks that have this process id.
            $tasks = Task::where('process_id', $process_id)->orderBy('rank', 'ASC')->get();

            return $tasks;
        } catch (Throwable $e) {
            return ExceptionHelper::customSingleError('Sorry, etwas ist schief gelaufen.', 500);
        }
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
            $rank = $request->rank;

            // Return if no process id given.
            if (!$process_id) {
                return ExceptionHelper::customSingleError('Kein Prozess angegeben.', 400);
            }

            if (!$rank && $rank !== 0) {
                return ExceptionHelper::customSingleError('Kein Ranking angegeben.', 400);
            }

            // Get current user.
            $user = Auth::user();

            // Check if user has permission to the given process.
            $has_process_permission = UserHelper::hasProcessPermission($user, $process_id);
            if (!$has_process_permission) {
                ExceptionHelper::customSingleError('Sie haben keinen Zugriff auf diesen Prozess.', 401);
            }

            // Create new task.
            $new_task = new Task([
                'title' => "",
                'process_id' => $process_id,
                'rank' => $rank,
            ]);
            $new_task->save();

            // Send newly created task to client.
            return $new_task;
        } catch (Throwable $e) {
            return ExceptionHelper::customSingleError('Sorry, etwas ist schief gelaufen', 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        try {
            $process_id = $request->process_id;
            $updated_task = $request->task;

            // Check if user has permission to the process.
            $user = Auth::user();
            $has_permission = UserHelper::hasProcessPermission($user, $process_id);
            if (!$has_permission) {
                return ExceptionHelper::customSingleError('Sie haben keinen Zugriff auf diesen Prozess.', 401);
            }

            // Load task.
            $task = Task::find($updated_task['id']);
            if (!$task) {
                return ExceptionHelper::customSingleError('Der Task wurde nicht gefunden.', 404);
            }

            // Iterate over every field of task from req and update the values.
            foreach ($updated_task as $key => $value) {
                // Skip if it's a field that should not be changed by the user.
                if ($key === 'created_at' || $key === 'id' || $key === 'id' || $key === 'updated_at') {
                    continue;
                }
                // Update value of task.
                $task->$key = $value;
            }
            $task->save();
            return $task;
        } catch (Throwable $e) {
            return ExceptionHelper::customSingleError('Sorry, etwas ist schief gelaufen', 500);
        }
    }
    /**
     * Update the rankings of all tasks of a process.
     */
    public function updateRankings(Request $request)
    {
        try {
            $process_id = $request->process_id;
            $tasks = $request->tasks;

            // Check if user has permission to the process.
            $user = Auth::user();
            $has_permission = UserHelper::hasProcessPermission($user, $process_id);
            if (!$has_permission) {
                return ExceptionHelper::customSingleError('Sie haben keinen Zugriff auf diesen Prozess.', 401);
            }

            // Find the 'old' task from DB for every task sent by client.
            $error = FALSE;
            $updated_tasks = [];
            foreach ($tasks as $task) {
                $old_task = Task::find($task['id']);
                // Error if task wasn't found.
                if (!$old_task) {
                    $error = TRUE;
                    break;
                }
                // Update the value. Don't save yet, because there might occur an error with another task.
                $old_task->rank = $task['rank'];
                $updated_tasks[] = $old_task;
            }
            // Error if something went wrong.
            if ($error) {
                return ExceptionHelper::customSingleError('Sorry, etwas ist schief gelaufen.', 500);
            }

            // Store updated tasks.
            foreach ($updated_tasks as $updated_task) {
                $updated_task->save();
            }

            // Send updated tasks to client.
            return $updated_tasks;
        } catch (Throwable $e) {
            return ExceptionHelper::customSingleError('Sorry, etwas ist schief gelaufen.', 500);
        }
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