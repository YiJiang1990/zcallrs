<?php

namespace App\Http\Transformers;


use App\Models\ExportLog;
use League\Fractal\TransformerAbstract;

class ExportLogTransformer extends TransformerAbstract
{

    public function transform(ExportLog $exportLog)
    {
        return [
            'id' => $exportLog->id,
            'name' => $exportLog->name,
            'export_num' => $exportLog->export_num,
            'file_path' => $exportLog->file_path,
            'type' => ( $exportLog->type == 'clients')? '客户': (( $exportLog->type == 'temporary')? '公海': '联系人'),
            'status' => ($exportLog->status == 1)? '正常': (($exportLog->status == 0)?'导出中': '失败'),
            'export_counts' => $exportLog->export_counts,
            'created_at' => $exportLog->created_at->toDateTimeString()
        ];
    }

}