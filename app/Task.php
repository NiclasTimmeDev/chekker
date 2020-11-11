<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'title',
        'rank',
        'process_id',
        'is_done',
        'has_watchers',
        'assignee_id',
        'has_due_date'
    ];
    // One to many relation with team.
    public function process()
    {
        return $this->belongsTo('App\Process');
    }
}