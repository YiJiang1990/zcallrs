<?php

namespace App\Models;

use App\Models\Permission\Group;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

/**
 * Class User
 * @package App\Models
 */
class User extends Authenticatable implements JWTSubject
{

    use Notifiable, SoftDeletes, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','phone','ended_at',
        'started_at','is_admin','is_corporate','is_sms',
        'parent_id','created_corporate_user_number',
        'max_add_corporate_user_number','avatar',
        'created_user_id','parent_uid'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'deleted_at',
    ];

    /**
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function group()
    {
        return $this->belongsToMany(Group::class,'group_has_user','user_id','group_id');
    }
}
