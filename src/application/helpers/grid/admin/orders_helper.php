<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

function orders_grid_columns()
{
    return [
        // options
        "options" => [
            "module_name"           => 'orders',
            "module_title"          => lang('module_orders'),
            "filter"                => false,
            "quick_stats"           => true,
            "csv"                   => [
                "csv_export"        => false,
                "has_access"        => "export_orders",
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
                    ORDER_STATUS_INACTIVE => [
                        "title"         => lang('table_inactive'),
                        "label_type"    => "grey"
                    ],
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
                "width"                 => "10",
            ],
            [
                "name"                  => "created_by",
                "title"                 => lang('table_created_by'),
                "field"                 => 'CONCAT(pls_users.first_name," ", COALESCE(pls_users.last_name, "")) as created_by',
                "width"                 => "5"
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
                "has_access"            => ["approve_orders", "update_orders", "delete_orders"],
            ],
        ],

        //additonal columns for database query
        "additional_columns" => [
            [
                "field"             => "pls_orders.order_id",
            ],
            [
                "field"             => "pls_orders.reason_id",
            ],
            
        ],

        // actions
        "actions" => [
            [
                "title"             => lang('table_btn_approve'),
                "link"              => create_url('/orders/approve/{{draft_order_id}}'),
                "class"             => "ico-approve",
                "type"              => "approve",
                "keys"              => ['draft_order_id'],
                "js_query" => [
                    "row"               => "reason_id",
                    "operator"          => "==",
                    "value"             => [
                        STATUS_REASON_VENUE_AWAITING_APPROVAL,
                        STATUS_REASON_VENUE_AWAITING_CHANGES,
                    ],
                ],
                "has_access"        => "approve_orders",
            ],
            [
                "title"             => lang('table_btn_edit'),
                "link"              => '/admin/orders/update/{{draft_order_id}}',
                "class"             => "ico-edit",
                "type"              => "edit",
                "keys"              => ['draft_order_id'],
                "js_query" => [
                    "row"               => "reason_id",
                    "operator"          => "==",
                    "value"             => [
                        0,
                    ],
                ],
                "has_access"        => "update_orders",
            ],
            // [
            //     "title"             => lang('table_btn_deactivate'),
            //     "link"              => '/admin/orders/deactivate/{{draft_order_id}}',
            //     "class"             => "ico-deactivate",
            //     "type"              => "deactivate",
            //     "keys"              => ['draft_order_id'],
            //     "js_query" => [
            //         "row"               => "status",
            //         "operator"          => "==",
            //         "value"             => [
            //             ORDER_STATUS_APPROVED,
            //         ],
            //     ],
            //     "attr" => [
            //         "data-alert"                => "/admin/orders/deactivate/{{draft_order_id}}",
            //         "data-redirect"             => "false",
            //         "data-module"               => "list",
            //         "data-alert-type"           => "warning",
            //         "data-alert-title"          => lang('alert_title'),
            //         "data-alert-text"           => lang('alert_text_deactivate_order'),
            //         "data-alert-title-success"  => lang('alert_title_success'),
            //         "data-alert-text-success"   => lang('alert_text_success_deactivate_order'),
            //         "data-alert-button"         => lang('table_btn_deactivate')
            //     ],
            //     "has_access"        => "update_orders",
            // ],
            // [
            //     "title"             => lang('table_btn_activate'),
            //     "link"              => '/admin/orders/deactivate/{{draft_order_id}}',
            //     "class"             => "ico-deactivate",
            //     "type"              => "deactivate",
            //     "keys"              => ['draft_order_id'],
            //     "js_query" => [
            //         "row"               => "status",
            //         "operator"          => "==",
            //         "value"             => [
            //             ORDER_STATUS_INACTIVE,
            //         ],
            //     ],
            //     "attr" => [
            //         "data-alert"                => "/admin/orders/deactivate/{{draft_order_id}}",
            //         "data-redirect"             => "false",
            //         "data-module"               => "list",
            //         "data-alert-type"           => "info",
            //         "data-alert-title"          => lang('alert_title'),
            //         "data-alert-text"           => lang('alert_text_activate_order'),
            //         "data-alert-title-success"  => lang('alert_title'),
            //         "data-alert-text-success"   => lang('alert_text_success_activate_order'),
            //         "data-alert-button"         => lang('table_btn_activate')
            //     ],
            //     "has_access"        => "update_orders",
            // ],
            // [
            //     "title"                 => lang('table_btn_cancel'),
            //     "link"                  => "#pls_cancellation-modal",
            //     "class"                 => "ico-cancel",
            //     "keys"                  => ['draft_order_id'],
            //     "js_query" => [
            //         "row"               => "status",
            //         "operator"          => "==",
            //         "value"             => [
            //             ORDER_STATUS_APPROVED,
            //         ],
            //     ],
            //     "attr" => [
            //         "data-toggle"               => "modal",
            //         "data-target"               => "#pls_cancellation-modal",
            //         "data-cancellation-id"      => "{{draft_order_id}}",
            //         "data-cancellation-url"     => "/admin/orders/cancel/{{draft_order_id}}",
            //     ],
            //     "has_access"            => "update_orders",
            // ],
            [
                "title"             => lang('table_btn_delete'),
                "link"              => '/admin/orders/delete/{{draft_order_id}}',
                "class"             => "ico-delete dropdown-divider",
                "keys"              => ['draft_order_id'],
                "attr" => [
                    "data-remove"       => '/admin/orders/delete/{{draft_order_id}}',
                    "data-redirect"     => "false",
                    "data-type"         => "list"
                ],
                "has_access"        => "delete_orders",
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
                    "group_title"       => lang('table_added'). ' / '.lang('table_approved'),
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
                    "url"               => "/admin/orders/get_ajax_categories/",
                    "group"             => "basic_information"
                ],
                [
                    "name"              => "added-by",
                    "title"             => lang('table_created_by'),
                    "dbfield"           => "pls_orders.created_by",
                    "field"             => "select",
                    "attr" => [
                        "data-empty"    => "true",
                        "data-search"   => "true"
                    ],
                    "operator"          => "=",
                    "url"               => "/admin/orders/get_ajax_creators/",
                    "group"             => "added"
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
                [
                    "name"              => "approved-by",
                    "title"             => lang('table_approved_by'),
                    "dbfield"           => "pls_orders.approved_by",
                    "field"             => "select",
                    "attr" => [
                        "data-empty"    => "true",
                        "data-search"   => "true"
                    ],
                    "operator"          => "=",
                    "url"               => "/admin/orders/get_ajax_approvers/",
                    "group"             => "added"
                ],
                [
                    "name"              => "approved-date",
                    "title"             => lang('table_approved_date'),
                    "range_title"       => [
                        "from"          => lang('table_from'),
                        "to"            => lang('table_to'),
                    ],
                    "dbfield"           => "DATE(pls_orders.approved_at)",
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
                "fields" => [
                ],
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
