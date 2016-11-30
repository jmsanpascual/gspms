<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectFund extends Model
{
    protected $appends = [
        'type'
    ];

    public function getTypeAttribute()
    {
        return 'Project';
    }

    public function referer()
    {
        return $this->hasOne('App\Project', 'id');
    }
}
