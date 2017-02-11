<?php

namespace App;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Hash;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     use SoftDeletes;

    protected $fillable = [
        'username', 'password',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'infos',
        'expertises',
        'roles',
        'remember_token',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $appends = [
        'info',
        'expertise',
        // 'role'
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

    public function notifications()
    {
        return $this->belongsToMany('App\Notification', 'user_notifications');
    }

    public function infos()
    {
        return $this->belongsToMany('App\PersonalInfo', 'user_info');
    }

    public function expertises()
    {
        return $this->belongsToMany('App\Expertise', 'user_expertise');
    }

    public function first_post_pic ()
    {
        return $this->hasOne(PostPicture::class)->orderBy('id', 'asc');
    }

    public function roles() {
        return $this->belongsToMany('App\Roles', 'user_roles', 'user_id', 'role_id');
    }

    public function setPasswordAttribute($pass)
    {
        $this->attributes['password'] = Hash::make($pass);
    }

    public function getInfoAttribute() {
        if (array_key_exists('infos', $this->getRelations())) {
            $info = $this['infos']->toArray();
            return array_shift($info);
        }
    }

    public function getExpertiseAttribute() {
        if (array_key_exists('expertises', $this->getRelations())) {
            $expertises = $this['expertises']->toArray();
            return array_shift($expertises);
        }
    }

    // public function getRoleAttribute() {
    //     if (array_key_exists('roles', $this->getRelations())) {
    //         $info = $this['roles']->toArray();
    //         return array_shift($info);
    //     }
    // }
}
