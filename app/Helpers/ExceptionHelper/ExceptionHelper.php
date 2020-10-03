<?php

namespace App\Helpers;

class ExceptionHelper
{

    /**
     * @param string $error
     *   The custom error message.
     * @param integer $status_code
     *   The status code.
     * @return response
     *   The response Object.
     */
    public static function customSingleError($error, $status_code)
    {
        return response()->json(
            [
                "error" => $error
            ],
            $status_code
        );
    }
}