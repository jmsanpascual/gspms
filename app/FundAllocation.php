<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FundAllocation extends Model
{
    protected $table = 'funds_allocation';

    public function project() {
        return $this->belongsTo('App\Projects', 'project_id', 'id');
    }
}
