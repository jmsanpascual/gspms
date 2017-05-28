<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $table = 'activity_tasks';

    protected $appends = [
        'volunteer'
    ];

    public function activity()
    {
        return $this->belongsTo('App\Activities');
    }

    public function getVolunteerAttribute()
    {
        $userId = $this->attributes['user_id'];
        $user = \App\User::joinPersonalInfo()->find($userId);
        $name = $user['first_name'] . ' ' . $user['last_name'];
        $name = trim($name);
        return $name ?: 'No volunteer yet';
    }
}
