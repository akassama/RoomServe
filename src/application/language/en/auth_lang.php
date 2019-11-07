<?php defined('BASEPATH') OR exit('No direct script access allowed');

/*==========================================================================
|                           ALERT MESSAGES
|==========================================================================*/
/*
|--------------------------------------------------------------------------
| Authenticaton & Authorization messages
|--------------------------------------------------------------------------
*/

$lang["auth_welcome_note"]               		= "Welcome";
$lang['auth_signup_failed']                  	= 'Error occured while signing up. Please, try again';
$lang['auth_login_success']                  	= 'You have successfully logged in';
$lang['auth_login_failed']                   	= 'Email or password incorrect';
$lang['auth_login_profile_inactive']           	= 'Your profile is deactivated. Please, contact with administrators';
$lang['auth_logout_success']                 	= 'You have successfully logged out';
$lang['auth_logout_failed']                  	= 'Wrong token';
$lang['auth_verification_send_success']      	= 'Your profile is successfully created and verification link has been sent. Please, check your email';
$lang['auth_verification_send_failed']       	= 'Your profile is created. Error occured while sending verification link';
$lang['auth_email_verification_success']     	= 'Your email is successfully verified';
$lang['auth_email_verification_failed']      	= 'Wrong verification link';
$lang['auth_reset_link_send_success']        	= 'Password recovery link has successfully sent. Please, check your email';
$lang['auth_reset_link_send_failed']         	= 'Error occured while sending password recovery link. Please, try again';
$lang['auth_reset_link_verification_failed'] 	= 'Wrong verification link';
$lang['auth_password_reset_success']         	= 'You password is successfully reset';
$lang['auth_password_reset_failed']          	= 'Error occured while setting new password';
$lang['auth_email_not_available']              	= 'Email address is not available';

$lang['auth_login_attempts_exceeded']          	= 'Maximum number of Login attempts exceeded. Please try after 10 minutes';
$lang['auth_login_attempts_left']           	= 'Email or password incorrect. You have {number} attempt(s) left';
