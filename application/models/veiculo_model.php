<?php
Class veiculo_model extends CI_Model {

	public function __construct() {
		parent::__construct();
		$this->load->database();
	}
	
//####### FUNÇÃO QUE INSERE DADOS NO BANCO NO CADASTRO-=-=-=-=-=-==-=-
	

public function cadastrar($input){
	$query = $this->db->insert('veiculo',$input);
	
	if($query == TRUE){
		return TRUE;
	}else{
		return FALSE;
	}
	
}

//####### FUNÇÃO QUE BUSCA DADOS NO BANCO NA PESQUISA-=-=-=-=-=-==-=-

public function pesquisar($veiculo_id){
	$this->db->where('veiculo_id',$veiculo_id);
	$this->db->from('veiculo');
	$this->db->order_by('placa','ASC');
	$query = $this->db->get();
	return $query->result_array();
}

//####### FUNÇÃO QUE EDITA DADOS NO BANCO NA PESQUISA-=-=-=-=-=-==-=-

public function editar($input,$veiculo_id){
    $this->db->where('veiculo_id',$veiculo_id);
    if($this->db->update('veiculo',$input)){
        return TRUE;
    }else{
        return FALSE;
    }
}

//####### FUNÇÃO QUE EXLUI DADOS NO BANCO NA PESQUISA-=-=-=-=-=-==-=-


public function excluir($veiculo_id){
	$this->db->where('veiculo_id',$veiculo_id);
	if($this->db->delete('veiculo')){
		return TRUE;
	}else{
		return FALSE;
	}
}

//####### FUNÇÃO QUE BUSCA O ID DO VEICULO NO BANCO-=-=-=-=-=-==-=-


public function get_veiculo_id($veiculo_id){
	$this->db->where('veiculo_id',$veiculo_id);
	$query = $this->db->get('veiculo');
	return $query->row_array();
}

//####### FUNÇÃO QUE BUSCA OS VEICULOS NO BANCO-=-=-=-=-=-==-=-


public function get_veiculos(){
	$this->db->order_by('placa','ASC');
	$query = $this->db->get('veiculo');
	return $query->result_array();
}

}