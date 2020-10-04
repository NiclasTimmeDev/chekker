<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Process extends Model
{
    // m:n relationship with users.
    public function users()
    {
        return $this->belongsToMany('App\User')->withTimestamps();
    }
}