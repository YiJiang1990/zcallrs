<?php

namespace App\Http\Transformers;


use App\Models\Options;
use League\Fractal\TransformerAbstract;

class OptionsTransformer extends TransformerAbstract
{
    public function transform(Options $options)
    {
        return [
            'id' => $options->id,
            'name' => $options->name,
            'selects_tab_id' => $options->selects_tab_id
        ];
    }
}