<?php defined('BASEPATH') OR exit('No direct script access allowed');

/*==============================================================================
|                      FILE MIME TYPE CONFIGURATIONS
|===============================================================================*/
$config['file_types'] = [
    'png' => 'image/png',
    'jpg' => 'image/jpg',
    'jpeg' => 'image/jpeg',
    'doc' => 'application/msword',
    'pdf' => 'application/pdf',
    'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
];

/*==============================================================================
|                            IMAGE CONFIGURATIONS
|===============================================================================
|
|                      !!! Configuration adding rule:  !!!
|
| $config['image'][module][image_type][other configs]
| e.g.  $config['image']['admin']['avatar']['path'] = '/uploads/admin/avatar/'
*/


/*-------------------------------------------------------------------------------
| General configurations
|-------------------------------------------------------------------------------*/

/* Image upload settings */
$config['image']['allowed_types'] = 'jpg|png|jpeg';
$config['image']['temp_path']     = '/uploads/temp/images/';

/* Folders naming settings*/
$config['image']['folder']['original'] = 'original';
$config['image']['folder']['xs']       = 'xs';
$config['image']['folder']['s']        = 's';
$config['image']['folder']['m']        = 'm';
$config['image']['folder']['l']        = 'l';
$config['image']['folder']['xl']       = 'xl';

/* Image size settings */
$config['image']['size']['xs']       = [150, 150];
$config['image']['size']['s']        = [250, 250];
$config['image']['size']['m']        = [600, 600];
$config['image']['size']['l']        = [1280, 1280];
$config['image']['size']['xl']       = [2000, 2000];

$config['image']['temp_preview']['url']  = '/files/temp/photo/';

$config['image']['types'] = [
    'partner_admin',
    'admin',
    'partner',
    'orders',
    'loyalty_scheme',
];

/*-------------------------------------------------------------------------------
| User configurations
|-------------------------------------------------------------------------------*/

//Avatar
/* Database and naming settings */
$cf_avatar['db_table']         = 'pls_users';
$cf_avatar['separate_table']   = FALSE;
$cf_avatar['db_field']         = 'photo';
$cf_avatar['db_id']            = 'user_id';
$cf_avatar['naming']           = $cf_avatar['db_table'].'__'.$cf_avatar['db_field'].'__';
$cf_avatar['is_image']         = TRUE;

/* Admin related settings */
$config['image']['admin']['avatar']  = $cf_avatar;
$config['image']['admin']['avatar']['path']    = '/uploads/admin/avatar/';

/* Partner administrator related settings */
$config['image']['partner_admin']['avatar']  = $cf_avatar;
$config['image']['partner_admin']['avatar']['path']   = '/uploads/partner_admin/avatar/';


/*-------------------------------------------------------------------------------
| Partner configurations
|-------------------------------------------------------------------------------*/

//Logo
/* Database and naming settings */
$cf_partner_logo['db_table']         = 'pls_partners';
$cf_partner_logo['separate_table']   = FALSE;
$cf_partner_logo['db_field']         = 'logo';
$cf_partner_logo['db_id']            = 'partner_id';
$cf_partner_logo['naming']           = $cf_partner_logo['db_table'].'__'.$cf_partner_logo['db_field'].'__';
$cf_partner_logo['is_image']         = TRUE;

/* Partner related settings */
$config['image']['partner']['logo']  = $cf_partner_logo;
$config['image']['partner']['logo']['path']    = '/uploads/student/logo/';

/* Partner contract related settings */
/* Database and naming settings */
$cf_contract['db_table']         = 'pls_post_attachments';
$cf_contract['separate_table']   = TRUE;
$cf_contract['db_field']         = 'file';
$cf_contract['type']             = 'partner';
$cf_contract['attachment_type']  = 'contract';
$cf_contract['db_id']            = 'type_id';
$cf_contract['naming']           = $cf_contract['db_table'].'__'.$cf_contract['db_field'].'__';
$cf_contract['is_image']         = FALSE;

$config['image']['partner']['contract'] = $cf_contract;
$config['image']['partner']['contract']['temp_preview']['url']  = '/files/temp/file/';
$config['image']['partner']['contract']['path']    = '/uploads/student/contract/';
$config['image']['partner']['contract']['temp_path']     = '/uploads/temp/files/';
$config['image']['partner']['contract']['allowed_types'] = 'pdf|doc|docx';


/*-------------------------------------------------------------------------------
| Loyalty scheme configurations
|-------------------------------------------------------------------------------*/

//Loyalty scheme
/* Database and naming settings */
$cf_ls_logo['db_table']         = 'pls_loyalty_schemes';
$cf_ls_logo['separate_table']   = FALSE;
$cf_ls_logo['db_field']         = 'logo';
$cf_ls_logo['db_id']            = 'loyalty_scheme_id';
$cf_ls_logo['naming']           = $cf_ls_logo['db_table'].'__'.$cf_ls_logo['db_field'].'__';
$cf_ls_logo['is_image']         = TRUE;

/* Admin related settings */
$config['image']['loyalty_scheme']['logo']  = $cf_ls_logo;
$config['image']['loyalty_scheme']['logo']['path']    = '/uploads/loyalty_scheme/logo/';

/*-------------------------------------------------------------------------------
| Orders configurations
|-------------------------------------------------------------------------------*/

//Orders
/* Database and naming settings */
$cf_orders_logo['db_table']         = 'pls_orders';
$cf_orders_logo['separate_table']   = FALSE;
$cf_orders_logo['db_field']         = 'logo';
$cf_orders_logo['db_id']            = 'order_id';
$cf_orders_logo['naming']           = $cf_orders_logo['db_table'].'__'.$cf_orders_logo['db_field'].'__';
$cf_orders_logo['is_image']         = TRUE;

/* Admin related settings */
$config['image']['orders']['logo']  = $cf_orders_logo;
$config['image']['orders']['logo']['path']    = '/uploads/orders/logo/';


/*-------------------------------------------------------------------------------
| Post photos configurations
|-------------------------------------------------------------------------------*/
/* Database and naming settings */
$cf_post_photo['db_table']         = 'pls_post_photos';
$cf_post_photo['separate_table']   = TRUE;
$cf_post_photo['db_field']         = 'photo';
$cf_post_photo['type']             = 'order';
$cf_post_photo['db_id']            = 'type_id';
$cf_post_photo['naming']           = $cf_post_photo['db_table'].'__'.$cf_post_photo['db_field'].'__';
$cf_post_photo['is_image']         = TRUE;

/* Post photos size settings */
$cf_post_photo['size']['xs']       = [200, 200]; //width, height
$cf_post_photo['size']['s']        = [300, 300]; //width, height

/* Admin related settings */
$config['image']['orders']['photo']  = $cf_post_photo;
$config['image']['orders']['photo']['path']    = '/uploads/orders/photo/';
