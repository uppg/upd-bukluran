<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

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
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ', 							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE', 					'ab');
define('FOPEN_READ_WRITE_CREATE', 				'a+b');
define('FOPEN_WRITE_CREATE_STRICT', 			'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');

/*
|--------------------------------------------------------------------------
| Bukluran
|--------------------------------------------------------------------------
*/

define('USER', 'user');
define('VALERR', 'valerr');
define('POSTBACKVAR', 'postbackvar');

define('STUDENT_GROUPID', 1);
define('FACULTY_GROUPID', 2);
define('ORG_GROUPID', 3);
define('OSA_GROUPID', 4);

//===OSA Manage Requirements Module===
define('REQ_NAME_MAXLENGTH', 128);
define('REQ_DESC_MAXLENGTH', 1024);

//===OSA Manage Organization Requirements Module===
define('ORG_REQ_COMMENT_MAXLENGTH', 1024);

//===Email Queue Module===
define('MEMBER_CONFIRMATION_EMAIL', 1);
define('FACULTY_CONFIRMATION_EMAIL', 2);
define('OSA_TO_ORGANIZATION_EMAIL', 3);
define('ANNOUNCEMENT_EMAIL', 4);
define('LOST_PASS_EMAIL', 5);
define('LOST_STUDENT_CODE_EMAIL', 6);
define('LOST_FACULTY_CODE_EMAIL', 7);

define('APP_NOT_SUBMITTED', 1);
define('APP_PENDING', 2);
define('APP_REJECTED', 3);
define('APP_RENEWED', 4);

/* End of file constants.php */
/* Location: ./system/application/config/constants.php */
