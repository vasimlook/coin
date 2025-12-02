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
        if ($condition_name == 'withdrawal_list_ajax') {
            $builder->where('refUser_id', $_SESSION['user']['id']);
        }
        if ($condition_name == 'online_topup_list_ajax') {            
            $builder->select('topups.*,u.phone');
            $builder->join('users u', 'u.id = topups.refUser_id', 'left');
            $builder->where('topups.refUser_id', $_SESSION['user']['id']);
            $builder->where('topups.manual', 0);
        } 
        if ($condition_name == 'topup_list_ajax') {            
            $builder->select('topups.*,u.phone');
            $builder->join('users u', 'u.id = topups.refUser_id', 'left');
            $builder->where('topups.refUser_id', $_SESSION['user']['id']);
            $builder->whereIn('topups.manual', [1,2]);            
        }       
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
        if ($condition_name == 'become_agent_user_list_ajax_admin') {
            $builder->where('users.user_type', 'user');
            $builder->where('users.become_agent_status', 1);
        }
        if ($condition_name == 'user_list_ajax_user') {
            $builder->select('users.*, IFNULL(SUM(agent_commission.commission), 0) as agent_total_commission');

            // ✅ Apply date filter inside the LEFT JOIN
            if(!empty($_POST['from_date']) && !empty($_POST['to_date'])) {
                $from_date = date('Y-m-d', strtotime(@$_POST['from_date']));
                $to_date   = date('Y-m-d', strtotime(@$_POST['to_date']));

                $builder->join(
                    'agent_commission',
                    "agent_commission.refUser_id = users.id 
                    AND DATE(agent_commission.date) >= '{$from_date}' 
                    AND DATE(agent_commission.date) <= '{$to_date}'",
                    'left'
                );
            } else {
                $builder->join('agent_commission', 'agent_commission.refUser_id = users.id', 'left');
            }

            $builder->groupBy('users.id');

            if(isset($_POST['status']) && $_POST['status'] != '') {
                $builder->where('users.status', $_POST['status']);  
            }

            $builder->where('users.user_type', 'user');
            $builder->where('users.refAgent_id', $_SESSION['user']['id']);

        }
        if ($condition_name == 'agent_user_list_ajax_user') {
            $builder->select('users.*, IFNULL(SUM(agent_commission.commission), 0) as agent_total_commission');

            // ✅ Apply date filter inside the LEFT JOIN
            if(!empty($_POST['from_date']) && !empty($_POST['to_date'])) {
                $from_date = date('Y-m-d', strtotime(@$_POST['from_date']));
                $to_date   = date('Y-m-d', strtotime(@$_POST['to_date']));

                $builder->join(
                    'agent_commission',
                    "agent_commission.refUser_id = users.id 
                    AND DATE(agent_commission.date) >= '{$from_date}' 
                    AND DATE(agent_commission.date) <= '{$to_date}'",
                    'left'
                );
            } else {
                $builder->join('agent_commission', 'agent_commission.refUser_id = users.id', 'left');
            }

            $builder->groupBy('users.id');

            if(isset($_POST['status']) && $_POST['status'] != '') {
                $builder->where('users.status', $_POST['status']);  
            }

            $builder->where('users.user_type', 'user');
            $builder->where('users.refAgent_id', $_POST['refAgent_id']);

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
        if ($condition_name == 'withdrawal_list_ajax_admin') {
            $builder->select('withdrawals.*,u.phone,u.name,a.name as admin_name,u.bank_name,u.ifsc_code,u.acc_no,u.p_pay,u.g_pay,u.bank_holder_name,u.upi_id,u.user_type');
            $builder->join('users u', 'u.id = withdrawals.refUser_id', 'left');
            $builder->join('admin as a', 'a.id = withdrawals.accept_by', 'left');
            if(isset($_POST['from_date']) && !empty($_POST['from_date']) && isset($_POST['to_date']) && !empty($_POST['to_date']))
            {
                $from_date = date('Y-m-d', strtotime(@$_POST['from_date']));
                $to_date = date('Y-m-d', strtotime(@$_POST['to_date']));
                $builder->where('DATE(withdrawals.date_added) >=', $from_date);
                $builder->where('DATE(withdrawals.date_added) <=', $to_date);
            }
            if(isset($_POST['status']) && $_POST['status'] != '')
            {
                $builder->where('withdrawals.status', $_POST['status']);  
            }
            if(isset($_POST['accept_by']) && $_POST['accept_by'] != '')
            {
                $builder->where('withdrawals.accept_by', $_POST['accept_by']);  
            }
        }
        if($condition_name == "admin_list_ajax_admin")
        {
            if(isset($_POST['status']) && $_POST['status'] != '')
            {
                $builder->where('admin.status', $_POST['status']);  
            }
        }
        if($condition_name == "market_list_ajax_admin")
        {
            if(isset($_POST['status']) && $_POST['status'] != '')
            {
                $builder->where('market.status', $_POST['status']);  
            }
            if(isset($_POST['is_starline']) && $_POST['is_starline'] != '')
            {
                $builder->where('market.is_starline', $_POST['is_starline']);  
            }
        }
        if($condition_name == "delhi_market_list_ajax_admin")
        {
            if(isset($_POST['status']) && $_POST['status'] != '')
            {
                $builder->where('delhi_market.status', $_POST['status']);  
            }
        }
        if($condition_name == 'get_admin_digit_entry_vyapar_ajax')
        {
            $entry_date = $_POST['date_added'];           
            $refMarket_id = $_POST['refMarket_id'];
            $entry_type = $_POST['entry_type']; 
            $slot_id = $_POST['slot_id'];            
            $builder->select("digit_entry.digit_entry_num AS game,SUM(digit_entry.digit_entry_price) AS total_price");            
            $builder->where("digit_entry.digit_entry_date",  date('Y-m-d', strtotime($entry_date)));
            $builder->where("digit_entry.refMarket_id",  $refMarket_id);
            $builder->where("digit_entry.digit_entry_type", $entry_type);
            $builder->where("digit_entry.slot_id", $slot_id);
            $builder->orderBy('digit_entry.digit_entry_num','asc');
            $builder->groupBy("digit_entry.digit_entry_num");   
        }
        if($condition_name == 'get_admin_pana_entry_vyapar_ajax')
        {
            $entry_date = $_POST['date_added'];
            $refMarket_id = $_POST['refMarket_id'];
            $entry_type = $_POST['entry_type'];
            $slot_id = $_POST['slot_id'];
            $builder->select("pana_entry.pana_entry_num AS game,SUM(pana_entry.pana_entry_price) AS total_price");
            $builder->join("pana_details", "pana_details.panu = pana_entry.pana_entry_num", "left");
            $builder->where("pana_entry.pana_entry_date",  date('Y-m-d', strtotime($entry_date)));
            $builder->where("pana_entry.refMarket_id",  $refMarket_id);
            $builder->where("pana_entry.pana_entry_type", $entry_type);
            $builder->where("pana_entry.slot_id", $slot_id);
            $builder->orderBy('pana_details.figure','asc');
            $builder->orderBy('pana_details.pana_type','asc');            
            $builder->groupBy("pana_entry.pana_entry_num");
        }
        if($condition_name == 'get_admin_halfsangam_entry_vyapar_ajax')
        {
            $entry_date = $_POST['date_added'];            
            $refMarket_id = $_POST['refMarket_id'];           

            $builder->select("halfsangam_entry.all_no AS game,SUM(halfsangam_entry.halfsangam_entry_price) AS total_price,SUM(halfsangam_entry.halfsangam_entry_price * halfsangam_entry.rate) as total_bid,SUM(agent_commission) as total_commission");            
            $builder->where("halfsangam_entry.halfsangam_entry_date",  date('Y-m-d', strtotime($entry_date)));
            $builder->where("halfsangam_entry.refMarket_id",  $refMarket_id);          

            $builder->groupBy("halfsangam_entry.all_no");   
        }
        if($condition_name == 'get_admin_fullsangam_entry_vyapar_ajax')
        {
            $entry_date = $_POST['date_added'];            
            $refMarket_id = $_POST['refMarket_id'];           

            $builder->select("fullsangam_entry.all_no AS game,SUM(fullsangam_entry.fullsangam_entry_price) AS total_pricee,SUM(fullsangam_entry.fullsangam_entry_price * fullsangam_entry.rate) as total_bid,SUM(agent_commission) as total_commission");            
            $builder->where("fullsangam_entry.fullsangam_entry_date",  date('Y-m-d', strtotime($entry_date)));
            $builder->where("fullsangam_entry.refMarket_id",  $refMarket_id);          

            $builder->groupBy("fullsangam_entry.all_no");   
        }
        if($condition_name == 'get_admin_pana_entry_vyapar_ajax_no_slot')
        {
            $entry_date = $_POST['date_added'];
            $refMarket_id = $_POST['refMarket_id'];
            $builder->select("pana_entry.pana_entry_num AS game,SUM(pana_entry.pana_entry_price) AS total_price,SUM(pana_entry.pana_entry_price * pana_entry.rate) as total_bid,SUM(agent_commission) as total_commission");
            $builder->where("pana_entry.pana_entry_date",  date('Y-m-d', strtotime($entry_date)));
            $builder->where("pana_entry.refMarket_id",  $refMarket_id);   
        }
        if($condition_name == 'get_admin_digit_entry_vyapar_ajax_no_slot')
        {
            $entry_date = $_POST['date_added'];           
            $refMarket_id = $_POST['refMarket_id'];            
            $builder->select("digit_entry.digit_entry_num AS game,SUM(digit_entry.digit_entry_price) AS total_price,SUM(digit_entry.digit_entry_price * digit_entry.rate) as total_bid,SUM(agent_commission) as total_commission");            
            $builder->where("digit_entry.digit_entry_date",  date('Y-m-d', strtotime($entry_date)));
            $builder->where("digit_entry.refMarket_id",  $refMarket_id);
            $builder->orderBy('digit_entry.digit_entry_num','asc');
            $builder->groupBy("digit_entry.digit_entry_num");   
        }
        if($condition_name == 'get_admin_jodi_entry_vyapar_ajax')
        {
            $entry_date = $_POST['date_added'];            
            $refMarket_id = $_POST['refMarket_id'];           

            $builder->select("jodi_entry.jodi_entry_num AS game,SUM(jodi_entry.jodi_entry_price) AS total_price,SUM(jodi_entry.jodi_entry_price * jodi_entry.rate) as total_bid,SUM(agent_commission) as total_commission");
            $builder->where("jodi_entry.jodi_entry_date",  date('Y-m-d', strtotime($entry_date)));
            $builder->where("jodi_entry.refMarket_id",  $refMarket_id);          
            $builder->orderBy('jodi_entry.jodi_entry_num','asc');
            $builder->groupBy("jodi_entry.jodi_entry_num");   
        }
        if ($condition_name == 'user_recharge_history_list_ajax_admin') {
            $builder->select('topups.*,u.phone,u.name,admin.name as admin_name,u.user_type');
            $builder->join('users u', 'u.id = topups.refUser_id', 'left');
            $builder->join('admin', 'admin.id = topups.accept_by', 'left');
            $builder->where('topups.status', 1);
            $builder->where('topups.refUser_id', $_POST['user_id']);
            if(isset($_POST['from_date']) && !empty($_POST['from_date']) && isset($_POST['to_date']) && !empty($_POST['to_date']))
            {
                $from_date = date('Y-m-d', strtotime(@$_POST['from_date']));
                $to_date = date('Y-m-d', strtotime(@$_POST['to_date']));
                $builder->where('DATE(topups.date_added) >=', $from_date);
                $builder->where('DATE(topups.date_added) <=', $to_date);
            }
        }
        if ($condition_name == 'user_withdrawals_history_list_ajax_admin') {
            $builder->select('withdrawals.*,u.phone,u.name,a.name as admin_name,u.user_type');
            $builder->join('users u', 'u.id = withdrawals.refUser_id', 'left');
            $builder->join('admin as a', 'a.id = withdrawals.accept_by', 'left');
            $builder->where('withdrawals.status', 1);
            $builder->where('withdrawals.refUser_id', $_POST['user_id']);
            if(isset($_POST['from_date']) && !empty($_POST['from_date']) && isset($_POST['to_date']) && !empty($_POST['to_date']))
            {
                $from_date = date('Y-m-d', strtotime(@$_POST['from_date']));
                $to_date = date('Y-m-d', strtotime(@$_POST['to_date']));
                $builder->where('DATE(withdrawals.date_added) >=', $from_date);
                $builder->where('DATE(withdrawals.date_added) <=', $to_date);
            }
        }
        if($condition_name == "digit_entry_play_game_history_ajax")
        {
            $builder->select('digit_entry.digit_entry_id as editId,digit_entry.digit_entry_type as type,digit_entry.digit_entry_num as num,digit_entry.digit_entry_price as price,digit_entry.digit_entry_price as price,digit_entry.digit_entry_date as datetime,u.name,u.phone,u.id as refUser_id,u.user_type,
            (CASE 
                WHEN digit_entry.win_status = 1 
                THEN digit_entry.digit_entry_price * digit_entry.rate 
                ELSE 0 
            END) as winning_price,market.market_name,market.hindi_name,bid_date_time');
            $builder->join('users u', 'u.id = digit_entry.refUser_id', 'left');
            $builder->join('market', 'market.market_id = digit_entry.refMarket_id', 'left');
            if($_POST['refMarket_id'] !='all')
            {
                $builder->where('digit_entry.refMarket_id', $_POST['refMarket_id']);
            }
            $builder->where('digit_entry.slot_id', $_POST['slot_id']);
            if(!empty($_POST['date_added']))
            {
                $builder->where('DATE(digit_entry.digit_entry_date)', date('Y-m-d', strtotime($_POST['date_added'])));
            }
            if(isset($_POST['win_status']) && $_POST['win_status'] != "")
            {
                $builder->where('digit_entry.win_status', $_POST['win_status']);
            }
            if(isset($_POST['type']) && $_POST['type'] != "")
            {
                $builder->where('digit_entry.digit_entry_type', $_POST['type']);
            }
            if((isset($_POST['figure_open']) && $_POST['figure_open'] !== '') || (isset($_POST['figure_close']) && $_POST['figure_close'] !== ''))
            {
                $builder->groupStart();
                if (isset($_POST['figure_open']) && $_POST['figure_open'] !== '') {
                    $builder->groupStart()->where('digit_entry.digit_entry_type', 'OPEN');
                    $builder->where('digit_entry.digit_entry_num', $_POST['figure_open'])->groupEnd();
                }

                if (isset($_POST['figure_close']) && $_POST['figure_close'] !== '') {
                    $builder->orGroupStart()->where('digit_entry.digit_entry_type', 'CLOSE');
                    $builder->where('digit_entry.digit_entry_num', $_POST['figure_close'])->groupEnd();
                }

                $builder->groupEnd(); // close main group
            }
            if(isset($_POST['refUser_id']) && $_POST['refUser_id'] != "")
            {
                $builder->where('digit_entry.refUser_id', $_POST['refUser_id']);
            }
            if(!empty($_POST['from_date']) && !empty($_POST['to_date']))
            {
                $from_date = date('Y-m-d', strtotime(@$_POST['from_date']));
                $to_date = date('Y-m-d', strtotime(@$_POST['to_date']));
                $builder->where('DATE(digit_entry.digit_entry_date) >=', $from_date);
                $builder->where('DATE(digit_entry.digit_entry_date) <=', $to_date);
            }
        }
        if($condition_name == "fullsangam_entry_play_game_history_ajax")
        {
            $builder->select('"OPEN" as type,fullsangam_entry.fullsangam_entry_id as editId,fullsangam_entry.all_no as num,fullsangam_entry.fullsangam_entry_price as price,fullsangam_entry.fullsangam_entry_date as datetime,u.name,u.phone,u.id as refUser_id,u.user_type,
            (CASE 
                WHEN fullsangam_entry.win_status = 1 
                THEN fullsangam_entry.fullsangam_entry_price * fullsangam_entry.rate 
                ELSE 0 
            END) as winning_price,market.market_name,market.hindi_name,bid_date_time');
            $builder->join('users u', 'u.id = fullsangam_entry.refUser_id', 'left');
            $builder->join('market', 'market.market_id = fullsangam_entry.refMarket_id', 'left');
            if($_POST['refMarket_id'] !='all')
            {
                $builder->where('fullsangam_entry.refMarket_id', $_POST['refMarket_id']);
            }
            if(!empty($_POST['date_added']))
            {
                $builder->where('DATE(fullsangam_entry.fullsangam_entry_date)', date('Y-m-d', strtotime($_POST['date_added'])));
            }
            if(isset($_POST['win_status']) && $_POST['win_status'] != "")
            {
                $builder->where('fullsangam_entry.win_status', $_POST['win_status']);
            }
            if(isset($_POST['refUser_id']) && $_POST['refUser_id'] != "")
            {
                $builder->where('fullsangam_entry.refUser_id', $_POST['refUser_id']);
            }
            if (isset($_POST['aankdo_open']) && $_POST['aankdo_open'] !== '' && isset($_POST['aankdo_close']) && $_POST['aankdo_close'] !== '') {
                $builder->where('fullsangam_entry.fullsangam_entry_openpana', $_POST['aankdo_open']);
                $builder->where('fullsangam_entry.fullsangam_entry_closepana', $_POST['aankdo_close']);
            }
            if(!empty($_POST['from_date']) && !empty($_POST['to_date']))
            {
                $from_date = date('Y-m-d', strtotime(@$_POST['from_date']));
                $to_date = date('Y-m-d', strtotime(@$_POST['to_date']));
                $builder->where('DATE(fullsangam_entry.fullsangam_entry_date) >=', $from_date);
                $builder->where('DATE(fullsangam_entry.fullsangam_entry_date) <=', $to_date);
            }
            if(isset($_POST['type']) && $_POST['type'] != "")
            {
                if($_POST['type'] != 'OPEN') {                    
                    $builder->where('1', '0');
                }                
            }
        }
        if($condition_name == "halfsangam_entry_play_game_history_ajax")
        {
            $builder->select('halfsangam_entry.halfsangam_entry_id as editId,halfsangam_entry.halfsangam_entry_type as type,halfsangam_entry.all_no as num,halfsangam_entry.halfsangam_entry_price as price,halfsangam_entry.halfsangam_entry_date as datetime,u.name,u.phone,u.id as refUser_id,u.user_type,
            (CASE 
                WHEN halfsangam_entry.win_status = 1 
                THEN halfsangam_entry.halfsangam_entry_price * halfsangam_entry.rate 
                ELSE 0 
            END) as winning_price,market.market_name,market.hindi_name,bid_date_time');
            $builder->join('users u', 'u.id = halfsangam_entry.refUser_id', 'left');
            $builder->join('market', 'market.market_id = halfsangam_entry.refMarket_id', 'left');
            if($_POST['refMarket_id'] !='all')
            {
                $builder->where('halfsangam_entry.refMarket_id', $_POST['refMarket_id']);
            }
            if(!empty($_POST['date_added']))
            {
                $builder->where('DATE(halfsangam_entry.halfsangam_entry_date)', date('Y-m-d', strtotime($_POST['date_added'])));
            }
            if(isset($_POST['win_status']) && $_POST['win_status'] != "")
            {
                $builder->where('halfsangam_entry.win_status', $_POST['win_status']);
            }
            if(isset($_POST['type']) && $_POST['type'] != "")
            {
                $builder->where('halfsangam_entry.halfsangam_entry_type', $_POST['type']);
            }
            if(isset($_POST['refUser_id']) && $_POST['refUser_id'] != "")
            {
                $builder->where('halfsangam_entry.refUser_id', $_POST['refUser_id']);
            }
            if (isset($_POST['aankdo_open']) && $_POST['aankdo_open'] !== '' && isset($_POST['aankdo_close']) && $_POST['aankdo_close'] !== '') 
            {
                $builder->groupStart();

                $builder->groupStart()->where('halfsangam_entry.halfsangam_entry_type', 'OPEN');
                $builder->where('halfsangam_entry.halfsangam_entry_num', $_POST['figure_open']);
                $builder->where('halfsangam_entry.halfsangam_entry_pana', $_POST['aankdo_close'])->groupEnd();

                $builder->orGroupStart(); // OR start for CLOSE condition

                $builder->where('halfsangam_entry.halfsangam_entry_type', 'CLOSE');
                $builder->where('halfsangam_entry.halfsangam_entry_pana', $_POST['aankdo_open']);
                $builder->where('halfsangam_entry.halfsangam_entry_num', $_POST['figure_close'])->groupEnd();
                
                $builder->groupEnd(); // close main group
                
            }
            if(!empty($_POST['from_date']) && !empty($_POST['to_date']))
            {
                $from_date = date('Y-m-d', strtotime(@$_POST['from_date']));
                $to_date = date('Y-m-d', strtotime(@$_POST['to_date']));
                $builder->where('DATE(halfsangam_entry.halfsangam_entry_date) >=', $from_date);
                $builder->where('DATE(halfsangam_entry.halfsangam_entry_date) <=', $to_date);
            }
        }
        if($condition_name == "jodi_entry_play_game_history_ajax")
        {
            $builder->select('"OPEN" as type,jodi_entry.jodi_entry_id as editId,jodi_entry.jodi_entry_num as num,jodi_entry.jodi_entry_price as price,jodi_entry.jodi_entry_date as datetime,u.name,u.phone,u.id as refUser_id,u.user_type,
            (CASE 
                WHEN jodi_entry.win_status = 1 
                THEN jodi_entry.jodi_entry_price * jodi_entry.rate 
                ELSE 0 
            END) as winning_price,market.market_name,market.hindi_name,bid_date_time');
            $builder->join('users u', 'u.id = jodi_entry.refUser_id', 'left');
            $builder->join('market', 'market.market_id = jodi_entry.refMarket_id', 'left');
            if($_POST['refMarket_id'] !='all')
            {
                $builder->where('jodi_entry.refMarket_id', $_POST['refMarket_id']);
            }
            if(!empty($_POST['date_added']))
            {
                $builder->where('DATE(jodi_entry.jodi_entry_date)', date('Y-m-d', strtotime($_POST['date_added'])));
            }
            if(isset($_POST['win_status']) && $_POST['win_status'] != "")
            {
                $builder->where('jodi_entry.win_status', $_POST['win_status']);
            }
            if(isset($_POST['refUser_id']) && $_POST['refUser_id'] != "")
            {
                $builder->where('jodi_entry.refUser_id', $_POST['refUser_id']);
            }
            if(isset($_POST['jodi']) && $_POST['jodi'] !== '')
            {
                $builder->where('jodi_entry.jodi_entry_num', $_POST['jodi']);
            }
            if(!empty($_POST['from_date']) && !empty($_POST['to_date']))
            {
                $from_date = date('Y-m-d', strtotime(@$_POST['from_date']));
                $to_date = date('Y-m-d', strtotime(@$_POST['to_date']));
                $builder->where('DATE(jodi_entry.jodi_entry_date) >=', $from_date);
                $builder->where('DATE(jodi_entry.jodi_entry_date) <=', $to_date);
            }
            if(isset($_POST['type']) && $_POST['type'] != "")
            {
                if($_POST['type'] != 'OPEN') {                    
                    $builder->where('1', '0');
                }
            }
        }
        if($condition_name == "pana_entry_play_game_history_ajax")
        {
            $builder->select('pana_entry.pana_entry_id as editId,pana_entry.pana_entry_type as type,pana_entry.pana_entry_num as num,pana_entry.pana_entry_price as price,pana_entry.pana_entry_date as datetime,u.name,u.phone,u.id as refUser_id,u.user_type,
            (CASE 
                WHEN pana_entry.win_status = 1 
                THEN pana_entry.pana_entry_price * pana_entry.rate 
                ELSE 0 
            END) as winning_price,market.market_name,market.hindi_name,bid_date_time');
            $builder->join('users u', 'u.id = pana_entry.refUser_id', 'left');
            $builder->join('market', 'market.market_id = pana_entry.refMarket_id', 'left');
            if($_POST['refMarket_id'] !='all')
            {
                $builder->where('pana_entry.refMarket_id', $_POST['refMarket_id']);
            }
            $builder->where('pana_entry.slot_id', $_POST['slot_id']);
            if(!empty($_POST['date_added']))
            {
                $builder->where('DATE(pana_entry.pana_entry_date)', date('Y-m-d', strtotime($_POST['date_added'])));
            }
            if(isset($_POST['win_status']) && $_POST['win_status'] != "")
            {
                $builder->where('pana_entry.win_status', $_POST['win_status']);
            }
            if(isset($_POST['type']) && $_POST['type'] != "")
            {
                $builder->where('pana_entry.pana_entry_type', $_POST['type']);
            }
            if(isset($_POST['refUser_id']) && $_POST['refUser_id'] != "")
            {
                $builder->where('pana_entry.refUser_id', $_POST['refUser_id']);
            }
            if((isset($_POST['aankdo_open']) && $_POST['aankdo_open'] !== '') || (isset($_POST['aankdo_close']) && $_POST['aankdo_close'] !== ''))
            {
                $builder->groupStart();

                if (isset($_POST['aankdo_open']) && $_POST['aankdo_open'] !== '') {
                    $builder->groupStart()->where('pana_entry.pana_entry_type', 'OPEN');
                    $builder->where('pana_entry.pana_entry_num', $_POST['aankdo_open'])->groupEnd();
                }

                if (isset($_POST['aankdo_close']) && $_POST['aankdo_close'] !== '') {
                    $builder->orGroupStart()->where('pana_entry.pana_entry_type', 'CLOSE');
                    $builder->where('pana_entry.pana_entry_num', $_POST['aankdo_close'])->groupEnd();
                }
                $builder->groupEnd(); // close OR group
                
            }
            if(!empty($_POST['from_date']) && !empty($_POST['to_date']))
            {
                $from_date = date('Y-m-d', strtotime(@$_POST['from_date']));
                $to_date = date('Y-m-d', strtotime(@$_POST['to_date']));
                $builder->where('DATE(pana_entry.pana_entry_date) >=', $from_date);
                $builder->where('DATE(pana_entry.pana_entry_date) <=', $to_date);
            }
        }
        if($condition_name == 'get_admin_delhi_digit_entry_vyapar_ajax')
        {
            $entry_date = $_POST['date_added'];           
            $refMarket_id = $_POST['refMarket_id'];
            $entry_type = $_POST['entry_type']; 
            $slot_id = $_POST['slot_id'];            
            $builder->select("delhi_digit_entry.digit_entry_num AS game,SUM(delhi_digit_entry.digit_entry_price) AS total_price");            
            $builder->where("delhi_digit_entry.digit_entry_date",  date('Y-m-d', strtotime($entry_date)));
            $builder->where("delhi_digit_entry.refMarket_id",  $refMarket_id);
            $builder->where("delhi_digit_entry.digit_entry_type", $entry_type);
            $builder->where("delhi_digit_entry.slot_id", $slot_id);
            $builder->orderBy('delhi_digit_entry.digit_entry_num','asc');
            $builder->groupBy("delhi_digit_entry.digit_entry_num");   
        }
        if($condition_name == 'get_admin_delhi_jodi_entry_vyapar_ajax')
        {
            $entry_date = $_POST['date_added'];            
            $refMarket_id = $_POST['refMarket_id'];           

            $builder->select("delhi_jodi_entry.jodi_entry_num AS game,SUM(delhi_jodi_entry.jodi_entry_price) AS total_price");
            $builder->where("delhi_jodi_entry.jodi_entry_date",  date('Y-m-d', strtotime($entry_date)));
            $builder->where("delhi_jodi_entry.refMarket_id",  $refMarket_id);          
            $builder->orderBy('delhi_jodi_entry.jodi_entry_num','asc');
            $builder->groupBy("delhi_jodi_entry.jodi_entry_num");   
        }
        if($condition_name == "delhi_digit_entry_play_game_history_ajax")
        {
            $builder->select('delhi_digit_entry.digit_entry_id as editId,delhi_digit_entry.digit_entry_type as type,delhi_digit_entry.digit_entry_num as num,delhi_digit_entry.digit_entry_price as price,delhi_digit_entry.digit_entry_price as price,delhi_digit_entry.digit_entry_date as datetime,u.name,u.phone,u.id as refUser_id,u.user_type,
            (CASE 
                WHEN delhi_digit_entry.win_status = 1 
                THEN delhi_digit_entry.digit_entry_price * delhi_digit_entry.rate 
                ELSE 0 
            END) as winning_price,delhi_market.market_name,delhi_market.hindi_name,bid_date_time');
            $builder->join('users u', 'u.id = delhi_digit_entry.refUser_id', 'left');
            $builder->join('delhi_market', 'delhi_market.market_id = delhi_digit_entry.refMarket_id', 'left');
            if(!empty($_POST['date_added']))
            {
                $builder->where('DATE(delhi_digit_entry.digit_entry_date)', date('Y-m-d', strtotime($_POST['date_added'])));
            }
            if($_POST['refMarket_id'] !='all')
            {
                $builder->where('delhi_digit_entry.refMarket_id', $_POST['refMarket_id']);
            }
            if(isset($_POST['win_status']) && $_POST['win_status'] != "")
            {
                $builder->where('delhi_digit_entry.win_status', $_POST['win_status']);
            }
            if(isset($_POST['type']) && $_POST['type'] != "")
            {
                $builder->where('delhi_digit_entry.digit_entry_type', $_POST['type']);
            }
            if(isset($_POST['refUser_id']) && $_POST['refUser_id'] != "")
            {
                $builder->where('delhi_digit_entry.refUser_id', $_POST['refUser_id']);
            }
            if ( (isset($_POST['figure_open']) && $_POST['figure_open'] !== '') || (isset($_POST['figure_close']) && $_POST['figure_close'] !== '') ) 
            {
                $builder->groupStart();

                if (isset($_POST['figure_open']) && $_POST['figure_open'] !== '') {
                    $builder->groupStart()
                            ->where('delhi_digit_entry.digit_entry_type', 'OPEN')
                            ->where('delhi_digit_entry.digit_entry_num', $_POST['figure_open'])
                            ->groupEnd();
                }

                if (isset($_POST['figure_close']) && $_POST['figure_close'] !== '') {
                    $builder->orGroupStart()
                            ->where('delhi_digit_entry.digit_entry_type', 'CLOSE')
                            ->where('delhi_digit_entry.digit_entry_num', $_POST['figure_close'])
                            ->groupEnd();
                }

                $builder->groupEnd();
            }

            if(!empty($_POST['from_date']) && !empty($_POST['to_date']))
            {
                $from_date = date('Y-m-d', strtotime(@$_POST['from_date']));
                $to_date = date('Y-m-d', strtotime(@$_POST['to_date']));
                $builder->where('DATE(delhi_digit_entry.digit_entry_date) >=', $from_date);
                $builder->where('DATE(delhi_digit_entry.digit_entry_date) <=', $to_date);
            }
        }
        if($condition_name == "delhi_jodi_entry_play_game_history_ajax")
        {
            $builder->select('"OPEN" as type,delhi_jodi_entry.jodi_entry_id as editId,delhi_jodi_entry.jodi_entry_num as num,delhi_jodi_entry.jodi_entry_price as price,delhi_jodi_entry.jodi_entry_date as datetime,u.name,u.phone,u.id as refUser_id,u.user_type,,
            (CASE 
                WHEN delhi_jodi_entry.win_status = 1 
                THEN delhi_jodi_entry.jodi_entry_price * delhi_jodi_entry.rate 
                ELSE 0 
            END) as winning_price,delhi_market.market_name,delhi_market.hindi_name,bid_date_time');
            $builder->join('users u', 'u.id = delhi_jodi_entry.refUser_id', 'left');
            $builder->join('delhi_market', 'delhi_market.market_id = delhi_jodi_entry.refMarket_id', 'left');
            if(!empty($_POST['date_added']))
            {
                $builder->where('DATE(delhi_jodi_entry.jodi_entry_date)', date('Y-m-d', strtotime($_POST['date_added'])));
            }
            if($_POST['refMarket_id'] !='all')
            {
                $builder->where('delhi_jodi_entry.refMarket_id', $_POST['refMarket_id']);
            }
            if(isset($_POST['win_status']) && $_POST['win_status'] != "")
            {
                $builder->where('delhi_jodi_entry.win_status', $_POST['win_status']);
            }
            if(isset($_POST['refUser_id']) && $_POST['refUser_id'] != "")
            {
                $builder->where('delhi_jodi_entry.refUser_id', $_POST['refUser_id']);
            }
            if(isset($_POST['jodi']) && $_POST['jodi'] !== '') 
            {
                $builder->where('delhi_jodi_entry.jodi_entry_num', $_POST['jodi']);
            }
            // if(isset($_POST['type']) && $_POST['type'] != "")
            // {
            //     if($_POST['type'] != 'OPEN') {                    
            //         $builder->where('1', '0');
            //     }
            // }
            if(!empty($_POST['from_date']) && !empty($_POST['to_date']))
            {
                $from_date = date('Y-m-d', strtotime(@$_POST['from_date']));
                $to_date = date('Y-m-d', strtotime(@$_POST['to_date']));
                $builder->where('DATE(delhi_jodi_entry.jodi_entry_date) >=', $from_date);
                $builder->where('DATE(delhi_jodi_entry.jodi_entry_date) <=', $to_date);
            }
        }
        if ($condition_name == 'log_list_ajax_admin') {            
            $builder->select('log.*,admin.name');
            $builder->join('admin', 'admin.id = log.admin_id', 'left');
            $builder->orderBy('log.id','DESC');
        }
        if($condition_name == 'transfer_history_ajax')
        {
            $builder->select('trnsfr.*, u_from.name AS from_name, u_to.name AS to_name');
            $builder->from('transfer_history as trnsfr');
            $builder->join('users AS u_from', 'trnsfr.from_id = u_from.id');
            $builder->join('users AS u_to', 'trnsfr.to_id = u_to.id');
            $builder->where('trnsfr.from_id', $_SESSION['user']['id']);
            $builder->orWhere('trnsfr.to_id', $_SESSION['user']['id']);
            $builder->groupBy('trnsfr.id');
        }

        if ($condition_name == 'user_transfer_point_ajax_admin') 
        {
            $builder->select('trnsfr.*, u_from.name AS from_name,u_from.phone AS from_phone, u_to.name AS to_name,u_to.phone AS to_phone,a.name as admin_name');
            $builder->from('transfer_history as trnsfr');
            $builder->join('users AS u_from', 'trnsfr.from_id = u_from.id');
            $builder->join('users AS u_to', 'trnsfr.to_id = u_to.id');
            $builder->join('admin as a', 'a.id = trnsfr.accept_by', 'left');
            if(isset($_POST['status']) && $_POST['status'] != '')
            {
                $builder->where('trnsfr.status', $_POST['status']);  
            }
            if(isset($_POST['accept_by']) && $_POST['accept_by'] != '')
            {
                $builder->where('trnsfr.accept_by', $_POST['accept_by']);  
            }
            if(isset($_POST['from_date']) && !empty($_POST['from_date']) && isset($_POST['to_date']) && !empty($_POST['to_date']))
            {
                $from_date = date('Y-m-d', strtotime(@$_POST['from_date']));
                $to_date = date('Y-m-d', strtotime(@$_POST['to_date']));
                $builder->where('DATE(trnsfr.created_at) >=', $from_date);
                $builder->where('DATE(trnsfr.created_at) <=', $to_date);
            }
            $builder->groupBy('trnsfr.id');
        }

        if($condition_name == "digit_entry_play_game_winning_history_ajax")
        {
            $builder->select('digit_entry.digit_entry_type as type,digit_entry.digit_entry_num as num,digit_entry.digit_entry_price as price,digit_entry.digit_entry_price as price,digit_entry.digit_entry_date as datetime,u.name,u.phone,u.id as refUser_id,u.user_type,,(digit_entry.digit_entry_price * digit_entry.rate) as winning_price');
            $builder->join('users u', 'u.id = digit_entry.refUser_id', 'left');
            $builder->where('digit_entry.refMarket_id', $_POST['refMarket_id']);
            $builder->where('digit_entry.slot_id', $_POST['slot_id']);
            if(!empty($_POST['date_added']))
            {
                $builder->where('DATE(digit_entry.digit_entry_date)', date('Y-m-d', strtotime($_POST['date_added'])));
            }
            if(isset($_POST['win_status']) && $_POST['win_status'] != "")
            {
                $builder->where('digit_entry.win_status', $_POST['win_status']);
            }
            if(isset($_POST['type']) && $_POST['type'] != "")
            {
                $builder->where('digit_entry.digit_entry_type', $_POST['type']);
            }
        }
        if($condition_name == "fullsangam_entry_play_game_winning_history_ajax")
        {
            $builder->select('"OPEN" as type,fullsangam_entry.all_no as num,fullsangam_entry.fullsangam_entry_price as price,fullsangam_entry.fullsangam_entry_date as datetime,u.name,u.phone,u.id as refUser_id,u.user_type,,(fullsangam_entry.fullsangam_entry_price * fullsangam_entry.rate) as winning_price');
            $builder->join('users u', 'u.id = fullsangam_entry.refUser_id', 'left');
            $builder->where('fullsangam_entry.refMarket_id', $_POST['refMarket_id']);
            if(!empty($_POST['date_added']))
            {
                $builder->where('DATE(fullsangam_entry.fullsangam_entry_date)', date('Y-m-d', strtotime($_POST['date_added'])));
            }
            if(isset($_POST['win_status']) && $_POST['win_status'] != "")
            {
                $builder->where('fullsangam_entry.win_status', $_POST['win_status']);
            }
            if(isset($_POST['type']) && $_POST['type'] != "")
            {
                if($_POST['type'] != 'OPEN') {                    
                    $builder->where('1', '0');
                }                
            }
        }
        if($condition_name == "halfsangam_entry_play_game_winning_history_ajax")
        {
            $builder->select('halfsangam_entry.halfsangam_entry_type as type,halfsangam_entry.all_no as num,halfsangam_entry.halfsangam_entry_price as price,halfsangam_entry.halfsangam_entry_date as datetime,u.name,u.phone,u.id as refUser_id,u.user_type,,(halfsangam_entry.halfsangam_entry_price * halfsangam_entry.rate) as winning_price');
            $builder->join('users u', 'u.id = halfsangam_entry.refUser_id', 'left');
            $builder->where('halfsangam_entry.refMarket_id', $_POST['refMarket_id']);
            if(!empty($_POST['date_added']))
            {
                $builder->where('DATE(halfsangam_entry.halfsangam_entry_date)', date('Y-m-d', strtotime($_POST['date_added'])));
            }
            if(isset($_POST['win_status']) && $_POST['win_status'] != "")
            {
                $builder->where('halfsangam_entry.win_status', $_POST['win_status']);
            }
            if(isset($_POST['type']) && $_POST['type'] != "")
            {
                $builder->where('halfsangam_entry.halfsangam_entry_type', $_POST['type']);
            }
        }
        if($condition_name == "jodi_entry_play_game_winning_history_ajax")
        {
            $builder->select('"OPEN" as type,jodi_entry.jodi_entry_num as num,jodi_entry.jodi_entry_price as price,jodi_entry.jodi_entry_date as datetime,u.name,u.phone,u.id as refUser_id,u.user_type,,(jodi_entry.jodi_entry_price * jodi_entry.rate) as winning_price');
            $builder->join('users u', 'u.id = jodi_entry.refUser_id', 'left');
            $builder->where('jodi_entry.refMarket_id', $_POST['refMarket_id']);
            if(!empty($_POST['date_added']))
            {
                $builder->where('DATE(jodi_entry.jodi_entry_date)', date('Y-m-d', strtotime($_POST['date_added'])));
            }
            if(isset($_POST['win_status']) && $_POST['win_status'] != "")
            {
                $builder->where('jodi_entry.win_status', $_POST['win_status']);
            }
            if(isset($_POST['type']) && $_POST['type'] != "")
            {
                if($_POST['type'] != 'OPEN') {
                    $builder->where('1', '0');
                }
            }
        }
        if($condition_name == "pana_entry_play_game_winning_history_ajax")
        {
            $builder->select('pana_entry.pana_entry_type as type,pana_entry.pana_entry_num as num,pana_entry.pana_entry_price as price,pana_entry.pana_entry_date as datetime,u.name,u.phone,u.id as refUser_id,u.user_type,,(pana_entry.pana_entry_price * pana_entry.rate) as winning_price');
            $builder->join('users u', 'u.id = pana_entry.refUser_id', 'left');
            $builder->where('pana_entry.refMarket_id', $_POST['refMarket_id']);
            $builder->where('pana_entry.slot_id', $_POST['slot_id']);
            if(!empty($_POST['date_added']))
            {
                $builder->where('DATE(pana_entry.pana_entry_date)', date('Y-m-d', strtotime($_POST['date_added'])));
            }
            if(isset($_POST['win_status']) && $_POST['win_status'] != "")
            {
                $builder->where('pana_entry.win_status', $_POST['win_status']);
            }
            if(isset($_POST['type']) && $_POST['type'] != "")
            {
                $builder->where('pana_entry.pana_entry_type', $_POST['type']);
            }
        }

        if($condition_name == "digit_entry_play_game_prediction_list_ajax")
        {
            $builder->select('digit_entry.digit_entry_type as type,digit_entry.digit_entry_num as num,digit_entry.digit_entry_price as price,digit_entry.digit_entry_price as price,digit_entry.digit_entry_date as datetime,u.name,u.phone,u.id as refUser_id,u.user_type,,(digit_entry.digit_entry_price * digit_entry.rate) as winning_price');
            $builder->join('users u', 'u.id = digit_entry.refUser_id', 'left');
            $builder->where('digit_entry.refMarket_id', $_POST['refMarket_id']);
            $builder->where('digit_entry.slot_id', $_POST['slot_id']);
            $builder->where('DATE(digit_entry.digit_entry_date)', date('Y-m-d', strtotime($_POST['date_added'])));
            $builder->where("((digit_entry_type = 'OPEN' AND digit_entry_num = '".$_POST['figure_open']."') OR (digit_entry_type = 'CLOSE' AND digit_entry_num = '".$_POST['figure_close']."'))");
            
        }
        if($condition_name == "fullsangam_entry_play_game_prediction_list_ajax")
        {
            $builder->select('"OPEN" as type,fullsangam_entry.all_no as num,fullsangam_entry.fullsangam_entry_price as price,fullsangam_entry.fullsangam_entry_date as datetime,u.name,u.phone,u.id as refUser_id,u.user_type,,(fullsangam_entry.fullsangam_entry_price * fullsangam_entry.rate) as winning_price');
            $builder->join('users u', 'u.id = fullsangam_entry.refUser_id', 'left');
            $builder->where('fullsangam_entry.refMarket_id', $_POST['refMarket_id']);
            $builder->where('DATE(fullsangam_entry.fullsangam_entry_date)', date('Y-m-d', strtotime($_POST['date_added'])));
            $builder->where('fullsangam_entry.fullsangam_entry_openpana', $_POST['aankdo_open']);
            $builder->where('fullsangam_entry.fullsangam_entry_closepana', $_POST['aankdo_close']);
        }
        if($condition_name == "halfsangam_entry_play_game_prediction_list_ajax")
        {
            $builder->select('halfsangam_entry.halfsangam_entry_type as type,halfsangam_entry.all_no as num,halfsangam_entry.halfsangam_entry_price as price,halfsangam_entry.halfsangam_entry_date as datetime,u.name,u.phone,u.id as refUser_id,u.user_type,,(halfsangam_entry.halfsangam_entry_price * halfsangam_entry.rate) as winning_price');
            $builder->join('users u', 'u.id = halfsangam_entry.refUser_id', 'left');
            $builder->where('halfsangam_entry.refMarket_id', $_POST['refMarket_id']);
            $builder->where('DATE(halfsangam_entry.halfsangam_entry_date)', date('Y-m-d', strtotime($_POST['date_added'])));
            $builder->where("((halfsangam_entry.halfsangam_entry_type = 'OPEN' AND halfsangam_entry.halfsangam_entry_num = '".$_POST['figure_open']."' AND halfsangam_entry.halfsangam_entry_pana = '".$_POST['aankdo_close']."') OR (halfsangam_entry.halfsangam_entry_type = 'CLOSE' AND halfsangam_entry.halfsangam_entry_num = '".$_POST['figure_close']."' AND halfsangam_entry.halfsangam_entry_pana = '".$_POST['aankdo_open']."'))");
        }
        if($condition_name == "jodi_entry_play_game_prediction_list_ajax")
        {
            $builder->select('"OPEN" as type,jodi_entry.jodi_entry_num as num,jodi_entry.jodi_entry_price as price,jodi_entry.jodi_entry_date as datetime,u.name,u.phone,u.id as refUser_id,u.user_type,,(jodi_entry.jodi_entry_price * jodi_entry.rate) as winning_price');
            $builder->join('users u', 'u.id = jodi_entry.refUser_id', 'left');
            $builder->where('jodi_entry.refMarket_id', $_POST['refMarket_id']);
            $builder->where('DATE(jodi_entry.jodi_entry_date)', date('Y-m-d', strtotime($_POST['date_added'])));
            $builder->where('jodi_entry.jodi_entry_num', $_POST['jodi']);
        }
        if($condition_name == "pana_entry_play_game_prediction_list_ajax")
        {
            $builder->select('pana_entry.pana_entry_type as type,pana_entry.pana_entry_num as num,pana_entry.pana_entry_price as price,pana_entry.pana_entry_date as datetime,u.name,u.phone,u.id as refUser_id,u.user_type,,(pana_entry.pana_entry_price * pana_entry.rate) as winning_price');
            $builder->join('users u', 'u.id = pana_entry.refUser_id', 'left');
            $builder->where('pana_entry.refMarket_id', $_POST['refMarket_id']);
            $builder->where('pana_entry.slot_id', $_POST['slot_id']);
            $builder->where('DATE(pana_entry.pana_entry_date)', date('Y-m-d', strtotime($_POST['date_added'])));
            $builder->where("((pana_entry.pana_entry_type = 'OPEN' AND pana_entry.pana_entry_num = '".$_POST['aankdo_open']."') OR (pana_entry.pana_entry_type = 'CLOSE' AND pana_entry.pana_entry_num = '".$_POST['aankdo_close']."'))");
            
        }
        if($condition_name == "delhi_digit_entry_play_game_prediction_list_ajax")
        {
            $builder->select('delhi_digit_entry.digit_entry_type as type,delhi_digit_entry.digit_entry_num as num,delhi_digit_entry.digit_entry_price as price,delhi_digit_entry.digit_entry_price as price,delhi_digit_entry.digit_entry_date as datetime,u.name,u.phone,u.id as refUser_id,u.user_type,,(delhi_digit_entry.digit_entry_price * delhi_digit_entry.rate) as winning_price');
            $builder->join('users u', 'u.id = refUser_id', 'left');
            $builder->where('refMarket_id', $_POST['refMarket_id']);
            $builder->where('slot_id', $_POST['slot_id']);
            $builder->where('DATE(digit_entry_date)', date('Y-m-d', strtotime($_POST['date_added'])));
            $builder->where("((digit_entry_type = 'OPEN' AND digit_entry_num = '".$_POST['figure_open']."') OR (digit_entry_type = 'CLOSE' AND digit_entry_num = '".$_POST['figure_close']."'))");
            
        }
        if($condition_name == "delhi_jodi_entry_play_game_prediction_list_ajax")
        {
            $builder->select('"OPEN" as type,delhi_jodi_entry.jodi_entry_num as num,delhi_jodi_entry.jodi_entry_price as price,delhi_jodi_entry.jodi_entry_date as datetime,u.name,u.phone,u.id as refUser_id,u.user_type,,(delhi_jodi_entry.jodi_entry_price * delhi_jodi_entry.rate) as winning_price');
            $builder->join('users u', 'u.id = delhi_jodi_entry.refUser_id', 'left');
            $builder->where('delhi_jodi_entry.refMarket_id', $_POST['refMarket_id']);
            $builder->where('DATE(delhi_jodi_entry.jodi_entry_date)', date('Y-m-d', strtotime($_POST['date_added'])));
            $builder->where('delhi_jodi_entry.jodi_entry_num', $_POST['jodi']);
        }
        if($condition_name == 'user_track_history_ajax')
        {
            $builder->select('user_track.*,m.market_name');
            $builder->join('market m', 'm.market_id = user_track.refMarket_id', 'left');
            if(isset($_POST['refMarket_id']) && $_POST['refMarket_id'] != 'all')
            {
                $builder->where('user_track.refMarket_id', $_POST['refMarket_id']);  
            }
            if(isset($_POST['refUser_id']) && $_POST['refUser_id'] != 'all')
            {
                $builder->where('user_track.refUser_id', $_POST['refUser_id']);  
            }
            if(isset($_POST['from_date']) && !empty($_POST['from_date']) && isset($_POST['to_date']) && !empty($_POST['to_date']))
            {
                $from_date = date('Y-m-d', strtotime(@$_POST['from_date']));
                $to_date = date('Y-m-d', strtotime(@$_POST['to_date']));
                $builder->where('DATE(user_track.win_date) >=', $from_date);
                $builder->where('DATE(user_track.win_date) <=', $to_date);
            }
        }
        if($condition_name == 'user_delhi_track_history_ajax')
        {
            $builder->select('user_delhi_track.*,dm.market_name');
            $builder->join('delhi_market dm', 'dm.market_id = user_delhi_track.refMarket_id', 'left');
            if(isset($_POST['refMarket_id']) && $_POST['refMarket_id'] != 'all')
            {
                $builder->where('user_delhi_track.refMarket_id', $_POST['refMarket_id']);  
            }
            if(isset($_POST['refUser_id']) && $_POST['refUser_id'] != 'all')
            {
                $builder->where('user_delhi_track.refUser_id', $_POST['refUser_id']);  
            }
            if(isset($_POST['from_date']) && !empty($_POST['from_date']) && isset($_POST['to_date']) && !empty($_POST['to_date']))
            {
                $from_date = date('Y-m-d', strtotime(@$_POST['from_date']));
                $to_date = date('Y-m-d', strtotime(@$_POST['to_date']));
                $builder->where('DATE(user_delhi_track.win_date) >=', $from_date);
                $builder->where('DATE(user_delhi_track.win_date) <=', $to_date);
            }
        }
    }
    //* Datatable END

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
}
