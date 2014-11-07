<?php

require_once('phpcassa/lib/autoload.php');
use phpcassa\ColumnFamily;
use phpcassa\ColumnSlice;
use phpcassa\Connection\ConnectionPool;
use phpcassa\UUID;

class Db 
{
    private  $cf, $CI;
    private $conn;
    private $cfObj;
    private $cfList = array();
    private $uuid;


    public function __construct() 
    {
        $this->CI = & get_instance();
        $this->creatPool('tesisfinal', array('127.0.0.1')); // crea la conexion a la base de datos dentro de cassandra
    }

    private function creatPool($keyspace, $servers=NULL) 
    {
        try 
        {
            $this->conn = new ConnectionPool($keyspace, $servers);
        } catch (Exception $e) 
        {
            show_error($e->getMessage());
        }
    }

    public function setCF($cf) {
        $this->cfObj = new ColumnFamily($this->conn, $cf); //crea la conexion a la tabla dentro utilizando el creatpool
    }


    public function query() {
        return $this->cfObj;
    }



    public function initCFs($cfl, $reinit=false) 
    {
        foreach ($cfl as $icf) 
        {
            $createCFInstance = false;
            if (!isset($this->cfList[strtolower($icf)])) 
            {
                $createCFInstance = true;
            }
            if ($reinit) 
            {
                $createCFInstance = true;
            }
            if ($createCFInstance) 
            {
                //init the CFs to be accessible by name
                $this->cfList[strtolower($icf)] = new ColumnFamily($this->conn, $icf);
            }
        }
    }

    public function uuid4()
    {
        $uuid= UUID::uuid4();
        return $uuid;
    }

     public function uuid1()
    {
        $uuid= UUID::mint(1, $node, null, $time, $sequence);
        return $uuid;
    }

}