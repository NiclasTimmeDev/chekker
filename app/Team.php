<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    // Determine which fields can be filled by the user.
    protected $fillable = ['name', 'access_code', 'user_id', 'is_premium'];

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

    // One to many relation with external persons.
    public function externalPersons()
    {
        return $this->hasMany('App\ExternalPerson');
    }
}