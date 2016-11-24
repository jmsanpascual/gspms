<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SchoolFund extends Model
{
    protected $fillable = [
        'school_id',
        'amount',
    ];

    public function school()
    {
        return $this->belongsTo('App\School');
    }
}