<?php

namespace App\Http\Controllers\Api\Call;

use App\Http\Transformers\Call\LogTransformer;
use Illuminate\Contracts\Logging\Log;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\Controller;
use App\Models\Log\Call;
use App\Http\Requests\Api\Call\LogRequest;

class LogController extends Controller
{
    private $model;

    public function __construct(Call $call)
    {

        $this->model = $call;
    }

    public function index(LogRequest $request)
    {

        $query = $this->model->query();

        $res = $request->all();

        if (!empty($res['start_time'])) {
            $query->where('start_time','>=',$res['start_time'][0])->where('start_time','<=',$res['start_time'][1]);
        }

        if (!empty($res['src'])) {
            $query->where('src','like',$res['src']);
        }

        if (!empty($res['dst'])) {
            $query->where('dst','like',$res['dst']);
        }

        if (!empty($res['answered'])) {
            $query->where('answered',$res['answered']);
        }

        if (!empty($res['direct'])) {
            $query->where('direct',$res['direct']);
        }
        $list = $query->where('parent_uid', $this->user()->parent_uid)->paginate($request->get('limit'));
        return $this->response->paginator($list, new LogTransformer());
    }

    public function destroy($id)
    {
        if ($this->model->where('parent_uid', Auth::user()->parent_uid)->where('id', $id)->delete()) {
            return $this->response->noContent();
        }
        abort(403, '删除失败!');
    }
}
