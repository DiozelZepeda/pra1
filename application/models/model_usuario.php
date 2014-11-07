<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// validacion para el modelo de usuario login cambio de clave CRUD
class model_usuario extends CI_Model{

	function __construct(){
		parent::__construct();	
	}
	


    function insert_alumnoindicador($creador,$ray) 
    {

        $this->db->setCF('alumnoindicador');

        $row = $this->db->query()->get_count($creador);
        $row = $row +1;
        $columns = array(   $row  => $ray);

        $this->db->query()->insert($creador, $columns);
        return true;
    }

    function insert_indicadores($creador,$ray) 
    {

    	$this->db->setCF('indicadores');
    	$this->db->query()->insert($creador, $ray);
    	return true;
    }

    function insert_indicadordate($creador,$ray) 
    {

        $this->db->setCF('indicadordate');
        $this->db->query()->insert($creador, $ray);
        return true;
    }

}