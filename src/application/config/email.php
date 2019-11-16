<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['useragent'] = 'CodeIgniter';
$config['protocol']  = getenv('EMAIL_PROTOCOL');
$config['smtp_host'] = getenv('EMAIL_HOST');
$config['smtp_user'] = getenv('EMAIL_USER');
$config['smtp_pass'] = getenv('EMAIL_PASS');
$config['smtp_port'] = getenv('EMAIL_PORT');
$config['smtp_crypto'] = getenv('EMAIL_CRYPTO');
$config['smtp_timeout'] = 5;
$config['wordwrap'] = TRUE;
$config['wrapchars'] = 76;
$config['mailtype'] = 'html';
$config['charset'] = 'utf-8';
$config['validate'] = FALSE;
$config['priority'] = 3;
$config['crlf'] = "\r\n";
$config['newline'] = "\r\n";
$config['bcc_batch_mode'] = FALSE;
$config['bcc_batch_size'] = 200;


