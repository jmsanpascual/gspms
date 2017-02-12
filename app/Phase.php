<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Phase extends Model
{
    protected $fillable = [
        'name',
        'count',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
