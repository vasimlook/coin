<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('health-check', function() {
    echo "Api working successfully";
});
//* user route
$routes->add('/', 'Login_c::home');
$routes->add('/login', 'Login_c::login');
$routes->add('logout', 'Login_c::logout');
$routes->add('change-password', 'Login_c::change_pwd');
$routes->add('verify-otp/(:num)', 'Login_c::verify_otp/$1');
$routes->add('change-forgot-password/(:any)', 'Login_c::change_frgt_pwd/$1');
$routes->add('forgot-password', 'Login_c::forgetpwd');
$routes->add('verify-pwd-otp/(:any)', 'Login_c::verify_pwd_otp/$1');
$routes->add('user-signup/registeration/(:any)', 'Login_c::signup/$1');
$routes->add('dashboard-user', 'User_c::index');
$routes->post('buy-coin', 'User_c::buy_coin');
$routes->add('update-bank', 'User_c::bank_details');
$routes->add('buy-history', 'User_c::buy_history');
$routes->add('sell-history', 'User_c::sell_history');
$routes->add('buy-history-ajax', 'User_c::buy_history_ajax');
$routes->add('sell-history-ajax', 'User_c::sell_history_ajax');


//* admin route
$routes->add('admin-login', 'Login_c::admin_login');
$routes->add('admin-logout', 'Login_c::admin_logout');
$routes->add('admin-change-password', 'Login_c::admin_change_pwd');
$routes->add('dashboard-admin', 'Admin_c::index');
$routes->add('admin-user-list', 'Admin_c::user_list');
$routes->add('admin-ajax-user-list', 'Admin_c::user_list_ajax');
$routes->add('admin-user-update-status', 'Admin_c::user_update_status');
$routes->add('admin-add-user', 'Admin_c::create_user');
$routes->add('admin-edit-user/(:any)', 'Admin_c::edit_user/$1');
$routes->add('admin-user-profile/(:num)/(:any)', 'Admin_c::user_profile/$1/$2');
$routes->add('admin-setting', 'Admin_c::admin_setting');
$routes->add('admin-coin-list', 'Admin_c::coin_list');
$routes->add('admin-coin-list-ajax', 'Admin_c::coin_list_ajax');
$routes->add('admin-coin-accept-link/(:num)/(:num)', 'Admin_c::accept_reject_coin/$1/$2');
$routes->add('admin-coin-release-link', 'Admin_c::release_coin');

//* cronjob route
$routes->add('remove-log-files', 'Crons_c::delete_log_files');
$routes->add('remove-custom-folder-files', 'Crons_c::delete_custom_folder_files');
$routes->get('run-query', 'Crons_c::run_query');