<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\ExportUserLogRequest;
use App\Http\Transformers\ExportUserLogTransformer;
use App\Models\ExportUserLog;

class ExportUserLogController extends Controller
{
    public function index(ExportUserLogRequest $request, ExportUserLog $userLog)
    {
        $selects = $userLog->orderBy('id', 'desc')->where('export_id',$request->get('id'))
            ->paginate($request->get('limit'));
        return $this->response->paginator($selects, new ExportUserLogTransformer());
    }
}
