<?php

namespace App\Http\Controllers\Api;


use Spatie\Permission\Models\Permission;
use Auth;
use App\Models\User;
use App\Http\Requests\Api\PermissionRequest;
use App\Http\Transformers\PermissionTransformer;

class PermissionController extends Controller
{
    public function index(PermissionRequest $request)
    {
        $permission = Permission::orderBy('id', 'desc')->paginate($request->get('limit'));
        return $this->response->paginator($permission, new PermissionTransformer());
    }

    public function userPermissions($id,PermissionRequest $request)
    {
        $user = User::findorfail($id);
        // 全部
        $permission['all'] = $user->getAllPermissions();
        if ($request->get('info')){
            // 直接权限
            $permission['direct'] = $user->getDirectPermissions(); // Or $user->permissions;
            // 从用户角色继承的权限
            $permission['via'] = $user->getPermissionsViaRoles();
        }
        return $this->response->array($permission);
    }

    public function permissionAll()
    {
        $permission = Permission::orderBy('id', 'desc')->get();
        return $this->response->collection ($permission, new PermissionTransformer());
    }
    public function create(PermissionRequest $request)
    {
        if (Permission::create(['name' => $request->get('name')])) {
            return $this->response->noContent();
        }
        abort(403, '新增失败');
    }

    public function update(PermissionRequest $request)
    {
        $permission = Permission::findById($request->get('id'),'admin');
        if ($permission->update(['name' => $request->get('name')])) {
            return $this->response->noContent();
        }
        abort(403, '编辑失败');
    }
    public function destroy($id)
    {
        if (Permission::findById($id,'admin')->delete()) {
            return $this->response->noContent();
        }
        abort(403, '删除失败');
    }
}
