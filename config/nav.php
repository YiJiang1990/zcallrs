<?php

return [
    'admin' => [
        // 用户
        [
            'path' => '/users',
            'name' => 'users',
            'meta' => ['title' => '用户管理', 'icon' => 'peoples'],
            'permission_id' => [11,12,18],
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
            'permission_id' => [2,4,6,5],
            'meta' => ['title' => '企业管理', 'icon' => 'peoples'],
            'children' => [
                ['path' => 'index',
                    'name' => 'corporate-index',
                    'component' => 'corporate/index',
                    'meta' => ['title' => '企业用户', 'icon' => 'peoples'],
                    'permission_id' => [2]
                ],
                ['path' => 'add',
                    'name' => 'corporate-add',
                    'component' => 'corporate/add',
                    'meta' => ['title' => '新增企业', 'icon' => 'people'],
                    'permission_id' => [4]
                ],
                ['path' => 'edit/ =>userId',
                    'name' => 'corporate-edit',
                    'hidden' => true,
                    'component' => 'corporate/edit',
                    'meta' => ['title' => '编辑企业'],
                    'permission_id' => [6]
                ],
                ['path' => 'delete',
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
            'permission_id' => [21,28,24],
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
                    'path' => ' =>id(\\d+)/add_permission',
                    'name' => 'add_permission',
                    'component' => 'roles/permission_give_role',
                    'hidden' => true,
                    'meta' => ['title' => '权限管理', 'icon' => 'list'],
                    'permission_id' => [24]
                ]
            ]
        ]
    ]
];