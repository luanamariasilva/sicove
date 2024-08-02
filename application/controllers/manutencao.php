<?php
class manutencao extends CI_Controller {
    
    public function __construct() {
        
        parent::__construct();
        
        $this->load->helper(array('form','url','array','date','html','file'));
        $this->load->library(array('Datas','session','calendar','table','form_validation','email','upload', 'MY_Upload'));
        $this->load->model('manutencao_model');
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

 
//####### CADASTRAR MANUTENÇÃO =-=-=-=-=-=-=-=-=-=-=-=-=-=-
    
    public function cadastrar_manutencao(){
    	
    	$data['title'] = "Cadastrar Manutenção";
    	$data['veiculos'] = $this->veiculo_model->get_veiculos();
       
       	if ($this->form_validation->run('manutencao/cadastrar_manutencao') == FALSE){
    		$this->load->view('template/header_sessao', $data);
    		$this->load->view('manutencao/cadastrar_manutencao');
    		$this->load->view('template/footer');
       	}else {
    		date_default_timezone_set('America/Fortaleza');
    		$data_hora_criacao = date('Y-m-d H:i:s');
    		$qtdservico = count($this->input->post('inputTipo'));
    		$descRegistro = "";
    	
    		for ($i = 0; $i < $qtdservico; $i++) {
    			$valor_formatado = str_replace('.', '',$this->input->post('inputValor')[$i]);
    			$valor_formatado = str_replace(',', '.', $valor_formatado);
    			
    		for ($i = 0; $i < $qtdservico; $i++) {
    			$valor_desconto = str_replace('.', '',$this->input->post('inputdesconto')[$i]);
    			$valor_desconto = str_replace(',', '.', $valor_desconto);
    			
    			
    			$descRegistro .= $this->input->post('inputTipo')[$i].';'.$this->input->post('inputDescricao')[$i].';'.$this->input->post('inputQtde')[$i].';'.$valor_formatado.';'.$valor_desconto.'#';
    			
    		}
	    		$descRegistro = substr($descRegistro, 0,-1);
	    		$input	=	array(
			    	'veiculo_id' 			=> 		$this->input->post('veiculo_id'),
			    	'data' 					=> 		$this->datas->dateToUS($this->input->post('data')),
			    	'resp_trans' 			=> 		$this->input->post('resp_trans'),
			    	'oficina' 				=> 		$this->input->post('oficina'),
			    	'resp_oficina' 			=> 		$this->input->post('resp_oficina'),
			    	'descricao' 			=> 		$this->input->post('descricao'),
			    	//'userfile' 			=> 		$this->input->post('userfile'),
	    			'data_hora_criacao' 	=> 		$data_hora_criacao,
			    	'user_id' 				=> 		$this->session->userdata('codusuario'),
	    			'peca_servico'  		=> 		$descRegistro
			       );
	    		
// 	    		echo "<pre>";
// 	    		print_r($descRegistro);
// 	    		echo "<pre>";
// 	    		exit;
	    		
	    		$retornoInsert = $this->manutencao_model->cadastrar_manutencao($input) ;
        		
        		
	    		if($retornoInsert != FALSE){
	    			
	    			self::upload_arquivo_titulos($input['veiculo_id'],$retornoInsert);
	    			
	    			echo '
	    					
	    					<script type="text/javascript">
							
	    					window.location="'.base_url().'index.php/home_sessao"
	    					alert("Manutenção cadastrada com sucesso!");
							
						  </script>';
    			}else{
    				echo '<script type="text/javascript"> alert("Não foi possível cadastrar Manutençõ! Tente novamente.");window.location="'.base_url().'index.php/home_sessao"</script>';
    			}
    			
    	}
    }
 }    
//####### UPLOAD DOCUMENTO MANUTENÇÃO =-=-=-=-=-=-=-=-=-=-=-=-=-=-
       
    public function upload_arquivo_titulos($veiculo_id, $retornoInsert) {
       
       	
    	$path = "./uploads/".$veiculo_id."/manutencao";
       	if(!is_dir($path)){
    		mkdir($path,0777,TRUE);
    	}
    	
       	$config['upload_path'] = $path.'/';
    	$config['overwrite'] = 'TRUE';
    	$config['allowed_types'] = 'jpg|png|jpeg|pdf|PDF';
    	$config['max_size']	= '30240';
    	$name = $_FILES['userfile']['name'];
    	$name_explode = explode('.', $name);
    	$extensao = $name_explode[count($name_explode) - 1];
    	$config['file_name'] = $retornoInsert;
       	$this->upload->initialize($config);
       	
       	
       	if($_FILES['userfile']['name'] != ""){
       	
    	if (! $this->upload->do_upload('userfile')) {
    		$mensagem = '<div class="alert alert-danger" role="alert">
    						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<strong>Erro no Formulario de Títulos:'.$this->upload->display_errors().'</strong> Preencha os campos novamente!
						</div>';
    		$this->session->set_userdata(array('alert' => $mensagem));
    		
      	}else {
    		$data = array('userfile' => $this->upload->data());
    	}
       	
       	}else{
       		return TRUE;
       	}
    }
    
//####### PESQUISAR MANUTENÇÃO =-=-=-=-=-=-=-=-=-=-=-=-=-=-
    
    public function pesquisar_manutencao(){
    
    	$data['title'] = "Pesquisar Manutenções";
    	$data['veiculos_dropdown'] = $this->veiculo_model->get_veiculos();
    	$data['veiculos'] = "";
    	
    	if ($this->form_validation->run('manutencao/pesquisar_manutencao') == FALSE) {
    	
    		$this->load->view('template/header_sessao', $data);
    		$this->load->view('manutencao/pesquisar_manutencao');
    		$this->load->view('template/footer');
    		
    	}else {
			
			$veiculo_id = $this->input->post('veiculo_id');
			$data['veiculos'] = $this->manutencao_model->pesquisar_manutencao($veiculo_id);
			
// 			echo "<pre>";
// 			print_r($data['veiculos']);
// 			echo "<pre>";
// 			exit; 
			
			$this->load->view('template/header_sessao', $data);
			$this->load->view('manutencao/pesquisar_manutencao');
			$this->load->view('template/footer');
		}    	
    }
    
//####### EDITAR MANUTENÇÃO =-=-=-=-=-=-=-=-=-=-=-=-=-=-
    
	public function editar_manutencao($id_manutencao){
		$data['title'] = "Editar Manutenção";
		$data['manutencao'] = $this->manutencao_model->get_manutencao_id($id_manutencao);
		
		$data['servicos_realizados'] = explode('#',$data['manutencao']['peca_servico']);
		
		if ($this->form_validation->run('manutencao/editar_manutencao') == FALSE) {
	  
			$this->load->view('template/header_sessao', $data);
	 		$this->load->view('manutencao/editar_manutencao');
			$this->load->view('template/footer');
	  
		}else {
			date_default_timezone_set('America/Fortaleza');
			$data_hora_criacao = date('Y-m-d H:i:s');
			$qtdservico = count($this->input->post('inputTipo'));
    		$descRegistro = "";
    		
    		for ($i = 0; $i < $qtdservico; $i++) {
    			$descRegistro .= $this->input->post('inputTipo')[$i].';'.$this->input->post('inputDescricao')[$i].';'.$this->input->post('inputQtde')[$i].';'.$this->input->post('inputValor')[$i].'#';
    		}
	    	$descRegistro = substr($descRegistro, 0,-1);
			
			$input = array(
				'data' 					=> $this->datas->dateToUS($this->input->post('data')),
				'resp_trans' 			=> $this->input->post('resp_trans'),
				'oficina' 				=> $this->input->post('oficina'),
				'resp_oficina' 			=> $this->input->post('resp_oficina'),
				'descricao' 			=> $this->input->post('descricao'),
				'data_hora_criacao' 	=> $data_hora_criacao,
				'user_id' 				=> $this->session->userdata('codusuario'),
				'peca_servico'  		=> $descRegistro
				
			);
				
			self::upload_arquivo_titulos($data['manutencao']['veiculo_id'],$id_manutencao);
			
			$confirmaUpload = $this->input->post('userfile');				
			
			if($this->manutencao_model->editar_manutencao($input, $id_manutencao) == TRUE){
				echo '<script type="text/javascript">
						alert("Dados de manutenção alterados com sucesso!");
						window.location="'.base_url().'index.php/manutencao/pesquisar_manutencao/'.$id_manutencao.'"
					</script>';
			}else{
				echo '<script type="text/javascript"> alert("Não foi possível alterar dados da manutenção! Tente novamente.");window.location="'.base_url().'index.php/manutencao/editar_manutencao"</script>';
			}
	  

	}
}
 
 //####### EXCLUIR MANUTENÇÃO =-=-=-=-=-=-=-=-=-=-=-=-=-=-
    
	public function excluir_manutencao($id_manutencao){
							
		$excluiDoc = $this->manutencao_model->excluir_manutencao($id_manutencao);	
		if($excluiDoc != FALSE){
			$caminho_anexo = "./uploads/".$excluiDoc['veiculo_id']."/manutencao/".$id_manutencao.".pdf";
				echo $caminho_anexo;
				
			unlink($caminho_anexo);
			
				
			echo '<script type="text/javascript">
						alert("Manutenção excluida com sucesso!");
						window.location="'.base_url().'index.php/manutencao/pesquisar_manutencao/'.$id_manutencao.'"
					</script>';
		}else {
			echo '<script type="text/javascript"> alert("Não foi possível excluir a manutenção! Tente novamente.");window.location="'.base_url().'index.php/manutencao/pesquisar_manutencao"</script>';
		}
	}    
	
	

}

