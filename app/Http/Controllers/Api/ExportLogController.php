<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\ExportLogRequest;
use App\Http\Transformers\ExportLogTransformer;
use App\Models\ExportLog;
use App\Models\ExportUserLog;
use Illuminate\Support\Facades\DB;

class ExportLogController extends Controller
{
    public function index(ExportLogRequest $request, ExportLog $exportLog)
    {
        $selects = $exportLog->where('parent_uid', $this->user()->parent_uid)
            ->orderBy('id', 'desc')
            ->paginate($request->get('limit'));
        return $this->response->paginator($selects, new ExportLogTransformer());
    }

    public function download(ExportLogRequest $request, ExportLog $exportLog, ExportUserLog $userLog)
    {
        $file = $exportLog->where('parent_uid', $this->user()->parent_uid)
            ->where('id', $request->get('id'))
            ->value('file_path');

        if (!$file) {
            abort(403,'下载失败');
        }
        DB::beginTransaction();
        try{
            $exportLog->where('parent_uid', $this->user()->parent_uid)
                ->where('id', $request->get('id'))->increment('export_num');
            $userLog->create([
                'export_id'=> $request->get('id'),
                'export_uid'=>$this->user()->id
            ]);
            DB::commit();
        }catch (\Exception $exception){
            abort(403,'下载失败');
            DB::rollback();
        }
        return $this->response->array(['path' => env('APP_URL').'/storage/'.$file]);
    }
}
