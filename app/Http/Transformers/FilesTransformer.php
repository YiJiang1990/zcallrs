<?php

namespace App\Http\Transformers;


use App\Models\Files;
use League\Fractal\TransformerAbstract;

class FilesTransformer extends TransformerAbstract
{
    public function transform(Files $files)
    {
        return [
            'id' => $files->id,
            //'user_id' => $image->user_id,
            //'type' => $image->type,
            // 'name' => $files->name,
            'path' => $files->path,
            //'created_at' => $image->created_at->toDateTimeString(),
            //'updated_at' => $image->updated_at->toDateTimeString(),
        ];
    }
}