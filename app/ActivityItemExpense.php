<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActivityItemExpense extends Model
{
    protected $appends = [
        'category'
    ];

    public function getCategoryAttribute()
    {
        $projExp_id = $this->attributes['project_expense_id'];
        $proj = ProjectExpense::find($projExp_id);
        return $proj->category;
    }
}
