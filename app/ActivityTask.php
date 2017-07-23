<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActivityTask extends Model
{
    protected $fillable = [
        'name',
        'activity_id',
        'done',
        'remarks',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function volunteers()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public function activity()
    {
        return $this->belongsTo('App\Activities');
    }
}
