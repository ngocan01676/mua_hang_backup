<?php
return [
    "sidebars" => [
        "user"=>false,
        "log" => [
            "name" => z_language("Nhật ký", false),
            "pos" => 1,
            "url" => "backend:log:list",
            "icon" => "fa fa-file-text"
        ],
        "configuration" => [
            "name" => z_language('Cấu hình', false),
            "pos" => 2,
            "url" => "backend:configuration:list",

        ],
        "module:admin" => [
            "name" => z_language('Mở rộng'),
            "pos" => 2,
            "url" => "",
            "header" => true,
            "icon"=>"fa fa-newspaper-o",
            "items" => [
                "dashboard" =>false,
                'log'=>false,
                'media'=>false,
                'configuration'=>false,
            ]
         ],

        "dashboard" => [
            "name" => z_language("Thống kê", false),
            "pos" => 1,
            "url" => "backend:dashboard:list",
            "icon" => "fa fa-dashboard"
        ],
        "media" => [
            "name" => z_language('Tài nguyên', false),
            "pos" => 2,
            "url" => "backend:dashboard:media",
            "header" => true,
            "icon"=>"fa fa-server",
        ],
        "backend:announce:list" => [
            "name" => "QL ".z_language("Thông báo"),
            "url" => "backend:announce:list",
            "pos" => 2,
            "header" => true,
            "icon"=>"fa fa fa-envelope",
        ],
        "backend:shop_ja:product:list" => [
            "name" => "QL ".z_language("Sản Shẩm"),
            "url" => "backend:shop_ja:product:list",
            "pos" => 2,
            "header" => true,
            "icon"=>"fa fa fa-table",
        ],
        "backend:shop_ja:category:show" => [
            "name" => z_language("CT Chuyển Phát"),
            "url" => "backend:shop_ja:category:show",
            "pos" => 2,
            "header" => true,
            "icon"=>"fa fa-cab",
        ],
        "backend:shop_ja:japan:category:show" => [
            "name" => z_language("QL Tỉnh"),
            "url" => "backend:shop_ja:japan:category:show",
            "pos" => 2,
            "header" => true,
            "icon"=>"fa  fa-thumbs-up",
        ],
        "backend:shop_ja:ship:list" => [
            "name" => z_language("QL Ship"),
            "url" => "backend:shop_ja:ship:list",
            "pos" => 2,
            "header" => true,
            "icon"=>"fa fa-inbox",
        ],
        "backend:shop_ja:japan:category:ship:show" => [
            "name" => z_language("QL COU"),
            "url" => "backend:shop_ja:japan:category:ship:show",
            "pos" => 2,
            "header" => true,
            "icon"=>"fa fa-newspaper-o",
        ],
        "backend:shop_ja:order:excel:list" => [
            "name" => "QL ".z_language("Hóa Đơn"),
            "url" => "backend:shop_ja:order:excel:list",
            "pos" => 2,
            "header" => true,
            "icon"=>"fa fa-cart-plus",
        ],
        "backend:shop_ja:order:search" => [
            "name" => "QL ".z_language("Tìm kiếm hóa đơn"),
            "url" => "backend:shop_ja:order:search:search",
            "pos" => 2,
            "header" => true,
            "icon"=>"fa fa-search",
        ],
        "module:shop-ja:excel:imports" => [
            "name" => "QL ".z_language("Nhập Checking"),
            "url" => "backend:shop_ja:order:action:imports",
            "pos" => 2,
            "header" => true,
            "icon"=>"fa fa-check-square-o",
        ],
        "module:shop-ja::excel:show" => [
            "name" => "QL ".z_language("Xuất Excel"),
            "url" => "backend:shop_ja:order:action:show",
            "pos" => 2,
            "header" => true,
            "icon"=>"fa fa-upload",
        ],
        "module:shop-ja:sim" => [
            "name" => z_language('Sim'),
            "pos" => 2,
            "url" => "backend:shop_ja:sim:list",
            "header" => true,
            "icon"=>"fa fa-sticky-note-o",
            "items" => [
                [
                    "name" => "QL ".z_language("Danh sách Sim"),
                    "url" => "backend:shop_ja:sim:list",
                ],
                [
                    "name" => "QL ".z_language("Xuất Sim hết hạn"),
                    "url" => "backend:shop_ja:sim:export",
                ],
            ]
        ],
        "shop-ja:user" => [
            "name" => z_language('Tài khoản'),
            "pos" => 2,
            "url" => "",
            "header" => true,
            "icon" => "fa fa-users",
            "order"=>1,
            "items" => [
                "1"=>[
                    "name" => z_language("Tài khoản", false),
                    "url" => "backend:shop_ja:user:list",
                ],
                "2"=>[
                    "name" => z_language("Tài khoản CTV", false),
                    "url" => "backend:shop_ja:user_cvt:ctv",
                ],
                "3"=>[
                    "name" => z_language("Quyền", false),
                    "url" => "backend:user:role:list",
                ]
            ]
        ]
    ]
];
