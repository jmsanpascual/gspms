<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activities extends Model
{
    protected $cast =[
        'quantity' => 'int',
        'price' => 'int'
    ];
}
