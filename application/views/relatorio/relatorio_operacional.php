
<!-- BIBLIOTECA DE PADRONIZAÇÃO DE DATA E TEMPO -->

<?php 
$CI = & get_instance();
$CI->load->library(array('Datas'));

?>

<!-- CABEÇALHO -->

<div class="row">
	<div class="col-md-8 col-md-offset-2">
	
		<!-- PAINEL DE INSERÇÃO DE DADOS -->
	
		<div class="panel  panel-success text-center">
		
			<!-- CABEÇALHO DO PAINEL -->
			
			<div class="panel-heading "><strong><?php echo $title;?></strong></div>
			
			<!-- CORPO DO PAINEL -->
			
			<div class="panel-body">
			<?php echo form_open('relatorio/relatorio_operacional', array('class' => 'form-horizontal'));?>	
			
				<!-- SELEÇÃO DA DATA INICIAL -->	
			
				<div class="form-group <?php echo (form_error('data_inicial') != '')? 'has-error':''; ?>">
					<label for="data_incial" class="col-md-3 control-label">Data Inicial</label>
					<div class="col-md-3">
						<input type="date" name="data_inicial" class="form-control form_datetime" autocomplete="off" id="data_inicial" value="<?php echo set_value('data_inicial')?>">
						<span id="erro"><?php echo form_error('data_inicial');?></span>
					</div>
				</div>
				
				<!-- SELEÇÃO DA DATA FINAL -->	
				
				<div class="form-group <?php echo (form_error('data_final') != '')? 'has-error':''; ?>">
					<label for="data_final" class="col-md-3 control-label">Data Final</label>
					<div class="col-md-3">
						<input type="date" name="data_final" class="form-control form_datetime" autocomplete="off" id="data_final" value="<?php echo set_value('data_final')?>">
						<span id="erro"><?php echo form_error('data_final');?></span>
					</div>
				</div>
				
				<!-- SELEÇÃO DA PLACA DO VEÍCULO -->	
				 	
			 	<div class="form-group <?php echo (form_error('veiculo_id') != '')? 'has-error':''; ?>">
					<label for="veiculo_id" class="col-md-3 control-label">Placa</label>
					<div class="col-md-3">
						<select class="form-control" name="veiculo_id" >
							<option value="" selected="selected">Selecione...</option>
							<option value="0">Todos os veículos</option>
							<?php 
								foreach ($veiculos as $value){
									echo "<option value=".$value['veiculo_id']." ".set_select('veiculo_id', $value['veiculo_id'])." >".$value['placa']."</option>"; 
								}
							?>
							
						</select>
						<span id="erro"><?php echo form_error('veiculo_id');?></span>
					</div>
				</div>
			</div>
			<!-- RODAPÉ DO PAINEL -->
			
			<div class="panel-footer">
			<button  type="button" value="Voltar" onClick="location.href='<?php echo base_url('index.php/home_sessao');?>'" class="btn btn-warning">Voltar</button>
			    <button type="submit" class="btn btn-success">Pesquisar</button>
			</div>	
			
				<?php echo form_close();?>
	</div>		
</div>
</div>


