<?php

    if (!defined('APP_NAME'))                            define('APP_NAME' ,        'App Name');
    if (!defined('APP_ORGANIZATION'))                    define('APP_ORGANIZATION' ,'org');
    if (!defined('APP_OWNER'))                           define('APP_OWNER' ,       'Rod');
    if (!defined('APP_DESCRIPTION'))                     define('APP_DESCRIPTION' , 'Desc.');

    if (!defined('MAX_LOGIN_ATTEMPTS_PER_HOUR'))         define('MAX_LOGIN_ATTEMPTS_PER_HOUR', 6);                                               // OK (LOGIN)
    if (!defined('CSRF_TOKEN_SECRET'))                   define('CSRF_TOKEN_SECRET', 'ogirdor');                                                 // OK (Everywhere)
    if (!defined('VERIFY_ENDPOINT'))                     define('VERIFY_ENDPOINT', 'http://localhost/supabkp/verify/includes/verify.php');       // OK (SIGNUP, VERIFY)
    if (!defined('RESET_ENDPOINT'))                      define('RESET_ENDPOINT', 'http://localhost/supabkp/reset_password/includes/reset.php'); // OK (RESET)
    if (!defined('TOKEN_EXPIRY_TIME'))                   define('TOKEN_EXPIRY_TIME', 'DATE_SUB(now(), interval 4 hour)');                        // OK (VERIFY)
    
    if (!defined('ALLOWED_INACTIVITY_TIME'))             define('ALLOWED_INACTIVITY_TIME', time()+1*60); // 1 HOUR
    /* If you use session_start(), session.cache_expire default is 180 minutes */

	if (!defined('MAX_EMAIL_VERIFICATION_REQS_PER_DAY')) define('MAX_EMAIL_VERIFICATION_REQUESTS_PER_DAY', 3);
    if (!defined('MAX_PASSWORD_RESET_REQS_PER_DAY'))     define('MAX_PASSWORD_RESET_REQUESTS_PER_DAY', 3);

    date_default_timezone_set('US/Eastern'); // OK
	error_reporting(1);                      // Disable before it goes live

?>