<?php

namespace App\Http\Transformers;

;
use App\Models\Tree\Tab;
use League\Fractal\TransformerAbstract;

class TreeSelectTabTransformer extends TransformerAbstract
{
    public function transform(Tab $tab)
    {
        return [
            'id' => $tab->id,
            'name' => $tab->name
        ];
    }
}