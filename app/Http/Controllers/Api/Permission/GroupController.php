<?php

namespace App\Http\Controllers\Api\Permission;

use App\Http\Controllers\Api\Controller;
use App\Http\Requests\Api\Permission\GroupRequest;
use App\Models\Permission\Group;
use App\Models\Permission\Actions;
use App\Models\Permission\GroupHasAction;
use App\Models\Permission\GroupHasUser;
use Auth;
use Illuminate\Support\Facades\DB;

class GroupController extends Controller
{
    private $_action = [
        'index' => ['group_name' => 'group', 'action_name' => 'select'],
        'create' => ['group_name' => 'group', 'action_name' => 'add'],
        'update' => ['group_name' => 'group', 'action_name' => 'edit'],
        'delete' => ['group_name' => 'group', 'action_name' => 'delete'],
        'action' => ['group_name' => 'group', 'action_name' => 'permission'],
        'editRole' => ['group_name' => 'user', 'action_name' => 'role'],

    ];

    private $not_permission_action_name = [];
    public function __construct(Actions $actions)
    {
        if (!in_array(request()->route()->getActionMethod(),$this->not_permission_action_name)) {
            if ($actions->permission($this->_action[request()->route()->getActionMethod()]) == false) {
                abort(403, '权限不足!');
            };
        }
    }

    public function index(Group $group, Actions $actions)
    {
        $data = $group->getGroup();
        $response['data']['list'] = $data['attr'];
        $response['data']['option'] = $data['tree'];
        $response['data']['actions'] = $actions->getAll();

        return $this->response->array($response);
    }

    public function create(GroupRequest $request, Group $group)
    {

        $group->fill($request->all());
        $group->parent_uid = Auth::user()->parent_uid;
        $group->save();
        return $this->response->created();
    }

    public function update(GroupRequest $request, Group $group)
    {
        $update = array_column($request->all(), ['name', 'pid']);
        $group->where('id', $request->get('id'))->update($update);
    }

    public function delete(GroupRequest $request, Group $group)
    {
        $id = $request->get('id');

        if ($group->where('pid', $id)->count()) {
            abort(403,'请先删除子级');
        }
        if ($group->where('id', $id)->delete()) {
            return $this->response->noContent();
        }
        abort(403,'删除失败');
    }

    public function action(GroupRequest $request, GroupHasAction $hasAction)
    {
        $permission = $request->get('permission');
        $id = $request->get('id');
        $insert = [];

        if ($permission) {
            foreach ($permission as $val) {
                $insert[] = ['group_id' => $id, 'action_id' => $val];
            }
        }

        DB::beginTransaction();

        try{
            $hasAction->where('group_id',$id)->delete();
            if ($insert) {
                $hasAction->insert($insert);
            }

            DB::commit();
            return $this->response->noContent();
        }catch (\Exception $exception) {

            DB::rollback();
            abort(403, $exception);
        }
    }

    public function editRole(GroupRequest $request, GroupHasUser $hasUser)
    {
        $group = $request->get('group');
        $id = $request->get('id');
        $insert = [];
        if ($group) {
            foreach ($group as $val) {
                $insert[] = ['group_id' => $val, 'user_id' => $id];
            }
        }

        DB::beginTransaction();

        try{

            $hasUser->where('user_id',$id)->delete();
            if ($insert) {
                $hasUser->insert($insert);
            }

            DB::commit();

            return $this->response->noContent();
        }catch (\Exception $exception) {

            DB::rollback();
            abort(403, $exception);
        }
    }

}
