<?php
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
define('APP_NAME','P247');
?>