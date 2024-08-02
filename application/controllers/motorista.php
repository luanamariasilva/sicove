<?php
class Motorista extends CI_Controller {
    
    public function __construct() {
        
        parent::__construct();
        
        $this->load->helper(array('form','url','array','date','html','file'));
        $this->load->library(array('Datas','session','calendar','table','form_validation','email','upload', 'MY_Upload'));
        $this->load->model('abastecimento_model');
        $this->load->model('veiculo_model');
        $this->load->model('motorista_model');
        
        
        if($this->session->userdata('logado') != TRUE){
            
            $data['title'] = "Sistema de Controle de Veículos";
            
            $this->load->view('template/header_sessao',$data);
            $this->load->view('sessao_expirada');
            $this->load->view('template/footer');
            $this->output->_display();
            exit();
        }
    }

    //####### CADASTRAR MOTORISTA =-=-=-=-=-=-=-=-=-=-=-=-=-=-
    public function get_motoristas(){
    	$this->motorista_model->get_motorista_ativos();
    }
    
    public function cadastrar_motoristas(){
    	$data['title'] = "Cadastrar Motoristas";
//     	$data['veiculos'] = $this->veiculo_model->get_veiculos();
//     	$data['motoristas'] = $this->motorista_model->get_motoristas();
    	
    	
    	//      	echo "<pre>";
    	//      		print_r($data['veiculos']);
    	//      	echo "<pre>";
    	//      	exit;
    	
    	if ($this->form_validation->run('motorista/cadastrar_motoristas') == FALSE){
    	
    		$this->load->view('template/header_sessao', $data);
    		$this->load->view('motorista/cadastrar_motoristas');
    		$this->load->view('template/footer');
    	
    	}else {
    		$input = array(
    			'nome' 					=> $this->input->post('nome'),
		    	'cpf' 					=> $this->input->post('cpf'),
	    		'cnh' 					=> $this->input->post('cnh'),
		    	'validade_habilitacao' 	=> $this->input->post('validade_habilitacao'),
    		);
    		
    		
    		$retornoInsert = $this->motorista_model->cadastrar_motorista($input);
    		
    			if($retornoInsert == 1){
	     			$this->session->set_userdata('alert', '<div class="alert alert-success"><h5><b>Motorista cadastrado com sucesso!</b></h5></div>');
	     			redirect('motorista/cadastrar_motoristas');
	     		}elseif($retornoInsert == 2){
	     			$this->session->set_userdata('alert', '<div class="alert alert-danger"><h5><b>O CPF já foi cadastrado</b></h5></div>');
	     			redirect('motorista/cadastrar_motoristas');
	     		}else{
	     			$this->session->set_userdata('alert', '<div class="alert alert-danger"><h5><b>Não foi possível cadastrar o motorista, tente novamente!</b></h5></div>');
	     			redirect('motorista/cadastrar_motoristas');
	     		}
	     		
    	}
    }
    
    public function editar_motorista($cpf){
    	$data['title'] = "Editar Motoristas";
		$data['motorista'] = $this->motorista_model->pesquisar_motorista($cpf);
		$data['cpf'] = $cpf;
    	
    	if ($this->form_validation->run('motorista/editar_motorista') == FALSE){
    		 
    		$this->load->view('template/header_sessao', $data);
    		$this->load->view('motorista/editar_motorista');
    		$this->load->view('template/footer');
    		 
    	}else {
    		$input = array(
    				'nome' 					=> $this->input->post('nome'),
    				'cpf' 					=> $this->input->post('cpf'),
    				'cnh' 					=> $this->input->post('cnh'),
    				'validade_habilitacao' 	=> $this->input->post('validade_habilitacao'),
    		);
    		
    		$retorno = $this->motorista_model->editar_motorista($input);
    		
    		if($retorno == TRUE){
    			$this->session->set_userdata('alert', '<div class="alert alert-success"><h5><b>Motorista atualizado com sucesso!</b></h5></div>');
    			redirect('motorista/pesquisar_motoristas');
    		}else{
    			$this->session->set_userdata('alert', '<div class="alert alert-danger"><h5><b>Não foi possível atualizar o motorista, tente novamente!</b></h5></div>');
    			redirect('motorista/pesquisar_motoristas');
    		}
    	}
    }
    
