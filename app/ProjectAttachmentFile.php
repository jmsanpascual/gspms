<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectAttachmentFile extends Model
{
    protected $hidden = [
        'dirFile'
    ];

    protected $appends = [
        'dirFile'
    ];

    public function getFileAttribute($value) {
        return asset('attachments') . '/' . $value;
    }

    public function getDirFileAttribute($value) {
        return public_path() . DIRECTORY_SEPARATOR . 'attachments' . DIRECTORY_SEPARATOR .
            $this->attributes['file'];
    }
}
