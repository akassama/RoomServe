<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['useragent'] = 'CodeIgniter';
$config['protocol']  = 'smtp';//getenv('EMAIL_PROTOCOL');
$config['smtp_host'] = 'smtp.sendgrid.net';//getenv('EMAIL_HOST');
$config['smtp_user'] = 'apikey';//getenv('EMAIL_USER');
$config['smtp_pass'] = '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';//getenv('EMAIL_PASS');
$config['smtp_port'] = '587';//getenv('EMAIL_PORT');
$config['smtp_crypto'] = 'tls';//getenv('EMAIL_CRYPTO');
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
