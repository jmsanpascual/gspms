<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Milestone extends Model
{
    protected $fillable = [
        'project_id',
        'phase_1',
        'phase_2',
        'phase_3',
    ];
}
