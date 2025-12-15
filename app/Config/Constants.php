<?php

/*
 | --------------------------------------------------------------------
 | App Namespace
 | --------------------------------------------------------------------
 |
 | This defines the default Namespace that is used throughout
 | CodeIgniter to refer to the Application directory. Change
 | this constant to change the namespace that all application
 | classes should use.
 |
 | NOTE: changing this will require manually modifying the
 | existing namespaces of App\* namespaced-classes.
 */
defined('APP_NAMESPACE') || define('APP_NAMESPACE', 'App');

/*
 | --------------------------------------------------------------------------
 | Composer Path
 | --------------------------------------------------------------------------
 |
 | The path that Composer's autoload file is expected to live. By default,
 | the vendor folder is in the Root directory, but you can customize that here.
 */
defined('COMPOSER_PATH') || define('COMPOSER_PATH', ROOTPATH . 'vendor/autoload.php');

/*
 |--------------------------------------------------------------------------
 | Timing Constants
 |--------------------------------------------------------------------------
 |
 | Provide simple ways to work with the myriad of PHP functions that
 | require information to be in seconds.
 */
defined('SECOND') || define('SECOND', 1);
defined('MINUTE') || define('MINUTE', 60);
defined('HOUR')   || define('HOUR', 3600);
defined('DAY')    || define('DAY', 86400);
defined('WEEK')   || define('WEEK', 604800);
defined('MONTH')  || define('MONTH', 2_592_000);
defined('YEAR')   || define('YEAR', 31_536_000);
defined('DECADE') || define('DECADE', 315_360_000);

/*
 | --------------------------------------------------------------------------
 | Exit Status Codes
 | --------------------------------------------------------------------------
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
defined('EXIT_SUCCESS')        || define('EXIT_SUCCESS', 0);        // no errors
defined('EXIT_ERROR')          || define('EXIT_ERROR', 1);          // generic error
defined('EXIT_CONFIG')         || define('EXIT_CONFIG', 3);         // configuration error
defined('EXIT_UNKNOWN_FILE')   || define('EXIT_UNKNOWN_FILE', 4);   // file not found
defined('EXIT_UNKNOWN_CLASS')  || define('EXIT_UNKNOWN_CLASS', 5);  // unknown class
defined('EXIT_UNKNOWN_METHOD') || define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     || define('EXIT_USER_INPUT', 7);     // invalid user input
defined('EXIT_DATABASE')       || define('EXIT_DATABASE', 8);       // database error
defined('EXIT__AUTO_MIN')      || define('EXIT__AUTO_MIN', 9);      // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      || define('EXIT__AUTO_MAX', 125);    // highest automatically-assigned error code

/**
 * @deprecated Use \CodeIgniter\Events\Events::PRIORITY_LOW instead.
 */
define('EVENT_PRIORITY_LOW', 200);

/**
 * @deprecated Use \CodeIgniter\Events\Events::PRIORITY_NORMAL instead.
 */
define('EVENT_PRIORITY_NORMAL', 100);

/**
 * @deprecated Use \CodeIgniter\Events\Events::PRIORITY_HIGH instead.
 */
define('EVENT_PRIORITY_HIGH', 10);

$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$r = $_SERVER['SCRIPT_NAME'];
$subdomain = explode('/', $r);
array_pop($subdomain);
$urllink=$protocol.$_SERVER['HTTP_HOST'];
if($urllink=="https://localhost" || $urllink=="http://localhost"){
    if(isset($subdomain[1])){
        $urllink.='/'.$subdomain[1];
    }    
} 
$domain = preg_replace('/^www\./', '', $_SERVER['HTTP_HOST']);
define('DOMAIN',$domain);
define('BASE_URL',"https://$domain");
define('IMG_DIR','uploads/');
define('IMG_DIR_LINK', BASE_URL.'/uploads/');
define('ASSETS_DIR_LINK', BASE_URL.'/assets/');
define('ASSETS_FOLDER', BASE_URL.'/assets/');
define('APP_NAME','BIGGROW');

