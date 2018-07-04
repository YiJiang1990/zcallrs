<?php

namespace App\Http\Transformers;

use App\Models\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    public function transform(User $user)
    {
        $arr = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
        ];
        if ($user->nav) {
            $arr['nav'] = $user->nav;
        }
        if ($user->roles){
            $arr['roles'] = $user->roles;
        }
        if ($user->permission) {
            $arr['permission'] = $user->permission;
        }
        return $arr;
        // return $user->attributesToArray();
    }
}
