<?php

namespace App\Http\Transformers;

use App\Models\ExportUserLog;
use League\Fractal\TransformerAbstract;

class ExportUserLogTransformer extends TransformerAbstract
{
    protected $availableIncludes = ['user'];

    public function transform(ExportUserLog $userLog)
    {
        return [
            'id' => $userLog->id,
            'export_id' => $userLog->export_id,
            'export_uid' => $userLog->export_uid,
            'created_at' => $userLog->created_at->toDateTimeString()
        ];
    }

    public function includeUser(ExportUserLog $userLog)
    {
        return $this->item($userLog->user, new UserTransformer());
    }
}