define('USER_LOGIN_LINK',BASE_URL.'/login');
define('USER_LOGOUT_LINK',BASE_URL.'/logout');
define('USER_CHANGE_PWD_LINK',BASE_URL.'/change-password');
define('USER_SIGNUP_LINK',BASE_URL.'/user-signup/registeration/');
define('USER_CHANGE_FRGT_PWD_LINK',BASE_URL.'/change-forgot-password/');
define('USER_FORGET_PWD_LINK',BASE_URL.'/forgot-password');
define('USER_PWD_OTP_LINK',BASE_URL.'/verify-pwd-otp/');
define('USER_VERIFY_OTP_LINK',BASE_URL.'/verify-otp/');
define('USER_DASHBOARD_LINK',BASE_URL.'/dashboard-user');
define('UPDATE_BANK_DETAILS_LINK',BASE_URL.'/update-bank');
define('BUY_COIN',BASE_URL.'/buy-coin');
define('BUY_HISTORY',BASE_URL.'/buy-history');
define('SELL_HISTORY',BASE_URL.'/sell-history');
define('BUY_HISTORY_AJAX',BASE_URL.'/buy-history-ajax');
define('SELL_HISTORY_AJAX',BASE_URL.'/sell-history-ajax');

//ADMIN LINK
define('ADMIN_LOGIN_LINK',BASE_URL.'/admin-login');
define('ADMIN_LOGOUT_LINK',BASE_URL.'/admin-logout');
define('ADMIN_CHANGE_PWD_LINK',BASE_URL.'/admin-change-password');
define('ADMIN_DASHBOARD_LINK',BASE_URL.'/dashboard-admin');
define('ADMIN_USER_LIST_LINK',BASE_URL.'/admin-user-list');
define('ADMIN_USER_AJAX_LIST_LINK',BASE_URL.'/admin-ajax-user-list');
define('ADMIN_USER_UPDATE_STATUS',BASE_URL.'/admin-user-update-status');
define('ADMIN_USER_ADD_LINK',BASE_URL.'/admin-add-user');
define('ADMIN_USER_EDIT_LINK',BASE_URL.'/admin-edit-user');
define('ADMIN_USER_PROFILE_LINK',BASE_URL.'/admin-user-profile/');
define('ADMIN_SETTINGS_LINK',BASE_URL.'/admin-setting');
define('ADMIN_COIN_LINK',BASE_URL.'/admin-coin-list');
define('ADMIN_COIN_AJAX_LINK',BASE_URL.'/admin-coin-list-ajax');
define('ADMIN_COIN_ACCEPT_LINK',BASE_URL.'/admin-coin-accept-link/');
define('ADMIN_RELEASE_COIN_LINK',BASE_URL.'/admin-coin-release-link');

//USER TITLE
define('USER_DASHBOARD_TITLE','DASHBOARD');
define('MY_EARNING_TITLE', 'MY-EARNING');
define('USER_LIST_TITLE', 'USER-LIST');
define('BANK_DETAILS_TITLE', 'BANK DETAILS');
define('BUY_COIN_TITLE', 'BUY-COIN');
define('BUY_LIST_TITLE', 'BUY HISTORY LIST');
define('SELL_LIST_TITLE', 'SELL HISTORY LIST');
//ADMIN TITLE
define('ADMIN_DASHBOARD_TITLE','Dashboard');
define('ADMIN_USER_LIST_TITLE','User List');
define('ADMIN_USER_ADD_TITLE','User Add');
define('ADMIN_USER_EDIT_TITLE','User Edit');
define('ADMIN_ADD_TITLE','Admin Add');
define('ADMIN_EDIT_TITLE', 'ADMIN Edit');
define('ADMIN_SETTINGS_TITLE','Admin Setting');
define('ADMIN_USER_PROFILE_TITLE', 'USER-PROFILE');
define('ADMIN_COIN_LIST_TITLE', 'COIN REQUEST LIST');

define("UPLOAD_FOLDER",BASE_URL.'/uploads/');
define('REGISTER_CODE', 'XAB12A');

//database
if(DOMAIN == 'coin.test'){
    define("DB_HOSTNAME",'localhost');
    define("DB_USERNAME",'root');
    define("DB_PASSWORD",'');
    define("DATABASE",'coin');
}
if(DOMAIN == 'coin.artoon.in'){
    define("DB_HOSTNAME",'localhost');
    define("DB_USERNAME",'root');
    define("DB_PASSWORD",'');
    define("DATABASE",'coin');
}
if(DOMAIN == 'biggrow.pro'){
    define("DB_HOSTNAME",'localhost');
    define("DB_USERNAME",'bigg_biggrow');
    define("DB_PASSWORD",'Biggrow@777');
    define("DATABASE",'bigg_biggrow');
}
