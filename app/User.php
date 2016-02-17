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

    // public function scopejoinUserInfo()
    // {
    //     $user_info = (new UserInfo)->getTable();
    //     return leftJoin($user_info . ' AS pi', 
    //             'users.id', '=', $user_info . '.user_id');
    // }
}
