<?php
Class manutencao_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    
    //####### FUNÇÃO QUE INSERE DADOS NO BANCO NO CADASTRO-=-=-=-=-=-==-=-
    
    
    public function cadastrar_manutencao($input){
    	$query = $this->db->insert('manutencao',$input);
    	$insertId =$this->db->insert_id();
	    if($query == TRUE){
	    	return $insertId;
	    }else{
	    	return FALSE;
	    }
    }

    //####### FUNÇÃO QUE BUSCA DADOS NO BANCO NA PESQUISA-=-=-=-=-=-==-=-
    
    
    public function pesquisar_manutencao($veiculo_id){
    	$this->db->where('M.veiculo_id',$veiculo_id, FALSE );
    	$this->db->where('M.veiculo_id','V.veiculo_id', FALSE );
    	$this->db->from('manutencao M, veiculo V', FALSE);
    	$this->db->order_by('data','ASC');
    	$query = $this->db->get();
    	return $query->result_array();
    	}
    	
    	//####### FUNÇÃO QUE EDITA DADOS NO BANCO NA PESQUISA-=-=-=-=-=-==-=-
    	   
    	
    public function editar_manutencao($input,$id_manutencao){
    	$this->db->where('id_manutencao',$id_manutencao);
    	if($this->db->update('manutencao',$input)){
    		return TRUE;
    		
    	}else{
    		return FALSE;
    		
    	}
    }
    
    //####### FUNÇÃO QUE EXCLUI DADOS NO BANCO NA PESQUISA-=-=-=-=-=-==-=-
    
    
    public function excluir_manutencao($id_manutencao){
    	$excluiDoc = self::get_manutencao_id($id_manutencao);
//     	echo "<pre>";
//     	print_r($excluiDoc);
//     	echo "<pre>";
//     	exit;
    	$this->db->where('id_manutencao',$id_manutencao);
    	if($this->db->delete('manutencao')){
    		return $excluiDoc;

    	}else{
    		return FALSE;
    	}
    }
    
    //####### FUNÇÃO QUE BUSCA O ID DE MANUTENÇÃO NO BANCO DE DADOS-=-=-=-=-=-==-=-
    
    
    public function get_manutencao_id($id_manutencao){
    	$this->db->where('id_manutencao',$id_manutencao);
    	$query = $this->db->get('manutencao');
    
    	return $query->row_array();
    }


}