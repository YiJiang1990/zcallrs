<?php

namespace App\Http\Controllers\Api;

use App\Handlers\FilesUploadHandler;
use App\Http\Transformers\FilesTransformer;
use App\Models\Files;
use App\Http\Requests\Api\FilesRequest;

class FilesController extends Controller
{
    public function store(FilesRequest $request, FilesUploadHandler $uploader, Files $files)
    {

        $user = $this->user();
        $result = $uploader->save($request->file, str_plural($request->type), $user->id);

        $files->path = $result['path'];
        $files->type = $request->type;
        $files->name = $request->file->getClientOriginalName();
        $files->user_id = $user->id;
        $files->parent_uid = $user->parent_uid;
        $files->save();

        return $this->response->item($files, new FilesTransformer())->setStatusCode(201);
    }
}
