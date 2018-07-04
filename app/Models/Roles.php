<?php
namespace App\Models;

use Spatie\Permission\Models\Role as OriginalRole;
class Roles extends OriginalRole
{
    public $guard_name = 'api';

    public function getAllPermissionsWith()
    {
        return $this->belongsToMany('App\Models\Permissions','role_has_permissions','role_id','permission_id');
    }
}