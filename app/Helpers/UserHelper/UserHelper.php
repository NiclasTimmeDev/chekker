<?php

namespace App\Helpers;

use App\User;

class UserHelper
{

    /**
     * Check if the user is a member of a given team.
     * @param \App\User $user
     *   The respective user.
     * @param string $team_id
     *   The id of the team.
     * 
     * @return Boolean
     *   true if user is member.
     */
    public static function isTeamMember($user, $team_id)
    {
        // Check if $user actually is a user object.
        if (!$user instanceof User) {
            return false;
        }

        // Check if user is team member.
        $is_member = $user->teams()->where('team_id', $team_id)->exists();
        if (!$is_member) {
            return false;
        }

        return true;
    }
}
