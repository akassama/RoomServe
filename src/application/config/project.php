<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// update version
$project['version'] = '1209';

$project['partner_admins_limit'] = 99;
$project['location_limit'] = 99;

$project['currencies'] = ['AED', 'USD'];
$project['default_currency'] = $project['currencies'][0];

//company logo
$project['logo'] = '/assets/images/admin/logo.jpg';

//Redemption ID length
$project['RID_length'] = 7;

//default email sender
$project['default_sender_email'] = 'noreply@prsl4.me';

// exchange rates
$project['exchange_rates'] = [
	'AED' => [
		'AED' => 1,
		'USD' => 3.67,
	],
	'USD' => [
		'AED' => 0.27,
		'USD' => 1,
	],
];

$config['project'] = $project;
