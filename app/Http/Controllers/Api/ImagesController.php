<?php

namespace App\Http\Controllers\Api;

use App\Models\Image;
use Illuminate\Http\Request;
use App\Handlers\ImageUploadHandler;
use App\Http\Transformers\ImageTransformer;
use App\Http\Requests\Api\ImageRequest;

class ImagesController extends Controller
{
    public function store(ImageRequest $request, ImageUploadHandler $uploader, Image $image)
    {
        $user = $this->user();

        $result = $uploader->save($request->image, str_plural($request->type), $user->id);

        $image->path = $result['path'];
        $image->type = $request->type;
        $image->user_id = $user->id;
        $image->parent_uid = $user->parent_uid;
        $image->save();

        return $this->response->item($image, new ImageTransformer())->setStatusCode(201);
    }
}
