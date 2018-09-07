<?php

namespace App\Http\Transformers;


use App\Models\Clients\Follow;
use League\Fractal\TransformerAbstract;

class FollowTransformer extends TransformerAbstract
{
    protected $availableIncludes = ['option','chance'];

    public function transform(Follow $follow)
    {
        return [
            'id' => $follow->id,
            'name' => $follow->name,
            'selects_tab_value_id' => $follow->selects_tab_value_id,
        ];
    }

    public function includeChance(Follow $follow)
    {
        return $this->item($follow->chance, new ChanceTransformer());
    }

    public function includeOption(Follow $follow)
    {
        return $this->item($follow->option,new OptionsTransformer());
    }
}