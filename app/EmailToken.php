<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmailToken extends Model
{
    // Fillable fields.
    protected $fillable = [
        'email_widget_id',
        'placeholder',
        'value',
    ];
}