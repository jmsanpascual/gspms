<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use SoftDeletes;

    protected $table = 'projects';

    protected $appends = [
      'start_date',
      'end_date',
      'actual_end'
    ];

    public function budget_request()
    {
        return $this->hasMany('App\ProjectBudgetRequest', 'proj_id');
    }

    public function expenses()
    {
        return $this->hasMany('App\ProjectBudgetRequest', 'proj_id');
    }

    public function getStartDateAttribute($val)
    {
        if(EMPTY($val)) return;

        return date('F j, Y', strtotime($val));
    }
    public function getEndDateAttribute($val)
    {
        if(EMPTY($val)) return;

        return date('F j, Y', strtotime($val));
    }
    public function getActualEndAttribute($val)
    {
        if(EMPTY($val)) return;

        return date('F j, Y', strtotime($val));
    }
}
