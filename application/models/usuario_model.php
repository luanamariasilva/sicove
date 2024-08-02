<?php

Class Usuario_model extends CI_Model {
	
	public function __construct() {
		parent::__construct();
		$this->load->database();
	}

public function novo($input){
	
	$query = $this->db->insert('servidor',$input);
	
	if($query == TRUE){
		return TRUE;
	}else{
		return FALSE;
	}
	
}

public function pesquisar($nome){
	
//	$this->db->where('nome',$cpf);
 	$this->db->where('nome LIKE','%'.$nome.'%');
	$query = $this->db->get('servidor');
	
	return $query->result_array();	

}

public function deletar_usuario($codservidor){
	
    $this->db->where('codservidor',$codservidor);
	$result_delete = $this->db->delete('servidor');
	
	if($result_delete == TRUE){
	
		return true;
	
	}else{
		return false;
	}
	
	
}
public function editar($input,$codservidor ){
    $this->db->where('codservidor',$codservidor);
	if($this->db->update('servidor', $input)){
		return TRUE;
	}else{
		return FALSE;
	}
}
// public function get_codservidor($){}

}