<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectBudgetRequest extends Model
{
    //
    protected $table = "proj_budget_request";

    public function scopeJoinBudgetStatus($query)
    {
    	$br_status = (new BudgetRequestStatus)->getTable();
    	return $query->leftJoin($br_status, $this->getTable(). ".status_id", "=",
    	 $br_status . ".id");
    }
}
