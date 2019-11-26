<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Site language configurations
|--------------------------------------------------------------------------
*/

//all available languages of current website
$config['site_languages'] = ['en', 'ru'];

//hide default language on url
$config['hide_default_lang'] = TRUE;

$config['language_wrapper'] = '<ul>%s</ul>';
$config['language_item_wrapper'] = '<li>%s</li>';

//main date format for backend
$config['date_format_php'] = 'd F Y';
$config['date_format_mysql'] = '';