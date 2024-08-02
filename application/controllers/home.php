<?php

class Home extends CI_Controller {
	
	public function __construct() {
		
		parent::__construct();
		$this->load->helper(array('form','url','array','date','html','file'));
		$this->load->library(array('Datas','session','calendar','table','form_validation','upload','MY_Upload','email'));
		$this->load->model('Login_model');
		session_start();

	}
	
	public function index () {
		
			$data['title'] = "";
				
			$this->load->view('template/header',$data);
			//$this->load->view('home');
			//$this->load->view('template/footer');
	}

	public function trocar_senha() {
	
		$nova_senha = $this->input->post('nova_senha');
		$re_nova_senha = $this->input->post('re_nova_senha');
	
		$id = $this->input->post('id');
	
		if ($nova_senha == $re_nova_senha) {
	
			$input = array(
					'senha' => md5($nova_senha)
			);
				
			if ($this->Login_model->atualiza_senha($id, $input)) {
					
				$alert = '<div class="alert alert-success" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<strong>Senha atualizada com sucesso!</strong>
				</div>';
					
				$this->session->set_userdata(array('alert' => $alert));
					
				redirect("/home_sessao");
					
			} else {
					
				$alert = '<div class="alert alert-danger" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<strong>Operação não realizada, tente novamente!</strong>
				</div>';
					
				$this->session->set_userdata(array('alert' => $alert));
					
				redirect("/home_sessao");
					
			}
				
		} else {
				
			$alert = '<div class="alert alert-danger" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<strong>As senhas informadas não conferem, tente novamente!</strong>
				</div>';
				
			$this->session->set_userdata(array('alert' => $alert));
				
			redirect("/home_sessao");
		}
	}
	
	public function _check_cpf_usuario_existente($cpf) {
	
		$cpf = str_replace(array('.', '-'), '', $cpf);
	
		$this->form_validation->set_message('_check_cpf_usuario_existente', 'O %s informado já está cadastrado');
	
		return $this->Login_model->check_cpf_usuario_existente($cpf);
	
	}
	
	public function _valid_cpf($cpf) {
		 
		$this->form_validation->set_message('_valid_cpf', '%s inválido');
		$cpf = preg_replace('/[^0-9]/','',$cpf);
	
		if (strlen($cpf) != 11 || preg_match('/^([0-9])\1+$/', $cpf)) {
			return FALSE;
		}
	
		// 9 primeiros digitos do cpf
		$digito = substr($cpf, 0, 9);
	
		// calculo dos 2 digitos verificadores
		for ($j=10; $j <= 11; $j++) {
	
			$sum = 0;
	
			for($i=0; $i< $j-1; $i++) {
				$sum += ($j-$i) * ((int) $digito[$i]);
			}
	
			$summod11 = $sum % 11;
			$digito[$j-1] = $summod11 < 2 ? 0 : 11 - $summod11;
		}
	
		if ($digito[9] == ((int)$cpf[9]) && $digito[10] == ((int)$cpf[10])){
				return TRUE;
		} else {
			$this->form_validation->set_message('_valid_cpf', '%s inválido');
			return FALSE;
		}
	}
}