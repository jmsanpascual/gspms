<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Log;
class Projects extends Model
{
    public function scopeJoinStatus($query)
    {
    	$stat_tb = (new ProjectStatus)->getTable();
    	return $query->leftJoin($stat_tb, $this->getTable() . '.proj_status_id', '=', $stat_tb . '.id');
    }
}
