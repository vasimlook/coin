<?php
// echo $this->db->getLastQuery();die; 
namespace App\Models;

use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Model;
use Mpdf\Tag\Em;

class Common_m extends Model
{
    protected $db;
    protected $session;
    public function __construct()
    {
        $this->session = session();
        $this->db = db_connect();
        helper('functions');
    }

    //* Datatable withdrawal list START
    public function _get_datatables_query($builder, $column_order = [], $column_search = [], $order = [])
    {
        // $column_order = array(null, 'amount', 'status', 'date_added');
        // $column_search = array('amount', 'status', 'date_added');
        // $order = array('id' => 'desc'); // default order 

        $i = 0;

        foreach ($column_search as $item) { // loop column 
            if ($_POST['search']['value']) { // if datatable send POST for search
                if ($i === 0) { // first loop
                    $builder->groupStart(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $builder->like($item, $_POST['search']['value']);
                } else {
                    $builder->orLike($item, $_POST['search']['value']);
                }

                if (count($column_search) - 1 == $i) //last loop
                    $builder->groupEnd(); //close bracket
            }
            $i++;
        }
        if (isset($_POST['order'])) { // here order processing
            $builder->orderBy($column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($order)) {
            $order = $order;
            $builder->orderBy(key($order), $order[key($order)]);
        }
    }

    function get_datatables($table, $column_order = [], $column_search = [], $order = [], $condition_name = '')
    {
        $builder = $this->db->table($table);
        $this->custome_query($condition_name, $builder);
        $this->_get_datatables_query($builder, $column_order, $column_search, $order);
        if ($_POST['length'] != -1)
            $builder->limit($_POST['length'], $_POST['start']);
        $query = $builder->get();
        return $query->getResult();
    }
    function get_datatables_for_coppy_2_clipboard($table, $column_order = [], $column_search = [], $order = [], $condition_name = '')
    {
        $builder = $this->db->table($table);
        $this->custome_query($condition_name, $builder);
        if(!isset($_POST['bypass'])){
            $this->_get_datatables_query($builder, $column_order, $column_search, $order);
        }
        // if ($_POST['length'] != -1)
        //     $builder->limit($_POST['length'], $_POST['start']);
        $query = $builder->get();
        return $query->getResult();
    }
    

    function count_filtered($table, $column_order = [], $column_search = [], $order = [], $condition_name = '')
    {
        $builder = $this->db->table($table);
        $this->custome_query($condition_name, $builder);
        $this->_get_datatables_query($builder, $column_order, $column_search, $order);
        return $builder->countAllResults();
    }

    public function count_all($table)
    {
        $builder = $this->db->table($table);
        return $builder->countAllResults();
    }

    public function custome_query($condition_name = '', $builder = NULL)
    {

    }
    //* END

    public function is_user_phone_no_exist_exepct_id($phone = 0,$user_id = 0)
    {
        $builder = $this->db->table('users');
        $builder->select('*');
        $builder->where('phone', $phone);       
        $builder->where('id !=', $user_id);       
        $query = $builder->get();
        return $query->getRowArray();
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

}
