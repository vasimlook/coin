<?php
// echo $this->db->getLastQuery();die;
namespace App\Models;
use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Model;

class Datatable_m extends Model
{
    protected $db;
    protected $session;
    public function __construct()
    {
        $this->session = session();
        $this->db = db_connect();
        helper('functions');
    }

    //* Datatable START
    public function _get_datatables_query($builder, $column_order = [], $column_search = [], $order = [])
    {
        // $column_order = array(null, 'amount', 'status', 'date_added');
        // $column_search = array('amount', 'status', 'date_added');
        // $order = array('id' => 'desc'); // default order 

        $i = 0;

        foreach ($column_search as $item) { // loop column 
            if (@$_POST['search']['value']) { // if datatable send POST for search
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

    public function count_all_multi_table_sum($tables = [])
    {
        $total = 0;
        foreach ($tables as $table) {
            $builder = $this->db->table($table);
            $total += $builder->countAllResults();
        }
        return $total;
    }

    public function custome_query($condition_name = '', $builder = NULL)
    {
        if ($condition_name == 'user_list_ajax_admin') {
            $builder->select('users.*');
            if(isset($_POST['status']) && $_POST['status'] != '')
            {
                $builder->where('users.status', $_POST['status']);  
            }
            if(isset($_POST['is_system_user']) && $_POST['is_system_user'] != '')
            {
                $builder->where('users.is_system_user', $_POST['is_system_user']);  
            }
        }
        if ($condition_name == 'coin_list_ajax_admin') {
            $builder->select('t_coin_request.*,b.phone as buyer_phone,b.name as buyer_name,s.phone as seller_phone,s.name as seller_name');
            $builder->join('users b', 'b.id = t_coin_request.buyer_id', 'left');
            $builder->join('users s', 's.id = t_coin_request.seller_id', 'left');

            if(isset($_POST['status']) && $_POST['status'] != '')
            {
                $builder->where('t_coin_request.status', $_POST['status']);  
            }
            if(isset($_POST['from_date']) && !empty($_POST['from_date']) && isset($_POST['to_date']) && !empty($_POST['to_date']))
            {
                $from_date = date('Y-m-d', strtotime(@$_POST['from_date']));
                $to_date = date('Y-m-d', strtotime(@$_POST['to_date']));
                $builder->where('DATE(t_coin_request.created_at) >=', $from_date);
                $builder->where('DATE(t_coin_request.created_at) <=', $to_date);
            }
        }
        if ($condition_name == 'coin_buy_list_ajax_user') {
            $builder->select('t_coin_request.*,s.phone as seller_phone,s.name as seller_name');
            $builder->join('users s', 's.id = t_coin_request.seller_id', 'left');

            $builder->where('t_coin_request.buyer_id', $_SESSION['user']['id']);  
            if(isset($_POST['status']) && $_POST['status'] != '')
            {
                $builder->where('t_coin_request.status', $_POST['status']);  
            }
            if(isset($_POST['from_date']) && !empty($_POST['from_date']) && isset($_POST['to_date']) && !empty($_POST['to_date']))
            {
                $from_date = date('Y-m-d', strtotime(@$_POST['from_date']));
                $to_date = date('Y-m-d', strtotime(@$_POST['to_date']));
                $builder->where('DATE(t_coin_request.created_at) >=', $from_date);
                $builder->where('DATE(t_coin_request.created_at) <=', $to_date);
            }
        }
        if ($condition_name == 'coin_sell_list_ajax_user') {
            $builder->select('t_coin_request.*,b.phone as buyer_phone,b.name as buyer_name');
            $builder->join('users b', 'b.id = t_coin_request.buyer_id', 'left');

            $builder->where('t_coin_request.seller_id', $_SESSION['user']['id']);  
            if(isset($_POST['status']) && $_POST['status'] != '')
            {
                $builder->where('t_coin_request.status', $_POST['status']);  
            }
            if(isset($_POST['from_date']) && !empty($_POST['from_date']) && isset($_POST['to_date']) && !empty($_POST['to_date']))
            {
                $from_date = date('Y-m-d', strtotime(@$_POST['from_date']));
                $to_date = date('Y-m-d', strtotime(@$_POST['to_date']));
                $builder->where('DATE(t_coin_request.created_at) >=', $from_date);
                $builder->where('DATE(t_coin_request.created_at) <=', $to_date);
            }
        }
    }
    //* Datatable END
}
