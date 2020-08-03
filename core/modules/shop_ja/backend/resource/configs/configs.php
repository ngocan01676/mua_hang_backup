<?php
    return [
        'views' => [
            'paths' => ['shop_ja' => 'backend'],
            'alias' => [
                'shop_ja.category.show' => 'shop_ja::controller.category.show',
            ],
        ],
        'packages' => [
            'namespaces' => [
                'ShopJa' => 'backend'
            ],
        ],
        'options'=>[
            'module:shop_ja:product' => [
                'config' => [
                    'columns' => [
                        'lists' => [
                            'id' => ['label' => z_language('Id', false), 'type' => 'id', 'primary' => true],
                            'code' => ['label' => z_language('Code', false), 'type' => 'id', 'primary' => true],
                            'title' => ['label' => z_language('Title', false), 'type' => 'title'],
                            'image' => ['label' => z_language('Image', false), 'type' => 'image'],
                            'status' => ['label' => z_language('Status', false), 'type' => 'status'],
                            'created_at' => ['label' => z_language('Create At', false), 'type' => 'date'],
                            'updated_at' => ['label' => z_language('Update At', false), 'type' => 'date']
                        ],
                    ],
                    'pagination' => [
                        'item' => 20,
                        'router' => [
                            'edit' => ['label' => z_language('Edit', false), 'name' => "backend:shop-ja:product:edit", 'par' => ['id' => 'id']],
                            'preview' => ['label' => z_language('Preview', false), 'name' => "backend:shop-ja:product:edit", 'par' => ['id' => 'id']],
                            'trash' => ['method' => 'post', 'label' => z_language('Trash', false), 'name' => "backend:shop-ja:product:delete", 'par' => ['id' => 'id']],
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
                            ],
                            'image'=>[
                                'width'  => '100px',
                                'height' => '100px',
                            ]
                        ],
                        "column"=>[
                            'image'=>[
                                'style'=>'width="100px";height="100px"'
                            ]
                        ]
                    ]
                ],
                'data' => [
                    'pagination' => ['item' => 20],
                    'columns' => ['id', 'title'],
                    'search' => ['title'],

                ],
                'views' => [
                    'configs.layout'
                ]
            ]
        ],
            'configs' => [
            'lists'=>[
                'shop_ja' => [
                        'view' => [
                                'post' => [
                                    'view' => 'blog::configs.post',
                                    'label' => z_language('Product'),
                                ],
                            ],
                            'label' => z_language("Shop", false),
                            'data' => [

                            ]
                        ]
            ]
        ],

    ];