<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

function groups_grid_columns()
{
    return [
        // options
        "options" => [
                "module_name"           => 'usergroups',
                "module_title"          => lang('module_user_groups'),
                "filter"                => false,
                "quick_stats"           => true,
                "csv" => [
                    "csv_export"        => false,
                    "has_access"        => "export_usergroups",
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
                "field"                 => "pls_users_groups.status",
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
                "field"                 => "pls_users_groups.name",
                "width"                 => "20"
            ],
            [
                "name"                  => "users",
                "title"                 => lang("table_users"),
                "field"                 => "COUNT(pls_users.user_id) as users",
                "width"                 => "1"
            ],
            [
                "name"                  => "created_at",
                "title"                 => lang('table_created_at'),
                "field"                 => 'DATE_FORMAT(pls_users_groups.created_at, "{{date_format}}") as created_at',
                "width"                 => "8"
            ],
            [
                "name"                  => "user_group_id",
                "class"                 => "actions",
                "title"                 => lang('table_actions'),
                "field"                 => "pls_users_groups.user_group_id",
                "width"                 => "1",
                "type"                  => "actions",
                "orderable"             => false,
                "csv"                   => false
            ]
        ],

        // actions
        "actions" => [
            [
                "title"                 => lang('table_btn_edit'),
                "link"                  => "/admin/settings/user_groups/update/{{user_group_id}}",
                "class"                 => "ico-edit",
                "keys"                  => ['user_group_id']
            ],
            [
                "title"                 => lang('table_btn_delete'),
                "link"                  => "/admin/settings/user_groups/delete/{{user_group_id}}",
                "class"                 => "ico-delete dropdown-divider",
                "attr" => [
                    "data-remove"       => "/admin/settings/user_groups/delete/{{user_group_id}}",
                    "data-redirect"     => "false",
                    "data-type"         => "list"
                ],
                "keys"                  => ['user_group_id']
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
                    "dbfield"           => "pls_users_groups.name",
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
                "group_by"              => "pls_users_groups.user_group_id",
                "preset"                => "all",
                "fields" => [
                ],
            ],
            [
                "name"                  => "active",
                "result"                => "0",
                "title"                 => lang('table_stats_active'),
                "color"                 => "success",
                "group_by"              => "pls_users_groups.user_group_id",
                "preset"                => "active",
                "fields" => [
                    [
                        "dbfield"           => "pls_users_groups.status",
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
                "group_by"              => "pls_users_groups.user_group_id",
                "preset"                => "inactive",
                "fields" => [
                    [
                        "dbfield"           => "pls_users_groups.status",
                        "operator"          => "=",
                        "value"             => STATUS_INACTIVE
                    ],
                ],
            ],
        ]

    ];
}
?>
