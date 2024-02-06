<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LogHistory extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'created_at' => 'datetime',
    ];
}
