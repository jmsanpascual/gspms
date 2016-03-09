<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectActivities extends Model
{
    //
    protected $table = 'proj_activities';

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
}
