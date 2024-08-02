<?php
class relatorio extends CI_Controller {
    
    public function __construct() {
        
        parent::__construct();
        
        $this->load->helper(array('form','url','array','date','html','file'));
        $this->load->library(array('Datas','session','calendar','table','form_validation','email','upload', 'MY_Upload'));
        $this->load->model('abastecimento_model');
        $this->load->model('manutencao_model');
        $this->load->model('veiculo_model');
        $this->load->model('relatorio_model');
        $this->load->model('motorista_model');
        
        
        if ($this->session->userdata('logado') != TRUE) {
            
            $data['title'] = "Sistema de Controle de Veículos";
            
            $this->load->view('template/header_sessao',$data);
            $this->load->view('sessao_expirada');
            $this->load->view('template/footer');
            $this->output->_display();
            exit();
        }
    }
    
    
    // IMPRIME O RELATORIO OPERACIONAL:

public function relatorio_uso_veiculo(){
	$data['title'] = "Relatório de Uso do Veículo";
	$data['veiculos'] = $this->veiculo_model->get_veiculos();
	$data['dados_uso'] = "";
	$data['data_inicial'] = "";
	$data['data_final'] = "";
	
	if ($this->form_validation->run('relatorio/relatorio_uso_veiculo') == FALSE){
		
		$this->load->view('template/header_sessao', $data);
		$this->load->view('relatorio/relatorio_uso_veiculo');
		$this->load->view('template/footer');
	
	}else {
		
		$input = array(
				"veiculo"    		=> $this->input->post('veiculo'),
				"data_inicial"    	=> $this->input->post('data_inicial'),
				"data_final"    	=> $this->input->post('data_final'),
		);
		
		$data['dados_uso'] = $this->relatorio_model->get_dados_uso($input);
		$data['data_inicial'] = $this->input->post('data_inicial');
		$data['data_final'] = $this->input->post('data_final');
		$data['veiculo'] = $this->input->post('veiculo');
		
		
		
		$this->load->view('template/header_sessao', $data);
		$this->load->view('relatorio/relatorio_uso_veiculo');
		$this->load->view('template/footer');
	}
	
}

public function relatorio_uso_motorista(){
	$data['title'] = "Relatório de Uso pelo Motorista";
	$data['motoristas'] = $this->motorista_model->get_motoristas();
	$data['dados_uso'] = "";
	$data['data_inicial'] = "";
	$data['data_final'] = "";
	
	if ($this->form_validation->run('relatorio/relatorio_uso_motorista') == FALSE){
	
		$this->load->view('template/header_sessao', $data);
		$this->load->view('relatorio/relatorio_uso_motorista');
		$this->load->view('template/footer');
	
	}else {
	
		$input = array(
				"motorista"    		=> $this->input->post('motorista'),
				"data_inicial"    	=> $this->input->post('data_inicial'),
				"data_final"    	=> $this->input->post('data_final'),
		);
	
		$data['dados_uso'] = $this->relatorio_model->get_dados_uso_motorista($input);
		$data['data_inicial'] = $this->input->post('data_inicial');
		$data['data_final'] = $this->input->post('data_final');
		$data['motorista'] = $this->input->post('motorista');
	
	
	
		$this->load->view('template/header_sessao', $data);
		$this->load->view('relatorio/relatorio_uso_motorista');
		$this->load->view('template/footer');
	}
}

public function gerar_relatorio_uso_veiculo($data_inicial, $data_final, $veiculo){
	$input = array(
				"veiculo"    		=> $veiculo,
				"data_inicial"    	=> $data_inicial,
				"data_final"    	=> $data_final,
		);
// 		print_r($this->session->all_userdata());
// 		exit;
		$dados_uso = $this->relatorio_model->get_dados_uso($input);
		
		$CI = & get_instance();
		$CI->load->library(array('Datas'));
		
		$data_inicial = explode('T', $data_inicial);
		$data_inicial = explode('-', $data_inicial[0]);
		$data_inicial = $data_inicial[2].'/'.$data_inicial[1].'/'.$data_inicial[0];
		
		$data_final = explode('T', $data_final);
		$data_final = explode('-', $data_final[0]);
		$data_final = $data_final[2].'/'.$data_final[1].'/'.$data_final[0];
		 
		date_default_timezone_set( 'America/Fortaleza' );
		setlocale( LC_ALL, 'pt_BR', 'pt_BR.iso-8859-1', 'pt_BR.utf-8', 'portuguese' );
		
			ob_start();
   	 
   	//####### INCLUSÃO A BIBLIOTECA HTML2PDF QUE GERA O PDF-=-=-=-=-=-=-=-=-=-=-=-=-=-
   	 
   	include_once(APPPATH . 'libraries/html2pdf_v4.03/html2pdf.class.php');
   	 
   	$html2pdf = new HTML2PDF('L','A4','pt','UTF-8');
   	$html2pdf->pdf->SetDisplayMode('fullpage');
   	 
   	//####### CADA CONTENT INCLUI UM CONTEÚDO NO PDF, SENDO ESCRITO EM HTML-=-=-=-=-=-=-=-=-=-=-=-=-=-
   	 
   	$content = "
  
	<page backtop='35mm' backbottom='20mm'  backleft='2mm' backright='15mm' style='font-size: 9pt'>
   
	   <page_header>
			  <table style='margin-top: 20px; width: 100%; border-bottom: solid 0px grey;'>
			     <tr>
					   <td style='padding-left:200px; text-align:center; width: 50%; border: 0px solid grey;'>
					   <img src='images/logo.jpg' width='220' >
					   </td>
					   
					   <td style='text-align: left; width: 50%; border: 0px solid grey''>
					   <img width='210' src='images/gov_pdf_sem_fundo.png'>
					   </td>
			    </tr>
			  </table>
     </page_header>
   			
  	<page_footer>	
   			
   	<table  style='width: 98%; padding:1%; margin-left:10px; border: 0px solid #ceced7; font-size:7pt;'>
		<tr>
			<td  style='text-align: right; width: 100%; border: 0px solid'>
			<img  width='15' src='images/livro.png'>
			<i>EMITIDO POR ".mb_strtoupper($this->session->userdata('usuario'),'UTF-8')." EM ".date('d/m/Y')." &agrave;s ".date('H:i:s')."</i>
			</td>
		</tr>
   </table>	
   			
         <div style='font-size:8pt; text-align:center; margin-top:15px; '>
			<strong > Academia Estadual de Segurança Pública do Ceará</strong><br>  
    		Avenida Presidente Costa e Silva, 1251 – Mondubim – Fortaleza/CE - CEP: 60.761-505 Fone: (85) 32960469 <br> 
    		© ".date('Y')." - Governo do Estado do Ceará. Todos os Direitos Reservados<br>
         </div> 
  </page_footer>
				";
   	
   		$content .= "
   				<table style='margin-left:5px; width=100%; border:1px solid #ceced7; border-collapse:collapse; font-size:8pt; padding-top:15px;' align='center'>
   	  			
   	  			  <thead>
   	  					<tr>
	   	  			         <td style=' border:1px solid #ceced7; width:105%; padding:15px;'align='center' colspan='9'>
	   	  			              <b>RELATÓRIO DE USO DO VEÍCULO, PERÍODO DE ".$data_inicial." A ".$data_final."</b> 
   					         </td>
	   	  			   </tr>
    					<tr>
                			<th style='padding:8px; border:solid #ceced7 1px; text-align:center; background-color: #dcdce7;'>VEÍCULO</th>
   							<th style='padding:8px; border:solid #ceced7 1px; text-align:center; background-color: #dcdce7;'>MOTORISTA</th>
               				<th style='padding:8px; border:solid #ceced7 1px; text-align:center; background-color: #dcdce7;'>QUILOMETRAGEM NA SAÍDA</th>
                			<th style='padding:8px; border:solid #ceced7 1px; text-align:center; background-color: #dcdce7;'>QUILOMETRAGEM NO RETORNO</th>
                			<th style='padding:8px; border:solid #ceced7 1px; text-align:center; background-color: #dcdce7;'>HORÁRIO DE SAÍDA</th>
                			<th style='padding:8px; border:solid #ceced7 1px; text-align:center; background-color: #dcdce7;'>HORÁRIO DE RETORNO</th>
    					</tr>
    			</thead>
    				<tbody>	   	  			         
   				";
   		foreach($dados_uso as $key => $item){
   
  $item['horario_saida'] = explode(' ', $item['horario_saida']);
  $hora = $item['horario_saida'][1];
  $item['horario_saida'] = explode('-', $item['horario_saida'][0]);
  $item['horario_saida'] =$item['horario_saida'][2]."/".$item['horario_saida'][1]."/".$item['horario_saida'][0]." ". $hora;
  
  $item['horario_retorno'] = explode(' ', $item['horario_retorno']);
  $hora2 = $item['horario_retorno'][1];
  $item['horario_retorno'] = explode('-', $item['horario_retorno'][0]);
  $item['horario_retorno'] =$item['horario_retorno'][2]."/".$item['horario_retorno'][1]."/".$item['horario_retorno'][0]." ". $hora2;  
//   echo "<pre>";
//      print_r($item['horario_saida']);
//   echo "</pre>";
//   exit;
	   		$content .="<tr>
	   						<td style='border: 1px solid #ceced7; width: 20%; font-size: 12px; text-align: center; padding:8px;'>".$item['nome_veiculo']." - ".$item['placa']."</td>
	   						<td style='border: 1px solid #ceced7; width: 12%; font-size: 12px; text-align: center; padding:8px;'>".$item['nome']."</td>
	   						<td style='border: 1px solid #ceced7; width: 2%; font-size: 12px; text-align: center; padding:8px;'>".$item['km_saida']."</td>
	   						<td style='border: 1px solid #ceced7; width: 2%; font-size: 12px; text-align: center; padding:8px;'>".$item['km_retorno']."</td>
	   						<td style='border: 1px solid #ceced7; width: 10%; font-size: 12px; text-align: center; padding:8px;'>".$item['horario_saida']."</td>
	   						<td style='border: 1px solid #ceced7; width: 10%; font-size: 12px; text-align: center; padding:8px;'>".$item['horario_retorno']."</td>
	   					</tr>
	   				";
   		}
   		$content .= "
   					</tbody>
   				</table>
   				";
   
   
   		$content .= "</page>";
   
   		//####### EXECUTA A FUNÇÃO DA BIBLIOTECA QUE GERA O PDF-=-=-=-=-=-==-=-
   		 
   		 
   		$nome = 'Relatório de Uso.pdf';
   		$html2pdf->WriteHTML($content);
   		$html2pdf->Output($nome,'I');
   
   		ob_end_flush();
}
    
public function relatorio_operacional(){
    	
    	$data['title'] = "Relatório Operacional";
    	$data['veiculos'] = $this->veiculo_model->get_veiculos();
    	$data['dados_manutencao'] = "";
    	$data['dados_abastecimento'] = "";
    	 
    	if ($this->form_validation->run('relatorio/relatorio_operacional') == FALSE){
    		$this->load->view('template/header_sessao', $data);
    		$this->load->view('relatorio/relatorio_operacional');
    		$this->load->view('template/footer');
    		
    	}else {
    		 
    		
    		$input	= array(
    				'data_inicial' 	=> $this->datas->dateToUS2($this->input->post('data_inicial')),
    				'data_final' 	=> $this->datas->dateToUS2($this->input->post('data_final')),
    				'veiculo_id' 	=> $this->input->post('veiculo_id'),
    				    		    		);
    		
    		$retornoInsert = $this->relatorio_model->get_manutencao_operacional($input);
    		$retornoInsert = $this->relatorio_model->get_abastecimento_periodo($input);
    	
    		
    		date_default_timezone_set('America/Fortaleza');
    		$data_hora_criacao = date('Y-m-d H:i:s');
    		$qtdservico = count($this->input->post('inputTipo'));
    		$descRegistro = "";
    		
    		
    		$veiculo_id = $input['veiculo_id'];
    		$data_inicial = $input['data_inicial'];
    		$data_final = $input['data_final'];
    		
    	
    		$data['veiculo_id'] = $veiculo_id;
    		$data['data_inicial'] = $data_inicial;
    		$data['data_final'] = $data_final;
    		
    		
    		$data['dados_manutencao'] = $this->relatorio_model->get_manutencao_operacional($input);
    		$data['dados_abastecimento'] = $this->relatorio_model->get_abastecimento_periodo($input);
    		
    		
    		$this->load->view('template/header_sessao', $data);
    		$this->load->view('relatorio/relatorio_operacional');
    		$this->load->view('template/footer');
    }

   }
    

