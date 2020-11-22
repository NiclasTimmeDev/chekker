<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmailWidget extends Model
{
    // Fillable fields.
    protected $fillable = [
        'task_id',
        'to',
        'cc',
        'subject',
        'body',
        'rank',
        'send_by_system',
        'has_tokens',
    ];
}