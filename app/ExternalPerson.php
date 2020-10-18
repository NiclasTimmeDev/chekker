<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExternalPerson extends Model
{
    protected $fillable = [
        'name',
        'team_id',
        'email',
        'organization',
    ];

    // One to many relation with team.
    public function team()
    {
        return $this->belongsTo('App\Team');
    }
}