<?php

return [
    [
        'value' => 'input',
        'label' => '输入框',
        'children' => [
            [
                'value' => 'text',
                'label' => '输入框',
            ],
            [
                'value' => 'textarea',
                'label' => '文本框',
            ]
        ]
    ],
    [
        'value' => 'box',
        'label' => '选择框',
        'children' => [
            [
                'value' => 'radio',
                'label' => '单选框',
            ],
            [
                'value' => 'checkbox',
                'label' => '多选框',
            ]
        ],
    ],
    [
        'value' => 'select',
        'label' => '下拉框',
        'children' => [
            [
                'value' => 'select',
                'label' => '单选下拉',
            ],
            [
                'value' => 'multiple',
                'label' => '多选下拉',
            ]
        ],
    ],
    [
        'value' => 'picker',
        'label' => '时间日期选择器',
        'children' => [
            [
                'value' => 'datetime',
                'label' => '时间日期',
            ],
            [
                'value' => 'time',
                'label' => '当天时间',
            ],
            [
                'value' => 'date',
                'label' => '日期',
            ]
        ],
    ],
    [
        'value' => 'upload',
        'label' => '上传',
        'children' => [
            [
                'value' => 'image',
                'label' => '图片',
            ],
            [
                'value' => 'file',
                'label' => '文件',
            ]
        ]
    ],
    [
        'value' => 'editor',
        'label' => '富文本编辑器',
        'children' => [
            [
                'value' => 'tinymce',
                'label' => '编辑器',
            ],
            [
                'value' => 'markdown',
                'label' => 'Markdown',
            ]
        ]
    ]
];
