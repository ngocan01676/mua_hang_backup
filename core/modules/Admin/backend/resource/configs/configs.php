<?php
return [
    'views' => [
        'paths' => ['backend' => 'backend'],
        'alias' => [
            'layout.create' => 'backend::controller.layout.create',
            'layout.edit' => 'backend::controller.layout.edit',
            'dashboard.router'=>'backend::controller.dashboard.router',
            'dashboard.media'=>'backend::controller.dashboard.media'
        ],
        'layouts'=>[
            'default' => 'backend::layout.layout',
        ],
        'default'=>'default'
    ],
    'packages' => [
        'namespaces' => [
            'Admin' => "backend"
        ],
        'providers' => [
            "Admin\Providers\AppServiceProvider" => "Admin\Providers\AppServiceProvider"
        ]
    ],
    'configs' => [
        'templates'=>[
            'category' => [
                'view' => 'backend::configs.category',
                'label' => z_language("Category", false),
                'data' => [

                ]
            ]
        ],
        'lists'=>[
            'system' => [
                'view' => 'backend::configs.config',
                'label' => z_language("System", false),
                'key'=>'core',
                'acl'=>acl_alias("SB:configuration:system"),
                'data' => [

                ]
            ],
            'category'=>[
                'template'=>'category',
                'name'=>false
            ],
            'media' => [
                'view' => [
                    'acl' => [
                        'view' => 'backend::configs.media.premission',
                        'label' => z_language('Permission'),
                        'save'=>0,
                        'acl'=>acl_alias("SB:configuration:media:premission"),
                    ],
                ],
                'label' => z_language("Media", false),
                'data' => [

                ],
            ]
        ],
        'controllers'=>[
            'Admin\Http\Controllers\EmailTemplateController'=>[
                'default'=>[
                    [
                        "DATE"=>z_language('Date',false),
                        "TIME"=>z_language('Time',false),
                        "DATE_TIME"=>z_language('Date Time',false)
                    ],
                    [
                        "FULL_NAME"=>z_language('Fullname',false),
                        "PHONE"=>z_language('Phone',false),
                        "ADDRESS"=>z_language('Address',false)
                    ],
                ],
                "Plugin:Contact:Email"=>[
                    [
                        "DATE"=>z_language('Date',false),
                        "TIME"=>z_language('Time',false),
                        "DATE_TIME"=>z_language('Date Time',false)
                    ],
                    [
                        "FULL_NAME"=>z_language('Fullname',false),
                        "PHONE"=>z_language('Phone',false),
                        "ADDRESS"=>z_language('Address',false)
                    ],
                    [
                        "PRICE"=>z_language('Price',false),
                        "ORDER_ID"=>z_language('Order Id',false),
                        "EMAIL"=>z_language('Email',false)
                    ]
                ]
            ]
        ]
    ],
    'options' => [
        'core:layout' => [
            'config' => [
                'columns' => [
                    'lists' => [
                        'id' => ['label' => z_language('Id', false), 'type' => 'id', 'primary' => true, 'order_by' => "numeric"],
                        'name' => ['label' => z_language('Name', false), 'type' => 'title', 'primary' => true, 'order_by' => 'alpha'],
                        'type' => ['label' => z_language('Type', false), 'type' => 'type', 'order_by' => 'amount'],
                        'status' => ['label' => z_language('Status', false), 'type' => 'status', 'order_by' => 'amount'],
                        'created_at' => ['label' => z_language('Create At', false), 'type' => 'date'],
                        'updated_at' => ['label' => z_language('Update At', false), 'type' => 'date']
                    ],
                ],
                'pagination' => [
                    'item' => 20,
                    'router' => [
                        'edit' => ['label' => z_language('Edit', false), 'name' => "backend:layout:edit", 'par' => ['id' => 'id']],
                        'trash' => ['method' => 'post', 'label' => z_language('Trash', false), 'name' => "backend:layout:delete", 'par' => ['id' => 'id']],
                    ]
                ],
                'config' => [
                    "type" => [
                        'status' => [
                            'label' => [
                                '1' => z_language('Public', false),
                                '0' => z_language('UnPublic', false),
                            ],
                            'type' => [
                                'name' => 'label',
                                'color' => [
                                    '1' => 'primary',
                                    '0' => 'danger'
                                ]
                            ]
                        ]
                    ]
                ]
            ],
            'data' => [
                'pagination' => ['item' => 20],
                'columns' => ['id', 'name'],
                'search' => ['name']
            ],
            'views' => [
                'configs.layout'
            ]
        ],
        'core:module:admin:email-template' => [
            'config' => [
                'columns' => [
                    'lists' => [
                        'id' => ['label' => z_language('Id', false), 'type' => 'id', 'primary' => true],
                        'name' => ['label' => z_language('Name', false), 'type' => 'title', 'primary' => true],
                        'parameters' => ['label' => z_language('Parameters', false), 'type' => 'text'],
                        'status' => ['label' => z_language('Status', false), 'type' => 'status'],
                        'id_key' => ['label' => z_language('Group', false), 'type' => 'text'],
                        'created_at' => ['label' => z_language('Create At', false), 'type' => 'date'],
                        'updated_at' => ['label' => z_language('Update At', false), 'type' => 'date']
                    ],
                    'config'=>[

                    ]
                ],
                'pagination' => [
                    'item' => 20,
                    'router' => [
                        'edit' => ['label' => z_language('Edit', false), 'name' => "backend:email_template:edit", 'par' => ['id' => 'id']],
                        'trash' => ['method' => 'post', 'label' => z_language('Trash', false), 'name' => "backend:email_template:delete", 'par' => ['id' => 'id']],
                    ]
                ],
                'config' => [
                    "type" => [
                        'status' => [
                            'label' => [
                                '1' => z_language('Public', false),
                                '0' => z_language('UnPublic', false),
                            ],
                            'type' => [
                                'name' => 'label',
                                'color' => [
                                    '1' => 'primary',
                                    '0' => 'danger'
                                ]
                            ]
                        ]
                    ]
                ]
            ],
            'data' => [
                'pagination' => ['item' => 20],
                'columns' => ['id', 'title'],
                'search' => ['title']
            ],
            'views' => [
                'configs.layout'
            ]
        ],
        'core:page' => [
            'config' => [
                'columns' => [
                    'lists' => [
                        'id' => ['label' => z_language('Id', false), 'type' => 'id', 'primary' => true],
                        'title' => ['label' => z_language('Title', false), 'type' => 'title', 'primary' => true],
                        'func_slug' => ['label' => z_language('Url', false), 'type' => 'text','callback' => "func_slug"],
                        'status' => ['label' => z_language('Status', false), 'type' => 'status'],
                        'created_at' => ['label' => z_language('Create At', false), 'type' => 'date'],
                        'updated_at' => ['label' => z_language('Update At', false), 'type' => 'date']
                    ],
                ],
                'pagination' => [
                    'item' => 20,
                    'router' => [
                        'edit' => ['label' => z_language('Edit', false), 'name' => "backend:page:edit", 'par' => ['id' => 'id']],
                        'trash' => ['method' => 'post', 'label' => z_language('Trash', false), 'name' => "backend:page:delete", 'par' => ['id' => 'id']],
                    ]
                ],
                'config' => [
                    "type" => [
                        'status' => [
                            'label' => [
                                '1' => z_language('Public', false),
                                '0' => z_language('UnPublic', false),
                            ],
                            'type' => [
                                'name' => 'label',
                                'color' => [
                                    '1' => 'primary',
                                    '0' => 'danger'
                                ]
                            ]
                        ]
                    ]
                ]
            ],
            'data' => [
                'pagination' => ['item' => 20],
                'columns' => ['id', 'title'],
                'search' => ['title']
            ],
            'views' => [
                'configs.layout'
            ]
        ],
        'core:announce' => [
            'config' => [
                'columns' => [
                    'lists' => [
                        'id' => ['label' => z_language('Mã', false), 'type' => 'id', 'primary' => true],
                        'title' => ['label' => z_language('Tiêu đề', false), 'type' => 'title', 'primary' => true],
                        'status' => ['label' => z_language('Trạng thái', false), 'type' => 'status'],
                        'get_name' => ['label' => z_language('Tài khoản', false), 'type' => 'text','callback' => "get_name"],
                        'message' => ['label' => z_language('Nội dung', false), 'type' => 'text'],
                        'date_start' => ['label' => z_language('Thời gian bắt đầu', false), 'type' => 'date'],
                        'date_end' => ['label' => z_language('Thời gian kết thúc', false), 'type' => 'date'],
                        'created_at' => ['label' => z_language('Tạo lúc', false), 'type' => 'date'],
                        'updated_at' => ['label' => z_language('Sửa lúc', false), 'type' => 'date']
                    ],
                ],
                'pagination' => [
                    'item' => 20,
                    'router' => [
                        'edit' => ['label' => z_language('Sửa', false), 'name' => "backend:announce:edit", 'par' => ['id' => 'id']],
                        'trash' => ['method' => 'post', 'label' => z_language('Xóa', false), 'name' => "backend:announce:delete", 'par' => ['id' => 'id']],
                    ]
                ],
                'config' => [
                    "type" => [
                        'status' => [
                            'label' => [
                                '1' => z_language('Bật', false),
                                '0' => z_language('Tắt', false),
                            ],
                            'type' => [
                                'name' => 'label',
                                'color' => [
                                    '1' => 'primary',
                                    '0' => 'danger'
                                ]
                            ]
                        ]
                    ]
                ]
            ],
            'data' => [
                'pagination' => ['item' => 20],
                'columns' => ['id', 'title'],
                'search' => ['title']
            ],
            'views' => [
                'configs.layout'
            ]
        ],
        'core:log' => [
            'config' => [
                'columns' => [
                    'lists' => [
                        'id' => ['label' => z_language('Id', false), 'type' => 'id', 'primary' => true],
                        'name' => ['label' => z_language('Tên', false), 'type' => 'title', 'primary' => true],
                        'actions' => ['label' => z_language('Hành Động', false), 'type' => 'text',],
                        'datas' => ['label' => z_language('Dữ liệu', false), 'type' => 'text', ],
                        'ips' => ['label' => z_language('Ip', false), 'type' => 'text', ],
                        'getAdmin' => ['label' => z_language('Tên Admin', false), 'type' => 'text','callback' => "getAdmin"],
                        'created_at' => ['label' => z_language('Create At', false), 'type' => 'date'],
                        'updated_at' => ['label' => z_language('Update At', false), 'type' => 'date']
                    ],
                ],
                'pagination' => [
                    'item' => 20,
                    'router' => [

                    ]
                ],
                'config' => [
                    "type" => [
                        'status' => [
                            'label' => [
                                '1' => z_language('Public', false),
                                '0' => z_language('UnPublic', false),
                            ],
                            'type' => [
                                'name' => 'label',
                                'color' => [
                                    '1' => 'primary',
                                    '0' => 'danger'
                                ]
                            ]
                        ]
                    ]
                ]
            ],
            'data' => [
                'pagination' => ['item' => 20],
                'columns' => ['id', 'title'],
                'search' => ['title']
            ],
            'views' => [
                'configs.layout'
            ]
        ],
        'core:backup' => [
            'config' => [
                'columns' => [
                    'lists' => [
                        'id' => ['label' => z_language('Id', false), 'type' => 'id', 'primary' => true],
                        'file_name' => ['label' => z_language('Tên File', false), 'type' => 'title', 'primary' => true],
                        'created_at' => ['label' => z_language('Create At', false), 'type' => 'date'],
                        'updated_at' => ['label' => z_language('Update At', false), 'type' => 'date']
                    ],
                ],
                'pagination' => [
                    'item' => 20,
                    'router' => [

                    ]
                ],
                'config' => [
                    "type" => [
                        'status' => [
                            'label' => [
                                '1' => z_language('Public', false),
                                '0' => z_language('UnPublic', false),
                            ],
                            'type' => [
                                'name' => 'label',
                                'color' => [
                                    '1' => 'primary',
                                    '0' => 'danger'
                                ]
                            ]
                        ]
                    ]
                ]
            ],
            'data' => [
                'pagination' => ['item' => 20],
                'columns' => ['id', 'title'],
                'search' => ['title']
            ],
            'views' => [
                'configs.layout'
            ]
        ]
    ],
    'registers'=>[
        'Admin\Http\Controllers\EmailTemplateController'=>[
            'Plugin:Contact:Email'=>[
                'composer'=>[],
                'key'=>'Contact:Email'
            ]
        ]
    ],

];