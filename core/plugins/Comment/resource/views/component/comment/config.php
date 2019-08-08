<?php
return component_config($_opt_,
    component_config_data(
        [
            "arr"=>[
                ["image"=>"image","title"=>"title","link"=>"link"]
            ]
        ]
    ),
    component_config_configs(
        [
            "template"=>["template" => "template", "data" => ["count" => 3]],
            "data"=>["view" => "data", "label" => "Data", "data" => ['count' => 4, 'key' => "lists"]],
        ]
    ),
    component_config_views([
        'view' => ["label" => "View", "view" => "view"]
    ]),
    ["name" => "Thumbnail Image","view"=>"view"]
);