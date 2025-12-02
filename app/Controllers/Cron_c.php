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

    function delete_log_files(){
        $baseDirectory = "logs/"; // Replace with your logs directory path               
        deleteOldLogFiles($baseDirectory);
    }

    function delete_custom_folder_files()
    {
        $folders = []; 
        $folders[] = IMG_DIR.'cutting/'; 
        $folders[] = IMG_DIR.'doc/';  
        $folders[] = IMG_DIR.'valan/';                   
        foreach ($folders as $folder) 
        {                                
            // Use glob to get a list of all files in the folder
            $files = glob($folder . '*');
            if ($files === false) {
            } else {
                // Loop through the files and delete each one
                foreach ($files as $file) 
                {
                    if (is_file($file) && filemtime($file) < strtotime('-6 days')) {
                        unlink($file);                    
                    }
                }
            }            
        }

    }
    function run_query() 
    {
        $db = \Config\Database::connect();

        $queries = [
            // "ALTER TABLE `setting` ADD `referal_modal` INT NOT NULL DEFAULT '1' AFTER `recharge_commission`;"
            "ALTER TABLE `setting` ADD `landing_page_no` INT NOT NULL DEFAULT '1' AFTER `referal_modal`;"
            ];
        // if(DOMAIN == 'reddymatka.pro'){ 
        //     // $queries[] = "UPDATE `setting` SET `primary_market` = '1' ";
        // }
        // if(DOMAIN == 'winbuzzsupermatka.online'){ 
        //     // $queries[] = "UPDATE `setting` SET `primary_market` = '2' ";
        // }
        // if(DOMAIN == 'officialmatka.com'){ 
        //     // $queries[] = "UPDATE `setting` SET `primary_market` = '2' ";
        // }
        // if(DOMAIN == 'dpk24x6.in'){ 
        //     // $queries[] = "UPDATE `setting` SET `primary_market` = '2' ";
        // }

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

