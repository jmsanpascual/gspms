<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActivityTask extends Model
{
    protected $fillable = [
        'name',
        'activity_id',
        'done',
        'remarks',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
