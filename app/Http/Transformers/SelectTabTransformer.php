<?php

namespace App\Http\Transformers;

use App\Models\SelectTab;
use League\Fractal\TransformerAbstract;

class SelectTabTransformer extends TransformerAbstract
{
    protected $availableIncludes = ['options'];

    public function transform(SelectTab $selectTab)
    {
        return [
            'id' => $selectTab->id,
            'name' => $selectTab->name
        ];
    }

    public function includeOptions(SelectTab $selectTab)
    {
        return $this->collection($selectTab->Options,new OptionsTransformer());
    }
}