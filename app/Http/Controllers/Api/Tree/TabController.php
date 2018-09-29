<?php

namespace App\Http\Controllers\Api\Tree;


use App\Http\Controllers\Api\Controller;
use App\Http\Requests\Api\SelectTabRequest;
use App\Http\Transformers\TreeSelectTabTransformer;
use App\Models\Tree\Tab;

class TabController extends Controller
{
    protected $model,$request;

    public function __construct(SelectTabRequest $request, Tab $tab)
    {
        $this->request = $request;
        $this->model = $tab;
    }

    public function index()
    {
       $data = $this->model->where('parent_uid',$this->user()->parent_uid)
            ->orderBy('id', 'desc')
            ->paginate($this->request->get('limit'));
        return $this->response->paginator($data, new TreeSelectTabTransformer());
    }

    public function create()
    {
        $me = $this->user();
        $this->model->fill($this->request->all());
        $this->model->user_id = $me->id;
        $this->model->parent_uid =  $me->parent_uid;
        $this->model->save();
        return $this->response->created();
    }

    public function update($id)
    {
        $where = ['id' => $id, 'parent_uid' => $this->user()->parent_uid];

        if ($this->model->where($where)->update(['name' => $this->request->get('name')])) {
            return $this->response->noContent();
        }

        abort(403, '修改失败!');
    }

    public function destroy($id)
    {
        if ($this->model->where('id',$id)->where('parent_uid',$this->user()->parent_uid)->delete()) {
            return $this->response->noContent();
        }
        abort(403, '删除失败!');
    }
}