   //IMPRIME O RELATÓRIO ABASTECIMENTO
   
    public function relatorio_abastecimento(){
    	 
    	$data['title'] = "Relatório de Abastecimento";
    	$data['veiculos'] = $this->veiculo_model->get_veiculos();
    	$data['dados_abastecimento'] = "";
    
    	if ($this->form_validation->run('relatorio/relatorio_abastecimento') == FALSE){
    		$this->load->view('template/header_sessao', $data);
    		$this->load->view('relatorio/relatorio_abastecimento');
    		$this->load->view('template/footer');
    	}else {
    		 
    
    		$input	= array(
    				'data_inicial' 	=> $this->datas->dateToUS2($this->input->post('data_inicial')),
    				'data_final' 	=> $this->datas->dateToUS2($this->input->post('data_final')),
    				'veiculo_id' 	=> $this->input->post('veiculo_id'),
    		);
    
    		$retornoInsert = $this->relatorio_model->get_abastecimento_periodo($input);
    		 
    
    		date_default_timezone_set('America/Fortaleza');
    		$data_hora_criacao = date('Y-m-d H:i:s');
    		$qtdservico = count($this->input->post('inputTipo'));
    		$descRegistro = "";
    
    
    		$veiculo_id = $input['veiculo_id'];
    		$data_inicial = $input['data_inicial'];
    		$data_final = $input['data_final'];
    
    
    
    		 
    		$data['veiculo_id'] = $veiculo_id;
    		$data['data_inicial'] = $data_inicial;
    		$data['data_final'] = $data_final;
    		$data['dados_abastecimento'] = $this->relatorio_model->get_abastecimento_periodo($input);
    
    		$this->load->view('template/header_sessao', $data);
    		$this->load->view('relatorio/relatorio_abastecimento');
    		$this->load->view('template/footer');
    	}
    
    }
    
    
     
    //####### GERAR PDF DO RELATÓRIO OPERACIONAL =-=-=-=-=-=-=-=-=-=-=-=-=-=-
    
