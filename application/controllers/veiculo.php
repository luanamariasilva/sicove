<?php 
//Codigo do CONSTRUTOR
class veiculo extends CI_Controller {
	
	public function __construct() {
		
		parent::__construct();
		
		$this->load->helper(array('form','url','array','date','html','file'));
		$this->load->library(array('Datas','session','calendar','table','form_validation','email'));
		$this->load->model('veiculo_model');
		
		if ($this->session->userdata('logado') != TRUE) {

			$data['title'] = "Sistema de Controle de Veículos";
            
            $this->load->view('template/header_sessao',$data);
			$this->load->view('sessao_expirada');
			$this->load->view('template/footer');
			$this->output->_display();
			exit();
		}
	}
//FUNÇÃO PARA CADASTRO DE DADOS
public function cadastrar(){
	//echo "Função cadastrar";
	$data['title'] = "Cadastrar Veículo";
	
	if ($this->form_validation->run('veiculo/cadastrar') == FALSE){
		$this->load->view('template/header_sessao', $data);
		$this->load->view('veiculo/cadastrar');
		$this->load->view('template/footer');
	
	} else {
		date_default_timezone_set('America/Fortaleza');
		$data_hora_criacao = date('Y-m-d H:i:s');
		$input = array(
				'modelo' 				=> 	strtoupper($this->input->post('modelo')),
				'placa' 				=> 	$this->input->post('placa'),
				'renavan' 				=> 	$this->input->post('renavan'),
				'chassi' 				=> 	$this->input->post('chassi'),
				'cor' 					=> 	strtoupper($this->input->post('cor')),
				'ano' 					=> 	$this->input->post('ano'),
				//TRATAMENTO DE DATA - TRANSFORMA EM DATA AMERICANA PARA QUE O BANCO ACEITE
				'data_emplacamento' 	=> 	$this->datas->dateToUS($this->input->post('data_emplacamento')),
				'combustivel' 			=> 	$this->input->post('combustivel'),
				'prox_licenciamento' 	=> 	$this->datas->dateToUS($this->input->post('prox_licenciamento')),
				'data_hora_criacao' 	=> 	$data_hora_criacao,				
				'user_id' 				=> 	$this->session->userdata('codusuario'),
							
		);
			//echo "<pre>";
			//print_r($input);
			//echo "<pre>";
			//exit;
			
		if($this->veiculo_model->cadastrar($input) == TRUE)
			echo '<script type="text/javascript">
						alert("Veículo cadastrado com sucesso!");
						window.location="'.base_url().'index.php/veiculo/pesquisar"
					</script>';
			else
				echo '<script type="text/javascript"> 
						alert("Não foi possível cadastrar o Veículo! Tente novamente.");
						window.location="'.base_url().'index.php/"
						</script>';
	}
	
	
	
}
//FUNÇÃO PARA PESQUISA DE DADOS
public function pesquisar(){
	
		$data['title'] = "Pesquisar Veículo";
		$data['veiculos_cadastrados'] = $this->veiculo_model->get_veiculos();
		
		$data['veiculos'] = "";
	
		if ($this->form_validation->run('veiculo/pesquisar') == FALSE) {
				
			$this->load->view('template/header_sessao', $data);
			$this->load->view('veiculo/pesquisar');
			$this->load->view('template/footer');
				
		} else {
			
			$veiculo_id = mb_strtoupper($this->input->post('placa'), 'UTF-8');
			redirect("veiculo/editar/".$veiculo_id);
			$data['veiculos'] = $this->veiculo_model->pesquisar($veiculo_id);
			
				
			$this->load->view('template/header_sessao', $data);
			$this->load->view('veiculo/pesquisar');
			$this->load->view('template/footer');
		
		}
}
/*public function editar_dados_veiculos($veiculo_id){
	$data['title'] = "Editar Veículo";
	$data['veiculo'] = $this->veiculo_model->get_veiculo_id($veiculo_id);
	

	if ($this->form_validation->run('veiculo/editar_dados_veiculos') == FALSE) {
	  
		$this->load->view('template/header_sessao', $data);
 		$this->load->view('veiculo/editar_dados_veiculos');
		$this->load->view('template/footer');
	  
	} else {
	  
		$input = array(
				'modelo' 				=> $this->input->post('modelo'),
				'placa' 				=> $this->input->post('placa'),
				'cor' 					=> $this->input->post('cor'),
				'ano' 					=> $this->input->post('ano'),
				//TRATAMENTO DE DATA - TRANSFORMA EM DATA AMERICANA PARA QUE O BANCO ACEITE
				'data_emplacamento' 	=> $this->datas->dateToUS($this->input->post('data_emplacamento')),
				'combustivel' 			=> $this->input->post('combustivel'),
				'prox_licenciamento' 	=> $this->datas->dateToUS($this->input->post('prox_licenciamento')),

		);
	  
		if($this->veiculo_model->editar($input, $veiculo_id) == TRUE){
			echo '<script type="text/javascript">
						alert("Dados de veículo alterados com sucesso!");
						window.location="'.base_url().'index.php/veiculo/editar_dados_veiculos/'.$veiculo_id.'"
					</script>';
		}else{
			echo '<script type="text/javascript"> alert("Não foi possível alterar dados do veículo! Tente novamente.");window.location="'.base_url().'index.php/"</script>';
		}
	  
		// 	    			echo "<pre>";
		// 	    			print_r($input);
		// 	    				echo "<pre>";
		// 	    				exit;
	}


}
*/
//FUNÇÃO PARA EDIÇÃO DE DADOS
public function editar_dados_veiculos($veiculo_id){
    $data['title'] 					= "Editar Veículo";
	$data['veiculo'] 				= $this->veiculo_model->get_veiculo_id($veiculo_id);
		
	if ($this->form_validation->run('veiculo/editar') == FALSE) {
	    
	    $this->load->view('template/header_sessao', $data);
	    $this->load->view('veiculo/editar_dados_veiculos');
	    $this->load->view('template/footer');
	    
	} else {
	    
	    $input = array(
	        'modelo' 				=> $this->input->post('modelo'),
	        'placa' 				=> $this->input->post('placa'),
	    	'renavan' 				=> $this->input->post('renavan'),
	    	'chassi' 				=> $this->input->post('chassi'),
	        'cor' 					=> $this->input->post('cor'),
	        'ano' 					=> $this->input->post('ano'),
	    	//TRATAMENTO DE DATA - TRANSFORMA EM DATA AMERICANA PARA QUE O BANCO ACEITE
	    	'data_emplacamento' 	=> $this->datas->dateToUS($this->input->post('data_emplacamento')),
	        'combustivel' 			=> $this->input->post('combustivel'),
	        'prox_licenciamento' 	=> $this->datas->dateToUS($this->input->post('prox_licenciamento')),

	    );
	    
	    if($this->veiculo_model->editar($input, $veiculo_id) == TRUE){
	        echo '<script type="text/javascript">
						alert("Dados de veículo alterados com sucesso!");
						window.location="'.base_url().'index.php/veiculo/editar_dados_veiculos/'.$veiculo_id.'"
					</script>';
	    }else{
	            echo '<script type="text/javascript"> alert("Não foi possível alterar dados do veículo! Tente novamente.");window.location="'.base_url().'index.php/"</script>';
	    }
	    
// 	    			echo "<pre>";
// 	    			print_r($input);
// 	    				echo "<pre>";
// 	    				exit;
	}

	
}
//FUNÇÃO PARA EXCLUSÃO DE DADOS
public function excluir($veiculo_id){
	
	if($this->veiculo_model->excluir($veiculo_id) == TRUE){
		echo '<script type="text/javascript">
					alert("Veículo excluido com sucesso!");
					window.location="'.base_url().'index.php/veiculo/pesquisar"
				</script>';
	}else {
			echo '<script type="text/javascript"> alert("Não foi possível excluir o Veículo! Tente novamente.");window.location="'.base_url().'index.php/"</script>';
	}
}

}