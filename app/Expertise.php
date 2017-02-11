<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expertise extends Model
{
    protected $table = 'expertise';

    protected $fillable = [
        'name',
    ];
}
