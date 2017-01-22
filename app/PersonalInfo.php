<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class PersonalInfo extends Model
{
    use SoftDeletes;
    protected $table = 'personal_info';

    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'contact_num',
        'email',
        'address',
        'birth_date',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function scopejoinUserInfo($query)
    {
        $user_info = (new UserInfo)->getTable();
        return $query->leftJoin($user_info, $this->getTable() . '.id', '=', $user_info . '.personal_info_id');
    }
}
