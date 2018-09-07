<?php

namespace App\Http\Controllers\Api\Corporate;

use App\Http\Requests\Api\UserRequest;
use App\Http\Transformers\UserTransformer;
use App\Models\Permission\Group;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\Controller;
use App\Models\Permission\Actions;

class UserController extends Controller
{
    /**
     * @var array
     */
    private $_where = [
        [ 'is_corporate' ,'=', 1]
    ];

    private $_action = [
      'index' => ['group_name' => 'user', 'action_name' => 'select'],
      'create' => ['group_name' => 'user', 'action_name' => 'add'],
      'update' => ['group_name' => 'user', 'action_name' => 'edit'],
      'edit' => ['group_name' => 'user', 'action_name' => 'edit'],
      'updatePassword' => ['group_name' => 'user', 'action_name' => 'password'],
      'updateDeletedTime' => ['group_name' => 'user', 'action_name' => 'delete'],

      'delUser' => ['group_name' => 'user', 'action_name' => 'delete_list'],
      'restore' => ['group_name' => 'user', 'action_name' => 'restore'],
      'destroy' => ['group_name' => 'user', 'action_name' => 'destroy'],
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
    public function index(Request $request, User $user,Group $group)
    {
        $this->_where[] = [ 'parent_uid' ,'=', $this->user()->parent_uid];
        $users = $user->where($this->_where)
            ->orderBy('id', 'desc')
            ->paginate($request->get('limit'));
        $tree = $group->getGroup(true,false,false);
        return $this->response->paginator($users, new UserTransformer())->addMeta('groupTree', $tree['tree']);
    }

    /**
     * @param UserRequest $request
     * @param User $user
     * @return mixed
     */

    public function create(UserRequest $request, User $user)
    {
        $me = Auth::user();
        $user->fill($request->all());
        $user->password = bcrypt($user->password);
        $user->created_user_id = Auth::id();
        $user->parent_uid =  $me->parent_uid;
        $user->is_corporate =  $me->is_corporate;
        $user->started_at = $me->started_at;
        $user->ended_at = $me->ended_at;
        $user->save();
        return $this->response->created();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function edit($id)
    {
        $data = User::findOrFail($id);
        return $this->response->item($data, new UserTransformer());
    }

    /**
     * @param $id
     * @param UserRequest $request
     * @param User $user
     * @return mixed
     */
    public function updatePassword($id, UserRequest $request, User $user)
    {
        $this->_where[] = ['id', $id];
        $this->_where[] = ['parent_uid', Auth::user()->parent_uid];
        if ($user->where($this->_where)->update(['password' => bcrypt($request->get('password'))])) {
            return $this->response->noContent();
        }
        abort(403, '修改失败!');
    }

    /**
     * @param User $user
     * @param Request $request
     * @return mixed
     */
    public function delUser(User $user, Request $request)
    {
        $where = [
            ['deleted_at', '<>', 'not null'],
            ['is_corporate', '=', 1],
            ['parent_uid', '=', $this->user()->parent_uid ]
        ];
        $data = $user->withTrashed()->where($where)->orderBy('deleted_at', 'desc')->paginate($request->get('limit'));
        return $this->response->paginator($data, new UserTransformer());
    }

    /**
     * @param $id
     * @param UserRequest $request
     * @param User $user
     * @return mixed
     */
    public function update($id, UserRequest $request, User $user)
    {
        $data = array_only($request->all(), ['name', 'phone', 'email']);
        $this->_where[] = ['id', $id];
        $this->_where[] = ['parent_uid', Auth::user()->parent_uid];
        if ($user->where($this->_where)->update($data)) {
            return $this->response->noContent();
        }
        abort(403, '修改失败!');
    }

    /**
     * @param $id
     * @param User $user
     * @return mixed
     */
    public function updateDeletedTime($id, User $user)
    {
        $this->_where[] = ['id', $id];
        $this->_where[] = ['parent_uid', Auth::user()->parent_uid];
        if ($user->where($this->_where)->delete()) {
            return $this->response->noContent();
        }
        abort(403, '删除失败!');

    }

    /**
     * @param $id
     * @param User $user
     * @return mixed
     */
    public function destroy($id, User $user)
    {
        $this->_where[] = ['id', '=', $id];
        $this->_where[] = ['parent_uid', Auth::user()->parent_uid];
        if ($user->withTrashed()->where($this->_where)->forceDelete()) {
            return $this->response->noContent();
        };
        abort(403, '删除失败!');
    }

    /**
     * @param $id
     * @param User $user
     * @return mixed
     */
    public function restore($id, User $user)
    {
        $this->_where[] = ['id', $id];
        $this->_where[] = ['parent_uid', Auth::user()->parent_uid];
        if ($user->withTrashed()->where($this->_where)->restore()) {
            return $this->response->noContent();
        }
        abort(403, '恢复失败!');

    }

}
