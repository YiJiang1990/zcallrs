<?php

namespace App\Http\Controllers\Api;

Use App\Http\Requests\Api\UserRequest;
use App\Models\Permission\Actions;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use App\Http\Transformers\UserTransformer;
use Spatie\Permission\Models\Permission;

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
    public function userShow(User $user,Actions $actions)
    {
        $auth = $this->user();
        // 後台數據
        if ($auth->is_admin == 1) {
            $model = $user->findorfail($auth->id);
            $auth->permission = $model->getAllPermissions()->where('guard_name', 'admin')->pluck('id','id');
            $auth->nav = config('nav.admin');
            $auth->roles = $model->getRoleNames();
        }

        // B端
       if ($auth->is_corporate == 1) {
           $auth->nav = config('nav.api');
           $auth->permission = $actions->getUserAction();
       }
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
     * @param UserRequest $request
     * @param User $user
     * @return mixed
     */
    public function create(UserRequest $request , User $user)
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
     * @param UserRequest $request
     * @param User $user
     * @return mixed
     */
    public function updatePassword($id, UserRequest $request, User $user)
    {
        $this->_where[] = ['id', $id];
        if ($user->where($this->_where)->update(['password'=> bcrypt($request->get('password'))])){
            return $this->response->noContent();
        }
        abort(403, '修改失败!');
    }

    /**
     * @param $id
     * @param UserRequest $request
     * @return mixed
     */
    public function update($id, UserRequest $request)
    {
        $data = array_only($request->all(), ['name', 'email', 'phone']);
        $this->_where[] = ['id', $id];
        if ( User::where($this->_where)->update($data)) {
            return $this->response->noContent();
        }
        abort(403, '修改失败!');
    }

    /**
     * @param UserRequest $request
     * @return mixed
     */
    public function delUser(UserRequest $request){
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
