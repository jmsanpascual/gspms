<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Volunteer extends Authenticatable
{
    protected $fillable = [
        'name',
        'contact_no',
        'email',
        'address',
        'birth_date',
    ];
}
