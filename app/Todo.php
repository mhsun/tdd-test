<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    protected $fillable = [
        'title', 'status'
    ];

    protected $casts = [
        'status' => 'bool'
    ];
}
