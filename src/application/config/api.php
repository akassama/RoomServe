<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//This key is the same among loyalty schemes and used only first time connection
$config['jwt_scheme_key']	= sha1('Loyalty_schemes');
//But this one used to generate access token for loyalty schemes
$config['jwt_key']	= sha1('Parasol_loyalty_scheme');
$config['token_expire_time']	= 2592000; //30 days
