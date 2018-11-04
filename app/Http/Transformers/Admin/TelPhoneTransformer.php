<?php

namespace App\Http\Transformers\Admin;

use League\Fractal\TransformerAbstract;
use App\Models\TelPhone;

class TelPhoneTransformer extends TransformerAbstract
{
    public function transform(TelPhone $phone)
    {
        return [
            'id' => $phone->id,
            'uid' => $phone->uid,
            'parent_uid' => $phone->parent_uid,
            'phone' => $phone->phone,
            'password' => $phone->password,
        ];
    }

}
