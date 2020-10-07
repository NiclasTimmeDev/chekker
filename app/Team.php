<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    // Determine which fields can be filled by the user.
    protected $fillable = ['name', 'access_code', 'user_id'];

    // Many to many  relationship with users.
    public function users()
    {
        return $this->belongsToMany('App\User')->withTimestamps();
    }

    // One to many relation with tags.
    public function tags()
    {
        return $this->hasMany('App\Tag');
    }
}