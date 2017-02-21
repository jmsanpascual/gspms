<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Specialization extends Model
{
    protected $appends = [
        'program'
    ];

    public function getProgramAttribute()
    {
        $programId = $this->attributes['program_id'];
        $program = Program::find($programId);
        return $program->name;
    }
}
