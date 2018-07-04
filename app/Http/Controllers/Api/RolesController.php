<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\RolesRequest;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Auth;
use App\Models\User;
use App\Models\Roles;
use App\Http\Transformers\RoleTransformer;

class RolesController extends Controller
{
    public function index(RolesRequest $request)
    {
        $role = Role::orderBy('id', 'desc')->paginate($request->get('limit'));
        return $this->response->paginator($role, new RoleTransformer());
    }

    public function roleAll( )
    {
        $role = Role::orderBy('id', 'desc')->get();
        return $this->response->collection($role, new RoleTransformer());
    }
    public function create(RolesRequest $request)
    {
        if (Role::create(['name' => $request->get('name')])) {
            return $this->response->noContent();
        }
        abort(403, '新增失败');
    }

    public function update(RolesRequest $request)
    {
        $role = Role::findById($request->get('id'));
        if ($role->update(['name' => $request->get('name')])) {
            return $this->response->noContent();
        }
        abort(403, '编辑失败');
    }

    public function destroy($id)
    {
        if (Role::findById($id)->delete()) {
            return $this->response->noContent();
        }
        abort(403, '删除失败');
    }

    public function addPermissionToRole($id,RolesRequest $request)
    {
        if (Role::findById($id)->syncPermissions($request->get('role'))){
            return $this->response->noContent();
        }
        abort(403, '授权失败');
    }
    public function userRole($id){
          $user = User::findorfail($id);
          $role = $user->getRoleNames();
          $user->role = $role;
          return $this->response->array($role);
    }

    public function addRoleToUser($id,RolesRequest $request)
    {
        $roles = $request->get('role');
        $role =  Role::whereIn('name',$roles)->get();
        if (User::findorfail($id)->syncRoles($role)) {
            return $this->response->noContent();
        }
        abort(403, '授权失败');
    }
    
    public function show($id)
    {
        $permissions = Roles::find($id)->getAllPermissionsWith;
        $role = Role::findById($id);
        $role->permission = $permissions;
        return $this->response->item($role,new RoleTransformer());
    }
}
