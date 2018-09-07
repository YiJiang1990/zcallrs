<?php

namespace App\Http\Controllers\Api;

use App\Models\SelectTab;
use App\Http\Requests\Api\SelectTabRequest;
use App\Http\Transformers\SelectTabTransformer;
use Auth;
use App\Models\Permission\Actions;

class SelectTabController extends Controller
{

    private $_action = [
        'index' => ['group_name' => 'option', 'action_name' => 'select'],
        'create' => ['group_name' => 'option', 'action_name' => 'add'],
        'update' => ['group_name' => 'option', 'action_name' => 'edit'],
        'destroy' => ['group_name' => 'option', 'action_name' => 'delete'],
    ];
    private $not_permission_action_name = ['userStoreAll'];
    public function __construct(Actions $actions)
    {
        if (!in_array(request()->route()->getActionMethod(),$this->not_permission_action_name)) {
            if ($actions->permission($this->_action[request()->route()->getActionMethod()]) == false) {
                abort(403, '权限不足!');
            };
        }
    }
    public function index(SelectTabRequest $request, SelectTab $selectTab)
    {
        $selects = $selectTab->where('parent_uid',$this->user()->parent_uid)
            ->orderBy('id', 'desc')
            ->paginate($request->get('limit'));
        return $this->response->paginator($selects, new SelectTabTransformer());
    }

    public function userStoreAll(SelectTab $selectTab)
    {
        $data = $selectTab->where('parent_uid',$this->user()->parent_uid)->get();

        return $this->response->collection($data, new SelectTabTransformer());
    }

    public function create(SelectTabRequest $request, SelectTab $selectTab)
    {
        $me = Auth::user();
        $selectTab->fill($request->all());
        $selectTab->user_id = Auth::id();
        $selectTab->parent_uid =  $me->parent_uid;
        $selectTab->save();
        return $this->response->created();
    }

    public function update($id, SelectTabRequest $request, SelectTab $selectTab)
    {
        $data = array_only($request->all(), ['name']);

        $where = ['id' => $id, 'parent_uid' => $this->user()->parent_uid];

        if ($selectTab->where($where)->update($data)) {
            return $this->response->noContent();
        }

        abort(403, '修改失败!');
    }

    public function destroy($id,SelectTab $selectTab)
    {
        if ($selectTab->where('id',$id)->where('parent_uid',$this->user()->parent_uid)->delete()) {
            return $this->response->noContent();
        }

        abort(403, '删除失败!');
    }
}
