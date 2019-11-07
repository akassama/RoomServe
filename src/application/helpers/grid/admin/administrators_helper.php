<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

function administrators_grid_columns()
{
    return [
        // options
        "options" => [
                "module_name"           => 'administrators',
                "module_title"          => lang('module_administrators'),
                "filter"                => false,
                "quick_stats"           => false,
                "csv" => [
                    "csv_export"        => false,
                    "has_access"        => "export_administrators",
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
                "field"                 => "pls_users.status",
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
                "name"                  => "full_name",
                "title"                 => lang('table_full_name'),
                "field"                 => 'CONCAT(pls_users.first_name," ", COALESCE(pls_users.last_name, "")) as full_name',
                "width"                 => "15"
            ],
            [
                "name"                  => "email",
                "title"                 => lang('table_email'),
                "field"                 => "pls_users.email",
                "width"                 => "8",
                "type"                  => "link",
                "link_type"             => "email"
            ],
            [
                "name"                  => "group_name",
                "title"                 => lang('table_group'),
                "field"                 => "pls_users_groups.name as group_name",
                "width"                 => "10"
            ],
            [
                "name"                  => "created_at",
                "title"                 => lang('table_created_at'),
                "field"                 => 'DATE_FORMAT(pls_users.created_at, "{{date_format}}") as created_at',
                "width"                 => "5"
            ],
            [
                "name"                  => "user_id",
                "class"                 => "actions",
                "title"                 => lang('table_actions'),
                "field"                 => "pls_users.user_id",
                "width"                 => "1",
                "type"                  => "actions",
                "orderable"             => false,
                "csv"                   => false,
                "has_access"            => ["update_administrators", "delete_administrators"],
            ]
        ],

        // actions
        "actions" => [
            [
                "title"                 => lang('table_btn_edit'),
                "link"                  => "/admin/users/update/{{user_id}}",
                "class"                 => "ico-edit",
                "keys"                  => ["user_id"],
                "js_query" => [
                    "row"               => "user_group_id",
                    "operator"          => "!=",
                    "value"             => [1],
                ],
                "has_access"            => "update_administrators",
            ],
            [
                "title"                 => lang('table_btn_delete'),
                "link"                  => "/admin/users/delete/{{user_id}}",
                "class"                 => "ico-delete dropdown-divider",
                "keys"                  => ["user_id"],
                "attr" => [
                    "data-remove"       => "/admin/users/delete/{{user_id}}",
                    "data-redirect"     => "false",
                    "data-type"         => "list"
                ],
                "js_query" => [
                    "row"               => "user_group_id",
                    "operator"          => "!=",
                    "value"             => [1],
                ],
                "has_access"            => "delete_administrators",
            ],
        ],

        // filters
        "filters" => [
            "groups" => [
                [
                    "group_name"        => "account",
                    "group_title"       => lang('table_account'),
                ],
                [
                    "group_name"        => "basic_information",
                    "group_title"       => lang('table_basic_info'),
                ]
            ],
            "fields" => [
                [
                    "name"              => "email",
                    "title"             => lang('table_email'),
                    "dbfield"           => "pls_users.email",
                    "field"             => "input",
                    "type"              => "email",
                    "operator"          => "like",
                    "group"             => "account"
                ],
                [
                    "name"              => "user_group_id",
                    "title"             => lang('table_group'),
                    "dbfield"           => "pls_users_groups_rel.user_group_id",
                    "field"             => "select",
                    "attr" => [
                        "data-empty"    => "true",
                        "data-search"   => "true"
                    ],
                    "operator"          => "=",
                    "url"               => "/admin/settings/user_groups/get_ajax_all_groups",
                    "group"             => "basic_information"
                ],
                [
                    "name"              => "first_name",
                    "title"             => lang('table_first_name'),
                    "dbfield"           => "pls_users.first_name",
                    "field"             => "input",
                    "type"              => "text",
                    "operator"          => "like",
                    "group"             => "basic_information"
                ],
                [
                    "name"              => "last_name",
                    "title"             => lang('table_last_name'),
                    "dbfield"           => "pls_users.last_name",
                    "field"             => "input",
                    "type"              => "text",
                    "operator"          => "like",
                    "group"             => "basic_information"
                ],
            ],
        ],
        //additonal columns for database query
        "additional_columns" => [
            [
                "field"                 => "pls_users_groups.user_group_id",
            ],
        ],

        // quick stat
        "quick_stats" => [
            [
                "name"                  => "total",
                "result"                => "0",
                "title"                 => lang('table_stats_total'),
                "color"                 => "info",
                "group_by"              => "pls_users.user_id",
                "preset"                => "all",
                "fields" => [
                ],
            ],
            [
                "name"                  => "active",
                "result"                => "0",
                "title"                 => lang('table_stats_active'),
                "color"                 => "success",
                "group_by"              => "pls_users.user_id",
                "preset"                => "active",
                "fields" => [
                    [
                        "dbfield"           => "pls_users.status",
                        "operator"          => "=",
                        "value"             => USER_STATUS_ACTIVE
                    ],
                ],
            ],
            [
                "name"                  => "inactive",
                "result"                => "0",
                "title"                 => lang('table_stats_inactive'),
                "color"                 => "grey",
                "group_by"              => "pls_users.user_id",
                "preset"                => "inactive",
                "fields" => [
                    [
                        "dbfield"           => "pls_users.status",
                        "operator"          => "=",
                        "value"             => USER_STATUS_INACTIVE
                    ],
                ],
            ],
        ]
    ];
}
