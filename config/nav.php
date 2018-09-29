<?php

return [
    'admin' => [
        // 用户
        [
            'path' => '/users',
            'name' => 'users',
            'meta' => ['title' => '用户管理', 'icon' => 'peoples'],
            'permission_id' => [11, 12, 18],
            'children' => [
                [
                    'path' => 'index',
                    'name' => 'users-index',
                    'component' => 'users/index',
                    'meta' => ['title' => '用户列表', 'icon' => 'peoples'],
                    'permission_id' => [11]
                ],
                [
                    'path' => 'add',
                    'name' => 'users-add',
                    'component' => 'users/add',
                    'meta' => ['title' => '新增用户', 'icon' => 'people'],
                    'permission_id' => [12]
                ],
                [
                    'path' => 'delete',
                    'name' => 'users-delete',
                    'component' => 'users/delete',
                    'meta' => ['title' => '删除用户', 'icon' => 'lock'],
                    'permission_id' => [18]
                ],
            ]
        ],
        // 企业用户
        [
            'path' => '/corporate',
            'name' => 'corporate',
            'permission_id' => [2, 4, 6, 5],
            'meta' => ['title' => '企业管理', 'icon' => 'peoples'],
            'children' => [
                [
                    'path' => 'index',
                    'name' => 'corporate-index',
                    'component' => 'corporate/index',
                    'meta' => ['title' => '企业用户', 'icon' => 'peoples'],
                    'permission_id' => [2]
                ],
                [
                    'path' => 'add',
                    'name' => 'corporate-add',
                    'component' => 'corporate/add',
                    'meta' => ['title' => '新增企业', 'icon' => 'people'],
                    'permission_id' => [4]
                ],
                [
                    'path' => 'edit/:userId',
                    'name' => 'corporate-edit',
                    'hidden' => true,
                    'component' => 'corporate/edit',
                    'meta' => ['title' => '编辑企业'],
                    'permission_id' => [6]
                ],
                [
                    'path' => 'delete',
                    'name' => 'corporate-delete',
                    'component' => 'corporate/delete',
                    'meta' => ['title' => '查看删除企业', 'icon' => 'lock'],
                    'permission_id' => [5]
                ]
            ]
        ],
        // 角色
        [
            'path' => '/roles',
            'name' => 'roles',
            'meta' => ['title' => '角色管理', 'icon' => 'theme'],
            'permission_id' => [21, 28, 24],
            'children' => [
                [
                    'path' => 'index',
                    'name' => 'roles-index',
                    'component' => 'roles/index',
                    'meta' => ['title' => '角色管理', 'icon' => 'theme'],
                    'permission_id' => [21]
                ],
                // [
                //     'path' => 'permission',
                //     'name' => 'permission-index',
                //     'component' => 'roles/permission',
                //     'meta' => ['title' => '功能管理', 'icon' => 'list'],
                //     'permission_id' => [28]
                // ],
                [
                    'path' => ':id(\\d+)/add_permission',
                    'name' => 'add_permission',
                    'component' => 'roles/permission_give_role',
                    'hidden' => true,
                    'meta' => ['title' => '权限管理', 'icon' => 'list'],
                    'permission_id' => [24]
                ]
            ]
        ]
    ],
    'api' => [
        // 客户管理
        [
            'path' => '/clients',
            'name' => 'clients',
            'meta' => ['title' => '客户管理', 'icon' => 'international'],
            'children' => [
                [
                    'path' => 'temporary',
                    'name' => 'temporary-clients-index',
                    'component' => 'clients/temporary',
                    'meta' => ['title' => '公海列表', 'icon' => 'internet'],
                    'permission' => ['name' => 'temporary', 'action' => 'select']
                ],
                [
                    'path' => 'index',
                    'name' => 'clients-index',
                    'component' => 'clients/index',
                    'meta' => ['title' => '客户列表', 'icon' => 'client'],
                    'permission' => ['name' => 'clients', 'action' => 'select']
                ],
                [
                    'path' => 'address',
                    'name' => 'address-index',
                    'component' => 'address/index',
                    'meta' => ['title' => '联系人', 'icon' => 'address-book'],
                    'permission' => ['name' => 'address_book', 'action' => 'select']
                ],
            ]
        ],
        // 商机管理
        [
            'path' => '/goods',
            'name' => 'goods',
            'meta' => ['title' => '商机管理', 'icon' => 'Store'],
            'children' => [
                [
                    'path' => 'chance',
                    'name' => 'chance',
                    'component' => 'chance/index',
                    'meta' => ['title' => '商机', 'icon' => 'chance'],
                ],
                [
                    'path' => 'follow',
                    'name' => 'follow',
                    'component' => 'follow/index',
                    'meta' => ['title' => '跟进', 'icon' => 'follow'],
                ],
                [
                    'path' => 'record',
                    'name' => 'record',
                    'component' => 'record/index',
                    'meta' => ['title' => '提醒', 'icon' => 'record'],
                ],
                [
                    'path' => 'product',
                    'name' => 'product',
                    'component' => 'product/index',
                    'meta' => ['title' => '产品', 'icon' => 'product'],
                ],
            ]
        ],
        // 企业用户
        [
            'path' => '/corporate',
            'name' => 'corporate',
            'meta' => ['title' => '用户管理', 'icon' => 'peoples'],
            'children' => [
                [
                    'path' => 'index',
                    'name' => 'corporate-index',
                    'component' => 'corporate/index',
                    'meta' => ['title' => '用户列表', 'icon' => 'peoples'],
                    'permission' => ['name' => 'user', 'action' => 'select']
                ],
                [
                    'path' => 'add',
                    'name' => 'corporate-add',
                    'component' => 'corporate/add',
                    'meta' => ['title' => '新增用户', 'icon' => 'people'],
                    'permission' => ['name' => 'user', 'action' => 'add']
                ],
                [
                    'path' => 'edit/:userId',
                    'name' => 'corporate-edit',
                    'hidden' => true,
                    'component' => 'corporate/edit',
                    'meta' => ['title' => '编辑用户'],
                ],
                [
                    'path' => 'delete',
                    'name' => 'corporate-delete',
                    'component' => 'corporate/delete',
                    'meta' => ['title' => '查看删除用户', 'icon' => 'lock'],
                    'permission' => ['name' => 'user', 'action' => 'delete_list']
                ]
            ]
        ],
        // 系统管理
        [
            'path' => '/setting',
            'name' => 'setting',
            'meta' => ['title' => '系统管理', 'icon' => 'setting'],
            'children' => [
                [
                    'path' => 'defined',
                    'name' => 'defined',
                    'component' => 'defined/index',
                    'meta' => ['title' => '自定义字段', 'icon' => 'DIY'],
                    'permission' => ['name' => 'DIY', 'action' => 'select']
                ],
                [
                    'path' => 'defined/:type/:name/add',
                    'name' => 'defined-add',
                    'hidden' => true,
                    'component' => 'defined/add',
                    'meta' => ['title' => '添加自定义字段', 'icon' => 'DIY'],
                ],
                [
                    'path' => 'option',
                    'name' => 'option',
                    'component' => 'option/index',
                    'meta' => ['title' => '选项管理', 'icon' => 'option'],
                    'permission' => ['name' => 'option', 'action' => 'select']
                ],
                [
                    'path' => 'tree-option',
                    'name' => 'tree-option',
                    'component' => 'option/tree',
                    'meta' => ['title' => '树选项管理', 'icon' => 'tree'],
                    'permission' => ['name' => 'option', 'action' => 'select']
                ],
                [
                    'hidden' => true,
                    'path' => 'tree-value/:id(\\d+)',
                    'name' => 'tree-value',
                    'component' => 'option/treeValue',
                    'meta' => ['title' => '选项树值管理', 'icon' => 'option'],
                ],
                [
                    'hidden' => true,
                    'path' => 'option/:id(\\d+)',
                    'name' => 'option-value',
                    'component' => 'option/value',
                    'meta' => ['title' => '选项值管理', 'icon' => 'option'],
                ],
                [
                    // 'hidden' => true,
                    'path' => 'group',
                    'name' => 'group',
                    'component' => 'group/index',
                    'meta' => ['title' => '角色管理', 'icon' => 'role'],
                    'permission' => ['name' => 'group', 'action' => 'select']
                ],
//                 ['path' => 'permission',
//                     'name' => 'permission',
//                     'component' => 'permission/index',
//                     'meta' => ['title' => '权限管理', 'icon' => 'permission'],
//                 ],
            ]
        ],
        // 数据管理
        [  'path' => '/data',
            'name' => 'data',
            'meta' => ['title' => '数据管理', 'icon' => 'data'],
            'children' => [
                [
                    'path' => 'export',
                    'name' => 'export',
                    'component' => 'export/index',
                    'meta' => ['title' => '导出记录', 'icon' => 'export-excel'],
                    //'permission' => ['name' => 'DIY', 'action' => 'select']
                ],
                [
                    'hidden' => true,
                    'path' => 'export/:id(\\d+)',
                    'name' => 'export-user',
                    'component' => 'export/user',
                    'meta' => ['title' => '导出人管理', 'icon' => 'export-excel'],
                ],
                [
                    'path' => 'import',
                    'name' => 'import',
                    'component' => 'import/index',
                    'meta' => ['title' => '导入记录', 'icon' => 'import'],
                    //'permission' => ['name' => 'DIY', 'action' => 'select']
                ],
                [
                    'hidden'=> true,
                    'path' => ':type/upload',
                    'name' => 'import-upload',
                    'component' => 'excel/uploadExcel',
                    'meta' => ['title' => '导入记录', 'icon' => 'import'],
                    //'permission' => ['name' => 'DIY', 'action' => 'select']
                ],
            ]
        ]
    ]
];