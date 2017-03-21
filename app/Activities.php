<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activities extends Model
{
    protected $hidden = [
        'projects',
    ];

    protected $appends = [
        'project',
    ];

    public function projects() {
        return $this->belongsToMany('App\Project', 'proj_activities', 'activity_id', 'proj_id');
    }

    public function getProjectAttribute() {
        if (array_key_exists('projects', $this->getRelations())) {
            $projects = $this['projects']->toArray();
            return array_shift($projects);
        }
    }
}
