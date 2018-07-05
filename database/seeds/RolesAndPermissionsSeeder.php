<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 重置角色和权限缓存
        app()['cache']->forget('spatie.permission.cache');
        // 创建权限
        Permission::create(['id' => '2','name' => '企业管理-企业用户列表','guard_name' => 'admin']);
        Permission::create(['id' => '4','name' => '企业管理-新增企业','guard_name' => 'admin']);
        Permission::create(['id' => '5','name' => '企业管理-查看删除企业','guard_name' => 'admin']);
        Permission::create(['id' => '6','name' => '企业管理-编辑企业','guard_name' => 'admin']);
        Permission::create(['id' => '7','name' => '企业管理-删除企业','guard_name' => 'admin']);
        Permission::create(['id' => '8','name' => '企业管理-删除列表-恢复','guard_name' => 'admin']);
        Permission::create(['id' => '9','name' => '企业管理-删除列表-删除','guard_name' => 'admin']);
        Permission::create(['id' => '10','name' => '企业管理-修改密码','guard_name' => 'admin']);
        Permission::create(['id' => '11','name' => '企业管理-用户列表','guard_name' => 'admin']);
        Permission::create(['id' => '12','name' => '企业管理-添加用户','guard_name' => 'admin']);
        Permission::create(['id' => '13','name' => '用户管理-用户列表-编辑','guard_name' => 'admin']);
        Permission::create(['id' => '14','name' => '用户管理-用户列表-角色管理','guard_name' => 'admin']);
        Permission::create(['id' => '15','name' => '用户管理-用户列表-查看授权功能','guard_name' => 'admin']);
        Permission::create(['id' => '16','name' => '用户管理-用户列表-修改密码','guard_name' => 'admin']);
        Permission::create(['id' => '17','name' => '用户管理-用户列表-删除','guard_name' => 'admin']);
        Permission::create(['id' => '18','name' => '用户管理-删除列表','guard_name' => 'admin']);
        Permission::create(['id' => '19','name' => '用户管理-删除列表-恢复','guard_name' => 'admin']);
        Permission::create(['id' => '20','name' => '用户管理-删除列表-删除','guard_name' => 'admin']);
        Permission::create(['id' => '21','name' => '角色管理-角色列表','guard_name' => 'admin']);
        Permission::create(['id' => '22','name' => '角色管理-角色列表-添加','guard_name' => 'admin']);
        Permission::create(['id' => '23','name' => '角色管理-角色列表-编辑','guard_name' => 'admin']);
        Permission::create(['id' => '24','name' => '角色管理-角色列表-权限管理','guard_name' => 'admin']);
        Permission::create(['id' => '25','name' => '角色管理-功能管理-添加','guard_name' => 'admin']);
        Permission::create(['id' => '26','name' => '角色管理-功能管理-编辑','guard_name' => 'admin']);
        Permission::create(['id' => '27','name' => '角色管理-功能管理-删除','guard_name' => 'admin']);
        Permission::create(['id' => '28','name' => '角色管理-功能管理','guard_name' => 'admin']);
        Permission::create(['id' => '29','name' => '角色管理-角色列表-删除','guard_name' => 'admin']);
        $role = Role::create(['name' => 'super-admin']);
        $role->givePermissionTo(Permission::all());
    }
}
