<?php

use Illuminate\Database\Seeder;
use App\Models\Permission\Actions;


class ActionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $date = date('Y-m-d H:i:s');
        $add = [
            ['group' => '公海管理','group_name' => 'temporary', 'name' => '查看', 'action_name' => 'select', 'created_at' => $date, 'updated_at' => $date],
            ['group' => '公海管理','group_name' => 'temporary', 'name' => '搜索', 'action_name' => 'search', 'created_at' => $date, 'updated_at' => $date],
            ['group' => '公海管理', 'group_name' => 'temporary','name' => '新增', 'action_name' => 'add', 'created_at' => $date, 'updated_at' => $date],
            ['group' => '公海管理', 'group_name' => 'temporary','name' => '编辑', 'action_name' => 'edit', 'created_at' => $date, 'updated_at' => $date],
            ['group' => '公海管理', 'group_name' => 'temporary','name' => '删除', 'action_name' => 'delete', 'created_at' => $date, 'updated_at' => $date],
            ['group' => '公海管理', 'group_name' => 'temporary','name' => '转入客户', 'action_name' => 'return', 'created_at' => $date, 'updated_at' => $date],
            ['group' => '公海管理', 'group_name' => 'temporary','name' => '导入', 'action_name' => 'import', 'created_at' => $date, 'updated_at' => $date],
            ['group' => '公海管理', 'group_name' => 'temporary','name' => '导出', 'action_name' => 'export', 'created_at' => $date, 'updated_at' => $date],
            ['group' => '公海管理', 'group_name' => 'temporary','name' => '添加自定义字段', 'action_name' => 'add_field', 'created_at' => $date, 'updated_at' => $date],
            ['group' => '公海管理', 'group_name' => 'temporary','name' => '编辑自定义字段', 'action_name' => 'edit_field', 'created_at' => $date, 'updated_at' => $date],

            ['group' => '客户管理','group_name' => 'clients', 'name' => '查看', 'action_name' => 'select', 'created_at' => $date, 'updated_at' => $date],
            ['group' => '客户管理','group_name' => 'clients', 'name' => '搜索', 'action_name' => 'search', 'created_at' => $date, 'updated_at' => $date],
            ['group' => '客户管理', 'group_name' => 'clients','name' => '新增', 'action_name' => 'add', 'created_at' => $date, 'updated_at' => $date],
            ['group' => '客户管理', 'group_name' => 'clients','name' => '编辑', 'action_name' => 'edit', 'created_at' => $date, 'updated_at' => $date],
            ['group' => '客户管理', 'group_name' => 'clients','name' => '删除', 'action_name' => 'delete', 'created_at' => $date, 'updated_at' => $date],
            ['group' => '客户管理', 'group_name' => 'clients','name' => '导入', 'action_name' => 'import', 'created_at' => $date, 'updated_at' => $date],
            ['group' => '客户管理', 'group_name' => 'clients','name' => '导出', 'action_name' => 'export', 'created_at' => $date, 'updated_at' => $date],
            ['group' => '客户管理', 'group_name' => 'clients','name' => '添加自定义字段', 'action_name' => 'add_field', 'created_at' => $date, 'updated_at' => $date],
            ['group' => '客户管理', 'group_name' => 'clients','name' => '编辑自定义字段', 'action_name' => 'edit_field', 'created_at' => $date, 'updated_at' => $date],

            ['group' => '联系人','group_name' => 'address_book', 'name' => '查看', 'action_name' => 'select', 'created_at' => $date, 'updated_at' => $date],
            ['group' => '联系人','group_name' => 'address_book', 'name' => '搜索', 'action_name' => 'search', 'created_at' => $date, 'updated_at' => $date],
            ['group' => '联系人', 'group_name' => 'address_book','name' => '新增', 'action_name' => 'add', 'created_at' => $date, 'updated_at' => $date],
            ['group' => '联系人', 'group_name' => 'address_book','name' => '编辑', 'action_name' => 'edit', 'created_at' => $date, 'updated_at' => $date],
            ['group' => '联系人', 'group_name' => 'address_book','name' => '删除', 'action_name' => 'delete', 'created_at' => $date, 'updated_at' => $date],
            ['group' => '联系人', 'group_name' => 'address_book','name' => '导入', 'action_name' => 'import', 'created_at' => $date, 'updated_at' => $date],
            ['group' => '联系人', 'group_name' => 'address_book','name' => '导出', 'action_name' => 'export', 'created_at' => $date, 'updated_at' => $date],
            ['group' => '联系人', 'group_name' => 'address_book','name' => '添加自定义字段', 'action_name' => 'add_field', 'created_at' => $date, 'updated_at' => $date],
            ['group' => '联系人', 'group_name' => 'address_book','name' => '编辑自定义字段', 'action_name' => 'edit_field', 'created_at' => $date, 'updated_at' => $date],

            ['group' => '用户管理','group_name' => 'user', 'name' => '查看', 'action_name' => 'select', 'created_at' => $date, 'updated_at' => $date],
            ['group' => '用户管理','group_name' => 'user', 'name' => '搜索', 'action_name' => 'search', 'created_at' => $date, 'updated_at' => $date],
            ['group' => '用户管理', 'group_name' => 'user','name' => '新增', 'action_name' => 'add', 'created_at' => $date, 'updated_at' => $date],
            ['group' => '用户管理', 'group_name' => 'user','name' => '编辑', 'action_name' => 'edit', 'created_at' => $date, 'updated_at' => $date],
            ['group' => '用户管理', 'group_name' => 'user','name' => '删除', 'action_name' => 'delete', 'created_at' => $date, 'updated_at' => $date],
            ['group' => '用户管理', 'group_name' => 'user','name' => '角色管理', 'action_name' => 'role', 'created_at' => $date, 'updated_at' => $date],
            ['group' => '用户管理', 'group_name' => 'user','name' => '修改密码', 'action_name' => 'password', 'created_at' => $date, 'updated_at' => $date],
            ['group' => '用户管理', 'group_name' => 'user','name' => '删除列表', 'action_name' => 'delete_list', 'created_at' => $date, 'updated_at' => $date],
            ['group' => '用户管理', 'group_name' => 'user','name' => '恢复', 'action_name' => 'restore', 'created_at' => $date, 'updated_at' => $date],
            ['group' => '用户管理', 'group_name' => 'user','name' => '彻底删除', 'action_name' => 'destroy', 'created_at' => $date, 'updated_at' => $date],

            ['group' => '自定义字段管理', 'group_name' => 'DIY','name' => '查看', 'action_name' => 'select', 'created_at' => $date, 'updated_at' => $date],

            ['group' => '选项管理', 'group_name' => 'option','name' => '查看', 'action_name' => 'select', 'created_at' => $date, 'updated_at' => $date],
            ['group' => '选项管理', 'group_name' => 'option','name' => '新增', 'action_name' => 'add', 'created_at' => $date, 'updated_at' => $date],
            ['group' => '选项管理', 'group_name' => 'option','name' => '编辑', 'action_name' => 'edit', 'created_at' => $date, 'updated_at' => $date],
            ['group' => '选项管理', 'group_name' => 'option','name' => '删除', 'action_name' => 'delete', 'created_at' => $date, 'updated_at' => $date],

            ['group' => '选项值管理', 'group_name' => 'option_value','name' => '查看', 'action_name' => 'select', 'created_at' => $date, 'updated_at' => $date],
            ['group' => '选项值管理', 'group_name' => 'option_value','name' => '新增', 'action_name' => 'add', 'created_at' => $date, 'updated_at' => $date],
            ['group' => '选项值管理', 'group_name' => 'option_value','name' => '编辑', 'action_name' => 'edit', 'created_at' => $date, 'updated_at' => $date],
            ['group' => '选项值管理', 'group_name' => 'option_value','name' => '删除', 'action_name' => 'delete', 'created_at' => $date, 'updated_at' => $date],

            ['group' => '角色管理', 'group_name' => 'group','name' => '查看', 'action_name' => 'select', 'created_at' => $date, 'updated_at' => $date],
            ['group' => '角色管理', 'group_name' => 'group','name' => '新增', 'action_name' => 'add', 'created_at' => $date, 'updated_at' => $date],
            ['group' => '角色管理', 'group_name' => 'group','name' => '编辑', 'action_name' => 'edit', 'created_at' => $date, 'updated_at' => $date],
            ['group' => '角色管理', 'group_name' => 'group','name' => '删除', 'action_name' => 'delete', 'created_at' => $date, 'updated_at' => $date],
            ['group' => '角色管理', 'group_name' => 'group','name' => '权限管理', 'action_name' => 'permission', 'created_at' => $date, 'updated_at' => $date],

            ['group' => '商机','group_name' => 'chance', 'name' => '查看', 'action_name' => 'select', 'created_at' => $date, 'updated_at' => $date],
            ['group' => '商机','group_name' => 'chance', 'name' => '搜索', 'action_name' => 'search', 'created_at' => $date, 'updated_at' => $date],
            ['group' => '商机', 'group_name' => 'chance','name' => '新增', 'action_name' => 'add', 'created_at' => $date, 'updated_at' => $date],
            ['group' => '商机', 'group_name' => 'chance','name' => '编辑', 'action_name' => 'edit', 'created_at' => $date, 'updated_at' => $date],
            ['group' => '商机', 'group_name' => 'chance','name' => '删除', 'action_name' => 'delete', 'created_at' => $date, 'updated_at' => $date],
            ['group' => '商机', 'group_name' => 'chance','name' => '导入', 'action_name' => 'import', 'created_at' => $date, 'updated_at' => $date],
            ['group' => '商机', 'group_name' => 'chance','name' => '导出', 'action_name' => 'export', 'created_at' => $date, 'updated_at' => $date],
            ['group' => '商机', 'group_name' => 'chance','name' => '添加自定义字段', 'action_name' => 'add_field', 'created_at' => $date, 'updated_at' => $date],
            ['group' => '商机', 'group_name' => 'chance','name' => '编辑自定义字段', 'action_name' => 'edit_field', 'created_at' => $date, 'updated_at' => $date],

            ['group' => '跟进','group_name' => 'follow', 'name' => '查看', 'action_name' => 'select', 'created_at' => $date, 'updated_at' => $date],
            ['group' => '跟进','group_name' => 'follow', 'name' => '搜索', 'action_name' => 'search', 'created_at' => $date, 'updated_at' => $date],
            ['group' => '跟进', 'group_name' => 'follow','name' => '新增', 'action_name' => 'add', 'created_at' => $date, 'updated_at' => $date],
            ['group' => '跟进', 'group_name' => 'follow','name' => '编辑', 'action_name' => 'edit', 'created_at' => $date, 'updated_at' => $date],
            ['group' => '跟进', 'group_name' => 'follow','name' => '删除', 'action_name' => 'delete', 'created_at' => $date, 'updated_at' => $date],
            ['group' => '跟进', 'group_name' => 'follow','name' => '导入', 'action_name' => 'import', 'created_at' => $date, 'updated_at' => $date],
            ['group' => '跟进', 'group_name' => 'follow','name' => '导出', 'action_name' => 'export', 'created_at' => $date, 'updated_at' => $date],
            ['group' => '跟进', 'group_name' => 'follow','name' => '添加自定义字段', 'action_name' => 'add_field', 'created_at' => $date, 'updated_at' => $date],
            ['group' => '跟进', 'group_name' => 'follow','name' => '编辑自定义字段', 'action_name' => 'edit_field', 'created_at' => $date, 'updated_at' => $date],

            ['group' => '提醒','group_name' => 'record', 'name' => '查看', 'action_name' => 'select', 'created_at' => $date, 'updated_at' => $date],
            ['group' => '提醒','group_name' => 'record', 'name' => '搜索', 'action_name' => 'search', 'created_at' => $date, 'updated_at' => $date],
            ['group' => '提醒', 'group_name' => 'record','name' => '新增', 'action_name' => 'add', 'created_at' => $date, 'updated_at' => $date],
            ['group' => '提醒', 'group_name' => 'record','name' => '编辑', 'action_name' => 'edit', 'created_at' => $date, 'updated_at' => $date],
            ['group' => '提醒', 'group_name' => 'record','name' => '删除', 'action_name' => 'delete', 'created_at' => $date, 'updated_at' => $date],
            ['group' => '提醒', 'group_name' => 'record','name' => '导入', 'action_name' => 'import', 'created_at' => $date, 'updated_at' => $date],
            ['group' => '提醒', 'group_name' => 'record','name' => '导出', 'action_name' => 'export', 'created_at' => $date, 'updated_at' => $date],
            ['group' => '提醒', 'group_name' => 'record','name' => '添加自定义字段', 'action_name' => 'add_field', 'created_at' => $date, 'updated_at' => $date],
            ['group' => '提醒', 'group_name' => 'record','name' => '编辑自定义字段', 'action_name' => 'edit_field', 'created_at' => $date, 'updated_at' => $date],

            ['group' => '产品','group_name' => 'product', 'name' => '查看', 'action_name' => 'select', 'created_at' => $date, 'updated_at' => $date],
            ['group' => '产品','group_name' => 'product', 'name' => '搜索', 'action_name' => 'search', 'created_at' => $date, 'updated_at' => $date],
            ['group' => '产品', 'group_name' => 'product','name' => '新增', 'action_name' => 'add', 'created_at' => $date, 'updated_at' => $date],
            ['group' => '产品', 'group_name' => 'product','name' => '编辑', 'action_name' => 'edit', 'created_at' => $date, 'updated_at' => $date],
            ['group' => '产品', 'group_name' => 'product','name' => '删除', 'action_name' => 'delete', 'created_at' => $date, 'updated_at' => $date],
            ['group' => '产品', 'group_name' => 'product','name' => '导入', 'action_name' => 'import', 'created_at' => $date, 'updated_at' => $date],
            ['group' => '产品', 'group_name' => 'product','name' => '导出', 'action_name' => 'export', 'created_at' => $date, 'updated_at' => $date],
            ['group' => '产品', 'group_name' => 'product','name' => '添加自定义字段', 'action_name' => 'add_field', 'created_at' => $date, 'updated_at' => $date],
            ['group' => '产品', 'group_name' => 'product','name' => '编辑自定义字段', 'action_name' => 'edit_field', 'created_at' => $date, 'updated_at' => $date],
        ];
        Actions::insert($add);
    }
}
