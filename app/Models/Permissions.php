<?php
namespace App\Models;

use Spatie\Permission\Models\Permission as OriginalPermission;

class Permissions extends OriginalPermission
{
    public $guard_name = 'api';

    public function getAllRolesWith()
    {
        return $this->belongsToMany('App\Models\Permissions','role_has_permissions','permission_id','role_id');
    }
}