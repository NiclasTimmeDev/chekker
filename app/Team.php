<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    // Determine which fields can be filled by the user.
    protected $fillable = ['name', 'access_code', 'user_id'];

    // m:n relationship with users.
    public function users()
    {
        return $this->belongsToMany('App\User')->withTimestamps();
    }
}