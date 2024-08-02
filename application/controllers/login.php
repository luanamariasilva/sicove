<?php

class Login extends CI_Controller {
	
	public function __construct() {
		
		parent::__construct();
		
		$this->load->helper(array('form','url','array','date','html'));
		$this->load->library(array('Datas','session','calendar','table','form_validation','upload','MY_Upload','email'));
		$this->load->model('Login_model');
		
	}
	
	
	//FUNÇÃO QUE EFETUA O LOGIN
	
	public function efetuar_login() {
		
		$data['title'] = "";
		
		if ($this->form_validation->run('login/index') == FALSE) {
			
			$data['contratos'] = array();

			$this->load->view('template/login_incorreto');
			//$this->load->view('home');
		} else {
			
			$cpf = str_replace(array('.', '-'), '', $this->input->post('inputCPF'));
			$senha = md5($this->input->post('inputSenha'));
			
			$dados = $this->Login_model->validar_acesso($cpf, $senha);

			
			if (count($dados) != 0) {

				$array_nome = explode(" ", $dados['nome']);

				$motorista = $this->Login_model->_check_motorista($cpf);
				
				if($motorista == 1){
					$data = array(
							'codusuario' => $dados['codservidor'],
							'usuario' => $dados['nome'],
							'cpf' => $dados['cpf'],
							'permissao' => 0,
							'email' => $dados['email'],
							'logado' => TRUE,
							'motorista' => 1
	//					    'perfil' =>$dados['perfil']
					);
				}else{
					$data = array(
							'codusuario' => $dados['codservidor'],
							'usuario' => $dados['nome'],
							'cpf' => $dados['cpf'],
							'permissao' => 0,
							'email' => $dados['email'],
							'logado' => TRUE,
							'motorista' => 0
							//					    'perfil' =>$dados['perfil']
					);
				}
			
				$this->session->set_userdata($data);

				redirect("home_sessao");
					
			} else {
				
				$data['title'] = "";
		
				$this->load->view('template/header', $data);
				$this->load->view('sessao');
				$this->load->view('template/footer');
			}
		}
	}
	
	//FUNÇÃO QUE EXECUTA O LOGOUT
	
	public function logout() {
		
		$this->session->sess_destroy();
		redirect("");
	
	}
	
	/* Métodos auxiliares */
	function calc_digitos_posicoes($digitos, $posicoes = 10, $soma_digitos = 0) {
		
		// Faz a soma dos dígitos com a posição
		// Ex. para 10 posições:
		// 0 2 5 4 6 2 8 8 4
		// x10 x9 x8 x7 x6 x5 x4 x3 x2
		// 0 + 18 + 40 + 28 + 36 + 10 + 32 + 24 + 8 = 196
		for($i = 0; $i < strlen ( $digitos ); $i ++) {
			$soma_digitos = $soma_digitos + ($digitos [$i] * $posicoes);
			$posicoes --;
		}
	
		// Captura o resto da divisão entre $soma_digitos dividido por 11
		// Ex.: 196 % 11 = 9
		$soma_digitos = $soma_digitos % 11;
	
		// Verifica se $soma_digitos é menor que 2
		if ($soma_digitos < 2) {
			// $soma_digitos agora será zero
			$soma_digitos = 0;
		} else {
			// Se for maior que 2, o resultado é 11 menos $soma_digitos
			// Ex.: 11 - 9 = 2
			// Nosso dígito procurado é 2
			$soma_digitos = 11 - $soma_digitos;
		}
	
		// Concatena mais um dígito aos primeiro nove dígitos
		// Ex.: 025462884 + 2 = 0254628842
		$cpf = $digitos . $soma_digitos;
	
		// Retorna
		return $cpf;
	}

	//FUNÇÃO QUE VALIDA CPF
	
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
            
        	if(!$this->Login_model->check_cpf_usuario_inexistence($cpf)){
                $this->form_validation->set_message('_valid_cpf', '%s não cadastrado');
                return FALSE;
            } else {
            	return TRUE;
            }
            
        } else {
        	$this->form_validation->set_message('_valid_cpf', '%s inválido');
            return FALSE;
        }
    }
    
    //FUNÇÃO QUE VALIDA A SENHA
    
    public function _valid_senha($senha) {
    	
    	$cpf = $this->input->post('inputCPF');
    	
    	if ($this->_valid_cpf($cpf)) {
    		
    		if (!$this->Login_model->check_senha($cpf, $senha)) {
    			$this->form_validation->set_message('_valid_senha', '%s incorreta.');
    			return FALSE;
    		} else {
    			return TRUE;
    		}
    		
    	} else {
    		return TRUE;
    	}	
    }
}