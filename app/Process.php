<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Process extends Model
{
    protected $fillable = [
        'title',
        'description',
        'permission',
        'team_id',
        'user_id',
        'recurrence_pattern',
        'category_id',
        'is_active',
    ];
    // m:n relationship with users.
    public function users()
    {
        return $this->belongsToMany('App\User')->withTimestamps();
    }
    // m:n relationship with tags.
    public function tags()
    {
        return $this->belongsToMany('App\Tag')->withTimestamps();
    }
}