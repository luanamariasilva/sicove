<?php

class Usuario extends CI_Controller {
	
	public function __construct() {
		
		parent::__construct();
		
		$this->load->helper(array('form','url','array','date','html','file'));
		$this->load->library(array('session','calendar','table','form_validation','email'));
		$this->load->model('Usuario_model');
		
		if ($this->session->userdata('logado') != TRUE) {

			$data['title'] = "Sistema de Controle de Veículos";
            
            $this->load->view('template/header_sessao',$data);
			$this->load->view('sessao_expirada');
			$this->load->view('template/footer');
			$this->output->_display();
			exit();
		}
	}

	public function novo(){
		
		$data['title'] = "Cadastrar Usuário";
	
		if ($this->form_validation->run('usuario/novo') == FALSE){
			$this->load->view('template/header_sessao', $data);
			$this->load->view('usuario/novo');
			$this->load->view('template/footer');
	
		} else {
			
			$input = array(
						'cpf' => preg_replace('/[^0-9]/','',$this->input->post('cpf')),
						'matricula' => $this->input->post('matricula'),
				     	'perfil' => $this->input->post('perfil'),
						'nome' => $this->input->post('nome'),
						'senha' => md5($this->input->post('senha')),
						'email' => $this->input->post('email'),
						'vinculada' => 0,
						'ativo' => 0,
						'telefone' => preg_replace('/[^0-9]/','',$this->input->post('telefone')),
			);
			
// 			echo "<pre>";
// 				print_r($input);
// 			echo "<pre>";
// 			exit;
	
			if($this->Usuario_model->novo($input) == TRUE)
				echo '<script type="text/javascript">
						alert("Usuário cadastrado com sucesso!");
						window.location="'.base_url().'index.php/home_sessao"
					</script>';
				else
					echo '<script type="text/javascript"> alert("Não foi possível criar o Usuário! Tente novamente.");window.location="'.base_url().'index.php/"</script>';
		}
		
		
	}

	public function pesquisar(){
		
		$data['title'] = "Pesquisar Usuário";
		$data['servidores'] = '';
		
		if ($this->form_validation->run('usuario/pesquisar') == FALSE){
			$this->load->view('template/header_sessao', $data);
			$this->load->view('usuario/pesquisar');
			$this->load->view('template/footer');
		}else{
			
			$nome = $this->input->post('nome');
			
		    $data['servidores'] = $this->Usuario_model->pesquisar($nome);
		    
		    $this->load->view('template/header_sessao', $data);
		    $this->load->view('usuario/pesquisar');
		    $this->load->view('template/footer');
		    
// 		    echo "<pre>";
// 		        print_r($cpf);
// 		    echo "</pre>";
// 		    exit;
		}
		
	}
	public function editar_usuario($codservidor){
		$data['title'] = "Editar Usuário";
		
		
		if ($this->form_validation->run('usuario/editar_usuario') == FALSE) {
			 
			$this->load->view('template/header_sessao', $data);
			$this->load->view('usuario/editar_usuario');
			$this->load->view('template/footer');
			 
		} else {
			 
			$input = array(
						'cpf' => preg_replace('/[^0-9]/','',$this->input->post('cpf')),
						'matricula' => $this->input->post('matricula'),
						'codservidor' => $this->session->userdata('codusuario'),
			    'categoria' => $this->input->post('categoria'),
						'nome' => $this->input->post('nome'),
						'email' => $this->input->post('email'),
						'telefone' => preg_replace('/[^0-9]/','',$this->input->post('telefone')),
			);
			 
		if($this->Usuario_model->editar($input) == TRUE)
				echo '<script type="text/javascript">
						alert("Usuário modificado com sucesso!");
						window.location="'.base_url().'index.php/usuario/pesquisar"
					</script>';
				else
					echo '<script type="text/javascript"> alert("Não foi possível modificar o Usuário! Tente novamente.");window.location="'.base_url().'index.php/"</script>';
		
		}
	}
	
	public function deletar_usuario($codservidor){
		
	    $this->Usuario_model->deletar_usuario($codservidor);
		
	    if($this->Usuario_model->deletar_usuario($codservidor) == TRUE){
			
			echo '<script type="text/javascript">
						alert("Usuário exluido com sucesso!");
						window.location="'.base_url().'index.php/usuario/pesquisar"
					</script>';
		}else{
			echo '<script type="text/javascript"> alert("Não foi possível excluir o Usuário! Tente novamente.");window.location="'.base_url().'index.php/usuario/pesquisar"</script>';
		}
		
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