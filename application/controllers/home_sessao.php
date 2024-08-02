<?php

class Home_sessao extends CI_Controller {
	
	public function __construct() {
		
		parent::__construct();
		
		$this->load->helper(array('form','url','array','date','html','file'));
		$this->load->library(array('session','calendar','table','form_validation','email'));
		$this->load->model('Login_model');

		if ($this->session->userdata('logado') != TRUE) {

			$data['title'] = "";
			
			$this->load->view('template/header',$data);
			//$this->load->view('home');
			//$this->load->view('template/footer');
			$this->output->_display();
			exit();
		}
	}

	public function index() {
	
		$data['title'] = "";
		$data['permissao'] = $this->session->userdata('permissao');
	
		$codusuario = $this->session->userdata('codusuario');
	
		$perfis = $this->Login_model->get_perfis($codusuario);
	
		if (count($perfis) == 1) {

			$data = array(
				'permissao' => $perfis[0]['codperfil'],
				'codusuario' => $perfis[0]['codusuario']
			);
	
			$this->session->set_userdata($data);
	
			$data['perfis'] = array();
		} else {
			$data['perfis'] = $perfis;
		}
		
		$data['contratos'] = array();
	
		$this->load->view('template/header_sessao', $data);
		$this->load->view('home');
		$this->load->view('template/footer');
	
	}
	
	
	
}