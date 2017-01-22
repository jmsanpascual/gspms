<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectActivities extends Model
{
    //
    protected $table = 'proj_activities';

    protected $dates = [
        'start_date',
        'end_date',
    ];

    public function tasks()
    {
        return $this->hasMany('App\ActivityTask', 'activity_id', 'activity_id');
    }

    public function scopejoinActivities($query)
    {
    	$activity = (new Activities)->getTable();
    	return $query->join($activity, $activity . '.id', '=', $this->table . '.activity_id');
    }

    public function scopejoinActivityStatus($query)
    {
    	$activity = (new Activities)->getTable();
    	$act_status = (new ActivityStatus)->getTable();
    	return $query->join($activity, $activity . '.id', '=', $this->table . '.activity_id')
    		->join($act_status, $act_status . '.id', '=', $activity . '.status_id');
    }

    function getStartDateAttribute()
    {
        return date("Y-m-d", strtotime($this->attributes['start_date']));
    }

    function getEndDateAttribute()
    {
        return date("Y-m-d", strtotime($this->attributes['end_date']));
    }
}
