<?php

namespace App\Http\Transformers;

use App\Models\User;
use League\Fractal\TransformerAbstract;

class CorporateTransformer extends TransformerAbstract
{
    public function transform(User $user)
    {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'max_add_corporate_user_number' => $user->max_add_corporate_user_number,
            'is_sms' => $user->is_sms,
            'started_at' => $user->started_at,
            'ended_at' => $user->ended_at,
        ];
    }
}