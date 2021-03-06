<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TextWidget extends Model
{
    // Fillable fields.
    protected $fillable = [
        'task_id',
        'value',
        'rank',
        'process_id',
        'widget_type'
    ];

    // One to many relation with task.
    public function process()
    {
        return $this->belongsTo('App\Task');
    }
}