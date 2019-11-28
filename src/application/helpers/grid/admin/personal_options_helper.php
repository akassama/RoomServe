<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

function personal_options_grid_columns()
{
    return [
        // options
        "options" => [
            "module_name"           => 'personal_options',
            "module_title"          => "Personal options",
            "quick_stats"           => true,
            "filter"                => false,
            "csv" => [
                "csv_export"        => false,
                "has_access"        => "",
            ],
            "order" => [
                "order_by"          => "created_at",
                "order_dir"         => "desc"
            ]
        ],

        // columns
        "columns" => [
            [
                "name"                  => "status",
                "title"                 => lang('table_status'),
                "field"                 => "pls_personal_options.status",
                "width"                 => "1",
                "type"                  => "label",
                "values" => [
                    "0" => [
                        "title"         => lang('table_inactive'),
                        "label_type"    => "grey"
                    ],
                    "1" => [
                        "title"         => lang('table_active'),
                        "label_type"    => "success"
                    ],
                ],
            ],
            [
                "name"                  => "name",
                "title"                 => lang('table_name'),
                "field"                 => "pls_personal_options.name",
                "width"                 => "25"
            ],
                      
            [
                "name"                  => "created_at",
                "title"                 => lang('table_created_at'),
                "field"                 => 'DATE_FORMAT(pls_personal_options.created_at, "{{date_format}}") as created_at',
                "width"                 => "5"
            ],
            [
                "name"                  => "personal_id",
                "class"                 => "actions",
                "title"                 => lang('table_actions'),
                "field"                 => "pls_personal_options.personal_id",
                "width"                 => "1",
                "type"                  => "actions",
                "orderable"             => false,
                "csv"                   => false,
                "has_access"            => ["update_categories", "delete_categories"],
            ]
        ],

        // actions
        "actions" => [
            [
                "title"                 => lang('table_btn_edit'),
                "link"                  => "/admin/settings/personal_options/update/{{personal_id}}",
                "class"                 => "ico-edit",
                "keys"                  => ['personal_id'],
                "has_access"            => "update_categories",
            ],
          

            [
                "title"                 => lang('table_btn_delete'),
                "link"                  => '/admin/settings/personal_options/delete/{{personal_id}}',
                "class"                 => "ico-delete dropdown-divider",
                "keys"                  => ['personal_id'],
                "attr" => [
                    "data-remove"       => '/admin/settings/personal_options/delete/{{personal_id}}',
                    "data-redirect"     => "false",
                    "data-type"         => "list"
                ],

                "has_access"            => "delete_categories",
            ],
        ],

        // filters
        "filters" => [
            "groups" => [
                [
                    "group_name"        => "basic_information",
                    "group_title"       => lang('table_basic_info'),
                ]
            ],
            "fields" => [
                [
                    "name"              => "name",
                    "title"             => lang('table_name'),
                    "dbfield"           => "pls_personal_options.name",
                    "field"             => "input",
                    "type"              => "text",
                    "operator"          => "like",
                    "group"             => "basic_information"
                ],
            ],
        ],

        // quick stat
        "quick_stats" => [
            [
                "name"                  => "total",
                "result"                => "0",
                "title"                 => lang('table_stats_total'),
                "color"                 => "info",
                "group_by"              => "pls_personal_options.personal_id",
                "preset"                => "all",
                "fields" => [
                ],
            ],
            [
                "name"                  => "active",
                "result"                => "0",
                "title"                 => lang('table_stats_active'),
                "color"                 => "success",
                "group_by"              => "pls_personal_options.personal_id",
                "preset"                => "active",
                "fields" => [
                    [
                        "dbfield"           => "pls_personal_options.status",
                        "operator"          => "=",
                        "value"             => STATUS_ACTIVE
                    ],
                ],
            ],
            [
                "name"                  => "inactive",
                "result"                => "0",
                "title"                 => lang('table_stats_inactive'),
                "color"                 => "grey",
                "group_by"              => "pls_personal_options.personal_id",
                "preset"                => "inactive",
                "fields" => [
                    [
                        "dbfield"           => "pls_personal_options.status",
                        "operator"          => "=",
                        "value"             => STATUS_INACTIVE
                    ],
                ],
            ],
        ]

    ];
}
