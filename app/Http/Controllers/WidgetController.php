<?php

namespace App\Http\Controllers;

use Throwable;
use App\TextWidget;
use App\Helpers\UserHelper;
use Illuminate\Http\Request;
use App\Helpers\ExceptionHelper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;

class WidgetController extends Controller
{
    /**
     * Get all 
     * @param string $process_id
     *   The process for which all steps shall be loaded.
     * 
     * @return Response
     */
    public function index(string $process_id)
    {
        try {
            // Check if user has permission to the process.
            $user = Auth::user();
            $has_permission = UserHelper::hasProcessPermission($user, $process_id);
            if (!$has_permission) {
                return ExceptionHelper::customSingleError('Sie haben keinen Zugriff auf diesen Prozess.', 401);
            }

            // All steps will be put into this array.
            $all_steps = [];

            // Get all corresponding text widgets.
            $text_widgets = $this->getAllTextWidgets($process_id);
            if (!is_array($text_widgets)) {
                return ExceptionHelper::customSingleError('Sorry, etwas ist schief gelaufen.', 500);
            }

            // Put text widgets to all_steps 
            $all_steps = array_merge($all_steps, $text_widgets);

            // Sort the steps by ranking.
            usort($all_steps, function ($a, $b) {
                if ($a->rank === $b->rank) {
                    return 0;
                }

                return ($a->rank < $b->rank) ? -1 : 1;
            });

            return $all_steps;
        } catch (Throwable $e) {
            ExceptionHelper::customSingleError('Sorry, etwas ist schief gelaufen', 500);
        }
    }

    /**
     * Get all Text Widget steps of a process.
     * 
     * @param string $process_id
     *   The process
     * 
     * @return array|false
     *   The text widgets. 
     */
    private function getAllTextWidgets($process_id)
    {
        try {
            $widget_collection =  TextWidget::where('process_id', $process_id)->get();

            // Check if query was successfull.
            if (!$widget_collection instanceof Collection) {
                return FALSE;
            }

            // Extract items from collection.
            return $widget_collection->all();
        } catch (Throwable $e) {
            return FALSE;
        }
    }

    // private function sortByRanking($a, $b)
    // {
    //     return ($a['rank'] < $b['rank']);
    // }
}