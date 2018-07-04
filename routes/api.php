<?php

use Illuminate\Http\Request;

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', [
    'namespace' => 'App\Http\Controllers\Api',
    'middleware' => 'serializer:array',
], function ($api) {
    // 获取 token
    $api->post('authorizations', 'AuthorizationController@store')
        ->name('api.authorizations.store');
    // 刷新 token
    $api->put('authorizations/current', 'AuthorizationController@update')
        ->name('api.authorizations.update');
    // 注销token
    $api->delete('authorizations/current', 'AuthorizationController@destroy')
        ->name('api.authorizations.destroy');

    $api->group(['middleware' => 'api.auth'], function ($api) {
        // 管理用户

        //  当前用户信息
        $api->get('user', 'UserController@userShow')->name('api.user.show');
        // 创建账号管理用户
        $api->post('user/register', 'UserController@create')->name('user.register');
        // 管理用户列表
        $api->get('users', 'UserController@index')->name('api.users.index');
        // 查看禁用管理用户列表
        $api->get('users/deleteUser', 'UserController@delUser');
        // 查看平台管理信息
        $api->get('users/{id}', 'UserController@show')->name('api.users.show');
        // 禁用平台管理用户
        $api->get('users/{id}/disabled', 'UserController@disabled')->name('api.users.disabled');
        // 修改管理用户密码
        $api->put('users/{id}', 'UserController@updatePassword');
        // 修改管理用户信息
        $api->patch('users/{id}', 'UserController@update');
        // 删除管理用户
        $api->delete('user/{id}', 'UserController@destroy');
        // 恢复管理用户
        $api->post('user/{id}', 'UserController@restore');
        // 获取用户授权
        $api->get('user/{id}/permission','PermissionController@userPermissions');


        // 企业
        // 获取企业用户列表
        $api->get('corporate', 'CorporateController@index')->name('corporate.list');
        // 获取删除企业列表
        $api->get('corporate/deleteUser', 'CorporateController@delUser')->name('corporate.delete.list');

        // 获取企业用户信息
        $api->get('corporate/{id}/edit', 'CorporateController@edit')->name('corporate.edit');
        // 修改企业用户信息
        $api->patch('corporate/{id}', 'CorporateController@update')->name('corporate.update');
        // 修改企业密码
        $api->put('corporate/{id}', 'CorporateController@updatePassword')->name('corporate.update.password');
        // 创建账号企业用户
        $api->post('corporate/register', 'CorporateController@create')->name('register.corporate.user');
        // 禁用企业用户
        $api->get('corporate/{id}', 'CorporateController@updateDeletedTime')->name('user.uodate.deleted');
        // 删除企业用户
        $api->delete('corporate/{id}', 'CorporateController@destroy')->name('user.delete');
        // 恢复企业用户
        $api->get('corporate/{id}/restore', 'CorporateController@restore')->name('user.restore');


        // 角色管理
        // 列表
        $api->get('role', 'RolesController@index');
        // 获取全部
        $api->get('role/all', 'RolesController@roleAll');
        //  查看用户角色
        $api->get('user/{id}/role', 'RolesController@userRole');
        // 赋予用户角色
        $api->patch('role/{id}/user', 'RolesController@addRoleToUser');
        // 新增
        $api->post('role', 'RolesController@create');
        // 编辑
        $api->put('role/{id}', 'RolesController@update');
        // 删除
        $api->delete('role/{id}', 'RolesController@destroy');
        // 获取角色的权限
        $api->get('role/{id}/permissions','RolesController@show');
        // 赋予角色权限
        $api->patch('permission/{id}','RolesController@addPermissionToRole');

        // 功能管理
        // 列表
        $api->get('permission', 'PermissionController@index');
        // 获取全部
        $api->get('permission/all', 'PermissionController@permissionAll');
        // 新增
        $api->post('permission', 'PermissionController@create');
        // 编辑
        $api->put('permission/{id}', 'PermissionController@update');
        // 删除
        $api->delete('permission/{id}', 'PermissionController@destroy');
    });
});
