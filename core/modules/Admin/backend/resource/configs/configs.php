<?php
return [
    'views' => [
        'paths' => ['backend' => 'backend'],
        'alias' => [

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
                    'formats'=>[
                        "DATE"=>z_language('Date',false),
                        "TIME"=>z_language('Time',false),
                        "DATE_TIME"=>z_language('Date Time',false)
                    ],
                ],

            ]
        ]
    ],
    'options' => [

        'core:module:admin:email-template' => [
            'config' => [
                'columns' => [
                    'lists' => [
                        'id' => ['label' => z_language('Id', false), 'type' => 'id', 'primary' => true],
                        'subject' => ['label' => z_language('Subject', false), 'type' => 'title', 'primary' => true],
                        'name' => ['label' => z_language('Name', false), 'type' => 'text'],
                        'alias' => ['label' => z_language('Alias', false), 'type' => 'text'],
                        'view_language' => ['label' => z_language('Language', false), 'type' => 'text','callback' => "view_language"],
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
                        'router' => ['label' => z_language('Router', false), 'type' => 'text'],
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
                        'id' => ['label' => z_language('M??', false), 'type' => 'id', 'primary' => true],
                        'title' => ['label' => z_language('Ti??u ?????', false), 'type' => 'title', 'primary' => true],
                        'status' => ['label' => z_language('Tr???ng th??i', false), 'type' => 'status'],
                        'get_name' => ['label' => z_language('T??i kho???n', false), 'type' => 'text','callback' => "get_name"],
                        'message' => ['label' => z_language('N???i dung', false), 'type' => 'text'],
                        'date_start' => ['label' => z_language('Th???i gian b???t ?????u', false), 'type' => 'date'],
                        'date_end' => ['label' => z_language('Th???i gian k???t th??c', false), 'type' => 'date'],
                        'created_at' => ['label' => z_language('T???o l??c', false), 'type' => 'date'],
                        'updated_at' => ['label' => z_language('S???a l??c', false), 'type' => 'date']
                    ],
                ],
                'pagination' => [
                    'item' => 20,
                    'router' => [
                        'edit' => ['label' => z_language('S???a', false), 'name' => "backend:announce:edit", 'par' => ['id' => 'id']],
                        'trash' => ['method' => 'post', 'label' => z_language('X??a', false), 'name' => "backend:announce:delete", 'par' => ['id' => 'id']],
                    ]
                ],
                'config' => [
                    "type" => [
                        'status' => [
                            'label' => [
                                '1' => z_language('B???t', false),
                                '0' => z_language('T???t', false),
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
                        'name' => ['label' => z_language('T??n', false), 'type' => 'title', 'primary' => true],
                        'actions' => ['label' => z_language('H??nh ?????ng', false), 'type' => 'text',],
                        'datas' => ['label' => z_language('D??? li???u', false), 'type' => 'text', ],
                        'ips' => ['label' => z_language('Ip', false), 'type' => 'text', ],
                        'getAdmin' => ['label' => z_language('T??n Admin', false), 'type' => 'text','callback' => "getAdmin"],
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
                        'file_name' => ['label' => z_language('T??n File', false), 'type' => 'title', 'primary' => true],
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
        'core:sitemap' => [
            'data' => [],
            'options'=>[
                'backend::controller.sitemap.option'=>[
                    'limit'=>5000
                ]
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
    'composers'=>[


        BACKEND => [
            'PluginSeo\Views\MetaComposer'=>[
                "backend::form.page"=>[
                    [
                        'item'=>"page",
                        'lang'=>['config'=>"blog","key"=>'post'],
                        'router'=>'backend:page:store',
                        'data'=>[],
                        'variable'=>'Page_MetaComposer_Seo',
                        'config'=>[
                            'name'=>'meta',
                        ],

                    ]
                ]
            ]
        ],

    ]
];