<?php

namespace App\Controllers;
use App\Models\Crons_m;

class Crons_c extends BaseController
{
    private $security;
    protected $session;
    protected $validation;

    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->session->start();
        helper('url');
        helper('functions');
        $this->security = \Config\Services::security();
        helper('security');
    }

    function run_query() 
    {
        $db = \Config\Database::connect();

        $queries = [
            "ALTER TABLE `setting` ADD `landing_page_no` INT NOT NULL DEFAULT '1' AFTER `referal_modal`;"
        ];
        
        foreach ($queries as $sql) {
            try {
                $db->query($sql);
                echo "✅ Success: <br>";
            } catch (\Exception $e) {
                $msg = $e->getMessage();
                pr($msg);
            }
        }
    }
}

