<?php

Class Login_model extends CI_Model {
	
	public function __construct() {
		parent::__construct();
		$this->load->database();
	}
	
	
	//####### FUNÇÃO QUE VALIDA OS DADOS DE ACESSO DURANTE O LOGIN-=-=-=-=-=-==-=-
	
	
	public function validar_acesso($cpf, $senha) {
// 		echo $cpf;
// 		exit;
		$this->db->select('codservidor, nome, cpf, senha, email, ativo, perfil');
		$this->db->where('cpf', $cpf);
		$this->db->where('senha', $senha);
		$this->db->where('ativo', '0');
// 		$this->db->where('perfil', $perfil);
		$query = $this->db->get('servidor');
	
		return $query->row_array();
	
	}
	
	public function _check_motorista($cpf){
		
		$cpf = substr_replace($cpf, '.', 3, 0);
		$cpf = substr_replace($cpf, '.', 7, 0);
		$cpf = substr_replace($cpf, '-', 11, 0);
		$this->db->where('cpf', $cpf);
		$query = $this->db->get('motorista');
		if($query->row_array()['nome'] != ''){
			return 1;
		}else{
			return 0;
		}
	}
	
	//####### FUNÇÃO QUE VALIDA O CPF DE ACESSO DURANTE O LOGIN-=-=-=-=-=-==-=-
	
		
	public function check_cpf_usuario_inexistence($cpf) {

		$this->db->where('cpf', $cpf);
		$query = $this->db->get('servidor');
		
		if ($query->num_rows() == 1) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	//####### FUNÇÕES QUE VALIDAM OS DADOS DE ACESSO DURANTE O LOGIN-=-=-=-=-=-==-=-
	
	public function check_cpf_usuario_existente($cpf) {
	
		$this->db->where('cpf', $cpf);
		$query = $this->db->get('servidor');
	
		if ($query->num_rows() == 0) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	public function check_senha($cpf, $senha) {
		
		$cpf = preg_replace('/[^0-9]/', '', $cpf);
		$this->db->where('cpf', $cpf);
		$this->db->where('senha', md5($senha));
		$query = $this->db->get('servidor');
		
		if ($query->num_rows() == 1) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	public function atualiza_senha($codservidor, $input) {
	
		$this->db->where('codservidor', $codservidor);
	
		if ($this->db->update('servidor', $input)) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	public function get_perfil($cod_usuario_perfil) {
	
		$this->db->where('cod_usuario_perfil', $cod_usuario_perfil);
		$this->db->from('usuario_perfil');
		$query = $this->db->get();
			
		return $query->row_array();
	
	}
	
	public function get_perfis($codusuario) {
	
		$this->db->where('U.codusuario', $codusuario, FALSE);
		$this->db->where('U.codperfil', 'P.codperfil', FALSE);
		$this->db->where('U.ativo', 0, FALSE);
		$this->db->order_by('U.codperfil ASC', FALSE);
		$this->db->from('usuario_perfil U, perfil P', FALSE);
		$query = $this->db->get();
			
		return $query->result_array();
	
	}
}
