<?php
// echo $this->db->getLastQuery();die; 
namespace App\Models;

use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Model;

class User_m extends Model
{
    protected $db;
    protected $session;
    public function __construct()
    {
        $this->session = session();
        $this->db = db_connect();
        helper('functions');
    }
    public function get_user_info($user_id = 0)
    {
        $builder = $this->db->table('users');
        $builder->select('*');
        $builder->where('id', $user_id);
        $row = $builder->get()->getRowArray();
        return $row;
    }
    public function get_all_user()
    {
        $builder = $this->db->table('users');
        $builder->select('*');
        $builder->where('status', 1);
        $row = $builder->get()->getResultArray();
        return $row;
    }
    public function update_user($params = [], $id = 0)
    {
        $builder = $this->db->table('users');
        $builder->where('id', $id);
        return $builder->update($params);
    }

    public function is_user_phone_no_exist_exepct_id($phone = 0, $user_id = 0)
    {
        $builder = $this->db->table('users');
        $builder->select('*');
        $builder->where('phone', $phone);
        $builder->where('id !=', $user_id);
        $query = $builder->get();
        return $query->getRowArray();
    }

    public function get_setting($id = 1)
    {
        $builder = $this->db->table('setting');
        $builder->where('id', $id);
        return $builder->get()->getRowArray();
    }

    public function get_sum_amount($table,$select = '', $where = '',$sum = '',$count = 0)
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
