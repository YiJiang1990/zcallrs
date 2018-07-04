<?php

namespace App\Http\Transformers;

use Spatie\Permission\Models\Role;
use League\Fractal\TransformerAbstract;

class RoleTransformer extends TransformerAbstract
{
    public function transform(Role $role)
    {
        if ($role->permission) {
          return  [
                'id' => $role->id,
                'name' => $role->name,
                'guard_name' => $role->guard_name,
                'permission' => $role->permission
            ];
        }
        if ($role->role){
            return [
                'role' => $role->role
            ];
        }
        return [
            'id' => $role->id,
            'name' => $role->name,
            'guard_name' => $role->guard_name,
        ];
    }
}