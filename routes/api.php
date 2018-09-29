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
    $api->post('authorizations/corporate', 'AuthorizationController@corporateLogin')
        ->name('api.authorizations.corporate');
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
         $api->group(['middleware' => ['permission:用户管理-添加用户_admin']],function ($api){
            $api->post('user/register', 'UserController@create')->name('user.register');
         });

        // 管理用户列表
       // $api->group(['middleware' => ['permission:用户管理-用户列表_admin']],function ($api){
            $api->get('users', 'UserController@index')->name('api.users.index');
       // });
        // 查看禁用管理用户列表
        $api->group(['middleware' => ['permission:用户管理-删除列表_admin']],function ($api){
            $api->get('users/deleteUser', 'UserController@delUser');
        });
        // 查看平台管理信息
            $api->get('users/{id}', 'UserController@show')->name('api.users.show');
        // 禁用平台管理用户
        $api->group(['middleware' => ['permission:用户管理-用户列表-删除_admin']],function ($api){
            $api->get('users/{id}/disabled', 'UserController@disabled')->name('api.users.disabled');
        });
        // 修改管理用户密码
        $api->group(['middleware' => ['permission:用户管理-用户列表-修改密码_admin']],function ($api){
            $api->put('users/{id}', 'UserController@updatePassword');
        });
        // 修改管理用户信息
        $api->group(['middleware' => ['permission:用户管理-用户列表-编辑_admin']],function ($api){
            $api->patch('users/{id}', 'UserController@update');
        });

        // 删除管理用户
        $api->group(['middleware' => ['permission:用户管理-删除列表-删除_admin']],function ($api){
            $api->delete('user/{id}', 'UserController@destroy');
        });

        // 恢复管理用户
        $api->group(['middleware' => ['permission:用户管理-删除列表-恢复_admin']],function ($api){
            $api->post('user/{id}', 'UserController@restore');
        });
        // 获取用户授权
        $api->group(['middleware' => ['permission:用户管理-用户列表-查看授权功能_admin']],function ($api){
            $api->get('user/{id}/permission','PermissionController@userPermissions');
        });



        // 企业
        // 获取企业用户列表
        $api->group(['middleware' => ['permission:企业管理-企业用户列表_admin']],function ($api){
            $api->get('corporate', 'CorporateController@index')->name('corporate.list');
        });

        // 获取删除企业列表
        $api->group(['middleware' => ['permission:企业管理-删除企业_admin']],function ($api){
            $api->get('corporate/deleteUser', 'CorporateController@delUser')->name('corporate.delete.list');
        });

        $api->group(['middleware' => ['permission:企业管理-编辑企业_admin']],function ($api){
            // 获取企业用户信息
            $api->get('corporate/{id}/edit', 'CorporateController@edit')->name('corporate.edit');
            // 修改企业用户信息
            $api->patch('corporate/{id}', 'CorporateController@update')->name('corporate.update');
        });

        $api->group(['middleware' => ['permission:企业管理-修改密码_admin']],function ($api){
            // 修改企业密码
            $api->put('corporate/{id}', 'CorporateController@updatePassword')->name('corporate.update.password');
        });

        $api->group(['middleware' => ['permission:企业管理-修改密码_admin']],function ($api){
            // 修改企业密码
            $api->put('corporate/{id}', 'CorporateController@updatePassword')->name('corporate.update.password');
        });

        $api->group(['middleware' => ['permission:企业管理-新增企业_admin']],function ($api){
            // 创建账号企业用户
            $api->post('corporate/register', 'CorporateController@create')->name('register.corporate.user');
        });

        $api->group(['middleware' => ['permission:企业管理-删除企业_admin']],function ($api){
            // 禁用企业用户
            $api->get('corporate/{id}', 'CorporateController@updateDeletedTime')->name('user.uodate.deleted');
        });

        $api->group(['middleware' => ['permission:企业管理-删除列表-删除_admin']],function ($api){
            // 删除企业用户
            $api->delete('corporate/{id}', 'CorporateController@destroy')->name('user.delete');
        });

        $api->group(['middleware' => ['permission:企业管理-删除列表-恢复_admin']],function ($api){
            // 恢复企业用户
            $api->get('corporate/{id}/restore', 'CorporateController@restore')->name('user.restore');
        });

        // 角色管理
        $api->group(['middleware' => ['permission:企业管理-删除列表-恢复_admin']],function ($api){
            // 列表
            $api->get('role', 'RolesController@index');
        });

        $api->group(['middleware' => ['permission:用户管理-用户列表-角色管理_admin']],function ($api){
            // 获取全部
            $api->get('role/all', 'RolesController@roleAll');
            //  查看用户角色
            $api->get('user/{id}/role', 'RolesController@userRole');
            // 赋予用户角色
            $api->patch('role/{id}/user', 'RolesController@addRoleToUser');
        });

        $api->group(['middleware' => ['permission:角色管理-角色列表-添加_admin']],function ($api){
            // 新增
            $api->post('role', 'RolesController@create');
        });

        $api->group(['middleware' => ['permission:角色管理-角色列表-编辑_admin']],function ($api){
            // 编辑
            $api->put('role/{id}', 'RolesController@update');
            // 获取角色的权限
            $api->get('role/{id}/permissions','RolesController@show');
            // 赋予角色权限
            $api->patch('permission/{id}','RolesController@addPermissionToRole');
            // 获取全部
            $api->get('permission/all', 'PermissionController@permissionAll');
        });

        $api->group(['middleware' => ['permission:角色管理-角色列表-删除_admin']],function ($api){
            // 删除
            $api->delete('role/{id}', 'RolesController@destroy');
        });

        // 功能管理
        $api->group(['middleware' => ['permission:角色管理-功能管理_admin']],function ($api){
            // 列表
            $api->get('permission', 'PermissionController@index');
        });

        $api->group(['middleware' => ['permission:角色管理-功能管理-添加_admin']],function ($api){
            // 新增
            $api->post('permission', 'PermissionController@create');
        });

        $api->group(['middleware' => ['permission:角色管理-功能管理-编辑_admin']],function ($api){
            // 编辑
            $api->put('permission/{id}', 'PermissionController@update');
        });

        $api->group(['middleware' => ['permission:角色管理-功能管理-删除_admin']],function ($api){
            // 删除
            $api->delete('permission/{id}', 'PermissionController@destroy');
        });

        /***************************************************平台分割线*************************************************/

        // B端
        // 用户列表
        $api->get('corporate_user', 'Corporate\UserController@index');
        // 删除用户列表
        $api->get('corporate_user/deleteUser', 'Corporate\UserController@delUser');
        // 创建用户
        $api->post('corporate_user/register', 'Corporate\UserController@create');
        // 修改密码
        $api->put('corporate_user/{id}', 'Corporate\UserController@updatePassword');
        // 获取用户信息
        $api->get('corporate_user/{id}/edit', 'Corporate\UserController@edit');
        // 修改用户信息
        $api->patch('corporate_user/{id}', 'Corporate\UserController@update');
        // 禁用企业用户
        $api->get('corporate_user/{id}', 'Corporate\UserController@updateDeletedTime');
        // 编辑
        $api->put('permission/{id}', 'PermissionController@update');
        // 删除用户
        $api->delete('corporate_user/{id}', 'CorporateController@destroy');
        // 恢复用户
        $api->get('corporate_user/{id}/restore', 'CorporateController@restore');

        // 客户or公海列表
        $api->get('clients', 'Clients\UserController@index');
        // 创建客户or公海
        $api->post('clients', 'Clients\UserController@create');
        // 逻辑删除客户or公海
        $api->get('clients/{id}','Clients\UserController@updateStatus');
        // 编辑客户or公海
        $api->put('clients/{id}','Clients\UserController@update');
        // 编辑客户or公海
        $api->patch('clients/{id}','Clients\UserController@updateType');
        // 导出客户or公海
        $api->post('clients/download','Clients\UserController@exportLog');
        //联系人列表
        $api->get('address_book', 'Clients\AddressBookController@index');
        // 创建联系人
        $api->post('address_book', 'Clients\AddressBookController@create');
        // 编辑联系人
        $api->put('address_book/{id}','Clients\AddressBookController@update');
        // 逻辑联系人
        $api->get('address_book/{id}','Clients\AddressBookController@updateStatus');

        // 获取自定义样式
        $api->get('config', 'Config\InputController@index');

        // 获取自定义字段列表
        $api->get('field','DiyFieldController@index');

        // 添加自定义字段
        $api->post('config/add_diy_field','DiyFieldController@create');
        // 修改自定义状态
        $api->put('config/update_field_status','DiyFieldController@updateStatus');

        // 上传图片
        $api->post('images','ImagesController@store');

        // 上传文件
        $api->post('files','FilesController@store');

        // 获取选择列表
        $api->get('options','SelectTabController@index');
        // 获取全部选项
        $api->get('options/all','SelectTabController@userStoreAll');

        // 添加选项
        $api->post('options','SelectTabController@create');
        // 编辑选项
        $api->put('options/{id}', 'SelectTabController@update');
        // 删除选项
        $api->delete('options/{id}','SelectTabController@destroy');
        // 获取选择值列表
        $api->get('options_value','OptionsController@index');
        // 添加选项值
        $api->post('options_value','OptionsController@create');
        // 编辑选项值
        $api->put('options_value/{id}', 'OptionsController@update');
        // 删除选项值
        $api->delete('options_value/{id}','OptionsController@destroy');

        // 选项树管理
        $api->get('tree','Tree\TabController@index');
        $api->post('tree','Tree\TabController@create');
        $api->put('tree/{id}', 'Tree\TabController@update');
        $api->delete('tree/{id}','Tree\TabController@destroy');
        $api->get('tree_value','Tree\ValueController@index');
        $api->post('tree_value','Tree\ValueController@create');
        $api->put('tree_value/{id}', 'Tree\ValueController@update');
        $api->delete('tree_value','Tree\ValueController@destroy');

        // 组管理
        $api->get('group','Permission\GroupController@index');
        $api->post('group','Permission\GroupController@create');
        $api->put('group','Permission\GroupController@update');
        $api->delete('group','Permission\GroupController@delete');
        $api->patch('group/action','Permission\GroupController@action');
        $api->patch('group/user','Permission\GroupController@editRole');

        // 产品
        $api->get('product','Clients\ProductController@index');
        $api->post('product','Clients\ProductController@create');
        $api->put('product','Clients\ProductController@update');
        $api->delete('product','Clients\ProductController@delete');

        // 商机
        $api->get('chance','Clients\ChanceController@index');
        $api->post('chance','Clients\ChanceController@create');
        $api->put('chance','Clients\ChanceController@update');
        $api->delete('chance','Clients\ChanceController@delete');

        // 提醒
        $api->get('record','Clients\RecordController@index');
        $api->post('record','Clients\RecordController@create');
        $api->put('record','Clients\RecordController@update');
        $api->delete('record','Clients\RecordController@delete');

        // 跟进
        $api->get('follow','Clients\FollowController@index');
        $api->post('follow','Clients\FollowController@create');
        $api->put('follow','Clients\FollowController@update');
        $api->delete('follow','Clients\FollowController@delete');

        // 导出
        $api->get('export','ExportLogController@index');
        $api->post('export/download','ExportLogController@download');
        $api->get('export/downloadLog','ExportUserLogController@index');

        //导入
        $api->get('import','ImportController@index');
        $api->post('import/field','ImportController@field');
        $api->post('import/upload','ImportController@create');
    });
});
