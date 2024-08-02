<?php

Class Recupera_senha_model extends CI_Model {

	public function __construct() {
		parent::__construct();
		$this->load->database();
	}
	
	public function check_cpf_usuario_inexistence($cpf) {
		
		$this->db->where('cpf', $cpf);
		$query = $this->db->get('servidor');

		if ($query->num_rows() == 1) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	public function update_usuario_senha($cpf, $nova_senha) {
		
		$this->db->where('cpf', $cpf);
		
		$data = array('senha' => md5($nova_senha));

		if ($this->db->update('servidor', $data)) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	public function pesquisa_usuario($cpf) {
		
		$this->db->where('cpf', $cpf);
		$this->db->from('servidor');
		$this->db->select('nome, email');
		$query = $this->db->get();
	
		return $query->row_array();
		
	}
}	