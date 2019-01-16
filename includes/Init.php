<?php

require_once "Database.php";

class Init
{

    /**
     * Configuration Data
     * @var array
     */

    private $config = [
        'db' => [
            'type' => 'mysql',
            'host' => 'localhost',
            'dbname' => 'Test_task_greenbrown',
            'user' => 'admin',
            'password' => 'admin'
        ],
        'table' => [
            'table_name' => 'test',
            'num_row' => 30,
            'result_list' => ['normal', 'illegal', 'failed', 'success']
        ]
    ];

    /**
     * PDO Object
     * @var PDO
     */

    private $db;

    function __construct() {
        $this->db = Database::getConnection($this->config['db']);
        $this->create();
        $this->fill($this->config['table']['num_row']);
    }

    /**
     * Create Table
     * @return bool
     */

    private function create() {
        $sql = sprintf("CREATE TABLE IF NOT EXISTS %s 
                (
                  id          int unsigned auto_increment primary key,
                  script_name varchar(25)                                     null,
                  start_time  int unsigned                                    null,
                  end_time    int unsigned                                    null,
                  result      enum ('normal', 'illegal', 'failed', 'success') null
                )
                ENGINE=MyISAM DEFAULT CHARSET=cp1251;
                ", $this->config['table']['table_name']);
        $res = (bool) $this->db->query($sql);
        return $res;
    }

    /**
     * Fill the table with random data
     * @param $num_row number generate rows
     * @return bool
     */

    private function fill($num_row) {
        if ($num_row > 0) {
            // delete old data
            $sql = sprintf("TRUNCATE TABLE %s", $this->config['table']['table_name']);
            $this->db->query($sql);
            $res_all = true;

            // fill row new random data
            for ($i = 0; $i < $num_row; $i++) {
                $script_name = 'test_script_'.$i;
                $start_time = rand(1, 50);
                $end_time = rand($start_time, 100);
                $result = $this->config['table']['result_list'][rand(0,3)];
                $sql_insert = sprintf("INSERT INTO %s 
                  (`script_name`, `start_time`, `end_time`, `result`) 
                  VALUES ('%s', %d, %d, '%s')",
                    $this->config['table']['table_name'],
                    $script_name,
                    $start_time,
                    $end_time,
                    $result);
                $res = (bool) $this->db->query($sql_insert);
                $res_all = $res_all && $res;
            }
            return $res_all;
        }
        else return false;
    }

    /**
     * Return data from table
     * @return array|bool
     */

    function get() {
        $sql = sprintf("SELECT * FROM %s WHERE result IN ('normal','success')", $this->config['table']['table_name']);
        $res = $this->db->query($sql);
        if (!$res) return false;
        return $res->fetchAll(PDO::FETCH_ASSOC);
    }
}