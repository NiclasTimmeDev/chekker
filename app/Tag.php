<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = [
        'title', 'team_id', 'background', 'text',
    ];

    // One to many relation with team.
    public function team()
    {
        return $this->belongsTo('App\Team');
    }
    // m:n relationship with processes.
    public function processes()
    {
        return $this->belongsToMany('App\Process')->withTimestamps();
    }
}