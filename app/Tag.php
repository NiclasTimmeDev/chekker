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
}