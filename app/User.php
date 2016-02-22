<?php

namespace App;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     use SoftDeletes;

    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function scopejoinUserInfo($query)
    {
        $user_info = (new UserInfo)->getTable();
        return $query->leftJoin($user_info, $this->getTable() . '.id', '=', $user_info . '.user_id');
    }

    public function scopejoinPersonalInfo($query)
    {
        $user_info = (new UserInfo)->getTable();
        $personal_info = (new PersonalInfo)->getTable();
        return $query->leftJoin($user_info, $this->getTable() . '.id', '=', $user_info . '.user_id')
                ->leftJoin($personal_info, $user_info . '.personal_info_id', '=', $personal_info . '.id');
    }

    public function scopejoinUserRole($query)
    {
        $user_role = (new UserRoles)->getTable();
        return $query->leftJoin($user_role, $this->getTable() . '.id', '=', $user_role . '.user_id');
    }
}
