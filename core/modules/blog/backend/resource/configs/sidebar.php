<?php
return [
    "sidebars" => [
        "module:blog" => [
            "name" => z_language('Blog'),
            "pos" => 2,
            "url" => "",
            "header" => true,
            "items" => [
                [
                    "name" => z_language("Post"),
                    "url" => "backend:blog:post:list",
                ],
                [
                    "name" => z_language("Category"),
                    "url" => "backend:blog:category:show",
                ],
                [
                    "name" => z_language("Comment"),
                    "url" => "backend:blog:comment:list",
                ]
            ]
        ]
    ]
];