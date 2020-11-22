<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubtaskWidget extends Model
{
    // Fillable fields.
    protected $fillable = [
        'task_id',
        'title',
        'rank',
        'count',
    ];
}