<?php

namespace App\Controllers;

use App\Models\User_m;
use App\Models\Common_m;
use App\Models\Login_m;
use App\Models\Datatable_m;

use CodeIgniter\Cookie\Cookie;
use CodeIgniter\Cookie\CookieStore;
use Config\Services;

class User_c extends BaseController
{
    private $security;
    protected $session;
    private $User_m;
    private $Common_m;
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
        $this->validation = \Config\Services::validation();
        sessionCheckUser();
        $this->User_m = new User_m();
        $this->Common_m = new Common_m();
        $user_info = $this->User_m->get_user_info($_SESSION['user']['id']);
        $setting_info = $this->User_m->get_setting();
        $this->session->set($setting_info);
        if (!empty($user_info)) {
            if (isset($_COOKIE['_devicedata']) && get_cookie('_devicedata') != '' && $user_info['devicedata'] == get_cookie('_devicedata')) {
            } else {
                logout_wrong_url();
            }
            $user_data = sessionUser($user_info);
            $this->session->set($user_data);
        } else {
            $_SESSION['balance'] = formatToTwoDecimalPlaces(0);
        }
    }
    
    public function index()
    {
        $_SESSION['form_token'] = bin2hex(random_bytes(16));
        $data['allUser'] = $this->User_m->get_all_user();
        $data['earning_coin'] = $this->User_m->get_sum_amount('t_coin_request','earning_amount',['seller_id' => $_SESSION['user']['id'],'status' => '2'],1,0);
        $data['first_level_commission'] = $this->User_m->get_sum_amount('t_coin_request','level_1_commission',['level_1_id' => $_SESSION['user']['id'],'status' => '2'],1,0);
        $data['second_level_commission'] = $this->User_m->get_sum_amount('t_coin_request','level_2_commission',['level_2_id' => $_SESSION['user']['id'],'status' => '2'],1,0);
        $data['level_1_user_count'] = $this->User_m->get_sum_amount('users','id',['level1' => $_SESSION['user']['id']],0,1);
        $data['level_2_user_count'] = $this->User_m->get_sum_amount('users','id',['level2' => $_SESSION['user']['id']],0,1);
        $data['title'] = USER_DASHBOARD_TITLE;
        echo load_view('user', 'user/dashboard', $data);
    } 

    public function bank_details()
    {
        helper('form');
        if (isset($_POST['submit'])) {
            $token = $_POST['form_token'] ?? null;
            if ($token && $_SESSION['form_token'] === $token) {                       
                $_SESSION['form_token'] = null; 
                $this->validation->setRules([
                    'bank_name' => [
                        'label'  => 'bank name',
                        'rules'  => 'permit_empty|alpha_numeric_space',
                        'errors' => [
                            'permit_empty|alpha_numeric_space' => 'Enter valid bank name',
                        ],
                    ],
                    'bank_holder_name' => [
                        'label'  => 'bank holder name',
                        'rules'  => 'permit_empty|alpha_numeric_space',
                        'errors' => [
                            'permit_empty|alpha_numeric_space' => 'Enter valid bank holder name',
                        ],
                    ],
                    'ifsc_code' => [
                        'label'  => 'IFSC Code',
                        'rules'  => 'permit_empty|alpha_numeric_space',
                        'errors' => [
                            'permit_empty|alpha_numeric_space' => 'Enter valid IFSC Code',
                        ],
                    ],
                    'acc_no' => [
                        'label'  => 'Account No',
                        'rules'  => 'permit_empty|alpha_numeric_space',
                        'errors' => [
                            'permit_empty|alpha_numeric_space' => 'Enter valid Account No',
                        ],
                    ],
                    'upi_id' => [
                        'label'  => 'UPI Id',
                        'rules'  => 'permit_empty',
                        'errors' => [
                            'permit_empty' => 'Enter valid UPI Id',
                        ],
                    ]
                ]);
                if (!$this->validation->run($_POST)) {
                    $data['errors'] = $this->validation->getErrors();
                } else {
                    $params = array();
                    $params['bank_name'] = $_POST['bank_name'];
                    $params['bank_holder_name'] = $_POST['bank_holder_name'];
                    $params['ifsc_code'] = $_POST['ifsc_code'];
                    $params['acc_no'] = $_POST['acc_no'];
                    $params['upi_id'] = $_POST['upi_id'];
                    $params['p_pay'] = !empty($_POST['p_pay']) ?$_POST['p_pay'] : '';
                    $params['g_pay'] = !empty($_POST['g_pay']) ?$_POST['g_pay'] : '';
                    $params['paytm_pay'] = !empty($_POST['paytm_pay']) ?$_POST['paytm_pay'] : '';
                    $res = $this->User_m->update_user($params, $_SESSION['user']['id']);
                    if ($res) {
                        successOrErrorMessage("Bank details updated Success", 'success_toast');
                    } else {
                        successOrErrorMessage("Somthing happen wrong", 'error_toast');
                    }
                }
            }
        }
        $_SESSION['form_token'] = bin2hex(random_bytes(16));
        $bank_details = $this->User_m->get_user_info($_SESSION['user']['id']);
        $data['bank_details'] = $bank_details;
        $data['title'] = BANK_DETAILS_TITLE;
        echo load_view('user', 'user/bankdetails', $data);
    }

    public function buy_coin()
    {
        $file = $this->request->getFile('screenshot');
        // ---- VALIDATION ----
        if (!$file || !$file->isValid()) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'No file uploaded or file is invalid.'
            ]);
        }

        // Size limit (2MB)
        if ($file->getSize() > 2 * 1024 * 1024) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'File size must be less than 2MB.'
            ]);
        }

        // Allowed formats
        $allowedTypes = ['jpg', 'jpeg', 'png', 'webp'];

        if (!in_array($file->getExtension(), $allowedTypes)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Only JPG, JPEG, PNG or WEBP allowed.'
            ]);
        }

        // Validate MIME
        $validMime = ['image/jpeg', 'image/png', 'image/webp'];

        if (!in_array($file->getMimeType(), $validMime)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Invalid image file type.'
            ]);
        }

        // Validate image is real (NOT corrupted)
        if (@getimagesize($file->getTempName()) === false) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'The file is not a valid image.'
            ]);
        }

        // ---- File Passed Validation ----
        $newName = time() . '.' . $file->getExtension();
        $file->move(ROOTPATH . 'uploads/screenshot', $newName);

        // Continue Your DB Logic...
        // ---------------------------------------------------
        $buyerID  = session('user.id');
        $sellerID = $this->request->getPost('user_id');
        $amount   = $this->request->getPost('balance');

        $params = [
            'buyer_id' => $buyerID,
            'seller_id' => $sellerID,
            'amount' => $amount,
            'screenshot' => $newName,
            'status' => 1
        ];

        $this->Common_m->insert_table_data('t_coin_request', $params);

        $this->Common_m->update_wallet($sellerID, $amount, 0, 'balance');

        successOrErrorMessage("Payment submitted successfully.", 'success_toast');
        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Screenshot uploaded successfully.'
        ]);
    }
}
