<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class PersonalInfo extends Model
{
    use SoftDeletes;
    protected $table = 'personal_info';
}
