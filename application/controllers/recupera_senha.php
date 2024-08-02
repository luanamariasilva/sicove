<?php

class Recupera_senha extends CI_Controller {
	
	public function __construct() {
		
		parent::__construct();
		
		$this->load->helper(array('form','url','array','date','html'));
		$this->load->library(array('Datas','session','calendar','table','form_validation','upload','MY_Upload','email'));
		$this->load->model('Recupera_senha_model');
		
	}
	
	public function index() {

		$cpf = str_replace(array('.', '-'), '', $this->input->post('inputCPF'));
		
		$senha = self::gera_senha(8, TRUE, TRUE, FALSE);
		
		$nova_senha = trim($senha);
		
		$result_email = self::envia_email($nova_senha, $cpf);

		$result_update_senha = $this->Recupera_senha_model->update_usuario_senha($cpf, $nova_senha);

		if ($result_email == TRUE AND $result_update_senha == TRUE) {
				
			$usuario = $this->Recupera_senha_model->pesquisa_usuario($cpf);
			$usuario_email = $usuario['email'];
				
			$alert = '<div class="alert alert-info" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<strong>Sua nova senha foi enviada para o email: '. $usuario_email .'</strong>
				</div>';
			
			$this->session->set_userdata(array('alert' => $alert));
			
			redirect("home");
			
		} else {
			
			$alert = '<div class="alert alert-danger" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<strong>Não foi posivel recuperar a senha! Tente novamente.</strong>
				</div>';
				
			$this->session->set_userdata(array('alert' => $alert));
				
			redirect("home");
		}
	}
	
	/* Métodos auxiliares */
	
	public function envia_email($senha, $cpf) {
		
		$dados_usuario = $this->Recupera_senha_model->pesquisa_usuario($cpf);

		$assunto = "GCONT - Sistema de Gerenciamento de Contratos - Recuperação de Senha";
        $mensagem = 'Prezado(a) <strong>'. $dados_usuario['nome'] .'</strong>,<br /><br /> Esta é sua nova senha de acesso:<br /><br /> <strong>'. $senha .'</strong> <br /><br /> Recomendamos que guarde-a em local seguro e atualize-a periódicamente.<br /><br />';
        $mensagem .= '<strong>Não responder esta mensagem.</strong><br /><br />';
        $mensagem .= "Equipe GCONT<br />";
        $mensagem .= "CTIC - Célula de Tecnologia da Informação e Comunicação<br />";
        $mensagem .= "(85) 3296-0015";

		$this->email->to($dados_usuario['email']);
		$this->email->from('ctic.aesp@gmail.com', 'CTIC-AESP');
		$this->email->reply_to('ctic@aesp.ce.gov.br', 'CTIC-AESP');
		$this->email->subject($assunto);
		$this->email->message($mensagem);

		if ($this->email->send()) {
			$email = TRUE;
		} else {
			$email = FALSE;
		}
		
		return $email;
	}
	
	public function _check_cpf_usuario_inexistence($cpf) {
		
		$cpf = str_replace(array('.', '-'), '', $cpf);
		$this->form_validation->set_message('_check_cpf_usuario_inexistence', 'O %s informado não está cadastrado');
		return $this->Recupera_senha_model->check_cpf_usuario_inexistence($cpf);

	}
	
	/**
	 * Multiplica dígitos vezes posições
	 *
	 * @param string $digitos
	 *        	Os digitos desejados
	 * @param int $posicoes
	 *        	A posição que vai iniciar a regressão
	 * @param int $soma_digitos
	 *        	A soma das multiplicações entre posições e dígitos
	 * @return int Os dígitos enviados concatenados com o último dígito
	 *
	 */
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
	
	function _valid_cpf($cpf = false) {

		// Exemplo de CPF: 025.462.884-23
		$this->form_validation->set_message('_valid_cpf', '%s inválido');
		
		// Verifica se o CPF foi enviado
		if (! $cpf) {
			return false;
		}
		
		// Remove tudo que não é número do CPF
		// Ex.: 025.462.884-23 = 02546288423
		$cpf = preg_replace ( '/[^0-9]/is', '', $cpf );
		
		// Verifica se o CPF tem 11 caracteres
		// Ex.: 02546288423 = 11 números
		if (strlen ( $cpf ) != 11) {
			return false;
		}
		
		// Captura os 9 primeiros dígitos do CPF
		// Ex.: 02546288423 = 025462884
		$digitos = substr ( $cpf, 0, 9 );
		
		// Faz o cálculo dos 9 primeiros dígitos do CPF para obter o primeiro dígito
		$novo_cpf = $this->calc_digitos_posicoes ( $digitos );
		
		// Faz o cálculo dos 10 dígitos do CPF para obter o último dígito
		$novo_cpf = $this->calc_digitos_posicoes ( $novo_cpf, 11 );
		
		// Verifica se o novo CPF gerado é idêntico ao CPF enviado
		if ($novo_cpf === $cpf) {
			// CPF válido
			return true;
		} else {
			// CPF inválido
			return false;
		}
	}
	
	function gera_senha($tamanho = 8, $maiusculas = TRUE, $numeros = TRUE, $simbolos = FALSE) {

		$lmin = 'abcdefghijklmnopqrstuvwxyz';
		$lmai = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$num = '1234567890';
		$simb = '!@#$%';
		$retorno = '';
		$caracteres = '';
	
		$caracteres .= $lmin;
		
		if ($maiusculas){
			$caracteres .= $lmai;
		}
		
		if ($numeros){
			$caracteres .= $num;
		}
		
		if ($simbolos){
			$caracteres .= $simb;
		}
	
		$len = strlen($caracteres);
	
		for ($n = 1; $n <= $tamanho; $n++) {
			$rand = mt_rand(1, $len);
			$retorno .= $caracteres[$rand-1];
		}
	
		return $retorno;
	}	
}