    public function gerar_realtorio_veiculo_pdf($veiculo_id){
    	$CI = & get_instance();
    	$CI->load->library(array('Datas'));
    	
    	$dados_abastecimento = $this->relatorio_model->get_abastecimento_veiculo($veiculo_id);
    	$dados_manutencao = $this->relatorio_model->get_manutencao_veiculo($veiculo_id);
    	
    	date_default_timezone_set( 'America/Sao_Paulo' );
    	setlocale( LC_ALL, 'pt_BR', 'pt_BR.iso-8859-1', 'pt_BR.utf-8', 'portuguese' );
//     	echo '<pre>';
//     	print_r($dados_abastecimento);
//     	echo '<pre>';
//     	exit;
		
    
    	ob_start();
    	
   //####### INCLUSÃO DA BIBLIOTECA HTML2PDF QUE GERA O PDF-=-=-=-=-=-=-=-=-=-=-=-=-=-
    		
    	include_once(APPPATH . 'libraries/html2pdf_v4.03/html2pdf.class.php');
    	
    	$html2pdf = new HTML2PDF('L','A4','pt','UTF-8');
    	$html2pdf->pdf->SetDisplayMode('fullpage');
   
   //####### CADA CONTENT INCLUI UM CONTEÚDO NO PDF, SENDO ESCRITO EM HTML-=-=-=-=-=-=-=-=-=-=-=-=-=-
    	
    	$content = "
				
				<page backtop='17mm' backbottom='7mm' backleft='5mm' backright='7mm'  style='font-size: 10pt'  >
    	
    					<table style='width: 100%; margin-top:-55px; margin-left: 10mm; border-bottom: solid 0px grey;'>
				            <tr>
				                <td style='text-align: center; width: 49%; border: 0px solid'>
				                	<img width='220' src='images/logo_left.jpg'>
				                </td>
				                <td style='text-align: center; width: 49%; border: 0px solid'>
				                	<img width='240' src='images/gov_pdf.jpg'>
				                </td>
				            </tr>
						</table>
				";
    	
    	$content .= "
    			<style>
    			h1 {
    			text-align: center;
    			font-size: 28px;
    			}
    			h2{
    			text-align: center;
    			font-size: 20px;
    			}
    			p {
    			text-align: justify;
    			font-size: 16px;
    			margin-right: 10mm;
    			margin-left: 10mm;
    			}
    			.table{
    			margin-left: 0mm;
    			
    			}
    			th{
    			border: 1px solid grey;
    			font-size: 18px;
    			text-align: center;
    			background-color: #349360;
    			height: 8mm;

 			   }
    			td{
    			font-size: 16px;			
    }
 	   			</style>
    			";
    	
    	$content.= "
    			<br>
    			<br>
    			<h1>Relatório de abastecimento e manutenção de veículos</h1>
    			<br>
    			<br>
    			<br>
    			";
    	
    	$content .= "
    			
    			<p>O relatório presente neste documento traz as informações de abastecimento e manutenção dos veículos da Academia Estadual de Segurança Pública por meio do Sistema de Controle de Veículos (SISCOVE). </p>
    			<br>

    			";
    	if(count($dados_abastecimento) > 0){
    		$content .= "<br>
   				<h2>Veículo: ".$dados_abastecimento[0]['placa']."</h2>
   				<br>
    			";
    	}
    	else{
    		$content .= "<br>
   				<h2>Veículo: ".$dados_manutencao[0]['placa']."</h2>
   				<br>
    			";}
    	$content .= "<br>
    			<h2>Dados de Manutenção</h2>
    			<br>
    			";
    	$content .= "
    		
    		<table  style='margin-left: 30mm; border: 0.8px solid grey; border-collapse: collapse;'>	
             		<thead>
    					<tr style='border: 0.8px solid grey;'>
                			<th>Data</th> 
               				<th>Responsável</th>
                			<th>Oficina</th>
                			<th>Tipo</th>
                			<th>Descricao</th>
                			<th style = 'width: 25mm'>QTD</th>
                			<th>Valor</th>
    					</tr>
    				</thead>
    				<tbody>	
    				"; 
    	$valor_manutencao_total = 0;
    	$valor_total_abastecimento = 0;
    	$valor_servico_total = 0;
    	$valor_peca_total = 0;
    	
    	//####### O LOOPING CRIA UMA LINHA NA TABELA PARA CADA DADO DE MANUTENÇÃO-=-=-=-=-=-==-=-
    	
    	foreach($dados_manutencao as $dado_manutencao){
    		$data = $CI->datas->dateToBR($dado_manutencao['data']);
    		$resp_trans = $dado_manutencao['resp_trans'];
    		$oficina = $dado_manutencao['oficina'];
    
    		
    		$array_peca_servico = explode("#",$dado_manutencao['peca_servico']);
    		 
    		$string_exibicao = "";
    		$valor_manutencao = 0;
    		
    		//####### O LOOPING DIVIDE A STRING DO SERVIÇO-=-=-=-=-=-==-=-
    		 
    		foreach ($array_peca_servico as $chave => $item_array){
    		
    			$exibicao_peca_servico = explode(";",$array_peca_servico[$chave]);
    		
    			if($exibicao_peca_servico[0] == 1){
    				$exibicao_peca_servico[0] = "Peça";
    				$valor_peca = $exibicao_peca_servico[3];
    				$valor_peca_total += $valor_peca;
    				
    			}else{
    				$exibicao_peca_servico[0] = "Serviço";
    				$valor_servico = $exibicao_peca_servico[3];
    				$valor_servico_total += $valor_servico;
    				 
    				
    				
    			}
    		
    			$string_exibicao .= "<br>";
    			
    			$content .= '<tr>			
								<td style="border: 1px solid grey; width: 20mm; font-size: 14px; text-align: center;">'.$CI->datas->dateToBR($dado_manutencao['data']).'</td>
	    		                <td style="border: 1px solid grey; width: 35mm; font-size: 14px; text-align: center;">'.$dado_manutencao["resp_trans"].'</td>
	    		                <td style="border: 1px solid grey; width: 30mm; font-size: 14px; text-align: center;">'.$dado_manutencao['oficina'].'</td>
	    		               			
									
					';
    			
    		
    			foreach ($exibicao_peca_servico as $key => $item){
    		
    				 
    				if($key == 3){
    					$valor_manutencao = $valor_manutencao + $item;
    				}
    				
    				$content .= '
								 <td style="border: 1px solid grey; font-size: 14px; text-align: center; height: 8mm">'.$item.'</td>
    				
	    		            ';
    				
    				
    				 
    				$string_exibicao .= $item." - ";
    				 
    			}
    			
    			$content .= '</tr>';
    		
    		
    			$string_exibicao = substr($string_exibicao,0,-3);
    			
    		
    		
    		}
    		
    		$valor_manutencao_total = $valor_manutencao_total + $valor_manutencao;
    			
    		$string_exibicao .= "<br>Total: R$ ".number_format($valor_manutencao,2,',','.');
    						
    	}
    		
    		$valor_manutencao_total = number_format($valor_manutencao_total,2,',','.');
    		$valor_servico_total = number_format($valor_servico_total,2,",",".");
    		$valor_peca_total = number_format($valor_peca_total,2,",",".");
    		$content .= '
    				

        				<tr>
        					<td colspan="6" class="table-active" style="border: 1px solid grey;"><strong>Valor Total de Peça: </strong></td>
       		 				<td style="border: 1px solid grey;  text-align: center; font-size: 16px; height: 8mm;"><strong>R$ '.$valor_peca_total.'</strong></td>
        				</tr>
        	
        				<tr>
        					<td colspan="6" class="table-active" style="border: 1px solid grey;"><strong>Valor Total de Serviço: </strong></td>
       		 				<td style="border: 1px solid grey;  text-align: center; font-size: 16px; height: 8mm;"><strong>R$ '.$valor_servico_total.'</strong></td>
        				</tr>
        	
        				<tr>
        					<td colspan="6" class="table-active" style="border: 1px solid grey;"><strong>Valor Total: </strong></td>
       		 				<td style="border: 1px solid grey;  text-align: center; font-size: 16px; height: 8mm;""><strong>R$ '.$valor_manutencao_total.'</strong></td>
        				</tr>
       				</tbody>
    		
    		</table>
    			    ';
    		
    		
    		$content .= "
    			<page_footer>
    				<div style='width: 100%; border-top: 0.8px solid gray; text-align: center; line-height:135%; font-size: 10px; padding-top:5px;'>
    				<b> Academia Estadual de Segurança Pública</b> <br>
    					Avenida Presidente Costa e Silva, 1251 – Mondubim – Fortaleza/CE - CEP: 60.761-505 Fone: (85) 32960469 <br>
    					© 2022 - Governo do Estado do Ceará. Todos os Direitos Reservados
    				</div>
    		</page_footer>
   
    			";
    		 
    		 
    		$content .= "</page>";
    		$content .= "
    				<page backtop='17mm' backbottom='7mm' backleft='5mm' backright='7mm'  style='font-size: 10pt' >
    				<table style='width: 100%; margin-top:-55px; margin-left: 10mm; border-bottom: solid 0px grey;'>
				            <tr>
				                <td style='text-align: center; width: 49%;'>
				                	<img width='220' src='images/logo_left.jpg'>
				                </td>
				                <td style='text-align: center; width: 49%;'>
				                	<img width='240' src='images/gov_pdf.jpg'>
				                </td>
				            </tr>
						</table>
    				<br>
    				<br>
    				<h2>Dados Abastecimento</h2>
    				";
    		$content .= "
    				<table  style='margin-left: 80mm; border: 0.8px solid grey; border-collapse: collapse;'>
    					<thead>
    						<tr>
    							<th>Data</th>
    							<th>Valor do Abastecimento</th>
    						</tr>
    					</thead>
    					<tbody>
    				";
    		
    		//####### O LOOPING CRIA UMA LINHA NA TABELA PARA CADA DADO DE ABASTEECIMENTO-=-=-==-==-=-
    		
    		foreach($dados_abastecimento as $dado_abastecimento){
    			$data = $CI->datas->dateToBR2($dado_abastecimento['data']);
    			$valor_abastecimento = $dado_abastecimento['valor'];
    			$valor_total_abastecimento += $valor_abastecimento;
    			$valor_abastecimento = number_format($valor_abastecimento,2,',','.');
    			$content .= "
    			
    						<tr>
    						<td style='border: 1px solid grey; width: 38mm; height: 6mm; font-size: 16px; text-align: center;'>$data</td>
    						<td style='border: 1px solid grey;width: 66mm; height: 6mm; font-size: 16px; text-align: right;'>R$ $valor_abastecimento</td>
    						</tr>
    				";
    		}
    		
    		$valor_total_abastecimento = number_format($valor_total_abastecimento,2,',','.');
    		$content .= "
    					<tr>
    						<td class='table-active' style='border: 1px solid grey; text-align: center;'><strong>Valor Total:</strong></td>
    						<td style='border: 1px solid grey; font-size: 16px; height: 8mm; text-align: right;'><strong>R$ $valor_total_abastecimento</strong></td>
    					</tr>
    					</tbody>
    				</table>";
    		
    		
    	

    		$content .= "
    			<page_footer>
    				<div style='width: 100%; border-top: 0.8px solid gray; text-align: center; line-height:135%; font-size: 10px; padding-top:5px;'>
    				<b> Academia Estadual de Segurança Pública</b> <br>
    					Avenida Presidente Costa e Silva, 1251 – Mondubim – Fortaleza/CE - CEP: 60.761-505 Fone: (85) 32960469 <br>
    					© 2022 - Governo do Estado do Ceará. Todos os Direitos Reservados
    				</div>
    		</page_footer>
    	
    			";
    	
    	
    	$content .= "</page>";
    	
    	//####### EXECUTA A FUNÇÃO DA BIBLIOTECA QUE GERA O PDF-=-=-=-=-=-==-=-
    	
    	$nome = 'Relatório De Veículo.pdf';
    	$html2pdf->WriteHTML($content);
    	$html2pdf->Output($nome,'I');
    	
    	ob_end_flush();
    	
    }
    
    //####### GERAR RELATÓRIO MANUTENÇÃO=-=-=-=-=-=-=-=-=-=-=-=-=-=-
    
    public function relatorio_manutencao(){
    	
    	$data['title'] = "Relatório de Manutenção";
    	$data['veiculos'] = $this->veiculo_model->get_veiculos();
    	$data['dados_manutencao'] = "";
    	 
    	if ($this->form_validation->run('relatorio/relatorio_manutencao') == FALSE){
    		$this->load->view('template/header_sessao', $data);
    		$this->load->view('relatorio/relatorio_manutencao');
    		$this->load->view('template/footer');
    	}else {
    		 
    		
    		$input	= array(
    				'data_inicial' 	=> $this->datas->dateToUS($this->input->post('data_inicial')),
    				'data_final' 	=> $this->datas->dateToUS($this->input->post('data_final')),
    				'veiculo_id' 	=> $this->input->post('veiculo_id'),
    				    		    		);
    		
    		$retornoInsert = $this->relatorio_model->get_manutencao_periodo($input);
    	
    		
    		date_default_timezone_set('America/Fortaleza');
    		$data_hora_criacao = date('Y-m-d H:i:s');
    		$qtdservico = count($this->input->post('inputTipo'));
    		$descRegistro = "";
    		
    		
    		$veiculo_id = $input['veiculo_id'];
    		$data_inicial = $input['data_inicial'];
    		$data_final = $input['data_final'];


    		
    	
    		$data['veiculo_id'] = $veiculo_id;
    		$data['data_inicial'] = $data_inicial;
    		$data['data_final'] = $data_final;
    		$data['dados_manutencao'] = $this->relatorio_model->get_manutencao_periodo($input);
    		
    		$this->load->view('template/header_sessao', $data);
    		$this->load->view('relatorio/relatorio_manutencao');
    		$this->load->view('template/footer');
    }

   }
   	public function gerar_realtorio_abastecimento_pdf($veiculo_id, $data_inicial, $data_final){
   
   		$input['veiculo_id'] = $veiculo_id;
   		$input['data_inicial'] = $data_inicial;
   		$input['data_final'] = $data_final;
   		
   		$datainicial = explode("-", $data_inicial);
   		$datainicial = $datainicial[2]."/".$datainicial[1]."/".$datainicial[0]; 
   
   		$datafinal = explode("-", $data_final);
   		$datafinal = $datafinal[2]."/".$datafinal[1]."/".$datafinal[0];
    		
   		
   
   	$CI = & get_instance();
   	$CI->load->library(array('Datas'));
   	$dados_abastecimento = $this->relatorio_model->get_abastecimento_periodo($input);
   	$dados_manutencao = $this->relatorio_model->get_manutencao_periodo($input);
   	$valor_total_abastecimento = 0;
   
   	date_default_timezone_set( 'America/Sao_Paulo' );
   	setlocale( LC_ALL, 'pt_BR', 'pt_BR.iso-8859-1', 'pt_BR.utf-8', 'portuguese' );
   	
   	$hora= date('H:i');
   	 
   	$nome_usuario = strtolower($this->session->userdata('usuario'));
   	$nome_usuario = ucwords($nome_usuario);
   	ob_start();
   
   	//####### INCLUSÃO A BIBLIOTECA HTML2PDF QUE GERA O PDF-=-=-=-=-=-=-=-=-=-=-=-=-=-
   
   	include_once(APPPATH . 'libraries/html2pdf_v4.03/html2pdf.class.php');
   
   	$html2pdf = new HTML2PDF('L','A4','pt','UTF-8');
   	$html2pdf->pdf->SetDisplayMode('fullpage');
   
   	//####### CADA CONTENT INCLUI UM CONTEÚDO NO PDF, SENDO ESCRITO EM HTML-=-=-=-=-=-=-=-=-=-=-=-=-=-
   
   	$content = "
   
	<page backtop='40mm' backbottom='10mm'  backleft='0mm' backright='10mm' style='font-size: 9pt'>
   
	   <page_header>
			  <table style='margin-top: 20px; width: 100%; border-bottom: solid 0px grey;'>
			     <tr>
					   <td style='padding-left:200px; text-align:center; width: 50%; border: 0px solid grey;'>
					   <img src='images/logo.jpg' width='220' >
					   </td>
					   
					   <td style='text-align: left; width: 50%; border: 0px solid grey''>
					   <img width='210' src='images/gov_pdf_sem_fundo.png'>
					   </td>
			    </tr>
			  </table>
     </page_header>
   			
  	<page_footer>
   			
	   	<table  style='width: 98%; padding:1%; margin-left:10px; border: 0px solid #ceced7; font-size:7pt;'>
			<tr>
				<td  style='text-align: right; width: 100%; border: 0px solid'>
				<img  width='15' src='images/livro.png'>
				<i>EMITIDO POR ".mb_strtoupper($nome_usuario,'UTF-8')." EM ".date('d/m/Y')." &agrave;s ".$hora."</i>
				</td>
			</tr>
	   </table>	
						
         <div style='font-size:8pt; text-align:center; margin-top:8px;'>
			<strong > Academia Estadual de Segurança Pública do Ceará</strong><br>  
    		Avenida Presidente Costa e Silva, 1251 – Mondubim – Fortaleza/CE - CEP: 60.761-505 Fone: (85) 32960469 <br> 
    		© ".date('Y')." - Governo do Estado do Ceará. Todos os Direitos Reservados<br>
         </div> 
  </page_footer>
 ";
   	if (count($dados_abastecimento) > 0){
   		
   	}
   	else{
   		if($veiculo_id != "0"){
   $content.="
   		<h4 style='text-align:center;'>RELATÓRIO DE ABASTECIMENTO DO VEÍCULO".$dados_abastecimento[0]['modelo']." ".$dados_abastecimento[0]['ano']." - ".$dados_abastecimento[0]['placa']."</h4>
   	";}
   
   $content.= "
    			<h4 style='text-align:center;'>RELATÓRIO DE ABASTECIMENTO DE TODOS OS VEÍCULOS</h4>
    			";}
   	
   	if($veiculo_id == "0"){
   		
   		$content .= "
    		<table style='margin-left:5px; width=95%; border:1px solid #ceced7; border-collapse:collapse; font-size:8pt;' align='center'>
   	  			  <thead>
   	  					<tr>
	   	  			         <td style=' border:1px solid #ceced7; width:105%; padding:15px;'align='center' colspan='3'>
	   	  			              <b>RELATÓRIO DE ABASTECIMENTO DOS VEÍCULOS, &nbsp;PERÍODO  ".$datainicial." A ".$datafinal."</b> 
   					         </td>
	   	  			   </tr>
    						<tr>
    							<th style='padding:8px; border:solid #ceced7 1px; text-align:center; background-color: #dcdce7;'>DATA</th>
   								<th style='padding:8px; border:solid #ceced7 1px; text-align:center; background-color: #dcdce7;'>PLACA</th>
    							<th align='center' style='padding:8px; border:solid #ceced7 1px; text-align:right;background-color: #dcdce7;'>VALOR (R$)</th>
    						</tr>
    					</thead>
    					<tbody>
    				";
   		}
   		else{
   			$content .= "
   					
    <table style='width:100%; border:0px solid #ceced7; border-collapse:collapse; font-size:8pt; padding-left:40px;' >  
	   	  		
	   					<tr>
	   	  			         <th style=' border:1px solid #ceced7; width:96%; padding:15px;'align='center'>
	   	  			              RELATÓRIO DE ABASTECIMENTO DO VEÍCULO, &nbsp;PERÍODOS ".$datainicial." A ".$datafinal."
   					         </th>
	   	  			   </tr>
	 </table>	
   					
   			<table style='width:100%; border:0px solid #ceced7; border-collapse:collapse; font-size:8pt; padding-left:40px;' >  		
    					<tr>
                			<th style=' border:1px solid #ceced7; padding:10px; background-color: #dcdce7;'align='center'>MODELO</th>
               				<th style='padding:10px; border:solid #ceced7 1px; background-color: #dcdce7; text-align:center;'>ANO DE FABRICAÇÃO</th>
                			<th style='padding:10px; border:solid #ceced7 1px; background-color: #dcdce7; text-align:center;'>PLACA</th>
   					    </tr>
	   			     
   	  			         
   	  			<tbody>              	
   	  			     <tr>
   	  			         <td style=' padding:8px; border: 1px solid #ceced7; font-size: 12px; text-align: center; width:32%;'>".$dados_manutencao[0]['modelo']." </td> 
   	  			         <td style='border: 1px solid #ceced7;  font-size: 12px; text-align: center; width:32%;'>".$dados_manutencao[0]['ano']." </td>
   	  			         <td style='border: 1px solid #ceced7;  font-size: 12px; text-align: center; width:32%;'>".$dados_manutencao[0]['placa']." </td>
   	  			     </tr> 
   	  			 </tbody>        		
   	  	   </table> 				
   					
   					
    				<table style='margin-right:5px; width=95%; border:1px solid #ceced7; border-collapse:collapse; font-size:8pt;' align='center'>
    					<thead>
    						<tr>
    							<th  style=' width:49%; padding:8px; border:solid #ceced7 1px; text-align:center; background-color: #dcdce7;'>DATA</th>
    							<th  style='  padding:8px; border:solid #ceced7 1px; text-align:center; background-color: #dcdce7;'>VALOR (R$)</th>
    						</tr>
    					</thead>
    					<tbody>
    				";
   			
   		}
   
   		//####### O LOOPING CRIA UMA LINHA NA TABELA PARA CADA DADO DE ABASTEECIMENTO-=-=-==-==-=-
   
   		$cnt = 1;
   		foreach($dados_abastecimento as $dado_abastecimento){
   			$data_pesquisa = explode("-", $dado_abastecimento['data']);
   			$data_pesquisa = $data_pesquisa[2]."/".$data_pesquisa[1]."/".$data_pesquisa[0];
   			$placa = $dado_abastecimento['placa'];
   			$valor_abastecimento = $dado_abastecimento['valor'];
   			$valor_total_abastecimento += $valor_abastecimento;
   			$valor_abastecimento = number_format($valor_abastecimento,2,',','.');
   			
   			if($veiculo_id == '0'){
   			$content .= "
   		
   			<tr>
   			<td style='padding:8px; border: 1px solid #ceced7; width: 25%; font-size: 12px; text-align: center;'>$data_pesquisa</td>
   			<td style='padding:8px; border: 1px solid #ceced7; width: 15%; font-size: 12px; text-align: center;'>$placa</td>
   			<td style='padding:8px; border: 1px solid #ceced7; width: 25%; font-size: 12px; text-align: center;'> $valor_abastecimento</td>
   			</tr>
   			";
   			}
   			
   			else{
   				$content .= "
   				 
   				<tr>
   				<td style='border: 1px solid #ceced7; width: 21%; font-size: 12px; height:6mm; text-align: center;'>$data_pesquisa</td>
   				<td style='border: 1px solid #ceced7; width: 48%; font-size: 12px; height:6mm; text-align: center;'> $valor_abastecimento</td>
   				</tr>
   				";
   				
   			}
			
   	}
			
   		$valor_total_abastecimento = number_format($valor_total_abastecimento,2,',','.');
   		
   		if($veiculo_id == "0"){
   			$content .= "
   			<tr>
	   			<td Colspan='2'  style=' border: 1px solid #ceced7; text-align: right;'><strong>&nbsp;VALOR TOTAL</strong></td>
	   			<td style='border: 1px solid #ceced7; text-align: center; font-size: 12px; height: 8mm;'><strong> $valor_total_abastecimento&nbsp;</strong></td>
   			</tr>
   			</tbody>
   			</table>";
   			}
   		
   		else{
   		$content .= "
   		<tr>
	   		<td style='border: 1px solid #ceced7; text-align: right;'><strong>&nbsp;VALOR TOTAL</strong></td>
	   		<td style='border: 1px solid #ceced7; text-align: center; font-size: 12px; height: 10mm;'><strong> $valor_total_abastecimento&nbsp;</strong></td>
   		</tr>
   		</tbody>
   		</table>";
   			
   		}
   		
   		
//    		echo "<pre>";
//    		      print_r($this->session->userdata);
//    		echo "</pre>";
//    		exit;
   		      
   
   		$content .= "</page>";
   		 
   		//####### EXECUTA A FUNÇÃO DA BIBLIOTECA QUE GERA O PDF-=-=-=-=-=-==-=-
   
   
   		$nome = 'Relatório De Abastecimento.pdf';
   		$html2pdf->WriteHTML($content);
   		$html2pdf->Output($nome,'I');
   		 
   		ob_end_flush();
   }
    
   
   	public function gerar_realtorio_manutencao_pdf($veiculo_id, $data_inicial, $data_final){
   	 
   	$input['veiculo_id'] = $veiculo_id;
   	$input['data_inicial'] = $data_inicial;
   	$input['data_final'] = $data_final;
   	
   	$datainicial = explode("-", $data_inicial);
   	$datainicial = $datainicial[2]."/".$datainicial[1]."/".$datainicial[0];
   	 
   	$datafinal = explode("-", $data_final);
   	$datafinal = $datafinal[2]."/".$datafinal[1]."/".$datafinal[0];
   	 
   	$CI = & get_instance();
   	$CI->load->library(array('Datas'));
   	$dados_manutencao = $this->relatorio_model->get_manutencao_periodo($input);
   	 
   	setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
   	date_default_timezone_set('America/Sao_Paulo');
   	
   	$hora= date('H:i');
   	
   	$nome_usuario = strtolower($this->session->userdata('usuario'));
   	$nome_usuario = ucwords($nome_usuario);
   	
   	ob_start();
   	 
   	//####### INCLUSÃO A BIBLIOTECA HTML2PDF QUE GERA O PDF-=-=-=-=-=-=-=-=-=-=-=-=-=-
   	 
   	include_once(APPPATH . 'libraries/html2pdf_v4.03/html2pdf.class.php');
   	 
   	$html2pdf = new HTML2PDF('L','A4','pt','UTF-8');
   	$html2pdf->pdf->SetDisplayMode('fullpage');
   	 
   	//####### CADA CONTENT INCLUI UM CONTEÚDO NO PDF, SENDO ESCRITO EM HTML-=-=-=-=-=-=-=-=-=-=-=-=-=-
   	 
   	$content = "
  
	<page backtop='35mm' backbottom='20mm'  backleft='2mm' backright='15mm' style='font-size: 9pt'>
   
	   <page_header>
			  <table style='margin-top: 20px; width: 100%; border-bottom: solid 0px grey;'>
			     <tr>
					   <td style='padding-left:200px; text-align:center; width: 50%; border: 0px solid grey;'>
					   <img src='images/logo.jpg' width='220' >
					   </td>
					   
					   <td style='text-align: left; width: 50%; border: 0px solid grey''>
					   <img width='210' src='images/gov_pdf_sem_fundo.png'>
					   </td>
			    </tr>
			  </table>
     </page_header>
   			
  	<page_footer>	
   			
   	<table  style='width: 98%; padding:1%; margin-left:10px; border: 0px solid #ceced7; font-size:7pt;'>
		<tr>
			<td  style='text-align: right; width: 100%; border: 0px solid'>
			<img  width='15' src='images/livro.png'>
			<i>EMITIDO POR ".mb_strtoupper($nome_usuario,'UTF-8')." EM ".date('d/m/Y')." &agrave;s ".$hora."</i>
			</td>
		</tr>
   </table>	
   			
         <div style='font-size:8pt; text-align:center; margin-top:15px; '>
			<strong > Academia Estadual de Segurança Pública do Ceará</strong><br>  
    		Avenida Presidente Costa e Silva, 1251 – Mondubim – Fortaleza/CE - CEP: 60.761-505 Fone: (85) 32960469 <br> 
    		© ".date('Y')." - Governo do Estado do Ceará. Todos os Direitos Reservados<br>
         </div> 
  </page_footer>
				";
   	
      $content.="
    			<h5 style='text-align:CENTER; font-size: 11pt; margin:25px; margin-bottom:35px;'>  </h5>
   		
    			";
   		 
   		
   		if($veiculo_id == "0"){
   	  	$content .= "
   			
    		<table style='margin-left:5px; width=100%; border:1px solid #ceced7; border-collapse:collapse; font-size:8pt;' align='center'>
   	  			
   	  			  <thead>
   	  					<tr>
	   	  			         <td style=' border:1px solid #ceced7; width:105%; padding:15px;'align='center' colspan='9'>
	   	  			              <b>RELATÓRIO DE MANUTENÇÃO DO VEÍCULO, PERÍODO DE ".$datainicial." A ".$datafinal."</b> 
   					         </td>
	   	  			   </tr>
    					<tr>
                			<th style='padding:8px; border:solid #ceced7 1px; text-align:center; background-color: #dcdce7;'>DATA</th>
   							<th style='padding:8px; border:solid #ceced7 1px; text-align:center; background-color: #dcdce7;'>PLACA</th>
               				<th style='padding:8px; border:solid #ceced7 1px; text-align:center; background-color: #dcdce7;'>RESPONSÁVEL</th>
                			<th style='padding:8px; border:solid #ceced7 1px; text-align:center; background-color: #dcdce7;'>OFICINA</th>
                			<th style='padding:8px; border:solid #ceced7 1px; text-align:center; background-color: #dcdce7;'>TIPO</th>
                			<th style='padding:8px; border:solid #ceced7 1px; text-align:center; background-color: #dcdce7;'>DESCRIÇÃO</th>
                			<th style='padding:8px; border:solid #ceced7 1px; text-align:center; background-color: #dcdce7;'>QTD</th>
                			<th style='padding:8px; border:solid #ceced7 1px; text-align:center; background-color: #dcdce7;'>VALOR (R$)</th>
   				            <th style='padding:8px; border:solid #ceced7 1px; text-align:center; background-color: #dcdce7;'>VALOR COM DESCONTO (R$)</th>
    					</tr>
    			</thead>
    				<tbody>
    				";
   		}else{
   			$content .= "
   			<table style='width:100%; border:0px solid #ceced7; border-collapse:collapse; font-size:8pt; padding-left:36px;' >  
	   	  		
	   					<tr>
	   	  			         <th style=' border:1px solid #ceced7; width:96%; padding:15px;'align='center'>
	   	  			              RELATÓRIO DE MANUTENÇÃO DO VEÍCULO, PERÍODO DE ".$datainicial." A ".$datafinal."
   					         </th>
	   	  			   </tr>
	   	   </table>	
   					
   			<table style='width:100%; border:0px solid #ceced7; border-collapse:collapse; font-size:8pt; padding-left:36px;' >  		
    					<tr>
                			<th style=' border:1px solid #ceced7; padding:10px; background-color: #dcdce7;'align='center'>MODELO</th>
               				<th style='padding:10px; border:solid #ceced7 1px; background-color: #dcdce7; text-align:center;'>ANO DE FABRICAÇÃO</th>
                			<th style='padding:10px; border:solid #ceced7 1px; background-color: #dcdce7; text-align:center;'>PLACA</th>
   					    </tr>
	   			     
   	  			         
   	  			<tbody>              	
   	  			     <tr>
   	  			         <td style=' padding:8px; border: 1px solid #ceced7; font-size: 12px; text-align: center; width:32%;'>".$dados_manutencao[0]['modelo']." </td> 
   	  			         <td style='border: 1px solid #ceced7;  font-size: 12px; text-align: center; width:32%;'>".$dados_manutencao[0]['ano']." </td>
   	  			         <td style='border: 1px solid #ceced7;  font-size: 12px; text-align: center; width:32%;'>".$dados_manutencao[0]['placa']." </td>
   	  			     </tr> 
   	  			 </tbody>        		
   	  	   </table> 				
   					
   		 
   
    		<table style='width=100%; border:1px solid grey; border-collapse:collapse; font-size:8pt;' align='center'>
             		<thead>
    					<tr>
                			<th style='padding:8px; border:solid #ceced7 1px; text-align:center; background-color: #dcdce7;'>DATA</th>
               				<th style='padding:8px; border:solid #ceced7 1px; text-align:center; background-color: #dcdce7;'>RESPONSÁVEL</th>
                			<th style='padding:8px; border:solid #ceced7 1px; text-align:center; background-color: #dcdce7;'>OFICINA</th>
                			<th style='padding:8px; border:solid #ceced7 1px; text-align:center; background-color: #dcdce7;'>TIPO</th>
                			<th style='padding:8px; border:solid #ceced7 1px; text-align:center; background-color: #dcdce7;'>DESCRIÇÃO</th>
                			<th style='padding:8px; border:solid #ceced7 1px; text-align:center; background-color: #dcdce7;'>QTD</th>
                			<th style='padding:8px; border:solid #ceced7 1px; text-align:center; background-color: #dcdce7;'>VALOR (R$)</th>
   					        <th style='padding:8px; border:solid #ceced7 1px; text-align:center; background-color: #dcdce7;'>VALOR COM DESCONTO (R$)</th>
    					</tr>
    				</thead>
    				<tbody>
    				";
   		}
   		$valor_manutencao_total = 0;
   		$valor_servico_total = 0;
   		$valor_peca_total = 0;
   		
   		$desconto_manutencao_total = 0;
   		$desconto_servico_total = 0;
   		$desconto_peca_total = 0;
   		
   		//####### O LOOPING CRIA UMA LINHA NA TABELA PARA CADA DADO DE MANUTENÇÃO-=-=-=-=-=-==-=-
   		
   		$cnt = 1;
   	
   		foreach($dados_manutencao as $dado_manutencao){
   			
   			$data = $CI->datas->dateToBR($dado_manutencao['data']);
   			$placa = $dado_manutencao['placa'];
   			$resp_trans = $dado_manutencao['resp_trans'];
   			$oficina = $dado_manutencao['oficina'];
   		
   			$array_peca_servico = explode("#",$dado_manutencao['peca_servico']);
   			
   			$string_exibicao = "";
   			$valor_manutencao = 0;
   			$desconto_manutencao = 0;
   			 
   			//####### O LOOPING DIVIDE A STRING DO SERVIÇO-=-=-=-=-=-==-=-
   		
   		
   			foreach ($array_peca_servico as $chave => $item_array){
   		
   				$exibicao_peca_servico = explode(";",$array_peca_servico[$chave]);
   			
   				
   				if(count($exibicao_peca_servico) == 4) {    // contagem dos índices
   					 
   					$exibicao_peca_servico[4] = $exibicao_peca_servico[3];
   				}
   				
   				if ($exibicao_peca_servico[4] == 0) {
   					$exibicao_peca_servico[4] = $exibicao_peca_servico[3];
   						
   				}
   				
   		
   				if($exibicao_peca_servico[0] == 1){
   					$exibicao_peca_servico[0] = "Peça";
   					$valor_peca = $exibicao_peca_servico[3];
   					$valor_peca_total += $valor_peca;
   					
   					$desconto_peca = $exibicao_peca_servico[4];
   					$desconto_peca_total += $desconto_peca;
   						
   				}else{
   					$exibicao_peca_servico[0] = "Serviço";
   					$valor_servico = $exibicao_peca_servico[3];
   					$valor_servico_total += $valor_servico;
   					
   					$desconto_servico = $exibicao_peca_servico[4];
   					$desconto_servico_total += $desconto_servico;
   				}
   		
   				
   					if($veiculo_id == "0"){
   						$content .= '<tr>
								<td style="border: 1px solid #ceced7; width: 8%; font-size: 12px; text-align: center;">'.$data.'</td>
	    		                <td style="border: 1px solid #ceced7; width: 10%; font-size: 12px; text-align: center;">'.$placa.'</td>
								<td style="border: 1px solid #ceced7; width: 10%; font-size: 12px; text-align: center;">'.$resp_trans.'</td>
	    		                <td style="padding:4px; border: 1px solid #ceced7; width: 12%; font-size: 12px; text-align: center;">'.$oficina.'</td>
	   
		
					';
   					}else{
   						$content .= '<tr>
								<td style="border: 1px solid #ceced7; width: 12%; font-size: 12px; text-align: center;">'.$data.'</td>
	    		                <td style="border: 1px solid #ceced7; width: 10%; font-size: 12px; text-align: center;">'.$resp_trans.'</td>
	    		                <td style="padding:4px; border: 1px solid #ceced7; width: 14%; font-size: 12px; text-align: center;">'.$oficina.'</td>
					';
   					}
   				
   		
   				foreach ($exibicao_peca_servico as $key => $item){
   		
   		
   					if($key == 3){
   						$valor_manutencao = $valor_manutencao + $item;
   					}
   					
   					if($key == 4){
   						$desconto_manutencao = $desconto_manutencao + $item;
   					}
   						
   			if ($veiculo_id == "0"){	
   					$content .= '
								 <td style="padding:5px; border: 1px solid #ceced7; width: 12%; height:3mm; font-size: 12px; text-align: center;">'.$item.'</td>
	    		            ';
   					
   			}else {
   				
   				$content .= '
								<td style="padding:5px; border: 1px solid #ceced7; width: 10%; height:3mm; font-size: 12px; text-align: center;">'.$item.'</td>
	    		            ';
   			}
   					
   					$string_exibicao .= $item." - ";
   		
   				}
   		
   		
   				$content .= '</tr>';
   		
   				$string_exibicao = substr($string_exibicao,0,-3);
   				
   				$cnt = $cnt + 1;
   					
   		
   		
   			}
   		
   			$valor_manutencao_total = $valor_manutencao_total + $valor_manutencao;
   			$string_exibicao .= "<br>Total: R$ ".number_format($valor_manutencao,2,',','.');
   			
   			$desconto_manutencao_total = $desconto_manutencao_total + $desconto_manutencao;
   			$string_exibicao .= "<p> Total: R$ ".number_format($desconto_manutencao,2,',','.')."</p>";
   			
   		}
   		
	   		$valor_manutencao_total = number_format($valor_manutencao_total,2,',','.');
	   		$valor_servico_total = number_format($valor_servico_total,2,",",".");
	   		$valor_peca_total = number_format($valor_peca_total,2,",",".");

	   		$desconto_manutencao_total = number_format($desconto_manutencao_total,2,',','.');
	   		$desconto_servico_total = number_format($desconto_servico_total,2,',','.');
	   		$desconto_peca_total = number_format($desconto_peca_total,2,',','.');
   		
   		if($veiculo_id == "0"){
   		
   		$content .= '
   						<tr>
        					<td colspan="7" style=" text-align: right; border: 1px solid #ceced7;font-size: 11px;"><strong>&nbsp;VALOR TOTAL DE PEÇAS </strong></td>
       		 				<td style="border: 1px solid #ceced7;  text-align: center; font-size: 11px; height: 6mm;"><strong>'.$valor_peca_total.'</strong></td>
       		 						
       		 			   <td style="border: 1px solid #ceced7;  text-align: center; font-size: 11px; height: 6mm;"><strong>'.$desconto_peca_total.'</strong></td>
        				</tr>
     
        				<tr>
        					<td colspan="7" style="text-align: right; border: 1px solid #ceced7;font-size: 11px;"><strong>&nbsp;VALOR TOTAL DE SERVIÇOS </strong></td>
       		 				<td style="border: 1px solid #ceced7;  text-align: center; font-size: 11px; height: 6mm;"><strong>'.$valor_servico_total.'</strong></td>
       		 						
       		 				<td style="border: 1px solid #ceced7;  text-align: center; font-size: 11px; height: 6mm;"><strong>'.$desconto_servico_total.'</strong></td>
        				</tr>
     
        				<tr>
        					<td colspan="7" style="text-align: right; border: 1px solid #ceced7; font-size: 11px;"><strong>&nbsp;VALOR TOTAL </strong></td>
       		 				<td style="border: 1px solid #ceced7;  text-align: center; font-size: 11px; height: 6mm;"><strong>'.$valor_manutencao_total.'</strong></td>
       		 						
       		 				<td style="border: 1px solid #ceced7;  text-align: center; font-size: 11px; height: 6mm;"><strong>'.$desconto_manutencao_total.'</strong></td>
        				</tr>
   		
    		</tbody>
   		
    		</table>
    			    ';
   		}else{
   			$content .= '
   						<tr>
        					<td colspan="6" style="text-align: right; border: 1px solid #ceced7;font-size: 11px;"><strong>&nbsp;VALOR TOTAL DE PEÇAS </strong></td>
       		 				<td style="border: 1px solid #ceced7;  text-align: center; font-size: 11px; height: 6mm;"><strong>'.$valor_peca_total.'</strong></td>
       		 						
       		 				<td style="border: 1px solid #ceced7;  text-align: center; font-size: 11x; height: 6mm;"><strong>'.$desconto_peca_total.'</strong></td>
       		 						
        				</tr>
     
        				<tr>
        					<td colspan="6" style="text-align: right; border: 1px solid #ceced7;font-size: 11px;"><strong>&nbsp;VALOR TOTAL DE SERVIÇOS </strong></td>
       		 				<td style="border: 1px solid #ceced7;  text-align: center; font-size: 11px; height: 6mm;"><strong>'.$valor_servico_total.'</strong></td>
       		 						
       		 				<td style="border: 1px solid #ceced7;  text-align: center; font-size: 11px; height: 6mm;"><strong>'.$desconto_servico_total.'</strong></td>
       		 						
        				</tr>
     
        				<tr>
        					<td colspan="6" style="text-align: right; border: 1px solid #ceced7; font-size: 11px;"><strong>&nbsp;VALOR TOTAL  </strong></td>
       		 				<td style="border: 1px solid #ceced7;  text-align: center; font-size: 11px; height: 6mm;"><strong>'.$valor_manutencao_total.'</strong></td>
       		 						
       		 				<td style="border: 1px solid #ceced7;  text-align: center; font-size: 11wpx; height: 6mm;"><strong>'.$desconto_manutencao_total.'</strong></td>
       		 						
        				</tr>
   
    		</tbody>
   
    		</table>
    			    ';
   			
   		}
   		
   		$content.="
   	
   				
   	";			
 
//    		$content .= "
//     			<page_footer>
//     				<div style='width: 100%; border-top: 0.8px solid grey; text-align: center; line-height:135%; font-size: 10px; padding-top:5px;'>
//     				<b> Academia Estadual de Segurança Pública</b> <br>
//     					Avenida Presidente Costa e Silva, 1251 – Mondubim – Fortaleza/CE - CEP: 60.761-505 Fone: (85) 32960469 <br>
//     					© 2022 - Governo do Estado do Ceará. Todos os Direitos Reservados
//     				</div>
//     		</page_footer>
   
//     			";
   
   
   		$content .= "</page>";
   
   		//####### EXECUTA A FUNÇÃO DA BIBLIOTECA QUE GERA O PDF-=-=-=-=-=-==-=-
   		 
   		 
   		$nome = 'Relatório Manutenção.pdf';
   		$html2pdf->WriteHTML($content);
   		$html2pdf->Output($nome,'I');
   
   		ob_end_flush();
   }
    
   //####### GERAR PDF DO RELATÓRIO POR PERÍODO=-=-=-=-=-=-=-=-=-=-=-=-=-=-
   
   public function gerar_relatorio_operacional_pdf($veiculo_id, $data_inicial, $data_final){
   	
   	$input['veiculo_id'] = $veiculo_id;
   	$input['data_inicial'] = $data_inicial;
   	$input['data_final'] = $data_final;
   	
   	$datainicial = explode("-", $data_inicial);
   	$datainicial = $datainicial[2]."/".$datainicial[1]."/".$datainicial[0];
   	 
   	$datafinal = explode("-", $data_final);
   	$datafinal = $datafinal[2]."/".$datafinal[1]."/".$datafinal[0];
   	
   	$CI = & get_instance();
   	$CI->load->library(array('Datas'));
   	$dados_abastecimento = $this->relatorio_model->get_abastecimento_periodo($input);
   	$dados_manutencao = $this->relatorio_model->get_manutencao_operacional($input);
   	
   	date_default_timezone_set( 'America/Sao_Paulo' );
   	setlocale( LC_ALL, 'pt_BR', 'pt_BR.iso-8859-1', 'pt_BR.utf-8', 'portuguese' );
   	
   	$nome_usuario = strtolower($this->session->userdata('usuario'));
   	$nome_usuario = ucwords($nome_usuario);
   	$hora = date('H:i');
   
   	ob_start();
   	
   	//####### INCLUSÃO A BIBLIOTECA HTML2PDF QUE GERA O PDF-=-=-=-=-=-=-=-=-=-=-=-=-=-
   	
   	include_once(APPPATH . 'libraries/html2pdf_v4.03/html2pdf.class.php');
   	
   	$html2pdf = new HTML2PDF('L','A4','pt','UTF-8');
   	$html2pdf->pdf->SetDisplayMode('fullpage');
   	
   	//####### CADA CONTENT INCLUI UM CONTEÚDO NO PDF, SENDO ESCRITO EM HTML-=-=-=-=-=-=-=-=-=-=-=-=-=-
   	
   	$content = "
   	
	<page backtop='35mm' backbottom='15mm'  backleft='0mm' backright='15mm' style='font-size: 9pt'>
   
	   <page_header>
			  <table style='margin-top: 20px; width: 100%; border-bottom: solid 0px grey;'>
			     <tr>
					   <td style='padding-left:200px; text-align:center; width: 50%; border: 0px solid grey;'>
					   <img src='images/logo.jpg' width='220' >
					   </td>
					   
					   <td style='text-align: left; width: 50%; border: 0px solid grey''>
					   <img width='210' src='images/gov_pdf_sem_fundo.png'>
					   </td>
			    </tr>
			  </table>
     </page_header>
   			
   	<page_footer>
   			
   	<table  style='width: 98%; padding:1%; margin-left:10px; border: 0px solid #ceced7; font-size:7pt;'>
		<tr>
			<td  style='text-align: right; width: 100%; border: 0px solid'>
			<img  width='15' src='images/livro.png'>
			<i>EMITIDO POR ".mb_strtoupper($nome_usuario,'UTF-8')." EM ".date('d/m/Y')." &agrave;s ".$hora."</i>
			</td>
		</tr>
   </table>	
					
         <div style='font-size:8pt; text-align:center; padding-top:15px;'>
			<strong > Academia Estadual de Segurança Pública do Ceará</strong><br>  
    		Avenida Presidente Costa e Silva, 1251 – Mondubim – Fortaleza/CE - CEP: 60.761-505 Fone: (85) 32960469 <br> 
    		© ".date('Y')." - Governo do Estado do Ceará. Todos os Direitos Reservados<br>
         </div> 
  </page_footer>
				";
   	
   	
   	$content.= "
    			<h5 style=' text-align:center; font-size:11pt; margin-bottom:15px'>RELATÓRIO GLOBAL</h5>
    			";
   
   	 
   if($veiculo_id == "0"){
   	
   $content .= "
   		
   		
    	<table style=' width=100%; border:1px solid #ceced7; border-collapse:collapse; font-size:8pt;' align='center'>
             <thead>
   	  					<tr>
	   	  			        <td style=' border:1px solid #ceced7; width:105%; padding:15px;'align='center' colspan='9'>
	   	  			              <b>RELATÓRIO DE MANUTENÇÃO DO VEÍCULO, PERÍODO DE ".$datainicial." A ".$datafinal."</b> 
   					        </td>
	   	  			   </tr>
   		             
    				<tr>
                		<th style='padding:8px; border:solid #ceced7 1px; text-align:center; background-color: #dcdce7;'>DATA</th>
   						<th style='padding:8px; border:solid #ceced7 1px; text-align:center; background-color: #dcdce7;'>PLACA</th>
               			<th style='padding:8px; border:solid #ceced7 1px; text-align:center; background-color: #dcdce7;'>RESPONSÁVEL</th>
                		<th style='padding:8px; border:solid #ceced7 1px; text-align:center; background-color: #dcdce7;'>OFICINA</th>
                		<th style='padding:8px; border:solid #ceced7 1px; text-align:center; background-color: #dcdce7;'>TIPO</th>
                		<th style='padding:8px; border:solid #ceced7 1px; text-align:center; background-color: #dcdce7;'>DESCRIÇÃO</th>
                		<th style='padding:8px; border:solid #ceced7 1px; text-align:center; background-color: #dcdce7;'>QTD</th>
               			<th style='padding:8px; border:solid #ceced7 1px; text-align:center; background-color: #dcdce7;'>VALOR (R$)</th>
   	                 	<th style='padding:8px; border:solid #ceced7 1px; text-align:center; background-color: #dcdce7;'>VALOR COM DESCONTO (R$)</th>
    			  </tr>
    		</thead>
    	<tbody>
    				";
   		}else{
   			
   $content .= "
   
   		<table style='width:100%; border:0px solid #ceced7; border-collapse:collapse; font-size:8pt; padding-left:15px;' >  
	   	  		
	   					<tr>
	   	  			         <th style=' border:1px solid #ceced7; width:103%; padding:15px;'align='center'>
	   	  			              RELATÓRIO DE MANUTENÇÃO DO VEÍCULO, PERÍODO DE ".$datainicial." A ".$datafinal."
   					         </th>
	   	  			   </tr>
	   	   </table>	
   					
   			<table style='width:100%; border:0px solid #ceced7; border-collapse:collapse; font-size:8pt; padding-left:15px;' >  		
    					<tr>
                			<th style=' border:1px solid #ceced7; padding:10px; background-color: #dcdce7;'align='center'>MODELO</th>
               				<th style='padding:10px; border:solid #ceced7 1px; background-color: #dcdce7; text-align:center;'>ANO DE FABRICAÇÃO</th>
                			<th style='padding:10px; border:solid #ceced7 1px; background-color: #dcdce7; text-align:center;'>PLACA</th>
   					    </tr>
	   			     
   	  			         
   	  			<tbody>              	
   	  			     <tr>
   	  			         <td style=' padding:8px; border: 1px solid #ceced7; font-size: 12px; text-align: center; width:38%;'>".$dados_manutencao[0]['modelo']." </td> 
   	  			         <td style='border: 1px solid #ceced7;  font-size: 12px; text-align: center; width:30%;'>".$dados_manutencao[0]['ano']." </td>
   	  			         <td style='border: 1px solid #ceced7;  font-size: 12px; text-align: center; width:35%;'>".$dados_manutencao[0]['placa']." </td>
   	  			     </tr> 
   	  			 </tbody>        		
   	  	   </table> 				
   		
    		<table style='width=100%; border:1px solid #ceced7; border-collapse:collapse; font-size:8pt; margin-left:15px;' align='center'>
             		<thead>
    					<tr>
                			<th style='padding:8px; border:solid #ceced7 1px; text-align:center; background-color: #dcdce7;'>DATA</th>
               				<th style='padding:5px; border:solid #ceced7 1px; text-align:center; background-color: #dcdce7;'>RESPONSÁVEL</th>
                			<th style='padding:8px; border:solid #ceced7 1px; text-align:center; background-color: #dcdce7;'>OFICINA</th>
                			<th style='padding:8px; border:solid #ceced7 1px; text-align:center; background-color: #dcdce7;'>TIPO</th>
                			<th style='padding:8px; border:solid #ceced7 1px; text-align:center; background-color: #dcdce7;'>DESCRIÇÃO</th>
                			<th style='padding:8px; border:solid #ceced7 1px; text-align:center; background-color: #dcdce7;'>QTD</th>
                			<th style='padding:8px; border:solid #ceced7 1px; text-align:center; background-color: #dcdce7;'>VALOR (R$)</th>
   		                    <th style='padding:8px; border:solid #ceced7 1px; text-align:center; background-color: #dcdce7;'>VALOR COM DESCONTO (R$)</th>
    					</tr>
    				</thead>
    				<tbody>
    				";
   		}
   	$valor_manutencao_total = 0;
   	$valor_total_abastecimento = 0;
   	$valor_servico_total = 0;
   	$valor_peca_total = 0;
   	
   	$desconto_manutencao_total = 0;
   	$desconto_servico_total = 0;
   	$desconto_peca_total = 0;
   	
   	//####### O LOOPING CRIA UMA LINHA NA TABELA PARA CADA DADO DE MANUTENÇÃO-=-=-=-=-=-==-=-
   	
   	
   $cnt = 1;
   		
   		foreach($dados_manutencao as $dado_manutencao){
   		
   			$data = $CI->datas->dateToBR($dado_manutencao['data']);
   			$placa = $dado_manutencao['placa'];
   			$resp_trans = $dado_manutencao['resp_trans'];
   			$oficina = $dado_manutencao['oficina'];
   		
   		
   			$array_peca_servico = explode("#",$dado_manutencao['peca_servico']);
   		
   			$string_exibicao = "";
   			$valor_manutencao = 0;
   			$desconto_manutencao = 0;
   			
   			//####### O LOOPING DIVIDE A STRING DO SERVIÇO-=-=-=-=-=-==-=-
   		
   		
   			foreach ($array_peca_servico as $chave => $item_array){
   		
   				$exibicao_peca_servico = explode(";",$array_peca_servico[$chave]);
   				
   				if(count($exibicao_peca_servico) == 4) {    // contagem dos índices
   						
   					$exibicao_peca_servico[4] = $exibicao_peca_servico[3];
   				}
   					
   				if ($exibicao_peca_servico[4] == 0) {
   					$exibicao_peca_servico[4] = $exibicao_peca_servico[3];
   						
   				}
   		
   				if($exibicao_peca_servico[0] == 1){
   					$exibicao_peca_servico[0] = "Peça";
   					$valor_peca = $exibicao_peca_servico[3];
   					$valor_peca_total += $valor_peca;
   					
   					$desconto_peca = $exibicao_peca_servico[4];
   					$desconto_peca_total += $desconto_peca;
   					
//    	echo "<pre>";
//    		 print_r($exibicao_peca_servico);
//     echo "</pre>";
//     exit;
   					
   				}else{
   					$exibicao_peca_servico[0] = "Serviço";
   					$valor_servico = $exibicao_peca_servico[3];
   					$valor_servico_total += $valor_servico;
   					
   					$desconto_servico = $exibicao_peca_servico[4];
   					$desconto_servico_total += $desconto_servico;
   				}
   		
   					if($veiculo_id == "0"){
   						$content .= '<tr>
								<td style="border: 1px solid #ceced7; width: 10%; font-size: 12px; text-align: center;">'.$data.'</td>
	    		                <td style="border: 1px solid #ceced7; width: 10%; font-size: 12px; text-align: center;">'.$placa.'</td>
								<td style="border: 1px solid #ceced7; width: 10%; font-size: 12px; text-align: center;">'.$resp_trans.'</td>
	    		                <td style="border: 1px solid #ceced7; width: 17%; font-size: 12px; text-align: center;">'.$oficina.'</td>
	   
		
					';
   					}else{
   						$content .= '<tr>
								<td style="border: 1px solid #ceced7; width: 10%; font-size: 12px; text-align: center;">'.$data.'</td>
	    		                <td style="border: 1px solid #ceced7; width: 10%; font-size: 12px; text-align: center;">'.$resp_trans.'</td>
	    		                <td style="border: 1px solid #ceced7; width: 17%; font-size: 12px; text-align: center;">'.$oficina.'</td>
   					
   					
					';
   					
   				}
   		
   				foreach ($exibicao_peca_servico as $key => $item){
   		
   					
//    					echo "<pre>";
//    					     print_r($item);
//    					echo "</pre>";
//    					exit;
   		
   					if($key == 3){
   						$valor_manutencao = $valor_manutencao + $item;
   					}
   						
   					
   			    	if($key == 4){
   						$desconto_manutencao = $desconto_manutencao + $item;
   				  	}
   						
   		  					if ($veiculo_id == "0"){	
   									$content .= '
										 <td style="padding:5px; border: 1px solid #ceced7; height:3mm; font-size: 12px; text-align: center;">'.$item.'</td>
	    		            ';
					   			}else {
   				
   										$content .= '
											<td style="padding:5px; border: 1px solid #ceced7; width:12%; height:3mm; font-size: 12px; text-align: center;">'.$item.'</td>
	    		            ';
   			}
   					
   					$string_exibicao .= $item." - ";
   		
   				}
   		
   		
   				$content .= '</tr>';
   		
   				$string_exibicao = substr($string_exibicao,0,-3);
   				
   				$cnt = $cnt + 1;
   					
   			}
   		
   			$valor_manutencao_total = $valor_manutencao_total + $valor_manutencao;
   			$string_exibicao .= "<br>Total: R$ ".number_format($valor_manutencao,2,',','.');
   			
   			$desconto_manutencao_total = $desconto_manutencao_total + $desconto_manutencao;
   			$string_exibicao .= "<p> Total: R$ ".number_format($desconto_manutencao,2,',','.')."</p>";
   			
   		}
   	
   			$valor_manutencao_total = number_format($valor_manutencao_total,2,',','.');
    		$valor_servico_total = number_format($valor_servico_total,2,",",".");
    		$valor_peca_total = number_format($valor_peca_total,2,",",".");
   		
    		$desconto_manutencao_total = number_format($desconto_manutencao_total,2,',','.');
    		$desconto_servico_total = number_format($desconto_servico_total,2,',','.');
    		$desconto_peca_total = number_format($desconto_peca_total,2,',','.');
    		
   		if($veiculo_id == "0"){
   		
   		$content .= '
   						<tr>
        					<td colspan="7" class="table-active" style=" text-align: right;border: 1px solid #ceced7;"><strong>&nbsp;VALOR TOTAL DE PEÇA </strong></td>
       		 				<td style="border: 1px solid #ceced7;  text-align: center; font-size: 12px; height: 6mm;"><strong>'.$valor_peca_total.'</strong></td>
       		 						
       		 				<td style="border: 1px solid #ceced7;  text-align: center; font-size: 12px; height: 6mm;"><strong>'.$desconto_peca_total.'</strong></td>
        				</tr>
     
        				<tr>
        					<td colspan="7" class="table-active" style=" text-align: right; border: 1px solid #ceced7;"><strong>&nbsp;VALOR TOTAL DE SERVIÇO </strong></td>
       		 				<td style="border: 1px solid #ceced7;  text-align: center; font-size: 12px; height: 6mm;"><strong>'.$valor_servico_total.'</strong></td>
       		 						
       		 				<td style="border: 1px solid #ceced7;  text-align: center; font-size: 12px; height: 6mm;"><strong>'.$desconto_servico_total.'</strong></td>
        				</tr>
     
        				<tr>
        					<td colspan="7" class="table-active" style=" text-align: right; border: 1px solid #ceced7;"><strong>&nbsp;VALOR TOTAL </strong></td>
       		 				<td style="border: 1px solid #ceced7;  text-align: center; font-size: 12px; height: 6mm;"><strong> '.$valor_manutencao_total.'</strong></td>
       		 						
       		 				<td style="border: 1px solid #ceced7;  text-align: center; font-size: 12px; height: 6mm;"><strong> '.$desconto_manutencao_total.'</strong></td>
        				</tr>
   		
    		</tbody>
   		
    		</table>
    			    ';
   		}else{
   			$content .= '
   						<tr>
        					<td colspan="6" class="table-active" style=" text-align: right; border: 1px solid #ceced7;"><strong>&nbsp;VALOR TOTAL DE PEÇA </strong></td>
       		 				<td style="border: 1px solid #ceced7;  text-align: center; font-size: 12px; height: 6mm;"><strong>R$ '.$valor_peca_total.'</strong></td>
       		 						
       		 				<td style="border: 1px solid #ceced7;  text-align: center; font-size: 12px; height: 6mm;"><strong>R$ '.$desconto_peca_total.'</strong></td>
        				</tr>
   
        				<tr>
        					<td colspan="6" class="table-active" style=" text-align: right; border: 1px solid #ceced7;"><strong>&nbsp;VALOR TOTAL DE SERVIÇO </strong></td>
       		 				<td style="border: 1px solid #ceced7;  text-align: center; font-size: 12px; height: 6mm;"><strong>R$ '.$valor_servico_total.'</strong></td>
       		 						
       		 				<td style="border: 1px solid #ceced7;  text-align: center; font-size: 12px; height: 6mm;"><strong>R$ '.$desconto_servico_total.'</strong></td>
        				</tr>
   
        				<tr>
        					<td colspan="6" class="table-active" style=" text-align: right; border: 1px solid #ceced7;"><strong>&nbsp;VALOR TORAL </strong></td>
       		 				<td style="border: 1px solid #ceced7;  text-align: center; font-size: 12px; height: 6mm;""><strong>R$ '.$valor_manutencao_total.'</strong></td>
       		 						
       		 				<td style="border: 1px solid #ceced7;  text-align: center; font-size: 12px; height: 6mm;"><strong>R$ '.$desconto_manutencao_total.'</strong></td>
        				</tr>
   
    		</tbody>
   
    		</table>
    			    ';
   			
   		}
   	
   	
//    	$content .= "
//     			<page_footer>
//    					<div style='width: 100%; border-top: 0.8px solid gray; text-align: center; line-height:135%; font-size: 10px; padding-top:5px;'>
//     				<b> Academia Estadual de Segurança Pública</b> <br>
//     					Avenida Presidente Costa e Silva, 1251 – Mondubim – Fortaleza/CE - CEP: 60.761-505 Fone: (85) 32960469 <br>
//     					© 2022 - Governo do Estado do Ceará. Todos os Direitos Reservados
//     				</div>
//     		</page_footer>
  
//     			";
   	 
   	 
   	$content .= "</page>";
   	$content .= "
    				
   	<page backtop='35mm' backbottom='5mm'  backleft='0mm' backright='10mm' style='font-size: 9pt'>
   
	   <page_header>
			  <table style='margin-top: 20px; width: 100%; border-bottom: solid 0px grey;'>
			     <tr>
					   <td style='padding-left:200px; text-align:center; width: 50%; border: 0px solid grey;'>
					   <img src='images/logo.jpg' width='210' >
					   </td>
					   
					   <td style='text-align: left; width: 50%; border: 0px solid grey''>
					   <img width='210' src='images/gov_pdf_sem_fundo.png'>
					   </td>
			    </tr>
			  </table>
     </page_header>
   			
   	<page_footer>	
   			
   	<table  style='width: 98%; padding:1%; margin-left:10px; border: 0px solid #ceced7; font-size:7pt;'>
		<tr>
			<td  style='text-align: right; width: 100%; border: 0px solid'>
			<img  width='15' src='images/livro.png'>
			<i>EMITIDO POR ".mb_strtoupper($nome_usuario,'UTF-8')." EM ".date('d/m/Y')." &agrave;s ".$hora."</i>
			</td>
		</tr>
   </table>	
					
         <div style='font-size:8pt; text-align:center; padding-top:15px;'>
			<strong > Academia Estadual de Segurança Pública do Ceará</strong><br>  
    		Avenida Presidente Costa e Silva, 1251 – Mondubim – Fortaleza/CE - CEP: 60.761-505 Fone: (85) 32960469 <br> 
    		© ".date('Y')." - Governo do Estado do Ceará. Todos os Direitos Reservados<br>
         </div> 
  </page_footer>
    				";
   	
   if($veiculo_id == "0"){
   		
   		$content .= "
   				
    				<table style='margin-left:4px; width=97%; border:1px solid #ceced7; border-collapse:collapse; font-size:8pt;' align='center'>
    					<thead>
   				
   		         		<tr>
	   	  			         <td style=' border:1px solid #ceced7; width:105%; padding:15px;'align='center' colspan='3'>
	   	  			              <b>RELATÓRIO DE ABASTECIMENTO DOS VEÍCULOS, &nbsp;PERÍODO  ".$datainicial." A ".$datafinal."</b> 
   					         </td>
	   	  		 	   </tr>
	   	  			              		
    						<tr>
    							<th style='padding:8px; border:solid #ceced7 1px; text-align:center; background-color: #dcdce7;'>DATA</th>
   								<th style='padding:8px; border:solid #ceced7 1px; text-align:center; background-color: #dcdce7;'>PLACA</th>
    							<th style='padding:8px; border:solid #ceced7 1px; text-align:center; background-color: #dcdce7;'>VALOR (R$)</th>
    						</tr>
    					</thead>
    					<tbody>
    				";
   		}
   		else{
   			$content .= "
   					
   			  <table style='width:100%; border:0px solid #ceced7; border-collapse:collapse; font-size:8pt; padding-left:20px;' >  
	   	  		
	   					<tr>
	   	  			         <th style=' border:1px solid #ceced7; width:99%; padding:15px;'align='center'>
	   	  			              RELATÓRIO DE ABASTECIMENTO DO VEÍCULO, &nbsp;PERÍODOS ".$datainicial." A ".$datafinal."
   					         </th>
	   	  			   </tr>
	 </table>	
   					
   			<table style='width:100%; border:0px solid #ceced7; border-collapse:collapse; font-size:8pt; padding-left:20px;' >  		
    					<tr>
                			<th style=' border:1px solid #ceced7; padding:10px; background-color: #dcdce7;'align='center'>MODELO</th>
               				<th style='padding:10px; border:solid #ceced7 1px; background-color: #dcdce7; text-align:center;'>ANO DE FABRICAÇÃO</th>
                			<th style='padding:10px; border:solid #ceced7 1px; background-color: #dcdce7; text-align:center;'>PLACA</th>
   					    </tr>
	   			     
   	  			         
   	  			<tbody>              	
   	  			     <tr>
   	  			         <td style=' padding:8px; border: 1px solid #ceced7; font-size: 12px; text-align: center; width:30%;'>".$dados_manutencao[0]['modelo']." </td> 
   	  			         <td style='border: 1px solid #ceced7;  font-size: 12px; text-align: center; width:34%;'>".$dados_manutencao[0]['ano']." </td>
   	  			         <td style='border: 1px solid #ceced7;  font-size: 12px; text-align: center; width:35%;'>".$dados_manutencao[0]['placa']." </td>
   	  			     </tr> 
   	  			 </tbody>        		
   	  	   </table> 				
   					
   					
    				<table style='margin-left:5px; width=99%; border:1px solid #ceced7; border-collapse:collapse; font-size:8pt;' align='center'>
    					<thead>
    						<tr>
    							<th  style=' width:49%; padding:8px; border:solid #ceced7 1px; text-align:center; background-color: #dcdce7;'>DATA</th>
    							<th  style=' width:49%; padding:8px; border:solid #ceced7 1px; text-align:center; background-color: #dcdce7;'>VALOR (R$)</th>
    						</tr>
    					</thead>
    					<tbody>
    				";
   			
   		}
   	
   	//####### O LOOPING CRIA UMA LINHA NA TABELA PARA CADA DADO DE ABASTEECIMENTO-=-=-==-==-=-
   	
   	
   	$cnt = 1;
   		foreach($dados_abastecimento as $dado_abastecimento){
   			$data = explode("-",$dado_abastecimento['data']);
  			$data = $data[2]."/".$data[1]."/".$data[0];
   	
//   			echo "<pre>";
//    			     print_r($data);
//    			echo "<pre>";
//    			exit;
   			
   		
   			$placa = $dado_abastecimento['placa'];
   			$valor_abastecimento = $dado_abastecimento['valor'];
   			$valor_total_abastecimento += $valor_abastecimento;
   			$valor_abastecimento = number_format($valor_abastecimento,2,',','.');
   			
   				if($veiculo_id == '0'){
   					$content .= "
   					 
   					<tr>
	   					<td style='border: 1px solid #ceced7; width: 27%; height: 6mm; font-size: 12px; text-align: center;'>$data</td>
	   					<td style='border: 1px solid #ceced7; width: 26%; height: 4mm; font-size: 12px; text-align: center;'>$placa</td>
	   					<td style='border: 1px solid #ceced7;width: 34%; height: 6mm; font-size: 12px; text-align: center;'> $valor_abastecimento</td>
   					</tr>
   					";
   				}
   				
   				else{
   					$content .= "
   				
   					<tr>
	   					<td style='border: 1px solid #ceced7; width: 25%; height: 6mm; font-size: 12px; text-align: center;'>$data</td>
	   					<td style='border: 1px solid #ceced7;width: 35%; height: 6mm; font-size: 12px; text-align: center;'> $valor_abastecimento</td>
   					</tr>
   					";
   			}
   			}
			
   		$valor_total_abastecimento = number_format($valor_total_abastecimento,2,',','.');
   
   		if($veiculo_id == "0"){
   			$content .= "
   			<tr>
	   			<td style=' colspan=2; border: 1px solid #ceced7; text-align: right;'><strong>&nbsp;VALOR TOTAL</strong></td>
	   			<td style=' border: 1px solid #ceced7; text-align: center; font-size: 12px; height: 8mm;'><strong>$valor_total_abastecimento</strong></td>
   			</tr>
   		</tbody>
   	</table>";
   			}
   		
   		else{
   		$content .= "
   		<tr>
	   		<td style=' colspan=1; border: 1px solid #ceced7; text-align: right;'><strong>&nbsp;VALOR TOTAL</strong></td>
	   		<td style=' border: 1px solid #ceced7; text-align: center; font-size: 12px; height: 6mm;'><strong>$valor_total_abastecimento</strong></td>
   		</tr>
   	</tbody>
  </table>";
   		}	
   		
   		   		
   		
   	
   		$content .= "
   				 
  </page>";
   	 
   	//####### EXECUTA A FUNÇÃO DA BIBLIOTECA QUE GERA O PDF-=-=-=-=-=-==-=-
   	
   	
   	$nome = 'Relatório De Veículo.pdf';
   	$html2pdf->WriteHTML($content);
   	$html2pdf->Output($nome,'I');
   	 
   	ob_end_flush();
   }
   
}


