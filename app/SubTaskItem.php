<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubTaskItem extends Model
{
    // Fillable fields.
    protected $fillable = [
        'task_id',
        'text',
        'rank',
        'is_done',
    ];
}