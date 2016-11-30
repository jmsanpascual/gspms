<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SchoolFund extends Model
{
    protected $fillable = [
        'school_id',
        'amount',
        'year',
        'received_date',
    ];

    protected $appends = [
        'type'
    ];

    public function getTypeAttribute()
    {
        return 'School';
    }

    public function referer()
    {
        return $this->hasOne('App\School', 'id');
    }
}
