<?php

namespace App\Http\Transformers;

use Spatie\Permission\Models\Permission;
use League\Fractal\TransformerAbstract;

class PermissionTransformer extends TransformerAbstract
{
    public function transform(Permission $permission)
    {
        $arr = [
            'id' => $permission->id,
            'name' => $permission->name,
            'guard_name' => $permission->guard_name,
            // 'created_at' => $permission->created_at,
            // 'updated_at' => $permission->updated_at,
        ];
        return $arr;
    }

}