    public function excluir_motorista($cpf){
		$retorno = $this->motorista_model->excluir_motorista($cpf);
		
		if($retorno == TRUE){
			$this->session->set_userdata('alert', '<div class="alert alert-success"><h5><b>Motorista excluído com sucesso!</b></h5></div>');
			redirect('motorista/pesquisar_motoristas');
		}else{
			$this->session->set_userdata('alert', '<div class="alert alert-danger"><h5><b>Não foi possível excluir o motorista, tente novamente!</b></h5></div>');
			redirect('motorista/pesquisar_motoristas');
		}
    }
    
    public function pesquisar_motoristas($motorista = ''){
    	
    	$data['title'] = "Pesquisar Motoristas";
    	$data['motorista'] = '';
    	
    	if ($this->form_validation->run('motorista/pesquisar_motoristas') == FALSE){
    		 
    		$this->load->view('template/header_sessao', $data);
    		$this->load->view('motorista/pesquisar_motorista');
    		$this->load->view('template/footer');
    		 
    	}else {
    		
    		$nome = $this->input->post('nome');
    		
    		$data['motorista'] = $this->motorista_model->pesquisar_motorista($nome);
    		
    		$this->load->view('template/header_sessao', $data);
    		$this->load->view('motorista/pesquisar_motorista');
    		$this->load->view('template/footer');
    	}
    }
    
     public function uso_veiculo(){
     	
     	$data['title'] = "Uso de Veículo";
     	$data['veiculos'] = $this->veiculo_model->get_veiculos();
     	$data['motoristas'] = $this->motorista_model->get_motoristas();
     	
     	
//      	echo "<pre>";
//      		print_r($data['veiculos']);
//      	echo "<pre>";
//      	exit;
     	
     	if ($this->form_validation->run('motorista/uso_veiculo') == FALSE){
     	
     		$this->load->view('template/header_sessao', $data);
     		$this->load->view('motorista/uso_veiculo');
     		$this->load->view('template/footer');
     	
     	}else {
     		date_default_timezone_set('America/Los_Angeles');
     		 
     		if(strtotime($this->input->post('horario_saida')) <= strtotime($this->input->post('horario_retorno'))){
	     		$input	=	array(
	     				'id_veiculo' 					=> 		$this->input->post('veiculo_id'),
	     				'codmotorista' 					=> 		$this->input->post('motorista'),
	     				'horario_saida' 		    	=> 		$this->input->post('horario_saida'),
	     				'horario_retorno' 				=> 		$this->input->post('horario_retorno'),
	     				'km_saida'	 					=> 		$this->input->post('km_saida'),
	     				'km_retorno' 					=> 		$this->input->post('km_retorno'),
	     				'observacoes' 					=> 		$this->input->post('observacoes'),
	     		);
	     		
	     		$retornoInsert = $this->motorista_model->cadastrar_uso_veiculo($input);
	     		
	     		if($retornoInsert == TRUE){
	     			$this->session->set_userdata('alert', '<div class="alert alert-success"><h5><b>Registro de uso realizado com sucesso!</b></h5></div>');
	     			redirect('motorista/uso_veiculo');
	     		}else{
	     			$this->session->set_userdata('alert', '<div class="alert alert-danger"><h5><b>Não foi possível realizar o registro do uso do veículo, tente novamente!</b></h5></div>');
	     			redirect('motorista/uso_veiculo');
	     		}
     		}else{
     			$this->session->set_userdata('alert', '<div class="alert alert-danger"><h5><b>A data de retorno deve ser maior ou igual a data de saída</b></h5></div>');
     			redirect('motorista/uso_veiculo');
     		}
 }
 
}
}