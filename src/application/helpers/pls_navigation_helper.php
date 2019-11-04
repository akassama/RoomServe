<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


//get permission filtered admin main navigation
function get_main_nav()
{
	return [
        
		[
			"url" => "orders",
			"title" => lang('module_orders'),
			"desc" => 'Manage orders',
			"class" => "reports",
			"access" => "access_orders"
		],
		
		[
			"url" => "users",
			"title" => "Users",
			"desc" => 'Manage users',
			"class" => "administrators",
			"access" => "access_administrators"
		],
		[
			"url" => "settings",
			"title" => "Settings",
			"desc" => lang('module_settings_desc'),
			"class" => "settings",
			"access" => ["access_usergroups", "access_loyalty_schemes", "access_categories"]
		]
	];
}


//get permission filtered admin settings navigation
function get_settings_nav()
{
	return [
		// [
		// 	"url" => "settings/user_groups",
		// 	"title" => lang('module_user_groups'),
		// 	"desc" => lang('module_user_groups_desc'),
		// 	"class" => "administrators",
		// 	"access" => "access_usergroups"
		// ],
		[
			"url" => "settings/cleaning_options",
			"title" => 'Cleaning options',
			"desc" => 'Manage cleaning options',
			"class" => "categories",
			"access" => "access_categories"
		],
		
	];
}


//get permission filtered admin reports navigation
function get_reports_nav()
{
	return [
		[
			"url" => "reports/csv_reports",
			"title" => lang('module_csv_reports'),
			"desc" => lang('module_csv_reports_desc'),
			"class" => "administrators",
			"access" => "access_csv_report"
		],
	];
}


//get permission filtered partner main navigation
function get_partner_main_nav()
{
	return [
		[
			"url" => "orders",
			"title" => lang('module_orders'),
			"desc" => 'Manage orders',
			"class" => "reports",
			"access" => ""
		],
		
		// [
		// 	"url" => "settings",
		// 	"title" => "Settings",
		// 	"desc" => lang('module_settings_desc'),
		// 	"class" => "settings",
		// 	"access" => ["partner_setting_partner", "access_usergroups_partner"]
		// ]
	];
}


//get permission filtered admin settings navigation
function get_partner_settings_nav()
{
	return [
		[
			"url" => "settings/general",
			"title" => lang('module_general'),
			"desc" => lang('module_general_desc'),
			"class" => "settings",
			"access" => "partner_setting_partner"
		],
	];
}


//get permission filtered partner admin reports navigation
function get_partner_reports_nav()
{
	return [
		[
			"url" => "reports/csv_reports",
			"title" => lang('module_csv_reports'),
			"desc" => lang('module_csv_reports_desc'),
			"class" => "administrators",
			"access" => "access_csv_report_partner"
		],
	];
}
