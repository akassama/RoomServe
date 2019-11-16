<?php defined('BASEPATH') OR exit('No direct script access allowed');

/*==========================================================================
|                           ALERT MESSAGES
|==========================================================================*/
/*
|--------------------------------------------------------------------------
| Admin CRUD messages
|--------------------------------------------------------------------------
*/
$lang['admin_create_success'] = 'New user was successfully created';
$lang['admin_create_failed']  = 'New user creation error, please try again';
$lang['admin_update_success'] = 'User info was successfully updated';
$lang['admin_update_failed']  = 'User info update error, please try again';
$lang['admin_update_denied']  = 'This User info cannot be updated!';
$lang['admin_delete_success'] = 'User was successfully deleted';
$lang['admin_delete_failed']  = 'User delete error, please try again';
$lang['admin_delete_denied']  = 'User cannot be deleted!';
$lang['admin_delete_warning'] = 'Are you sure you want to delete this user?';

//admin profile update messages
$lang['admin_profile_update_success'] = 'Your profile was updated successfully';
$lang['admin_profile_update_failed']  = 'Profile update error, please try again';


/*
|--------------------------------------------------------------------------
| User group CRUD messages
|--------------------------------------------------------------------------
*/
$lang['group_create_success'] = 'New user group was successfully created';
$lang['group_create_failed']  = 'New user group creation error, please try again';
$lang['group_update_success'] = 'User group was successfully updated';
$lang['group_update_failed']  = 'User group update error, please try again';
$lang['group_update_denied']  = 'User group "User" is read-only!';
$lang['group_delete_success'] = 'User group was successfully deleted';
$lang['group_delete_failed']  = 'User group delete error, please try again';
$lang['group_delete_warning'] = 'Are you sure you want to delete this user group?';
$lang['group_delete_denied'] = 'There are {{num}} user(s) in this group now, clean the group first!';

//password change messages
$lang['change_password_success'] = 'New password was successfully set';
$lang['change_password_failed']  = 'Password change error, please try again';


/*
|--------------------------------------------------------------------------
| Cleaning option CRUD messages
|--------------------------------------------------------------------------
*/
$lang['cleaning_option_create_success'] = 'New cleaning option was successfully created';
$lang['cleaning_option_create_failed']  = 'New cleaning option creation error, please try again';
$lang['cleaning_option_create_denied']  = 'Cleaning option creation is limited';
$lang['cleaning_option_update_success'] = 'Cleaning option was successfully updated';
$lang['cleaning_option_update_failed']  = 'Cleaning option update error, please try again';
$lang['cleaning_option_delete_success'] = 'Cleaning option was successfully deleted';
$lang['cleaning_option_delete_failed']  = 'Cleaning option delete error, please try again';



/*
|--------------------------------------------------------------------------
| Orders CRUD messages
|--------------------------------------------------------------------------
*/
$lang['order_create_success'] = 'New order was successfully created';
$lang['order_create_failed']  = 'New order creation error, please try again';
$lang['order_create_denied']  = 'Order creation is limited';
$lang['order_update_success'] = 'Order was successfully updated';
$lang['order_update_failed']  = 'Order update error, please try again';
$lang['order_delete_success'] = 'Order was successfully deleted';
$lang['order_delete_failed']  = 'Order delete error, please try again';
$lang['order_change_reset_success'] = 'Changes in order was successfully reset';
$lang['order_change_reset_failed']  = 'Error occured while resetting order changes, please try again';
$lang['order_saved_with_inactive_status']  = 'Due to partner deactivation, the order(s) is(are) saved as inactive';

$lang['order_deactivate_success'] = 'Order is successfully deactivated';
$lang['order_deactivate_denied'] = '"{{Order_name}}" cannot be activated, please activate the Partner "{{Partner_name}}" first.';

$lang['email_theme_update'] = 'Your order has been updated!';
$lang['email_theme_decline'] = 'Your order has been declined!';
$lang['email_theme_approve'] = 'Your order has been approved!';
$lang['email_theme_delete'] = 'Your order has been deleted!';
$lang['email_theme_deactivate'] = 'Your order has been deactivated!';
$lang['email_theme_cancel'] = 'Your order has been canceled!';
$lang['email_message_update'] = 'Your order has been updated by admin! Check changing!';
$lang['email_message_decline'] = 'Your order has been declined by admin! Check changing!';
$lang['email_message_approve'] = 'Your order has been approved by admin! Check changing!';;
$lang['email_message_delete'] = 'Your order has been deleted by admin! Check changing!';
$lang['email_message_deactivate'] = 'Your order has been deactivated by admin! Check changing!';
$lang['email_message_cancel'] = 'Your order has been canceled by admin! Check changing!';


$lang['email_message_reason'] = 'Reason for decline: ';
/*
|--------------------------------------------------------------------------
| Status changes messages
|--------------------------------------------------------------------------
*/
$lang['status_message_partner_deactivated'] = 'Partner is deactivated by Users';
$lang['status_message_partner_expired'] = 'Partner is expired';

$lang['status_message_order_deactivated'] = 'Order is deactivated by Users';
$lang['status_message_order_expired'] = 'Order is expired';
