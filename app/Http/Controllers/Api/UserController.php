<?php

namespace App\Http\Controllers\Api;


use App\Http\Requests\Api\Authorization\StoreRequest;
use App\Http\Transformers\PermissionTransformer;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use App\Http\Transformers\UserTransformer;
use Spatie\Permission\Contracts\Permission;

/**
 * Class UserController
 * @package App\Http\Controllers\Api
 */
class UserController extends Controller
{
    /**
     * @var array
     */
    private $_where = [
        [ 'is_admin' ,'=', 1]
    ];

    /**
     * @return mixed
     */
    public function userShow(User $user)
    {
        $auth = $this->user();
        $model = $user->findorfail($auth->id);
        $auth->permission = $model->getAllPermissions()->where('guard_name', 'api')->pluck('id','id');
        $auth->nav = config('nav.admin');
        $auth->roles = $model->getRoleNames();
        return $this->response->item($auth, new UserTransformer());
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        $users = User::where('is_admin',1)->orderBy('id', 'desc')->paginate($request->get('limit'));

        return $this->response->paginator($users, new UserTransformer());
    }

    /**
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        $user = User::findOrFail($id);

        return $this->response->item($user, new UserTransformer());
    }

    /**
     * @param StoreRequest $request
     * @param User $user
     * @return mixed
     */
    public function create(StoreRequest $request , User $user)
    {
        $user->fill($request->all());
        $user->password = bcrypt($user->password);
        $user->is_admin = 1;
        $user->created_user_id = Auth::id();
        $user->save();
        return $this->response->created();
    }

    /**
     * @param $id
     * @param User $user
     * @return mixed
     */
    public function disabled($id, User $user)
    {
        $this->_where[] = ['id', $id];
        if ( $user->where($this->_where)->delete()) {
            return $this->response->noContent();
        }
        abort(403, '删除失败!');
    }

    /**
     * @param $id
     * @param StoreRequest $request
     * @param User $user
     * @return mixed
     */
    public function updatePassword($id, StoreRequest $request, User $user)
    {
        $this->_where[] = ['id', $id];
        if ($user->where($this->_where)->update(['password'=> bcrypt($request->get('password'))])){
            return $this->response->noContent();
        }
        abort(403, '修改失败!');
    }

    /**
     * @param $id
     * @param StoreRequest $request
     * @return mixed
     */
    public function update($id, StoreRequest $request)
    {
        $data = array_only($request->all(), ['name', 'email', 'phone']);
        $this->_where[] = ['id', $id];
        if ( User::where($this->_where)->update($data)) {
            return $this->response->noContent();
        }
        abort(403, '修改失败!');
    }

    /**
     * @param StoreRequest $request
     * @return mixed
     */
    public function delUser(StoreRequest $request){
        $this->_where[] =  [ 'deleted_at','<>','not null'];
        $data = User::withTrashed()->where($this->_where)->orderBy('deleted_at', 'desc')->paginate($request->get('limit'));
        return $this->response->paginator($data, new UserTransformer());
    }

    /**
     * @param $id
     * @param User $user
     * @return mixed
     */
    public function destroy($id, User $user)
    {
        $this->_where[] = ['id','=', $id];
        if ($user->withTrashed()->where($this->_where)->forceDelete()){
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
        if ($user->withTrashed()->where($this->_where)->restore()) {
            return $this->response->noContent();
        }
        abort(403, '恢复失败!');

    }


}
