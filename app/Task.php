<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $table = 'activity_tasks';

    public function activity() {
        return $this->belongsTo('App\Activities');
    }
}
