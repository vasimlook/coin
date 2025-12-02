<?php

namespace App\Controllers;
use App\Models\Login_m;
use App\Models\User_m;

use CodeIgniter\Cookie\Cookie;
use CodeIgniter\Cookie\CookieStore;
use Config\Services;
use App\Libraries\S3Uploader;

class Login_c extends BaseController
{
    private $Login_m;
    private $User_m;
    private $security;
    protected $session;
    protected $validation;
    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->session->start();
        helper('url');
        helper('functions');
        helper('cookie');
        $this->security = \Config\Services::security();
        helper('security');
        $this->Login_m = new Login_m();
        $this->User_m = new User_m();
        $this->validation = \Config\Services::validation();
        if (!check_html_injection_new($_POST)) {
            successOrErrorMessage("You are trying to hacking..", 'error_toast');
            return redirect()->back();
        }
    }

    public function update_market_date()
    {
        $this->Login_m->update_market_date_stauts();
    }
    function daily_user_track() {
        $this->Login_m->update_daily_user_track();
    }

    public function yantra_auto_result($game_name = '')
    {
        // $currentMinute = (int) date('i');        
        // if (($currentMinute % 3 === 0 && $game_name == 'game70s') || $game_name == 'game130s') {                    
            $id = $this->Login_m->yantra_auto_result($game_name);
            if(!empty($id)){                
                if (!file_exists(IMG_DIR . $game_name)) {                       
                    if (mkdir(IMG_DIR . $game_name)) {
                    }
                }
                $folderPath = $filePath = IMG_DIR . $game_name . '/';
                $fileName = $id.'.txt';                    
                $filePath = $folderPath . $fileName;
                $file = fopen($filePath, 'w');
                fclose($file);
            } 
        // }       
    }
    public function check_game_file($game_name = '', $game_id = 0)
    {
        header('Content-Type: text/event-stream');
        header('Cache-Control: no-cache');
        $filePath = IMG_DIR . $game_name . '/' . $game_id . '.txt';
        if (is_file($filePath) || file_exists($filePath)) {
            echo "data: {\"success\": \"1\"}\n\n";
        } else {
            echo "data: {\"success\": \"0\"}\n\n";
        }
        ob_flush();
        flush();
        die;
    }

    public function play_store()
    {
        // $data['title'] = APP_NAME.' - Play Store';
        // $data['num'] = 1;
        // echo single_page('playstore', $data);                   
        $cleanUrl = str_replace(['https://', 'http://'], '', REDIRECT_PLAY_STORE_LINK);
        $intent = "intent://{$cleanUrl}#Intent;scheme=https;package=com.android.chrome;end";
        header("Location: $intent");
        exit;                
    }
    public function play_store_mh()
    {
        // $data['title'] = APP_NAME.' - Play Store';
        // $data['num'] = 0;
        // echo single_page('playstore', $data);
        $cleanUrl = str_replace(['https://', 'http://'], '', REDIRECT_MH_PLAY_STORE_LINK);
        $intent = "intent://{$cleanUrl}#Intent;scheme=https;package=com.android.chrome;end";
        header("Location: $intent");
        exit;
    }

    public function redirect_play_store()
    {
        $data['title'] = APP_NAME.' - Play Store';
        $data['num'] = 1;
        echo single_page('playstore', $data);
    }
    public function redirect_play_store_mh()
    {
        $data['title'] = APP_NAME.' - Play Store';
        $data['num'] = 0;
        echo single_page('playstore', $data);
    }
    public function home()
    {
        $data['title'] = 'Home';
        $data['num'] = 0;
        echo single_page('user/home', $data);
    }

    public function login()
    {
        helper('form');        
        if (isset($_POST['username']) && isset($_POST['password'])) {
            $this->validation->setRules([
                'username' => [
                    'label'  => 'username',
                    'rules'  => 'required|min_length[10]|max_length[10]|numeric',
                    'errors' => [
                        'required' => 'Mobile no is required',
                        'min_length' => 'Mobile no is not valid',
                        'max_length' => 'Mobile no is not valid',
                        'numeric' => 'Mobile no is not valid',
                    ],
                ],
                'password' => [
                    'label'  => 'password',
                    'rules'  => 'required',
                    'errors' => [
                        'required' => 'Password is required',
                    ],
                ],
            ]);
            if (!$this->validation->run($_POST)) {
                $data['errors'] = $this->validation->getErrors();
            } else {
                $result = $this->Login_m->login($_POST['username'], $_POST['password'], '');
                if ($result) {
                    $uid = encrypt_decrypt_custom($_SESSION['user']['id']);
                    // $cxrtosdta = encrypt_decrypt_custom($_SESSION['user']['phone']);                    
                    set_cookie('_xlozgqian', $uid, time() + (10 * 365 * 24 * 60 * 60), '', '/', '', true, true, 'None');
                    $params = [];
                    $devicedata = md5(uniqid(mt_rand(), true));                    
                    set_cookie('_devicedata', $devicedata, time() + (10 * 365 * 24 * 60 * 60), '', '/', '', true, true, 'None');
                    $params['devicedata'] = $devicedata;
                    $params['actual_pwd'] = $_POST['password'];
                    $this->Login_m->update_user_details($_SESSION['user']['phone'],$params);
                    return redirect()->to(USER_DASHBOARD_LINK)->withCookies();
                }
            }
        } else {
            if (get_cookie('_xlozgqian') != '') {
                $user_id = encrypt_decrypt_custom(get_cookie('_xlozgqian'), 'decrypt');
                if (isset($_POST['username']) && isset($_POST['password'])) {
                    $result = $this->Login_m->login($_POST['username'], $_POST['password'], '');
                } else {
                    $result = $this->Login_m->login('', '', $user_id);
                }
                if ($result) {                    
                    // $cxrtosdta = encrypt_decrypt_custom($_SESSION['user']['phone']);                    
                    $uid = encrypt_decrypt_custom($_SESSION['user']['id']);                    
                    set_cookie('_xlozgqian', $uid, time() + (10 * 365 * 24 * 60 * 60), '', '/', '', true, true, 'None');                    
                    $params = [];                        
                    $devicedata = md5(uniqid(mt_rand(), true));
                    set_cookie('_devicedata', $devicedata, time() + (10 * 365 * 24 * 60 * 60), '', '/', '', true, true, 'None');
                    $params['devicedata'] = $devicedata;
                    $this->Login_m->update_user_details($_SESSION['user']['phone'],$params);
                    return redirect()->to(USER_DASHBOARD_LINK)->withCookies();                    
                }
            }
        }
        $data['title'] = "Login";

        echo single_page('user/login', $data);
    }

    public function logout()
    {        
        $url = BASE_URL;
        delete_cookie('_xlozgqian');
        delete_cookie('_devicedata');
        session_destroy();
        return redirect()->to($url)->withCookies();
    }    

    public function change_pwd()
    {
        sessionCheckUser();
        helper('form');        
        if (isset($_POST['old_password']) && isset($_POST['new_password']) && isset($_POST['confirm_new_password'])) {
            $this->validation->setRules([
                'old_password' => [
                    'label'  => 'old_password',
                    'rules'  => 'required',
                    'errors' => [
                        'required' => 'Old password is required',
                    ],
                ],
                'new_password' => [
                    'label'  => 'new_password',
                    'rules'  => 'required',
                    'errors' => [
                        'required' => 'New password is required',
                    ],
                ],
                'confirm_new_password' => [
                    'label'  => 'confirm_new_password',
                    'rules'  => 'required',
                    'errors' => [
                        'required' => 'Confirm password is required',
                    ],
                ],
            ]);
            if (!$this->validation->run($_POST)) {
                $data['errors'] = $this->validation->getErrors();
            } else {
                $result = $this->Login_m->check_current_password($_POST['old_password']);
                if (!$result) {
                    successOrErrorMessage("Old Password is wrong. Please enter correct password.", 'error_toast');
                    return redirect()->to(USER_CHANGE_PWD_LINK);
                } else if ($_POST['new_password'] == $_POST['old_password']) {
                    successOrErrorMessage("New Password and old password are same. Please use another password.", 'error_toast');
                    return redirect()->to(USER_CHANGE_PWD_LINK);
                } else if ($_POST['new_password'] != $_POST['confirm_new_password']) {
                    successOrErrorMessage("New Password and confirm password are not same.", 'error_toast');
                    return redirect()->to(USER_CHANGE_PWD_LINK);
                } else {
                    $result = $this->Login_m->update_password(array("user_new_password" => $_POST['new_password']));
                    successOrErrorMessage("Password changed successfully.", 'success_toast');
                    return redirect()->to(USER_CHANGE_PWD_LINK);
                }
            }
        }
        $data['title'] = "Change Password";
        $_SESSION['form_token'] = bin2hex(random_bytes(16));       
        echo load_view('user', 'user/change_pwd', $data);
    }

    public function signup($url_refferal_code = 0)
    {
        if(DOMAIN == 'make10x.games'){
            echo 'Under Maintenance';die;
        }
        helper('form');
        if (isset($_POST['username'])) {
            $this->validation->setRules([
                'name' => [
                    'label'  => 'name',
                    'rules'  => 'required',
                    'errors' => [
                        'required' => 'Name is required',
                    ],
                ],
                'username' => [
                    'label'  => 'username',
                    'rules'  => 'required|min_length[10]|max_length[10]|numeric',
                    'errors' => [
                        'required' => 'Mobile no is required',
                        'min_length' => 'Mobile no is not valid',
                        'max_length' => 'Mobile no is not valid',
                        'numeric' => 'Mobile no is not valid',
                    ],
                ],
                'password' => [
                    'label'  => 'password',
                    'rules'  => 'required',
                    'errors' => [
                        'required' => 'Password is required',
                    ],
                ],
                'referral_code' => [
                    'label'  => 'referral_code',
                    'rules'  => 'required|alpha_numeric',
                    'errors' => [
                        'required|alpha_numeric' => 'Enter valid referral code',
                    ],
                ],
            ]);
            if (!$this->validation->run($_POST)) {
                $data['errors'] = $this->validation->getErrors();
            } else {
                $url_refferal_code = $_POST['referral_code'] ?? $url_refferal_code;
                $result = $this->Login_m->exist_user($_POST['username']);
                if (isset($result['phone']) && isset($result['otp_verify']) && $result['otp_verify'] == '1') {
                    successOrErrorMessage("Mobile number allready exist", 'error_toast');
                    return redirect()->to(USER_SIGNUP_LINK . $url_refferal_code);
                }
                else if (isset($result['phone']) && isset($result['otp_verify']) && $result['otp_verify'] == '0')
                {
                    if(date('Y-m-d') == $result['otp_date'] && $result['otp_count'] >= 3)
                    {
                        successOrErrorMessage("OTP Limit Over.", 'error_toast');
                        return redirect()->to(USER_SIGNUP_LINK . $url_refferal_code);
                    }
                    else
                    {                        
                        $otp = rand(1000, 9999);                                               
                        send_otp($_POST['username'], $otp);
                        send_otp_fast2($_POST['username'], $otp);
                        $params = [];
                        $password = md5($_POST['password']);
                        $new_password = sha1($password);
                        $params['password'] = $new_password; 
                        $params['actual_pwd'] = $_POST['password'];
                        $params['otp'] = $otp;
                        $params['otp_date'] = date('Y-m-d');
                        $params['otp_count'] = (isset($result['otp_count']) && $result['otp_count'] !='' && date('Y-m-d') == $result['otp_date'])?($result['otp_count']+1):1;
                        $res = $this->Login_m->update_user_details($result['phone'],$params);
                        if ($res) {
                            successOrErrorMessage("Registration success Please verify OTP", 'success_toast');
                            return redirect()->to(USER_VERIFY_OTP_LINK.$_POST['username']);
                        }
                    }
                }
                else {
                    $password = md5($_POST['password']);
                    $new_password = sha1($password);
                    $params = array();
                    $params['profile_img_no'] = rand(1, 40);
                    $params['name'] = $_POST['name'];
                    $params['phone'] = $_POST['username'];
                    $params['status'] = 1;                 
                    $params['password'] = $new_password;                                                            
                    $params['actual_pwd'] = $_POST['password'];                                                            
                    $otp = rand(1000, 9999);
                    send_otp($_POST['username'], $otp);
                    send_otp_fast2($_POST['username'], $otp);

                    // generate uniqe alpa numeric referal code
                    $is_unique = false;
                    while (!$is_unique) {
                        $referral_code = randomString(6);
                        $existing_code = $this->Login_m->get_table_data(['referral_code' => $referral_code],'users');
                        if (empty($existing_code)) {
                            $is_unique = true;
                        }
                    }

                    $get_user_level = $this->Login_m->get_table_data(['referral_code' => $url_refferal_code],'users');

                    $params['otp'] = $otp;
                    $params['otp_date'] = date('Y-m-d');
                    $params['otp_count'] = 1;
                    $params['referral_code'] = $referral_code;
                    $params['level1'] = $get_user_level[0]['id'] ?? '';
                    $params['level2'] = $get_user_level[0]['level1'] ?? '';
                    $params['created_at'] = date('Y-m-d h:i:s');
                    $last_id = $this->Login_m->registration($params);
                    if ($last_id) {
                        successOrErrorMessage("Registration success Please verify OTP", 'success_toast');
                        return redirect()->to(USER_VERIFY_OTP_LINK.$_POST['username']);
                    }
                }
            }
        }
        $data['referral_code'] = $url_refferal_code;
        $data['title'] = "Signup";
        echo single_page('user/signup', $data);
    }

    public function verify_otp($mono = '')
    {
        $result1 = $this->Login_m->exist_user($mono);
        if(isset($result1['otp_verify']) && $result1['otp_verify'] == '0')
        {
            helper('form');
            if (isset($_POST['otp'])) {            
                $this->validation->setRules([               
                    'otp' => [
                        'label'  => 'otp',
                        'rules'  => 'required|min_length[4]|max_length[4]|numeric',
                        'errors' => [
                            'required' => 'OTP is required',
                            'min_length' => 'OTP is not valid',
                            'max_length' => 'OTP is not valid',
                            'numeric' => 'OTP is not valid',
                        ],
                    ]                
                ]);
                if (!$this->validation->run($_POST)) {
                    $data['errors'] = $this->validation->getErrors();
                } else {                              
                    $result = $this->Login_m->verify_otp($_POST['otp'], $mono);                               
                    if ($result == false) {
                        successOrErrorMessage("Wrong OTP", 'error_toast');                    
                    } else {                                                            
                        $res = $this->Login_m->update_otp_verification($mono);
                        if ($res) {
                            successOrErrorMessage("Registration success", 'success_toast');
                            $uid = encrypt_decrypt_custom($result1['id']);                    
                            set_cookie('_xlozgqian', $uid, time() + (10 * 365 * 24 * 60 * 60), '', '/', '', true, true, 'None');
                            return redirect()->to(USER_LOGIN_LINK)->withCookies();
                        }
                    }
                }
            }
            $data['mono'] = $mono;        
            $data['title'] = "OTP Verify";            

            echo single_page('user/otp_verify', $data);
        }
        else
        {
            return redirect()->to(USER_LOGIN_LINK);
        }
    }

    public function forgetpwd()
    {
        if(DOMAIN == 'make10x.games'){
            echo 'Under Maintenance';die;
        }
        helper('form');
        if (isset($_POST['mobileno'])) {            
            $this->validation->setRules([               
                'mobileno' => [
                    'label'  => 'mobileno',
                    'rules'  => 'required|min_length[10]|max_length[10]|numeric',
                    'errors' => [
                        'required' => 'Mobile no is required',
                        'min_length' => 'Mobile no is not valid',
                        'max_length' => 'Mobile no is not valid',
                        'numeric' => 'Mobile no is not valid',
                    ],
                ]                
            ]);
            if (!$this->validation->run($_POST)) {
                $data['errors'] = $this->validation->getErrors();
            } else {                              
                $result = $this->Login_m->exist_user($_POST['mobileno']);                               
                if (isset($result['phone'])) 
                {
                    if(date('Y-m-d') == $result['pwd_date'] && $result['pwd_count'] >= 3)
                    {
                        successOrErrorMessage("Forget Password Limit Over.", 'error_toast');
                        return redirect()->to(USER_LOGIN_LINK);
                    }
                    else
                    {
                        $otp = rand(1000, 9999);                        
                        send_otp($_POST['mobileno'], $otp);
                        send_otp_fast2($_POST['mobileno'], $otp);
                        $params = [];
                        $params['pwd_otp_code'] = $otp;
                        $params['pwd_date'] = date('Y-m-d');
                        $params['pwd_count'] = (isset($result['pwd_count']) && $result['pwd_count'] !='' && date('Y-m-d') == $result['pwd_date'])?($result['pwd_count']+1):1;
                        $res = $this->Login_m->update_user_details($result['phone'],$params);
                        if ($res) {
                            successOrErrorMessage("Forge Password OTP is sent to your mobile successfully.", 'success_toast');
                            return redirect()->to(USER_PWD_OTP_LINK.$result['phone']);
                        }
                    }
                } else {                                                            
                    successOrErrorMessage("Mobile number not exist.", 'error_toast');                    
                }
            }
        }
        $data['title'] = "Forget Password";
        
        echo single_page('user/forget_pwd', $data);
    }

    public function verify_pwd_otp($mono = '')
    {
        $result = $this->Login_m->exist_user($mono);
        if(isset($result['pwd_otp_verify']) && $result['pwd_otp_verify'] == '0' && $result['pwd_otp_code'] != 0)
        {
            helper('form');
            if (isset($_POST['otp'])) {            
                $this->validation->setRules([               
                    'otp' => [
                        'label'  => 'otp',
                        'rules'  => 'required|min_length[4]|max_length[4]|numeric',
                        'errors' => [
                            'required' => 'OTP is required',
                            'min_length' => 'OTP is not valid',
                            'max_length' => 'OTP is not valid',
                            'numeric' => 'OTP is not valid',
                        ],
                    ]                
                ]);
                if (!$this->validation->run($_POST)) {
                    $data['errors'] = $this->validation->getErrors();
                } else {                              
                    $result = $this->Login_m->verify_pwd_otp($_POST['otp'], $mono);                               
                    if ($result == false) {
                        successOrErrorMessage("Wrong OTP", 'error_toast'); 
                        return redirect()->to(USER_PWD_OTP_LINK.$mono);                   
                    } else {                                 
                        $params = [];
                        $params['pwd_request_flag'] = 1; 
                        $params['pwd_otp_verify'] = 1; 
                        $params['pwd_otp_code'] = '';      
                        $params['pwd_count'] = 0;      
                        $params['pwd_date'] = NULL;                                 
                        $res = $this->Login_m->update_user_details($mono,$params);
                        if ($res) {
                            successOrErrorMessage("Password OTP verify successfully", 'success_toast');
                            return redirect()->to(USER_CHANGE_FRGT_PWD_LINK.$mono);
                        }
                    }
                }
            }
            $data['mono'] = $mono;        
            $data['title'] = "OTP Verify";
            echo single_page('user/pwd_otp_verify', $data);
        }
        else
        {
            return redirect()->to(USER_CHANGE_FRGT_PWD_LINK.$mono);
        }
    }

    public function change_frgt_pwd($mono)
    {
        helper('form');
        $result = $this->Login_m->exist_user($mono);
        if(isset($result['pwd_request_flag']) && $result['pwd_request_flag'] == '1')
        {
            if (isset($_POST['new_password']) && isset($_POST['confirm_new_password'])) {
                $this->validation->setRules([
                    'new_password' => [
                        'label'  => 'new_password',
                        'rules'  => 'required',
                        'errors' => [
                            'required' => 'New password is required',
                        ],
                    ],
                    'confirm_new_password' => [
                        'label'  => 'confirm_new_password',
                        'rules'  => 'required',
                        'errors' => [
                            'required' => 'Confirm password is required',
                        ],
                    ],
                ]);
                if (!$this->validation->run($_POST)) {
                    $data['errors'] = $this->validation->getErrors();
                } else {
                    if ($_POST['new_password'] != $_POST['confirm_new_password']) {
                        successOrErrorMessage("New Password and confirm password are not same.", 'error_toast');
                        return redirect()->to(USER_CHANGE_FRGT_PWD_LINK.$mono);
                    } else {
                        $params = [];
                        $params['password'] = sha1(md5($_POST['new_password']));
                        $params['actual_pwd'] = $_POST['new_password'];
                        $params['pwd_request_flag'] = 0;
                        $params['pwd_otp_verify'] = 0;
                        $result = $this->Login_m->update_user_details($mono,$params);
                        successOrErrorMessage("Password changed successfully.", 'success_toast');
                        return redirect()->to(USER_LOGIN_LINK);
                    }
                }
            }
            $data['title'] = "Change Password";
            $data['mono'] = $mono;            
            $page = 'forget_change_pwd';
            if($_SESSION['dashboard'] == 2)
            {
                $page = 'forget_change_pwd2';
            }
            echo single_page('user/forget_change_pwd', $data);
        }
        else
        {
            return redirect()->to(USER_LOGIN_LINK);
        }
    }


    //***************/ Admin related code ***********************//
    public function admin_login()
    {        
        helper('form');
        if (isset($_POST['username']) && isset($_POST['password'])) {
            $this->validation->setRules([
                'username' => [
                    'label'  => 'username',
                    'rules'  => 'required|min_length[10]|max_length[10]|numeric',
                    'errors' => [
                        'required' => 'Mobile no is required',
                        'min_length' => 'Mobile no is not valid',
                        'max_length' => 'Mobile no is not valid',
                        'numeric' => 'Mobile no is not valid',
                    ],
                ],
                'password' => [
                    'label'  => 'password',
                    'rules'  => 'required',
                    'errors' => [
                        'required' => 'Password is required',
                    ],
                ],
            ]);
            if (!$this->validation->run($_POST)) {
                $data['errors'] = $this->validation->getErrors();
            } else {
                $result = $this->Login_m->admin_login($_POST['username'], $_POST['password'], '');
                if ($result) {
                    $uid = encrypt_decrypt_custom($_SESSION['admin']['id']);
                    // $cxrtosdta = encrypt_decrypt_custom($_SESSION['admin']['phone']);                    
                    set_cookie('_xlozgqianA', $uid, time() + (10 * 365 * 24 * 60 * 60), '', '/', '', true, true, 'None');                                          
                    $params = [];
                    $devicedata = md5(uniqid(mt_rand(), true));                                            
                    set_cookie('_devicedataA', $devicedata, time() + (10 * 365 * 24 * 60 * 60), '', '/', '', true, true, 'None');                        
                    $params['devicedata'] = $devicedata;
                    $this->Login_m->update_admin_details($_SESSION['admin']['phone'],$params);
                    return redirect()->to(ADMIN_DASHBOARD_LINK)->withCookies();
                }
            }
        } else {
            if (get_cookie('_xlozgqianA') != '') {
                $user_id = encrypt_decrypt_custom(get_cookie('_xlozgqianA'), 'decrypt');
                if (isset($_POST['username']) && isset($_POST['password'])) {
                    $result = $this->Login_m->admin_login($_POST['username'], $_POST['password'], '');
                } else {
                    $result = $this->Login_m->admin_login('', '', $user_id);
                }
                if ($result) {                    
                    // $cxrtosdta = encrypt_decrypt_custom($_SESSION['admin']['phone']);                    
                    $uid = encrypt_decrypt_custom($_SESSION['admin']['id']);                    
                    set_cookie('_xlozgqianA', $uid, time() + (10 * 365 * 24 * 60 * 60), '', '/', '', true, true, 'None');                    
                    $params = [];                        
                    $devicedata = md5(uniqid(mt_rand(), true));                                            
                    set_cookie('_devicedataA', $devicedata, time() + (10 * 365 * 24 * 60 * 60), '', '/', '', true, true, 'None');                        
                    $params['devicedata'] = $devicedata;
                    $this->Login_m->update_admin_details($_SESSION['admin']['phone'],$params);
                    return redirect()->to(ADMIN_DASHBOARD_LINK)->withCookies();                    
                }
            }
        }
        $data['title'] = "Login";
        echo single_page('admin/login', $data);
    }

    public function admin_logout()
    {        
        $url = ADMIN_LOGIN_LINK;
        delete_cookie('_xlozgqianA');
        delete_cookie('_devicedataA');
        session_destroy();
        return redirect()->to($url)->withCookies();
    }

    public function admin_change_pwd()
    {
        sessionCheckAdmin();
        helper('form');        
        if (isset($_POST['old_password']) && isset($_POST['new_password']) && isset($_POST['confirm_new_password'])) {
            $this->validation->setRules([
                'old_password' => [
                    'label'  => 'old_password',
                    'rules'  => 'required',
                    'errors' => [
                        'required' => 'Old password is required',
                    ],
                ],
                'new_password' => [
                    'label'  => 'new_password',
                    'rules'  => 'required',
                    'errors' => [
                        'required' => 'New password is required',
                    ],
                ],
                'confirm_new_password' => [
                    'label'  => 'confirm_new_password',
                    'rules'  => 'required',
                    'errors' => [
                        'required' => 'Confirm password is required',
                    ],
                ],
            ]);
            if (!$this->validation->run($_POST)) {
                $data['errors'] = $this->validation->getErrors();
            } else {
                $result = $this->Login_m->check_current_password_admin($_POST['old_password']);
                if (!$result) {
                    successOrErrorMessage("Old Password is wrong. Please enter correct password.", 'error_toast');
                    return redirect()->to(ADMIN_CHANGE_PWD_LINK);
                } else if ($_POST['new_password'] == $_POST['old_password']) {
                    successOrErrorMessage("New Password and old password are same. Please use another password.", 'error_toast');
                    return redirect()->to(ADMIN_CHANGE_PWD_LINK);
                } else if ($_POST['new_password'] != $_POST['confirm_new_password']) {
                    successOrErrorMessage("New Password and confirm password are not same.", 'error_toast');
                    return redirect()->to(ADMIN_CHANGE_PWD_LINK);
                } else {
                    $result = $this->Login_m->update_password_admin(array("user_new_password" => $_POST['new_password']));
                    successOrErrorMessage("Password changed successfully.", 'success_toast');
                    return redirect()->to(ADMIN_CHANGE_PWD_LINK);
                }
            }
        }
        if (isset($_POST['setting_old_password']) && isset($_POST['setting_new_password']) && isset($_POST['setting_confirm_new_password']) && isset($_POST['change_setting_password'])) {
            $this->validation->setRules([
                'setting_old_password' => [
                    'label'  => 'setting_old_password',
                    'rules'  => 'required',
                    'errors' => [
                        'required' => 'Old password is required',
                    ],
                ],
                'setting_new_password' => [
                    'label'  => 'setting_new_password',
                    'rules'  => 'required',
                    'errors' => [
                        'required' => 'New password is required',
                    ],
                ],
                'setting_confirm_new_password' => [
                    'label'  => 'setting_confirm_new_password',
                    'rules'  => 'required',
                    'errors' => [
                        'required' => 'Confirm password is required',
                    ],
                ],
            ]);
            if (!$this->validation->run($_POST)) {
                $data['errors'] = $this->validation->getErrors();
            } else {
                $_POST['change_setting_password'] = $_POST['setting_old_password'];
                $result = $this->Login_m->check_setting_password_admin($_POST['setting_old_password']);
                if (!$result) {
                    successOrErrorMessage("Old Password is wrong. Please enter correct password.", 'error_toast');
                    return redirect()->to(ADMIN_CHANGE_PWD_LINK);
                } else if ($_POST['setting_new_password'] == $_POST['setting_old_password']) {
                    successOrErrorMessage("New Password and old password are same. Please use another password.", 'error_toast');
                    return redirect()->to(ADMIN_CHANGE_PWD_LINK);
                } else if ($_POST['setting_new_password'] != $_POST['setting_confirm_new_password']) {
                    successOrErrorMessage("New Password and confirm password are not same.", 'error_toast');
                    return redirect()->to(ADMIN_CHANGE_PWD_LINK);
                } else {
                    $result = $this->Login_m->update_setting_password_admin(array("new_setting_password" => $_POST['setting_new_password']));
                    successOrErrorMessage("Password changed successfully.", 'success_toast');
                    return redirect()->to(ADMIN_CHANGE_PWD_LINK);
                }
            }
        }
        $data['title'] = "Change Password";
        $_SESSION['form_token'] = bin2hex(random_bytes(16));       
        echo load_view('admin', 'admin/change_pwd', $data);
    }
}
