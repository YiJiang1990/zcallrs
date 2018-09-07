<?php

namespace App\Models;

use Auth;
use Illuminate\Database\Eloquent\Model;

class ExportLog extends Model
{
    protected $table = 'export_log';
    protected $fillable = ['name', 'export_num', 'file_path', 'uid',
        'parent_uid', 'type', 'status', 'search_data', 'export_counts'];

    public function add($request)
    {
        $filePath = 'exports/'.iconv('UTF-8', 'GBK', str_random(64) . '.xlsx');
        return $this->create([
            'name' => $request->input('excel_name','excel-list'),
            'file_path' => $filePath,
            'uid' => Auth::user()->id,
            'parent_uid' => Auth::user()->parent_uid,
            'type' => $request->get('type'),
            'status' => 1,
        ]);
    }
}
