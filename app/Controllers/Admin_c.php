<?php
namespace App\Controllers;
use App\Models\Admin_m;
use App\Models\Datatable_m;

use CodeIgniter\Cookie\Cookie;
use CodeIgniter\Cookie\CookieStore;
use Config\Services;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Models\Login_m;
class Admin_c extends BaseController
{
    private $security;
    protected $session;
    private $Admin_m;
    private $Datatable_m;
    protected $validation;
    private $Login_m;
    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->session->start();
        helper('url');
        helper('functions');
        helper('cookie');
        sessionCheckAdmin();
        $this->security = \Config\Services::security();
        helper('security');
        $this->validation = \Config\Services::validation();
        $this->Admin_m = new Admin_m();
        $this->Datatable_m = new Datatable_m();
        $this->Login_m = new Login_m();
        $setting_info = $this->Admin_m->get_setting();
        $this->session->set($setting_info);
    }
    
    public function index()
    {
        $data['title'] = ADMIN_DASHBOARD_TITLE;

        $data['earning_coin'] = $this->Admin_m->get_sum_amount('t_coin_request','earning_amount',['status' => '2'],1,0);
        $data['pending_earning_coin'] = $this->Admin_m->get_sum_amount('t_coin_request','earning_amount',['status' => '1'],1,0);
        $data['first_level_commission'] = $this->Admin_m->get_sum_amount('t_coin_request','level_1_commission',['status' => '2'],1,0);
        $data['second_level_commission'] = $this->Admin_m->get_sum_amount('t_coin_request','level_2_commission',['status' => '2'],1,0);
        $data['pending_first_level_commission'] = $this->Admin_m->get_sum_amount('t_coin_request','level_1_commission',['status' => '1'],1,0);
        $data['pending_second_level_commission'] = $this->Admin_m->get_sum_amount('t_coin_request','level_2_commission',['status' => '1'],1,0);
        $data['active_user_count'] = $this->Admin_m->get_sum_amount('users','id',['status' => 0],0,1);
        $data['inactive_user_count'] = $this->Admin_m->get_sum_amount('users','id',['status' => 1],0,1);


        echo load_view('admin', 'admin/dashboard', $data);
    }

    public function user_list($user_type = 'User')
    {
        $data['title'] = ADMIN_USER_LIST_TITLE;
        $data['user_type'] = $user_type;
        echo load_view('admin', 'admin/user_list', $data);
    }
    public function user_list_ajax()
    {
        $table = 'users';
        $list = $this->Datatable_m->get_datatables($table, [null,'users.name','users.phone'], ['users.name','users.phone'], ['users.id' => 'desc'], 'user_list_ajax_admin');
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $datarow) {
            $check_status = "";
            $action = "";
            if ($datarow->status == 1) {
                $check_status = 'checked';
            }
            $action = "
            <a href='".ADMIN_USER_EDIT_LINK.'/'.$datarow->id."' class='btn btn-xs text-white bg-dark'>Edit&nbsp;<em class='icon ni ni-edit'></em></a> "; 
            
            $status = '<div class="custom-control custom-switch">
                <input type="checkbox" name="status" class="custom-control-input" onclick="update_status('.$datarow->id.')" id="status_'.$datarow->id.'" '.$check_status.' value="'.$datarow->id.'">
                <label class="custom-control-label" for="status_'.$datarow->id.'"></label>
            </div>';

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = '<a href="' . ADMIN_USER_PROFILE_LINK . $datarow->id . '/user" ">' . split_string_by_space_or_position($datarow->name,10) . '</a>';
            $row[] = '<a href="' . ADMIN_USER_PROFILE_LINK . $datarow->id . '/user" ">' . $datarow->phone . '</a>';               
            $row[] = $datarow->actual_pwd;                      
            $row[] = $datarow->otp;                    
            $row[] = date('d-M h:i A', strtotime($datarow->created_at));                    
            $row[] = $status;                      
            $row[] = $action;                               
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Datatable_m->count_all($table),
            "recordsFiltered" => $this->Datatable_m->count_filtered($table, [null,'users.name','users.phone'], ['users.name','users.phone'], ['users.id' => 'desc'], 'user_list_ajax_admin'),
            "data" => $data,
            "csrf" => csrf_hash(),
        );
        echo json_encode($output);
    }
    public function user_update_status()
    {
        $id = $_POST['id'];
        $status = $_POST['status'];
        echo $this->Admin_m->update_user(['status'=>$status],$id);
    }

    public function create_user()
    {
        helper('form');
        if (isset($_POST['submit'])) {
            $token = $_POST['form_token'] ?? null;
            if ($token && $_SESSION['form_token'] === $token) {                       
                $_SESSION['form_token'] = null; 
                $this->validation->setRules([
                    'name' => [
                        'label'  => 'name|max_length[3]',
                        'rules'  => 'required',
                        'errors' => [
                            'required' => 'Admin name is required',
                            'max_length' => 'Enter valid admin name',
                        ],
                    ],
                    'phone' => [
                        'label'  => 'phone',
                        'rules'  => 'required|numeric|max_length[10]|min_length[10]',
                        'errors' => [
                            'required' => 'Phone number is required',
                            'numeric' => 'Enter valid Phone number',
                            'max_length' => 'Enter valid Phone number',
                            'min_length' => 'Enter valid Phone number',
                        ],
                    ],
                ]);
                if (!$this->validation->run($_POST)) {
                    $data['errors'] = $this->validation->getErrors();
                } else {
                    $exist_phone = $this->Admin_m->get_user_info_by_phone($_POST['phone']);
                    $password = md5('123');
                    $new_password = sha1($password);
                    if (empty($exist_phone)) {
                        $params = [
                            'name' => $_POST['name'],
                            'phone' => $_POST['phone'],
                            'status' => '1',
                            'password' => $new_password,
                            'otp_verify' => 1,
                            'is_system_user' => isset($_POST['is_system_user']) && $_POST['is_system_user'] == 1 ? 1 : 0,
                            'created_at' => date('Y-m-d h:i:s'),
                        ];
                        $id = $this->Admin_m->create_user($params);
                        successOrErrorMessage("User created successfully", 'success_toast');
                        // create_log($_SESSION['admin']['id'],'admin','Add User by Admin','add_user');
                        return redirect()->to(ADMIN_USER_LIST_LINK);
                    } else {
                        successOrErrorMessage("Phone number must be unique", 'error_toast');
                    }
                }
            }
        }
        $_SESSION['form_token'] = bin2hex(random_bytes(16));
        $data['title'] = ADMIN_USER_ADD_TITLE;
        echo load_view('admin', 'admin/add_user', $data);
    }

    public function edit_user($user_id)
    {
        helper('form');
        if (isset($_POST['submit'])) {
            $token = $_POST['form_token'] ?? null;
            if ($token && $_SESSION['form_token'] === $token) {                       
                $_SESSION['form_token'] = null; 
                $this->validation->setRules([
                    'name' => [
                        'label'  => 'name|max_length[3]',
                        'rules'  => 'required',
                        'errors' => [
                            'required' => 'Admin name is required',
                            'max_length' => 'Enter valid admin name',
                        ],
                    ],
                    'phone' => [
                        'label'  => 'phone',
                        'rules'  => 'required|numeric|max_length[10]|min_length[10]',
                        'errors' => [
                            'required' => 'Phone number is required',
                            'numeric' => 'Enter valid Phone number',
                            'max_length' => 'Enter valid Phone number',
                            'min_length' => 'Enter valid Phone number',
                        ],
                    ],
                ]);
                if (!$this->validation->run($_POST)) {
                    $data['errors'] = $this->validation->getErrors();
                } else {
                    $exist_phone = $this->Admin_m->is_user_phone_no_exist_exepct_id($_POST['phone'],$user_id);
                    if (empty($exist_phone)) {
                        $params = [
                            'name' => $_POST['name'],
                            'phone' => $_POST['phone'],
                            'is_system_user' => isset($_POST['is_system_user']) && $_POST['is_system_user'] == 1 ? 1 : 0
                        ];
                        if(isset($_POST['password']) && !empty($_POST['password']))
                        {
                            $params['password'] = sha1(md5($_POST['password']));
                            $params['actual_pwd'] = $_POST['password'];
                        }
                        $this->Admin_m->update_user($params, $user_id);
                        
                        successOrErrorMessage("edited successfully", 'success_toast');
                        // create_log($_SESSION['admin']['id'],'admin','Upadted User By Admin','update_user');
                        return redirect()->to(ADMIN_USER_LIST_LINK);
                    } else {
                        successOrErrorMessage("Phone number must be unique", 'error_toast');
                    }
                }
            }
        }
        $_SESSION['form_token'] = bin2hex(random_bytes(16));
        $data['title'] = ADMIN_USER_EDIT_TITLE;
        $data['user_data'] = $this->Admin_m->get_user_info($user_id);
        echo load_view('admin', 'admin/edit_user', $data);
    }    

    public function user_profile($user_id = 0,$user_type = '')
    {
        helper('form');
        $_SESSION['form_token'] = bin2hex(random_bytes(16));
        $data['title'] = ADMIN_USER_PROFILE_TITLE;
        $data['user_id'] = $user_id;
        $data['user_type'] = $user_type;
        $data['user_info'] = $this->Admin_m->get_user_info($user_id,$user_type);
        echo load_view('admin', 'admin/user_profile', $data);
    }
    public function admin_setting()
    {
        helper('form');
        if (isset($_POST['submit'])) {
            if($_POST['earning_pr'] < 0 || $_POST['earning_pr'] > 100 || !is_numeric($_POST['earning_pr']) || $_POST['first_level_commission'] < 0 || $_POST['first_level_commission'] > 100 || !is_numeric($_POST['first_level_commission']) || $_POST['second_level_commission'] < 0 || $_POST['second_level_commission'] > 100 || !is_numeric($_POST['second_level_commission'])){
                successOrErrorMessage("Percentage value must be greater than or equal to 0", 'error_toast'); 
                return redirect()->to(ADMIN_SETTINGS_LINK);
            }
            $params = [];           
            $params['first_level_commission'] = (isset($_POST['first_level_commission'])) ? $_POST['first_level_commission'] : 10;
            $params['second_level_commission'] = (isset($_POST['second_level_commission'])) ? $_POST['second_level_commission'] : 0;
            $params['earning_pr'] = (isset($_POST['earning_pr'])) ? $_POST['earning_pr'] : 0;
            $res = $this->Admin_m->update_settings($params);            
            successOrErrorMessage("Details updated successfully", 'success_toast'); 
            return redirect()->to(ADMIN_SETTINGS_LINK);

        }

        $_SESSION['form_token'] = bin2hex(random_bytes(16));
        $data['setting'] = $this->Admin_m->get_setting();
        $data['title'] = ADMIN_SETTINGS_TITLE;
        echo load_view('admin', 'admin/settings', $data);
    }
    public function coin_list()
    {
        $data['title'] = ADMIN_COIN_LIST_TITLE;
        echo load_view('admin', 'admin/coin_list', $data);
    }
    public function accept_reject_coin($id = 0,$status = 0)
    {
        $get_transfer_history = $this->Admin_m->get_table_data(['id'=>$id],'t_coin_request');
        
        if(!empty($get_transfer_history) && $get_transfer_history[0]['status'] == 1 )
        {
            $get_user_details = $this->Admin_m->get_table_data(['id'=>$get_transfer_history[0]['buyer_id']],'users');
            
            $first_level_commission = (!empty($_SESSION['first_level_commission'])) ? ($get_transfer_history[0]['amount']/100)*$_SESSION['first_level_commission'] : 0;
            $second_level_commission = (!empty($_SESSION['second_level_commission'])) ? ($get_transfer_history[0]['amount']/100)*$_SESSION['second_level_commission'] : 0;
            
            $earning_amount = (!empty($_SESSION['earning_pr'])) ? ($get_transfer_history[0]['amount']/100)*$_SESSION['earning_pr']:0; 
            $params = [];
            $params['status'] = $status;
            $params['earning_amount'] = $earning_amount;
            $params['level_1_commission'] = $first_level_commission;
            $params['level_2_commission'] = $second_level_commission;
            $params['level_1_id'] = $get_user_details[0]['level1'];
            $params['level_2_id'] = $get_user_details[0]['level2'];
            
            $this->Admin_m->update_table_data(['id'=>$id],'t_coin_request',$params);
            if($status == 2)
            {
                $amount = $get_transfer_history[0]['amount'] + $earning_amount;
                $this->Admin_m->update_wallet($get_transfer_history[0]['buyer_id'], $amount, 1,'balance');
    
                if($first_level_commission > 0 && $get_user_details[0]['level1'] > 0)
                {
                    $this->Admin_m->update_wallet($get_user_details[0]['level1'], $first_level_commission, 1,'balance');
                }
                if($second_level_commission > 0 && $get_user_details[0]['level2'] > 0)
                {
                    $this->Admin_m->update_wallet($get_user_details[0]['level2'], $second_level_commission, 1,'balance');
                }
            }
            else if($status == 3)
            {
                $total_amount = $get_transfer_history[0]['amount'];
                $this->Admin_m->update_wallet($get_transfer_history[0]['seller_id'], $total_amount, 1,'balance');
            }
            $accept_relect = ($status == 2) ? 'Accepted' : 'Rejected';
            successOrErrorMessage("Coin {$accept_relect} Successfully", 'success_toast');
        }
        else
        {
            successOrErrorMessage("Somthing happen wrong", 'error_toast');
        }
        return redirect()->to(ADMIN_COIN_LINK);
    }
    public function coin_list_ajax()
    {
        $table = 't_coin_request';
        $list = $this->Datatable_m->get_datatables($table, [null, 't_coin_request.amount', 't_coin_request.screen_shot', 't_coin_request.status', 't_coin_request.created_at', 'u.phone', 'u.name'], ['t_coin_request.amount', 't_coin_request.screen_shot', 't_coin_request.status', 't_coin_request.created_at', 'u.phone', 'u.name','admin.name'], ['t_coin_request.id' => 'desc'], 'coin_list_ajax_admin');
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $datarow) {
            $status = "";
            $action = "";
            if ($datarow->status == 2) {
                $status = '<span class="badge bg-success">Accepted</span>';
            }
            if ($datarow->status == 3) {
                $status = '<span class="badge bg-danger">Rejected</span>';
            }
            if ($datarow->status == 1) {
                $status = '<span class="badge bg-warning">Pending</span>';
                $action = "<a href='".ADMIN_COIN_ACCEPT_LINK.$datarow->id.'/2'."' class='btn btn-xs text-light bg-success text-light'>Accept&nbsp;<em class='icon ni ni-check'></em></a>&nbsp;&nbsp;<a href='".ADMIN_COIN_ACCEPT_LINK.$datarow->id.'/3'."' class='btn btn-xs text-light bg-danger text-light'>Reject&nbsp;<em class='icon ni ni-check'></em></a>";
            }

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = "Name :".$datarow->buyer_name."<br>Phone:".$datarow->buyer_phone;
            $row[] = "Name :".$datarow->seller_name."<br>Phone:".$datarow->seller_phone;
            $row[] = "<div class='img-box'><img src='".BASE_URL."/uploads/screenshot/".$datarow->screenshot."' width='50' height='50' class='zoom-img' /> <button class='view-btn'>View</button> </div>";
            $row[] = (!empty($_SESSION['earning_pr'])) ? $datarow->amount + (($datarow->amount/100)*$_SESSION['earning_pr']):$datarow->amount;
            $row[] = date('d-M h:i A', strtotime($datarow->created_at));                       
            $row[] = $status;
            $row[] = $action; 
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Datatable_m->count_all($table),
            "recordsFiltered" => $this->Datatable_m->count_filtered($table, [null, 't_coin_request.amount', 't_coin_request.screen_shot', 't_coin_request.status', 't_coin_request.created_at', 'u.phone', 'u.name'], ['t_coin_request.amount', 't_coin_request.screen_shot', 't_coin_request.status', 't_coin_request.created_at', 'u.phone', 'u.name','admin.name'], ['t_coin_request.id' => 'desc'], 'coin_list_ajax_admin'),
            "data" => $data,
            "csrf" => csrf_hash(),
        );
        echo json_encode($output);
    }

    public function release_coin()
    {
        helper('form');
        if (isset($_POST['submit'])) {
            $token = $_POST['form_token'] ?? null;
            if ($token && $_SESSION['form_token'] === $token) {                       
                $_SESSION['form_token'] = null;
                $amount = $_POST['amount'];
                $total_user = count($_POST['user_id']); 
                if($total_user > 0 && $amount > 0)
                {
                    $per_user_amount = floor($amount / $total_user);
                    foreach($_POST['user_id'] as $user_id)
                    {
                        $this->Admin_m->update_wallet($user_id, $per_user_amount, 1,'balance');
                    }
                }               
                successOrErrorMessage("edited successfully", 'success_toast');
            }
        }
        $_SESSION['form_token'] = bin2hex(random_bytes(16));
        $data['title'] = ADMIN_USER_EDIT_TITLE;
        $data['user_data'] = $this->Admin_m->get_table_data(['is_system_user'=>1],'users');
        echo load_view('admin', 'admin/coin_release', $data);
    }
}
