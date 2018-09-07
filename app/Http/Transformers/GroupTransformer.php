<?php

namespace App\Http\Transformers;

use App\Models\Permission\Group;
use League\Fractal\TransformerAbstract;

class GroupTransformer extends TransformerAbstract
{
    public function transform(Group $group)
    {
        return [
                'id' => $group->id,
                'name' => $group->name,
        ];
    }
}