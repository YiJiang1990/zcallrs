<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use App\Http\Transformers\CorporateTransformer;
use App\Http\Requests\Api\CorporateRequest;

/**
 * Class CorporateController
 * @package App\Http\Controllers\Api
 */
class CorporateController extends Controller
{
    /**
     * @var array
     */
    private $_where = [
        ['is_corporate', '=', 1]
    ];

    /**
     * @param Request $request
     * @param User $user
     * @return mixed
     */
    public function index(Request $request, User $user)
    {
        $data = $user->where('is_corporate', 1)->orderBy('id', 'desc')->paginate($request->get('limit'));

        return $this->response->paginator($data, new CorporateTransformer());
    }

    /**
     * @param CorporateRequest $request
     * @param User $user
     * @return mixed
     */
    public function create(CorporateRequest $request, User $user)
    {

        $user->fill($request->all());
        $user->password = bcrypt($user->password);
        $user->created_user_id = Auth::id();
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
        return $this->response->item($data, new CorporateTransformer());
    }

    /**
     * @param $id
     * @param CorporateRequest $request
     * @param User $user
     * @return mixed
     */
    public function updatePassword($id, CorporateRequest $request, User $user)
    {
        $this->_where[] = ['id', $id];
        if ($user->where($this->_where)->update(['password' => bcrypt($request->get('password'))])) {
            return $this->response->noContent();
        }
        abort(403, '修改失败!');
    }

    /**
     * @param $id
     * @param CorporateRequest $request
     * @param User $user
     * @return mixed
     */
    public function update($id, CorporateRequest $request, User $user)
    {
        $data = array_only($request->all(), ['name', 'is_sms', 'max_add_corporate_user_number', 'ended_at', 'started_at']);
        $this->_where[] = ['id', $id];

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
        if ($user->withTrashed()->where($this->_where)->forceDelete()) {
            return $this->response->noContent();
        };
        abort(403, '删除失败!');
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
        ];
        $data = $user->withTrashed()->where($where)->orderBy('deleted_at', 'desc')->paginate($request->get('limit'));
        return $this->response->paginator($data, new CorporateTransformer());
    }

    /**
     * @param $id
     * @param User $user
     * @return mixed
     */
    public function restore($id, User $user)
    {
        $this->_where[] = ['id', $id];
        if ($user->withTrashed()->where($this->_where)->restore()) {
            return $this->response->noContent();
        }
        abort(403, '恢复失败!');

    }

}
