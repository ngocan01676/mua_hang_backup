<?php
return component_config($_opt_,
    component_config_data(
        [

        ]
    ),
    component_config_configs(
        [
            "temp" => ["template" => "template", "data" => ["count" => 3]],
            "data" => ["view" => "data", "label" => "Data", "data" => ['count' => 4, 'key' => "lists"]],
        ]
    ),
    component_config_views([
        'view' => ["label" => "View", "view" => "list"]
    ]),
    ["name" => "PeopleTalkAboutUs", "view" => "view"]
);