<?php

    error_reporting(1);                      // Disable before it goes live    

    date_default_timezone_set('US/Eastern'); 
    
    if (!defined('APP_NAME'))                    define('APP_NAME' ,        'daLogin');
    if (!defined('APP_ORGANIZATION'))            define('APP_ORGANIZATION' ,'daLogin');
    if (!defined('APP_OWNER'))                   define('APP_OWNER' ,       'daLogin');
    if (!defined('APP_DESCRIPTION'))             define('APP_DESCRIPTION' , 'daLogin');

    if (!defined('CSRF_TOKEN_SECRET'))           define('CSRF_TOKEN_SECRET', 'blablabla');
    if (!defined('WEB_ADDRESS'))                 define('WEB_ADDRESS',       'http://localhost/');
    if (!defined('WEB_DIR'))                     define('WEB_DIR',           'somefolder/');

    /****************************************************************************************************/

    if (!defined('INACTIVE_TIME_LIMIT'))         define('INACTIVE_TIME_LIMIT',         600); // 10 minutes

    if (!defined('MAX_LOGIN_ATTEMPTS_PER_HOUR')) define('MAX_LOGIN_ATTEMPTS_PER_HOUR', 5);

    if (!defined('TOKEN_EXPIRY_TIME'))           define('TOKEN_EXPIRY_TIME',           'DATE_SUB(now(), interval 1 hour)'); // 1 hour

    if (!defined('EMAIL_REQ_EXPIRY_TIME'))       define('EMAIL_REQ_EXPIRY_TIME',       'DATE_SUB(now(), interval 12 hour)'); // 12 hours
    if (!defined('MAX_EMAIL_REQS_PER_DAY'))      define('MAX_EMAIL_REQS_PER_DAY',      5);

    /**********************************************************************************************************************************************************************/
    if (!defined('VERIFY_ENDPOINT'))             define('VERIFY_ENDPOINT',             'http://localhost/supabkp/verify/includes/verify.php');        // OK (SIGNUP, VERIFY)
    /*************************************************************************************************************************************************************/

?>