<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

function order_student_grid_columns()
{
    return [
        // options
        "options" => [
            "module_name"           => 'order_student',
            "module_title"          => lang('module_orders'),
            "filter"                => false,
            "quick_stats"           => false,
            "csv"                   => [
                "csv_export"        => false,
                "has_access"        => "export_order_student",
            ],
            "order"                 => [
                "order_by"          => "created_at",
                "order_dir"         => "desc"
            ]
        ],

        // columns
        "columns" => [
            [
                "name"                  => "status",
                "title"                 => lang("table_status"),
                "field"                 => "pls_orders.status",
                "width"                 => "1",
                "type"                  => "label",
                "values"                => [
                   
                    ORDER_STATUS_APPROVED   => [
                        "title"         => lang('table_approved'),
                        "label_type"    => "success"
                    ],
                    ORDER_STATUS_PENDING => [
                        "title"         => lang('table_pending'),
                        "label_type"    => "warning"
                    ],
                   
                    ORDER_STATUS_DECLINED => [
                        "title"         => lang('table_declined'),
                        "label_type"    => "purple"
                    ],
                    ORDER_STATUS_CANCELLED => [
                        "title"         => lang('table_cancelled'),
                        "label_type"    => "black"
                    ],
                ],
            ],
           
            [
                "name"                  => "name",
                "title"                 => lang("table_name"),
                "field"                 => "pls_orders_translations.name",
                "width"                 => "15"
            ],
            [
                "name"                  => "category",
                "title"                 => "Cleaning option",
                "field"                 => "pls_cleaning_options.name as category",
                "width"                 => "15",
            ],
            [
                "name"                  => "created_at",
                "title"                 => lang('table_created_at'),
                "field"                 => 'DATE_FORMAT(pls_orders.created_at, "{{date_format}}") as created_at',
                "width"                 => "5"
            ],
            [
                "name"                  => "draft_order_id",
                "class"                 => "actions",
                "title"                 => lang('table_actions'),
                "field"                 => "pls_orders.draft_order_id",
                "width"                 => "1",
                "type"                  => "actions",
                "orderable"             => false,
                "csv"                   => false,
                "has_access"            => [],
            ],
        ],
        //additonal columns for database query
        "additional_columns" => [
            [
                "field"                 => "pls_orders.order_id",
            ],
        ],
        // actions
        "actions" => [
            [
                "title"             => lang('table_btn_edit'),
                "link"              => create_partner_url('/orders/update/{{draft_order_id}}'),
                "class"             => "ico-edit",
                "keys"              => ['draft_order_id'],
                "has_access"        => "",
            ],
             [
                 "title"             => lang('table_btn_delete'),
                 "link"              => create_partner_url('/orders/delete/{{draft_order_id}}'),
                 "class"             => "ico-delete dropdown-divider",
                 "keys"              => ['draft_order_id'],
                 "attr" => [
                     "data-remove"       => create_partner_url('/orders/delete/{{draft_order_id}}'),
                     "data-redirect"     => "false",
                     "data-type"         => "list"
                 ],
                 "has_access"        => "delete_order_student",
             ],
        ],

        // filters
        "filters" => [
            "groups" => [
                [
                    "group_name"        => "basic_information",
                    "group_title"       => lang('table_basic_info'),
                ],
                [
                    "group_name"        => "added",
                    "group_title"       => lang('table_added'),
                ],
            ],
            "fields" => [
                [
                    "name"              => "name",
                    "title"             => lang('table_name'),
                    "dbfield"           => "pls_orders_translations.name",
                    "field"             => "input",
                    "operator"          => "like",
                    "group"             => "basic_information"
                ],
                [
                    "name"              => "category",
                    "title"             => lang('table_category'),
                    "dbfield"           => "pls_orders.option_id",
                    "field"             => "select",
                    "attr" => [
                        "data-empty"    => "true",
                        "data-search"   => "true"
                    ],
                    "operator"          => "=",
                    "url"               => create_partner_url("/orders/get_ajax_categories/"),
                    "group"             => "basic_information"
                ],
                [
                    "name"              => "added-date",
                    "title"             => lang('table_added_date'),
                    "range_title"       => [
                        "from"          => lang('table_from'),
                        "to"            => lang('table_to'),
                    ],
                    "dbfield"           => "DATE(pls_orders.created_at)",
                    "field"             => "range",
                    "operator"          => "range",
                    "type"              => "date",
                    "group"             => "added"
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
                "group_by"              => "pls_orders.order_id",
                "preset"                => "all",
                "fields"                => [],
            ],
            [
                "name"                  => "approved",
                "result"                => "0",
                "title"                 => lang('table_stats_approved'),
                "color"                 => "success",
                "group_by"              => "pls_orders.order_id",
                "preset"                => "approved",
                "fields" => [
                    [
                        "dbfield"           => "pls_orders.status",
                        "operator"          => "=",
                        "value"             => ORDER_STATUS_APPROVED
                    ],
                ],
            ],
            
            [
                "name"                  => "pending",
                "result"                => "0",
                "title"                 => lang('table_stats_pending'),
                "color"                 => "warning",
                "group_by"              => "pls_orders.order_id",
                "preset"                => "pending",
                "fields" => [
                    [
                        "dbfield"           => "pls_orders.status",
                        "operator"          => "=",
                        "value"             =>
                            ORDER_STATUS_PENDING,

                    ],
                    [
                        "dbfield"           => "pls_orders.draft_order_id",
                        "operator"          => "",
                        "value"             => 0
                    ],
                ],
            ],
            
            [
                "name"                  => "declined",
                "result"                => "0",
                "title"                 => lang('table_stats_declined'),
                "color"                 => "purple",
                "group_by"              => "pls_orders.order_id",
                "preset"                => "declined",
                "fields" => [
                    [
                        "dbfield"           => "pls_orders.status",
                        "operator"          => "=",
                        "value"             => ORDER_STATUS_DECLINED
                    ],
                    [
                        "dbfield"           => "pls_orders.draft_order_id",
                        "operator"          => "",
                        "value"             => 0
                    ],
                ],
            ],
            [
                "name"                  => "cancelled",
                "result"                => "0",
                "title"                 => lang('table_stats_cancelled'),
                "color"                 => "black",
                "group_by"              => "pls_orders.order_id",
                "preset"                => "cancelled",
                "fields" => [
                    [
                        "dbfield"           => "pls_orders.status",
                        "operator"          => "=",
                        "value"             => ORDER_STATUS_CANCELLED
                    ],
                ],
            ]
        ]

    ];
}
