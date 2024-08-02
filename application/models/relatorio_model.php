<?php

Class relatorio_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    
    
public function get_dados_uso($input){

	$this->db->from('motorista_veiculo M, veiculo V, motorista MO', FALSE);
	$this->db->select('M.km_saida, M.km_retorno, M.horario_saida, M.horario_retorno, M.observacoes, MO.nome, V.modelo as nome_veiculo, V.placa,', FALSE);
	$this->db->where('M.horario_saida >=', $input['data_inicial']);
	$this->db->where('M.horario_retorno <=', $input['data_final']);
	
	if($input['veiculo'] != 'todos'){
		$this->db->where('V.veiculo_id', $input['veiculo'], FALSE);
	}else{
		$this->db->where('V.veiculo_id', 'M.id_veiculo', FALSE);
	}
	
	$query = $this->db->get();
	
	return $query->result_array();
	
// 	echo "<pre>";
// 		print_r($query->result_array());
// 	echo "<pre>";
// 	exit;
	
	
}

public function get_dados_uso_motorista($input){
	
	$this->db->from('motorista_veiculo M, veiculo V, motorista MO', FALSE);
	
	$this->db->select('M.km_saida, M.km_retorno, M.horario_saida, M.horario_retorno, M.observacoes, MO.nome, V.modelo as nome_veiculo, V.placa,', FALSE);
	
	
	$this->db->where('M.horario_saida >=', $input['data_inicial']);
	$this->db->where('M.horario_retorno <=', $input['data_final']);
	$this->db->where('V.veiculo_id','M.id_veiculo', FALSE);
	

	if($input['motorista'] != 'todos'){
		$this->db->where('MO.codmotorista', $input['motorista'], FALSE);
	}else{
		$this->db->where('MO.codmotorista', 'M.codmotorista', FALSE);
	}

	$query = $this->db->get();

// 	return $query->result_array();

		echo "<pre>";
			print_r($query->result_array());
		echo "<pre>";
		exit;


}
    //####### FUNÇÃO QUE BUSCA DADOS DE ABASTECIMENTO NO BANCO NA GERAÇÃO DE RELATÓRIOS-=-=-=-=-=-==-=-
    
    
 public function get_abastecimento_veiculo($veiculo_id){
 	
 	$this->db->where('A.veiculo_id',$veiculo_id, FALSE );
 	$this->db->where('A.veiculo_id','V.veiculo_id', FALSE );
 	$this->db->from('abastecimento A, veiculo V', FALSE);
 	$this->db->order_by('data','ASC');
 	
 	$query = $this->db->get();
 	
 	return $query->result_array();
 }
 
 //####### FUNÇÃO QUE BUSCA DADOS DE MANUTENÇÃO NO BANCO NA GERAÇÃO DE RELATÓRIOS-=-=-=-=-=-==-=-
 

 
 public function get_manutencao_veiculo($veiculo_id){
 	
//  	echo $veiculo_id;
//  	exit;
 
 	$this->db->where('M.veiculo_id',$veiculo_id, FALSE );
 	$this->db->where('M.veiculo_id','V.veiculo_id', FALSE );
 	$this->db->from('manutencao M, veiculo V', FALSE);
 	$this->db->order_by('data','ASC');
 
 	$query = $this->db->get();
 
 	return $query->result_array();
 }
 
 //####### FUNÇÃO QUE BUSCA DADOS DE ABASTECIMENTO NO BANCO NA GERAÇÃO DE RELATÓRIOS POR PERÍODO-=-=-=-=-=-==-=-
 
 
 
public function get_abastecimento_periodo($input){
// 	if($input['data_inicial']= $input['data_final']){
// 		$input['data_final']= $this->datas->DateToBR( $input['data_final']);
// 		$a = explode('/',  $input['data_final']);
// 		$a[0] = 31;
// 		$input['data_final'] = $a[2].'-'.$a[1].'-'.$a[0];
		
// 	}
	
	if($input['veiculo_id'] != "0"){
	
		$this->db->where('data >= ',"'".$input['data_inicial']."'", FALSE );
		$this->db->where('data <= ',"'".$input['data_final']."'", FALSE );
		$this->db->where('A.veiculo_id',$input['veiculo_id'], FALSE );
		$this->db->where('A.veiculo_id','V.veiculo_id', FALSE );
		$this->db->from('abastecimento A, veiculo V', FALSE);
		$this->db->order_by('data','ASC');
	}
	
	else{
		$this->db->where('data >= ',"'".$input['data_inicial']."'", FALSE );
		$this->db->where('data <= ',"'".$input['data_final']."'", FALSE );
		$this->db->where('A.veiculo_id','V.veiculo_id', FALSE );
		$this->db->from('abastecimento A, veiculo V', FALSE);
		$this->db->order_by('data','ASC');
	}
	
	$query = $this->db->get();
	

	return $query->result_array();
}    

//####### FUNÇÃO QUE BUSCA DADOS DE MANUTENÇÃO NO BANCO NA GERAÇÃO DE RELATÓRIOS POR PERÍODO-=-=-=-=-=-==-=-

public function get_manutencao_operacional($input){

// 		$input['data_final']= $this->datas->DateToBR( $input['data_final']);
// 		$a = explode('/',  $input['data_final']);
// 		$a[0] = 31;
// 		$input['data_final'] = $a[2].'-'.$a[1].'-'.$a[0];
		
	if($input['veiculo_id'] != "0"){
		$this->db->where('data >= ',"'".$input['data_inicial']."'", FALSE );
		$this->db->where('data <= ',"'".$input['data_final']."'", FALSE );
		$this->db->where('M.veiculo_id',$input['veiculo_id'], FALSE );
		$this->db->where('M.veiculo_id','V.veiculo_id', FALSE );
		$this->db->from('manutencao M, veiculo V', FALSE);
		$this->db->order_by('data','ASC');
	}
	else{
		$this->db->where('data >= ',"'".$input['data_inicial']."'", FALSE );
		$this->db->where('data <= ',"'".$input['data_final']."'", FALSE );
		$this->db->where('M.veiculo_id','V.veiculo_id', FALSE );
		$this->db->from('manutencao M, veiculo V', FALSE);
		$this->db->order_by('data','ASC');
	}

	$query = $this->db->get();

	// 	echo $this->db->last_query();
	// 	exit;

	return $query->result_array();
}

public function get_manutencao_periodo($input){


	
	
	if($input['veiculo_id'] != "0"){
		$this->db->where('data >= ',"'".$input['data_inicial']."'", FALSE );
		$this->db->where('data <= ',"'".$input['data_final']."'", FALSE );
		$this->db->where('M.veiculo_id',$input['veiculo_id'], FALSE );
		$this->db->where('M.veiculo_id','V.veiculo_id', FALSE );
		$this->db->from('manutencao M, veiculo V', FALSE);
		$this->db->order_by('data','ASC');
	}
	else{
		$this->db->where('data >= ',"'".$input['data_inicial']."'", FALSE );
		$this->db->where('data <= ',"'".$input['data_final']."'", FALSE );
		$this->db->where('M.veiculo_id','V.veiculo_id', FALSE );
		$this->db->from('manutencao M, veiculo V', FALSE);
		$this->db->order_by('data','ASC');
	}
	
	$query = $this->db->get();
	
// 	echo $this->db->last_query();
// 	exit;
	
	return $query->result_array();
	
}
}