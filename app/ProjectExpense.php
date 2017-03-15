<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class ProjectExpense extends Model
{
    protected $appends = [
        'remaining_amount'
    ];

    public function getRemainingAmountAttribute()
    {
        $id = $this->attributes['id'];
        $budget = $this->attributes['amount'];
        $activityExpense = ActivityItemExpense::where('project_expense_id', $id)
            ->sum(DB::raw('quantity * price'));

        return $budget - $activityExpense;
    }
}
