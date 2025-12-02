<?php
// echo $this->db->getLastQuery();die;
namespace App\Models;
use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Model;

class Admin_m extends Model
{
    protected $db;
    protected $session;
    public function __construct()
    {
        $this->session = session();
        $this->db = db_connect();
        helper('functions');
    }

    public function update_admin($params = [], $id = 0)
    {
        $builder = $this->db->table('admin');
        $builder->where('id', $id);
        return $builder->update($params);
    }
    
    public function update_user($params = [], $id = 0)
    {
        $builder = $this->db->table('users');
        $builder->where('id', $id);
        return $builder->update($params);
    }

    public function get_user_info($user_id = 0)
    {
        $builder = $this->db->table('users');        
        $builder->where('id', $user_id);
        $query = $builder->get();
        return $query->getRowArray();
    }

    public function get_user_info_by_phone($phone = 0)
    {
        $builder = $this->db->table('users');
        $builder->select('*');
        $builder->where('phone', $phone);
        $query = $builder->get();
        return $query->getRowArray();
    }
    
    public function create_user($params = [])
    {
        $builder = $this->db->table('users');
        $builder->insert($params);
        $insert_id = $this->db->insertID();
        return $insert_id;
    }

    public function is_user_phone_no_exist_exepct_id($phone = 0,$user_id = 0)
    {
        $builder = $this->db->table('users');
        $builder->select('*');
        $builder->where('phone', $phone);       
        $builder->where('id !=', $user_id);       
        $query = $builder->get();
        return $query->getRowArray();
    }
    public function update_settings($params = [], $id = 1)
    {
        $builder = $this->db->table('setting');
        $builder->where('id', $id);
        return $builder->update($params);
    }

    public function get_setting($id = 1)
    {
        $builder = $this->db->table('setting');
        $builder->where('id', $id);
        return $builder->get()->getRowArray();
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
    public function update_wallet($id = 0, $amount = 0, $add = 0, $column = 'amount')
    {
        $builder = $this->db->table('users');
        $builder->where('id', $id);
        if ($add == 1) {
            $builder->set("$column", "$column + $amount", false);
        } else {
            $builder->set("$column", "$column - $amount", false);
        }

        return $builder->update();
    }
    public function get_sum_amount($table,$select = '', $where,$sum = '',$count)
    {
        $builder = $this->db->table($table);
        if(!empty($sum)) {
            $builder->select("SUM($select) as total");
        } else if(!empty($count)) {
            $builder->select("COUNT($select) as total");
        }
        if (!empty($where)) {
            $builder->where($where);
        }
        $query = $builder->get();
        $row = $query->getRowArray();
        return $row['total'];
    }
}
