<?php

namespace App\Http\Controllers\Api\Tree;

use App\Models\Tree\Option;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\Controller;
use App\Http\Requests\Api\Permission\GroupRequest;

class ValueController extends Controller
{

    protected $model;

    public function __construct(Option $option)
    {
        $this->model = $option;
    }

    public function index()
    {
        $data = $this->model->getList();
        $response['data']['list'] = $data['attr'];
        $response['data']['option'] = $data['tree'];
        return $this->response->array($response);
    }

    public function create(GroupRequest $request)
    {
        $this->model->fill($request->all());
        $this->model->parent_uid = $this->user()->parent_uid;
        $this->model->user_id = $this->user()->id;
        $this->model->save();
        return $this->response->created();
    }

    public function update(GroupRequest $request)
    {
        $update = $request->only(['name','pid']);
        $this->model->where('id', $request->get('id'))->where('parent_uid',$this->user()->parent_uid)->update($update);
        return $this->response->noContent();
    }

    public function destroy(GroupRequest $request)
    {
        $id = $request->get('id');

        if ($this->model->where('parent_uid',$this->user()->parent_uid)->where('id', $id)->delete()) {
            return $this->response->noContent();
        }
        abort(403,'删除失败');
    }

}
