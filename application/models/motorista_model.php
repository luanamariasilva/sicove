<?php
class Motorista_model extends CI_Model {

	public function __construct() {
		parent::__construct();
		$this->load->database();
		
	}

	
//    public function get_motorista_ativos(){
//    	$this->db->where('perfil', 2);
//    	$query = $this->db->get('servidor');
   
//    }
   
//    public function novo_motorista($input){
   
//    	$query = $this->db->insert('servidor',$input);
   
//    	if($query == TRUE){
//    		return TRUE;
//    	}else{
//    		return FALSE;
//    	}
   
//    }
	
	public function cadastrar_uso_veiculo($input){
// 		 echo "<pre>";
// 		 	print_r($input);
// 		 echo "<pre>";
// 		 exit;
		$query = $this->db->insert('motorista_veiculo',$input);
		 
		if($query == TRUE){
			return TRUE;
		}else{
			return FALSE;
		}
		 
	}
	
	public function verificar_cpf_motorista($input){
		$this->db->where('cpf', $input['cpf']);
		$query = $this->db->get('motorista');
			if(count($query->row_array()) > 0){
					return 0;//já possui
				}else{
					return 1; //Não possui
				}
	}
	
	public function excluir_motorista($cpf){
		$this->db->where('cpf', $cpf);
		$query = $this->db->delete('motorista');
		if($query == TRUE){
			return TRUE;//sucesso
		}else{
			return FALSE; //falhou
		}
	}
	
	public function editar_motorista($input){
		$this->db->where('cpf', $input['cpf']);
		$query = $this->db->update('motorista', $input);
		if($query == TRUE){
			return TRUE;//sucesso
		}else{
			return FALSE; //falhou
		}
	}
	
	public function pesquisar_motorista($nome){
	    $this->db->where('nome LIKE','%'.$nome.'%');
		$query = $this->db->get('motorista');
		
		return $query->row_array();
	}
	
	public function cadastrar_motorista($input){
		
		$result = $this->verificar_cpf_motorista($input);
		
		if($result == 1){
			$query = $this->db->insert('motorista', $input);
			
			if($query == TRUE){
				return 1;//sucesso
			}else{
				return 0; //falhou
			}
		}else{
			return 2; //cpf já cadastrado
		}
	}
	
	public function get_motoristas($codmotorista){
	    $query = $this->db->get('motorista');
	    return $query->result_array();
	}
	
	
	
	public function get_motorista(){
		$query = $this->db->get('motorista');
		return $query->result_array();
	}
	
}




// echo "<pre>";
// print_r($this->session->userdata('usuario'));
// echo "<pre>";
// exit;