<?php if(($dados_abastecimento) == ''){ ?>

<?php }else{ ?>


<?php if(count($dados_abastecimento) > 0 or count($dados_manutencao) > 0){ ?>
		
		<!-- LINHA COM A PLACA DO VEÍCULO -->
		
		<div class="alert alert-warning text-center" role="alert"><strong><?php 
			if($veiculo_id == "0"){echo "Exibindo para todos os veículos";}
			elseif(($veiculo_id != "0") || ($veiculo_id == "")) {echo "Veículo ".$dados_manutencao[0]['placa'];}?></strong>
		 
			
			<!-- BOTÃO GERAR PDF -->
			
			<button type="button" onClick="location.href='<?php echo base_url('index.php/relatorio/gerar_relatorio_operacional_pdf/'.$veiculo_id.'/'.$data_inicial.'/'.$data_final);?>'" class="btn btn-danger" >PDF</button>
		</div> 
		<br>
		
		<!-- INÍCIO DOS DADOS DE ABASTECIMENTO -->
		
		<div class="alert alert-success text-center" role="alert"><strong>Dados Abastecimento</strong></div>
		
		<!-- TABELA DE DADOS DE ABASTECIMENTO -->
		
		<table id="example1" class="table table-striped table-bordered" style="width: device-width">
		
		<!-- CABEÇALHO DA TABELA -->
		
		<?php if($veiculo_id == "0"){?>
		
        
         <thead>
             <tr>
                <th style="text-align: center;">Ordem</th>
                <th style="text-align: center;" >Data</th>
                <th style="text-align: center;">Placa</th> 
                <th style="text-align: center;" >Valor (R$)</th>
            </tr>
       </thead>
     
       <?php }
       else{?>
     
       	<thead>
             <tr>
                <th>Ordem</th>
                <th style="text-align: center;">Data</th> 
                <th style="text-align: center;">Valor (R$)</th>
            </tr>
       </thead>
     
       <?php }?>
       
       <!-- CORPO DA TABELA -->
       
        <tbody>     
            
            <?php
    $cnt = 1;
    $valor_abastecimento = 0; 
    $valor_total_abastecimento = 0;
   
    foreach ($dados_abastecimento as $dado_abastecimento){  
    
    	$data_cadastrada = explode("-", $dado_abastecimento['data']);
    	$data_cadastrada = $data_cadastrada[2]."/".$data_cadastrada[1]."/".$data_cadastrada[0];

	?>
			
			<!-- LINHA DE DADOS DE ABASTECIMENTO -->
			
            <?php if($veiculo_id=="0"){?>
            <tr>
                <td style="width:105px; text-align: center;"><?php echo $cnt;?></td>
                <td style="text-align: center;"><?php echo $data_cadastrada;?></td>
                <td style="text-align: center;"><?php echo $dado_abastecimento['placa'];?>
                <td style="text-align: center;"><?php echo number_format($dado_abastecimento['valor'],2,',','.')?></td><?php 
                $valor_abastecimento = $dado_abastecimento['valor'];
                $valor_total_abastecimento += $valor_abastecimento;
                ?>
               
            </tr>
            <?php } 
            else{?>
            		<tr>
            		<td style="width:105px; text-align: center;"><?php echo $cnt;?></td>
            	        <td style="text-align: center;"><?php echo $data_cadastrada;?></td>
            	        <td style="text-align: center;"><?php echo number_format($dado_abastecimento['valor'],2,',','.')?></td><?php 
            	        $valor_abastecimento = $dado_abastecimento['valor'];
            	        $valor_total_abastecimento += $valor_abastecimento;
            	                ?>
            	   </tr>
            	<?php }?>
<?php $cnt = $cnt+1; }?>
        
        </tbody>
        
        <!-- RODAPÉ DA TABELA -->
        
        <tfoot>
        
        	<!-- LINHA COM O VALOR TOTAL -->
        	<?php if($veiculo_id == "0"){?>
        	<tr>
        		<td align="right" colspan="3" class="table-active" ><strong>Valor Total </strong></td>
       		 	<td style="text-align: center;"><strong><?php echo number_format($valor_total_abastecimento,2,',','.');?></strong></td>
        	</tr>
        	
        	<?php }
        	else{?>
        	<tr>
        		<td align="right" colspan="2" class="table-active" ><strong>Valor Total </strong></td>
       		 	<td style="text-align: center;"><strong><?php echo number_format($valor_total_abastecimento,2,',','.');?></strong></td>
        	</tr>
        	<?php }?>
        </tfoot>
        </table>
        <br>
        
        <!-- INÍCIO DOS DADOS DE MANUTENÇÃO -->
        
		<div class="alert alert-success text-center" role="alert"><strong>Dados Manuntenção</strong></div>
        
        <!-- TABELA DE DADOS DE MANUTENÇÃO -->
        
         <table id="example2" class="table table-striped table-bordered" style="width:100%">
         
      
        <?php if($veiculo_id == "0"){?>
        <thead>
             <tr>
                <th style="text-align: center">Ordem</th>
                <th style="text-align: center">Data</th>
                <th style="text-align: center">Placa</th> 
                <th style="text-align: center">Responsável</th>
                <th style="text-align: center">Oficina</th>
                <th style="text-align: center">Tipo</th>
                <th style="text-align: center">Descricao</th>
                <th style="text-align: center">QTD</th>
                <th style="text-align: center">Valor R$)</th>
                <th style="text-align: center">Valor com Desconto (R$)</th>
            </tr>
        </thead>
        <?php }
        else{?>
        <thead>
             <tr>
                <th style="text-align: center">Ordem</th>
                <th style="text-align: center">Data</th>
                <th style="text-align: center">Responsável</th>
                <th style="text-align: center">Oficina</th>
                <th style="text-align: center">Tipo</th>
                <th style="text-align: center">Descricao</th>
                <th style="text-align: center">QTD</th>
                <th style="text-align: center">Valor (R$)</th>
                <th style="text-align: center">Valor com Desconto (R$)</th>
            </tr>
        </thead>
        <?php }?>
        
        <tbody>   
            <?php
            
    $cnt = 1;
    
    $valor_manutencao_total = 0;
    $valor_servico_total = 0;
    $valor_peca_total = 0;
    
    $desconto_manutencao_total = 0;
    $desconto_servico_total = 0;
    $desconto_peca_total = 0;
    
    foreach ($dados_manutencao as $dado_manutencao){   	
    	
    	$array_peca_servico = explode("#",$dado_manutencao['peca_servico']);
    	
    	$string_exibicao = "";
    	$valor_manutencao = 0;
    	$desconto_manutencao = 0;
    	
    	foreach ($array_peca_servico as $chave => $items_array){
			
    		$exibicao_peca_servico = explode(";",$array_peca_servico[$chave]); //contagem dos índices 
    		
	    		if(count($exibicao_peca_servico) == 4) {
	    		
	    			$exibicao_peca_servico[4] = $exibicao_peca_servico[3];
	    		}
	    		
	    		if ($exibicao_peca_servico[4] == 0) {
	    			$exibicao_peca_servico[4] = $exibicao_peca_servico[3];
	    		
	    		}

	    		$desconto_valor = isset($exibicao_peca_servico[4])? $exibicao_peca_servico[4]:$exibicao_peca_servico[3];
	    		
	    	if($exibicao_peca_servico[0] == 1){
	    		$exibicao_peca_servico[0] = "Peça";
	    		$valor_peca = $exibicao_peca_servico[3];
	    		$valor_peca_total += $valor_peca;
	    		
	    		$desconto_peca = $desconto_valor;
	    		$desconto_peca_total += $desconto_peca;
	    		
	    	}else{
	    		$exibicao_peca_servico[0] = "Serviço";
	    		$valor_servico = $exibicao_peca_servico[3]; 
	    		$valor_servico_total += $valor_servico;
	    		
	    		$desconto_servico = $desconto_valor;
	    		$desconto_servico_total += $desconto_servico;
	    		
// 	    		echo "<pre>";
// 	    		print_r($exibicao_peca_servico);
// 	    		echo "<pre>";
// 	    		exit;
	    		
	    	}
	    	
	    	$string_exibicao .= "<p>";
	    	if($veiculo_id == "0"){
	    		echo '<tr align="center">
								<td>'.$cnt.'</td>
								<td>'.$CI->datas->dateToBR($dado_manutencao['data']).'</td>
								<td>'.$dado_manutencao['placa'].'</td>
	    		                <td>'.$dado_manutencao["resp_trans"].'</td>
	    		                <td>'.$dado_manutencao['oficina'].'</td>
	    		      
					
					';
	    	}else{
	    		echo'<tr align="center">
								<td>'.$cnt.'</td>
								<td>'.$CI->datas->dateToBR($dado_manutencao['data']).'</td>
	    		                <td>'.$dado_manutencao["resp_trans"].'</td>
	    		                <td>'.$dado_manutencao['oficina'].'</td>
	    		
					';
	    		 
	    		 
	    	}
	    	
	    	foreach ($exibicao_peca_servico as $key => $item){

	    		
	    		if($key == 3){
	    			$valor_manutencao = $valor_manutencao + $item;
	    		}
	    		
	    		if($key == 4){
	    			$desconto_manutencao = $desconto_manutencao + $item;
	    		}
	    		
	    		echo '
								 <td>'.$item.'</td>
	    		               
	    		            ';
	    		
	    		$string_exibicao .= $item." - ";
	    		
	    	}
	    	
	    	echo '</tr>';
	    	
	    	$string_exibicao = substr($string_exibicao,0,-3);
	    	$string_exibicao .= "</p>";
	    	
	    	
  	  }
  
  	  $valor_manutencao_total = $valor_manutencao_total + $valor_manutencao;
  	  $string_exibicao .= "<p> Total: R$ ".number_format($valor_manutencao,2,',','.')."</p>";
  	  
  	  $desconto_manutencao_total = $desconto_manutencao_total + $desconto_manutencao;
  	  $string_exibicao .= "<p> Total: R$ ".number_format($desconto_manutencao,2,',','.')."</p>";
?>
			
			<!-- LINHA DE DADOS DE MANUTENÇÃO -->
            

<?php $cnt = $cnt+1; }?> 
    
       
        
     
        </tbody>
        
        <!-- RODAPÉ DA TABELA -->
        
        <tfoot>
        	<?php if($veiculo_id == "0"){?>
        	
        	<tr>
        		<td align="right" colspan="8" class="table-active"><strong>Valor Total de Peça </strong></td>
       		 	<td align="center"><strong><?php echo  number_format($valor_peca_total,2,',','.');?></strong></td>
       		 	
       		 	<td align="center" ><strong><?php echo  number_format($desconto_peca_total,2,',','.');?></strong></td>
        	</tr>
        	
        	<tr>
        		<td align="right" colspan="8" class="table-active"><strong>Valor Total de Serviço </strong></td>
       		 	<td align="center"><strong><?php echo  number_format($valor_servico_total,2,',','.');?></strong></td>
       		 	
       		 	<td align="center" ><strong><?php echo  number_format($desconto_servico_total,2,',','.');?></strong></td>
        	</tr>
        	
        	<tr>
        		<td align="right" colspan="8" class="table-active"><strong>Valor Total </strong></td>
       		 	<td align="center"><strong><?php echo  number_format($valor_manutencao_total,2,',','.');?></strong></td>
       		 	
       		 	<td align="center"><strong><?php echo  number_format($desconto_manutencao_total,2,',','.');?></strong></td>
        	</tr>
        	
        	<?php }
        	else{?>
        	
        	<tr>
        		<td align="right" colspan="7" class="table-active"><strong>Valor Total de Peça </strong></td>
       		 	<td align="center"><strong><?php echo  number_format($valor_peca_total,2,',','.');?></strong></td>
       		 	
       		 	<td align="center" ><strong><?php echo number_format($desconto_peca_total,2,',','.');?></strong></td>
        	</tr>
        	
        	<tr>
        		<td align="right" colspan="7" class="table-active"><strong>Valor Total de Serviço </strong></td>
       		 	<td align="center"><strong><?php echo  number_format($valor_servico_total,2,',','.');?></strong></td>
       		 	
       		 	<td align="center" ><strong><?php echo number_format($desconto_servico_total,2,',','.');?></strong></td>
        	</tr>
        	
        	<tr>
        		<td align="right" colspan="7" class="table-active"><strong>Valor Total </strong></td>
       		 	<td align="center"><strong><?php echo  number_format($valor_manutencao_total,2,',','.');?></strong></td>
       		 	
       		 	<td align="center"><strong><?php echo number_format($desconto_manutencao_total,2,',','.');?></strong></td>
        	</tr>
        	<?php }?>
        	
        </tfoot>
        
        </table>
			

<?php }else{?>
		<div class="alert alert-warning text-center" role="alert"><strong>Nenhum registro encontrado!</strong></div>    
<?php }?>
<?php }?>

