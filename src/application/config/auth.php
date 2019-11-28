<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config["auth"] = array(
    'email_verification_link'        => 'auth/verify/',
    'reset_password_link'            => 'auth/reset_password/',
    'admin_reset_password_link'      => 'auth/reset_password/'
);

$config['max_login_attempt']            = 20;
$config['attempt_time_interval']        = 600; //in seconds
