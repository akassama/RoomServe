<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code


/*
|--------------------------------------------------------------------------
| PLS constants
|--------------------------------------------------------------------------
| Here you can define custom constants
|
*/

//GENERAL STATUSES
defined('STATUS_ACTIVE')        		        OR define('STATUS_ACTIVE', 1);
defined('STATUS_INACTIVE')        		        OR define('STATUS_INACTIVE', 0);
defined('STATUS_DRAFT')                         OR define('STATUS_DRAFT', -2); //for CRUD draft


defined('LOGIN_ATTEMPS_STATUS_SUCCESS')         OR define('LOGIN_ATTEMPS_STATUS_SUCCESS', 1);
defined('LOGIN_ATTEMPS_STATUS_FAILED')          OR define('LOGIN_ATTEMPS_STATUS_FAILED', 0);

//Super administrator id
defined('SUPER_ADMINISTRATOR')  	            OR define('SUPER_ADMINISTRATOR', 1);

//User roles
defined('USER_ROLE_ADMINISTRATOR')  	        OR define('USER_ROLE_ADMINISTRATOR', 1);
defined('USER_ROLE_PARTNER_ADMINISTRATOR')  	OR define('USER_ROLE_PARTNER_ADMINISTRATOR', 2);
defined('USER_ROLE_NAME_PARTNER_ADMINISTRATOR') OR define('USER_ROLE_NAME_PARTNER_ADMINISTRATOR', 'partner_administrator');

//User statuses
defined('USER_STATUS_ACTIVE')  			        OR define('USER_STATUS_ACTIVE', 1);
defined('USER_STATUS_INACTIVE')  		        OR define('USER_STATUS_INACTIVE', 0);
defined('USER_STATUS_NOT_VERIFIED')		        OR define('USER_STATUS_NOT_VERIFIED', -1);

//Group constants
//ids
defined('SUPER_ADMINISTRATOR_GROUP')            OR define('SUPER_ADMINISTRATOR_GROUP', 1);
defined('PARTNER_SUPER_ADMIN_GROUP')  	        OR define('PARTNER_SUPER_ADMIN_GROUP', 2);
defined('PATTERN_GROUP_ID')         	        OR define('PATTERN_GROUP_ID', 3);

//TYPE VENUE
defined('TYPE_VENUE')  	                        OR define('TYPE_VENUE', 'order');
defined('TYPE_OFFER')  	                        OR define('TYPE_OFFER', 'offer');


//Loyalty scheme connection statuses
defined('CONNECTION_STATUS_CONNECTED')  	OR define('CONNECTION_STATUS_CONNECTED', 1);
defined('CONNECTION_STATUS_NOT_CONNECTED')  OR define('CONNECTION_STATUS_NOT_CONNECTED', 0);
defined('CONNECTION_STATUS_FAILED')  		OR define('CONNECTION_STATUS_FAILED', -1);

//PARTNER STATUSES
defined('PARTNER_STATUS_INACTIVE')  	                OR define('PARTNER_STATUS_INACTIVE', 0);
defined('PARTNER_STATUS_ACTIVE')     	                OR define('PARTNER_STATUS_ACTIVE', 1);
defined('PARTNER_STATUS_PENDING')                       OR define('PARTNER_STATUS_PENDING', 2);
defined('PARTNER_STATUS_EXPIRED')   	                OR define('PARTNER_STATUS_EXPIRED', 3);
defined('PARTNER_STATUS_CANCELLED')  	                OR define('PARTNER_STATUS_CANCELLED', 4);

//VENUE STATUSES
defined('ORDER_STATUS_INACTIVE')  	                OR define('ORDER_STATUS_INACTIVE', 0);
defined('ORDER_STATUS_APPROVED')   	                OR define('ORDER_STATUS_APPROVED', 1);
defined('ORDER_STATUS_PENDING')                     OR define('ORDER_STATUS_PENDING', 2);
defined('ORDER_STATUS_EXPIRED')  	                OR define('ORDER_STATUS_EXPIRED', 3);
defined('ORDER_STATUS_DECLINED')  	                OR define('ORDER_STATUS_DECLINED', 4);
defined('ORDER_STATUS_CANCELLED')   	            OR define('ORDER_STATUS_CANCELLED', 5);

//OFFER STATUSES
defined('OFFER_STATUS_INACTIVE')  	                OR define('OFFER_STATUS_INACTIVE', 0);
defined('OFFER_STATUS_ACTIVE')   	                OR define('OFFER_STATUS_ACTIVE', 1);
defined('OFFER_STATUS_PENDING')  	                OR define('OFFER_STATUS_PENDING', 2);

/*
 * SYSTEM STATUS REASONS
 */

//VENUE REASONS
defined('STATUS_REASON_VENUE_AWAITING_APPROVAL')       OR define('STATUS_REASON_VENUE_AWAITING_APPROVAL', 3);
defined('STATUS_REASON_VENUE_AWAITING_CHANGES')        OR define('STATUS_REASON_VENUE_AWAITING_CHANGES', 4);
