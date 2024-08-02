<?php
Class abastecimento_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

   //####### FUNÇÃO QUE INSERE DADOS NO BANCO DURANTE O CADASTRO-=-=-=-=-=-==-=-
    
    public function cadastrar_abastecimento($input){
    	
    	$query = $this->db->insert('abastecimento',$input);
    	
    	$insertId =$this->db->insert_id();
	    
	    if($query == TRUE){
	    	return $insertId;
	    }else{
	    	return FALSE;
	    }
    }
    
    //####### FUNÇÃO QUE BUSCA DADOS NO BANCO DURANTE A PESQUISA-=-=-=-=-=-==-=-
    

    public function pesquisar_abastecimento($veiculo_id){
    
    	$this->db->where('A.veiculo_id',$veiculo_id, FALSE );
    	$this->db->where('A.veiculo_id','V.veiculo_id', FALSE );
    	$this->db->from('abastecimento A, veiculo V', FALSE);
    	$this->db->order_by('data','ASC');
    	$query = $this->db->get();
    	
    	return $query->result_array();
    }
    
    //####### FUNÇÃO QUE EDITA DADOS NO BANCO DURANTE A PESQUISA-=-=-=-=-=-==-=-
    
    	
    public function editar_abastecimento($input,$id_abastecimento){
    	$this->db->where('id_abastecimento',$id_abastecimento);
    	if($this->db->update('abastecimento',$input)){
    		return TRUE;
    		
    	}else{
    		return FALSE;
    		
    	}
    }
    
    //####### FUNÇÃO QUE EXCLUI DADOS NO BANCO DURANTE A PESQUISA-=-=-=-=-=-==-=-
    
    
    public function excluir_abastecimento($id_abastecimento){
    	$excluiDoc = self::get_abastecimento_id($id_abastecimento);
//     	echo "<pre>";
//     	print_r($excluiDoc);
//     	echo "<pre>";
//     	exit;
    	$this->db->where('id_abastecimento',$id_abastecimento);
    	if($this->db->delete('abastecimento')){
    		return $excluiDoc;

    	}else{
    		return FALSE;
    	}
    }
    
    //####### FUNÇÃO QUE BUSCA O ID DE ABASTECIMENTO NO BANCO-=-=-=-=-=-==-=-
    
    public function get_abastecimento_id($id_abastecimento){
    	$this->db->where('id_abastecimento',$id_abastecimento);
    	$query = $this->db->get('abastecimento');
    
    	return $query->row_array();
    }


}