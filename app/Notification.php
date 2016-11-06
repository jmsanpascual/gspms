<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Notification extends Model
{
    public function project() {
        return $this->hasOne('App\Project');
    }

    public function getCreatedAtAttribute($val)
    {
        return Carbon::createFromFormat('Y-m-d h:i:s', $val)
            ->setTimezone('Asia/Singapore')
            ->format('Y-m-d h:i A');
    }
}
