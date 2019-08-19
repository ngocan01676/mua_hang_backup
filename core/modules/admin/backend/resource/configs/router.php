<?php
return [
    'routers' => [
        'backend' => [
            'dashboard' => [
                "namespace" => "Admin\Http\Controllers",
                "controller" => "DashboardController",
                "prefix" => "admin",
                "guard" => "backend",// pải login
                "router" => [
                    "list" => [
                        "url" => "/",
                    ],
                    "option" => [
                        "url" => "/option",
                        "method" => ['post'],
                    ]
                ]
            ],
            'elfinder' => [
                "namespace" => "Admin\Http\Controllers",
                "controller" => "ElfinderController",
                "prefix" => "admin/elfinder",
                "guard" => "backend",// pải login
                "router" => [
                    "list" => [
                        "url" => "/",
                    ],
                    "showConnector" => [
                        "url" => '/show-connector',
                        "method" => ['get', 'post'],
                    ],
                    "tinymce4" => [
                        "url" => '/show-tinymce4',
                        "method" => ['get', 'post'],
                    ]
                ]
            ],
            'page' => [
                "namespace" => "Admin\Http\Controllers",
                "controller" => "PageController",
                "prefix" => "admin/page",
                "guard" => "backend",// pải login
                "router" => [
                    "list" => [
                        "url" => "/",
                    ],
                    "create" => [
                        "url" => "/create",
                    ],
                    "edit" => [
                        "url" => "/edit/{id}",
                    ],
                    "delete" => [
                        "url" => "/delete/{id}",
                        "method" => ['post'],
                    ],
                    "store" => [
                        "url" => "/store",
                        "method" => ['post'],
                    ]
                ]
            ],
            'language' => [
                "namespace" => "Admin\Http\Controllers",
                "controller" => "LanguageController",
                "prefix" => "admin/language",
                "guard" => "backend",// pải login
                "router" => [
                    "list" => [
                        "url" => "/",
                    ],
                    "ajax:save" => [
                        "url" => "/save",
                        "method" => ['post'],
                        "action" => "ajaxFormSave"
                    ],
                ]
            ],
            'layout' => [
                "namespace" => "Admin\Http\Controllers",
                "controller" => "LayoutController",
                "prefix" => "admin/layout",
                "guard" => "backend",// pải login
                "router" => [
                    "list" => [
                        "url" => "/",
                    ],
                    "create" => [
                        "url" => "/create",
                    ],
                    "edit" => [
                        "url" => "/edit/{id}",
                    ],
                    "delete" => [
                        "url" => "/delete/{id}",
                        "method" => ['post'],
                    ],
                    "ajax" => [
                        "url" => "/ajax",
                        "method" => ['post'],
                        "action" => "ajaxPost"
                    ],
                    "ajax:form_config" => [
                        "url" => "/ajax-form-config",
                        "method" => ['post'],
                        "action" => "ajaxFormConfig"
                    ],
                    "ajax:review_blade" => [
                        "url" => "/ajax-review-blade",
                        "method" => ['post'],
                        "action" => "ajaxReviewBlade"
                    ],
                    "ajax:get_lang" => [
                        "url" => "/ajax-get-lang",
                        "method" => ['post'],
                        "action" => "ajaxGetLang"
                    ],
                    "ajax:get_com" => [
                        "url" => "/ajax-post-com",
                        "method" => ['post'],
                        "action" => "ajaxPostCom"
                    ],
                ]
            ]
        ]
    ]
];