<!-- FUNÇÕES E BIBLIOTECAS -->

<script type="text/javascript">
//MASCARA DATA
$(document).ready(function() {
	//$("#telefone").mask('(99)99999-9999');
	//$("#cpf").mask('999.999.999-99');
	
	   	$(document).ready(function() {
    

    
});

	   	<!-- PADRONIZAÇÃO DE DADOS NA INSERÇÃO -->
		
	$(".inputValor").mask("000.000.000.000.000,00", {reverse: true})
	$('.datas_cal').datepicker();	
});
	$(document).ready(function() {


		<!-- DATA TABLE DA TABELA DE ABASTECIMENTO -->

$('#example1').DataTable({
	language: {
		"sEmptyTable": "Nenhum registro encontrado",
		"sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
		"sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
		"sInfoFiltered": "(Filtrados de MAX registros)",
		"sInfoPostFix": "",    "sInfoThousands": ".",
		"sLengthMenu": "Resultados por página",
		"sLoadingRecords": "Carregando...",
		"sProcessing": "Processando...",
		"sZeroRecords": "Nenhum registro encontrado",
		"sSearch": "Pesquisar",
		"oPaginate": {
			"sNext": "Próximo",
			"sPrevious": "Anterior",
			"sFirst": "Primeiro",
			"sLast": "Último"
		},
		"oAria": {
			"sSortAscending": ": Ordenar colunas de forma ascendente",
			"sSortDescending": ": Ordenar colunas de forma descendente"
		}
	},
});

});
   	$(document).ready(function() {


   		<!-- DATA TABLE DADOS DE MANUTENÇÃO -->

   	    
    $('#example2').DataTable({
		language: {
			"sEmptyTable": "Nenhum registro encontrado",
			"sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
			"sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
			"sInfoFiltered": "(Filtrados de MAX registros)",
			"sInfoPostFix": "",    "sInfoThousands": ".",
			"sLengthMenu": "Resultados por página",
			"sLoadingRecords": "Carregando...",
			"sProcessing": "Processando...",
			"sZeroRecords": "Nenhum registro encontrado",
			"sSearch": "Pesquisar",
			"oPaginate": {
				"sNext": "Próximo",
				"sPrevious": "Anterior",
				"sFirst": "Primeiro",
				"sLast": "Último"
			},
			"oAria": {
				"sSortAscending": ": Ordenar colunas de forma ascendente",
				"sSortDescending": ": Ordenar colunas de forma descendente"
			}
		},
	});
    
});
   	</script>
   	
 