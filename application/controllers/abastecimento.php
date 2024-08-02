<?php
class abastecimento extends CI_Controller {
    
    public function __construct() {
        
        parent::__construct();
        
        $this->load->helper(array('form','url','array','date','html','file'));
        $this->load->library(array('Datas','session','calendar','table','form_validation','email','upload', 'MY_Upload'));
        $this->load->model('abastecimento_model');
        $this->load->model('veiculo_model');
        
        if($this->session->userdata('logado') != TRUE){
            
            $data['title'] = "Sistema de Controle de Veículos";
            
            $this->load->view('template/header_sessao',$data);
            $this->load->view('sessao_expirada');
            $this->load->view('template/footer');
            $this->output->_display();
            exit();
        }
    }

    //####### CADASTRAR ABASTECIMENTO =-=-=-=-=-=-=-=-=-=-=-=-=-=-
    
    public function cadastrar_abastecimento(){
    	 
    	$data['title'] = "Cadastrar Abastecimento";
    	$data['veiculos'] = $this->veiculo_model->get_veiculos();
    	
    	if ($this->form_validation->run('abastecimento/cadastrar_abastecimento') == FALSE){
    		$this->load->view('template/header_sessao', $data);
    		$this->load->view('abastecimento/cadastrar_abastecimento');
    		$this->load->view('template/footer');
    	}else {
    		date_default_timezone_set('America/Fortaleza');
    		$data_hora_criacao = date('Y-m-d H:i:s');  
    		$valor_formatado = str_replace('.', '', $this->input->post('valor'));
    		$valor_formatado = str_replace(',', '.', $valor_formatado);
    		

    		$input	=	array(
    				'veiculo_id' 			=> 		$this->input->post('veiculo_id'),
    				'data' 					=> 		$this->datas->dateToUS2($this->input->post('data')),
    				'valor' 			    => 		$valor_formatado,
    //				'userfile' 			    => 		$this->input->post('userfile'),
    				'data_hora_criacao' 	=> 		$data_hora_criacao,
    				'user_id' 				=> 		$this->session->userdata('codusuario'),
    		    		);
    		 
    		 
    		$retornoInsert = $this->abastecimento_model->cadastrar_abastecimento($input);
    
    
    
    		if($retornoInsert != FALSE){
    
    			self::upload_arquivo_titulos($input['veiculo_id'],$retornoInsert);
    
    			echo '
    
	    					<script type="text/javascript">
				
	    					window.location="'.base_url().'index.php/home_sessao"
	    					alert("Abastecimento cadastrado com sucesso!");
				
						  </script>';
    		}else{
    			echo '<script type="text/javascript"> alert("Não foi possível cadastrar a Abastecimento! Tente novamente.");window.location="'.base_url().'index.php/home_sessao"</script>';
    		}
    	}
    }
    
    //####### UPLOAD DOCUMENTO ABASTECIMENTO =-=-=-=-=-=-=-=-=-=-=-=-=-=-
     
    public function upload_arquivo_titulos($veiculo_id, $retornoInsert) {
    	 
    
    	$path = "./uploads/".$veiculo_id."/abastecimento";
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
    
    //####### PESQUISAR ABASTECIMENTO =-=-=-=-=-=-=-=-=-=-=-=-=-=-
    
    public function pesquisar_abastecimento(){
    
    	$data['title'] = "Pesquisar Abastecimentos";
    	$data['veiculos_dropdown'] = $this->veiculo_model->get_veiculos();
    	$data['veiculos'] = "";
    	 
    	if ($this->form_validation->run('abastecimento/pesquisar_abastecimento') == FALSE) {
    		 
    		$this->load->view('template/header_sessao', $data);
    		$this->load->view('abastecimento/pesquisar_abastecimento');
    		$this->load->view('template/footer');
    
    	}else {
    			
    		$veiculo_id = $this->input->post('veiculo_id');
    		$data['veiculos'] = $this->abastecimento_model->pesquisar_abastecimento($veiculo_id);
    			
    		// 			echo "<pre>";
    		// 			print_r($data['veiculos']);
    		// 			echo "<pre>";
    		// 			exit;
    			
    		$this->load->view('template/header_sessao', $data);
    		$this->load->view('abastecimento/pesquisar_abastecimento');
    		$this->load->view('template/footer');
    	}
    }
    
    //####### EDITAR ABASTECIMENTO =-=-=-=-=-=-=-=-=-=-=-=-=-=-
    
    public function editar_abastecimento($id_abastecimento){
    	$data['title'] = "Editar Abastecimento";
    	$data['abastecimento'] = $this->abastecimento_model->get_abastecimento_id($id_abastecimento);
    
    	if ($this->form_validation->run('abastecimento/editar_abastecimento') == FALSE) {
    		 
    		$this->load->view('template/header_sessao', $data);
    		$this->load->view('abastecimento/editar_abastecimento');
    		$this->load->view('template/footer');
    		 
    	}else {
    		
    		date_default_timezone_set('America/Fortaleza');
    		$data_hora_criacao = date('Y-m-d H:i:s');
    		
    		$valor_formatado = str_replace('.', '', $this->input->post('valor'));
    		$valor_formatado = str_replace(',', '.', $valor_formatado);
    		    			
    		$input = array(
    				'data' 					=> $this->datas->dateToUS($this->input->post('data')),
    				'data_hora_criacao' 	=> $data_hora_criacao,
    				'valor' 		    	=> $valor_formatado,
    				'user_id' 				=> $this->session->userdata('codusuario'),
    				    
    		);
    
//     					echo "<pre>";
//     					print_r($input);
//     					echo "<pre>";
//     					exit;
    		
    		self::upload_arquivo_titulos($data['abastecimento']['veiculo_id'],$id_abastecimento);
    		
    		$confirmaUpload = $this->input->post('userfile');
    		    
    			
    		if($this->abastecimento_model->editar_abastecimento($input, $id_abastecimento) == TRUE){
    			echo '<script type="text/javascript">
						alert("Dados de abastecimento alterados com sucesso!");
						window.location="'.base_url().'index.php/abastecimento/pesquisar_abastecimento/'.$id_abastecimento.'"
					</script>';
    		}else{
    			echo '<script type="text/javascript"> alert("Não foi possível alterar os dados do abastecimento! Tente novamente.");window.location="'.base_url().'index.php/abastecimento/editar_abastecimento"</script>';
    		}
    		 
    
    	}
    }
    
    //####### EXCLUIR ABASTECIMENTO =-=-=-=-=-=-=-=-=-=-=-=-=-=-
    
    public function excluir_abastecimento($id_abastecimento){
    		
    	$excluiDoc = $this->abastecimento_model->excluir_abastecimento($id_abastecimento);
    	if($excluiDoc != FALSE){
    		$caminho_anexo = "./uploads/".$excluiDoc['veiculo_id']."/abastecimento/".$id_abastecimento.".pdf";
    		echo $caminho_anexo;
    
    		unlink($caminho_anexo);
    			
    
    		echo '<script type="text/javascript">
						alert("Abastecimento excluido com sucesso!");
						window.location="'.base_url().'index.php/abastecimento/pesquisar_abastecimento"
					</script>';
    	}else {
    		echo '<script type="text/javascript"> alert("Não foi possível excluir o abastecimento! Tente novamente.");window.location="'.base_url().'index.php/abastecimento/pesquisar_abastecimento"</script>';
    	}
    }
        
}
