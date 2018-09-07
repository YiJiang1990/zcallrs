<?php

namespace App\Http\Transformers;

use App\Models\DiyCommonField;
use League\Fractal\TransformerAbstract;

class FieldTransformer extends TransformerAbstract
{
    public function transform(DiyCommonField $commonField)
    {
        return [
                'id' => $commonField->id,
                'title' => $commonField->title,
                'name' => $commonField->name,
                'from' => $commonField->from,
                'parent_type' => $commonField->parent_type,
                'children_type' => $commonField->children_type,
                'style_type' => $commonField->style_type,
                'status' => $commonField->status,
        ];
    }
}