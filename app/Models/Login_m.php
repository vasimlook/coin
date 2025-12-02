<?php
// echo $this->db->getLastQuery();die;
namespace App\Models;
use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Model;

class Login_m extends Model
{

    protected $db;
    protected $session;

    public function __construct()
    {
        $this->session = session();
        $this->db = db_connect();
        helper('functions');
    }
    public function login($username = '', $password = '', $user_id = '')
    {
        if ($user_id != '' && $username == '' && $password == '') {
            $builder = $this->db->table('users');
            $builder->select('*');
            $builder->where('id', $user_id);
            $builder->where('status', 1);
            $builder->where('otp_verify', 1);
            $res_data = $builder->get()->getRowArray();
        }
        if ($user_id == '' && $username != '' && $password != '') {
            $password = md5($password);
            $password = sha1($password);

            $builder = $this->db->table('users');
            $builder->select('*');
            $builder->where('phone', $username);
            $builder->where('password', $password);
            $builder->where('status', 1);
            $builder->where('otp_verify', 1);
            $res_data = $builder->get()->getRowArray();
        }
        if (isset($res_data)) {
            if (($user_id != '' && $username == '' && $password == '') || ($username == $res_data['phone'] && $password == $res_data['password'])) {
                $user_data = sessionUser($res_data);
                $this->session->set($user_data);
                return true;
            }            
        }
        delete_cookie('_xlozgqian');
        successOrErrorMessage("Invalid Username & Password", 'error_toast');
        return false;
    }

    public function admin_login($username = '', $password = '', $user_id = '')
    {
        if ($user_id != '' && $username == '' && $password == '') {
            $builder = $this->db->table('admin');
            $builder->select('*');
            $builder->where('id', $user_id);
            $builder->where('status', 1);            
            $res_data = $builder->get()->getRowArray();
        }
        if ($user_id == '' && $username != '' && $password != '') {
            $password = md5($password);
            $password = sha1($password);

            $builder = $this->db->table('admin');
            $builder->select('*');
            $builder->where('phone', $username);
            $builder->where('password', $password);
            $builder->where('status', 1);            
            $res_data = $builder->get()->getRowArray();
        }
        if (isset($res_data)) {
            if (($user_id != '' && $username == '' && $password == '') || ($username == $res_data['phone'] && $password == $res_data['password'])) {
                $user_data = sessionAdmin($res_data);
                $this->session->set($user_data);
                return true;
            }            
        }
        delete_cookie('_xlozgqianA');
        successOrErrorMessage("Invalid Username & Password", 'error_toast');
        return false;
    }

    public function update_user_details($mono,$params)
    {    
        $builder = $this->db->table('users');
        $builder->where('phone', $mono);
        return $builder->update($params);        
    }
    
    public function update_user($params = [], $id = 0)
    {
        $builder = $this->db->table('users');
        $builder->where('id', $id);
        return $builder->update($params);
    }

    public function update_admin_details($mono,$params)
    {    
        $builder = $this->db->table('admin');
        $builder->where('phone', $mono);
        return $builder->update($params);        
    }

    public function check_current_password_admin($current_password = '')
    {
        $current_password = md5($current_password);
        $current_password = sha1($current_password);
        $id = $_SESSION['admin']['id'];
        $builder = $this->db->table('admin');
        $builder->select('password');
        $builder->where('id', $id);
        $builder->where('password', $current_password);        
        $row = $builder->get()->getRowArray();        
        if (isset($row)) {
            if ($current_password == $row['password']) {
                return true; //matched
            }
        }
        return false; //not matched
    }

    public function check_current_password($current_password = '')
    {
        $current_password = md5($current_password);
        $current_password = sha1($current_password);
        $id = $_SESSION['user']['id'];
        $builder = $this->db->table('users');
        $builder->select('password');
        $builder->where('id', $id);
        $builder->where('password', $current_password);        
        $row = $builder->get()->getRowArray();        
        if (isset($row)) {
            if ($current_password == $row['password']) {
                return true; //matched
            }
        }
        return false; //not matched
    }

    public function update_password($params = [])
    {
        $new_password = md5($params['user_new_password']);
        $new_password = sha1($new_password);
        $id = $_SESSION['user']['id'];
        $params = [
            'password' => $new_password,
            'actual_pwd' => $params['user_new_password']
        ];
        $builder = $this->db->table('users');
        $builder->where('id', $id);
        return $builder->update($params);
    }

    public function update_password_admin($params = [])
    {
        $new_password = md5($params['user_new_password']);
        $new_password = sha1($new_password);
        $id = $_SESSION['admin']['id'];
        $params = [
            'password' => $new_password
        ];
        $builder = $this->db->table('admin');
        $builder->where('id', $id);
        return $builder->update($params);
    }

    public function exist_user($usrername = '')
    {
        $builder = $this->db->table('users');
        $builder->select('*');
        $builder->where('phone', $usrername);
        $row = $builder->get()->getRowArray();        
        return $row;
    }
    public function get_user_info_by_id($id = '')
    {
        $builder = $this->db->table('users');
        $builder->select('*');
        $builder->where('id', $id);
        $row = $builder->get()->getRowArray();        
        return $row;
    }

    public function verify_otp($otp = '', $mono = '')
    {        
        $builder = $this->db->table('users');
        $builder->select('*');
        $builder->where('phone', $mono);
        $builder->where('otp', $otp);
        $builder->where('otp_verify', 0);
        $row = $builder->get()->getRowArray();        
        if (!empty($row)) {
            return true;
        }
        return false;
    }

    public function registration($params = [])
    {
        $builder = $this->db->table('users');
        $builder->insert($params);
        return $this->db->insertID();
    }

    public function verify_pwd_otp($otp = '', $mono = '')
    {        
        $builder = $this->db->table('users');
        $builder->select('*');
        $builder->where('phone', $mono);
        $builder->where('pwd_otp_code', $otp);
        $builder->where('pwd_otp_verify', 0);
        $row = $builder->get()->getRowArray();        
        if (!empty($row)) {
            return true;
        }
        return false;
    }

    public function update_otp_verification($mono = '')
    {    
        $params = [];
        $params['otp_verify'] = 1; 
        $params['otp'] = '';      
        $params['otp_count'] = 0;      
        $params['otp_date'] = NULL;      
        $builder = $this->db->table('users');
        $builder->where('phone', $mono);
        return $builder->update($params);        
    } 
    

    public function login_log($params = [])
    {
        $builder = $this->db->table('login_attempt');
        $builder->insert($params);        
        return true;
    }

    public function get_admin_detail($id = 0)
    {
        $builder = $this->db->table('admin');
        $builder->select('*');
        $builder->where('id', $id);
        $row = $builder->get()->getRowArray();
        if (!empty($row)) {
            return $row;
        }
        return false;
    }
    function update_table_data($where,$table,$params)
    {
        $builder = $this->db->table($table);
        $builder->where($where);
        return $builder->update($params);
    }
    function insert_table_data($table,$params)
    {
        $builder = $this->db->table($table);
        return $builder->insert($params);
    }
    function get_table_data($where = [],$table = '')
    {
        $builder = $this->db->table($table);
        if(!empty($where))
        {
            $builder->where($where);
        }
        $query = $builder->get();
        return $query->getResultArray();
    }
    
}
