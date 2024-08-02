
<!-- BIBLIOTECA DE PADRONIZAÇÃO DE DATA E TEMPO -->	

<?php 
$CI = & get_instance();
$CI->load->library(array('Datas'));
?>

<!-- CABEÇALHO -->	

<div class="row">
	<div class="col-md-8 col-md-offset-2">
		
		<!-- PAINEL DE RELATÓRIO POR PERÍODO -->	
		
		<div class="panel  panel-success text-center">
			
			<!-- CABEÇALHO DO PAINEL -->	
			
			<div class="panel-heading "><strong><?php echo $title;?></strong></div>
			
			<!-- CORPO DO PAINEL -->	
			
			<div class="panel-body">
			<?php echo form_open('relatorio/relatorio_abastecimento', array('class' => 'form-horizontal'));?>
			
				<!-- SELEÇÃO DA DATA INICIAL -->	
			
				<div class="form-group <?php echo (form_error('data_inicial') != '')? 'has-error':''; ?>">
					<label for="data_incial" class="col-md-3 control-label">Data Inicial</label>
					<div class="col-md-3">
						<input type="month" name="data_inicial" class="form-control form_datetime" autocomplete="off" id="data_inicial" value="<?php echo set_value('data_inicial')?>">
						<span id="erro"><?php echo form_error('data_inicial');?></span>
					</div>
				</div>
				
				<!-- SELEÇÃO DA DATA FINAL -->	
				
				<div class="form-group <?php echo (form_error('data_final') != '')? 'has-error':''; ?>">
					<label for="data_final" class="col-md-3 control-label">Data Final</label>
					<div class="col-md-3">
						<input type="month" name="data_final" class="form-control form_datetime" autocomplete="off" id="data_final" value="<?php echo set_value('data_final')?>">
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
			
				<!-- BOTÃO VOLTAR -->	
			
				<button  type="button" value="Voltar" onClick="location.href='<?php echo base_url('index.php/home_sessao');?>'" class="btn btn-warning">Voltar</button>
			
				<!-- BOTÃO PESQUISAR -->	
			
				<button type="submit" class="btn btn-success">Pesquisar</button>
			</div>	
			
				<?php echo form_close();?>
	</div>		
</div>
</div>
<?php if(($dados_abastecimento) == ''){ ?>

<?php }else{ ?>


<?php if(count($dados_abastecimento) > 0){ ?>

// <?php 
//  echo "<pre>";
//  print_r($dados_abastecimento);
// echo "</pre>";
// exit;
// ?>
		
		
		
		<div class="alert alert-warning text-center" role="alert"><strong><?php 
			if($veiculo_id == "0"){echo "Exibindo para todos os veículos";}
			elseif($veiculo_id != "0"){echo "Veículo ".$dados_abastecimento[0]['placa'];}?></strong>
		
			<!-- BOTÃO PARA GERAR O PDF -->	
		
			<button type="button" onClick="location.href='<?php echo base_url('index.php/relatorio/gerar_realtorio_abastecimento_pdf/'.$veiculo_id.'/'.$data_inicial.'/'.$data_final);?>'" class="btn btn-danger" >PDF</button>
		</div> 
		<br>
		
		
        
        <!-- INÍCIO DOS DADOS DE MANUTENÇÃO NO RELATÓRIO -->	
        
		<div class="alert alert-success text-center" role="alert"><strong>Dados Abastecimento</strong></div>
        
        <!-- TABELA DE DADOS DE MANUTENÇÃO -->	
        
       	
       
        <table id="example1" class="table table-striped table-bordered" style="width: device-width">
		
		<!-- CABEÇALHO DA TABELA -->
		<?php if($veiculo_id == "0"){?>
        <thead>
             <tr>
                <th style="text-align: center;">Ordem</th>
                <th style="text-align: center;">Data</th>
                <th style="text-align: center;">Placa</th>  
                <th style="text-align: center;">Valor (R$)</th>
            </tr>
       </thead>
       <?php }
       else{?>
       <thead>
             <tr>
                <th style="text-align: center;">Ordem</th>
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
    	
    	$data_pesquisa = explode("-", $dado_abastecimento['data']);
    	$data_pesquisa = $data_pesquisa[1]."/".$data_pesquisa[0];
    	
//     	echo "<pre>";
//     	      print_r($data_pesquisa);
//     	echo "</pre>";
//         exit;
	?>
			
			<!-- LINHA DE DADOS DE ABASTECIMENTO -->
			<?php if($veiculo_id == "0"){?>
            <tr>
                <td style="width:40px; text-align: center;"><?php echo $cnt;?></td>
                <td style=" text-align: center;"><?php echo $data_pesquisa;?></td>
                <td style=" text-align: center;"><?php echo $dado_abastecimento['placa'];?>
                <td style=" text-align: center;"><?php echo number_format($dado_abastecimento['valor'],2, ',', ' ')?></td><?php 
                $valor_abastecimento = $dado_abastecimento['valor'];
                $valor_total_abastecimento += $valor_abastecimento;
                ?>
            </tr>
            <?php }
            else{?>
            <tr>
                <td style="width:40px; text-align: center;"><?php echo $cnt;?></td>
                <td style="text-align: center;"><?php echo $data_pesquisa;?></td>
                <td style=" text-align: center;"><?php echo number_format($dado_abastecimento['valor'],2,',','.')?></td><?php 
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
        	<?php if($veiculo_id=="0"){?>
        	<tr>
        		<td align="right" colspan="3" class="table-active" ><strong>Valor Total </strong></td>
       		 	<td style="text-align: center;"><strong><?php echo number_format($valor_total_abastecimento,2,',','.');?></strong></td>
        	</tr>
        </tfoot>
        <?php }
        else{?>
        	<tr>
        		<td align="right" colspan="2" class="table-active" ><strong>Valor Total </strong></td>
       		 	<td style="text-align: center;"><strong><?php echo number_format($valor_total_abastecimento,2,',','.');?></strong></td>
        	</tr>
        <?php }?>
        </table>
			

<?php }else{?>
		<div class="alert alert-warning text-center" role="alert"><strong>Nenhum registro encontrado!</strong></div>    
<?php }?>
<?php }?>

<!-- FUNÇÕES E BIBLIOTECAS -->	

<script type="text/javascript">
   	$(document).ready(function() {
    
<!-- PADRONIZAÇÃO DOS DADOS NA INSERÇÃO -->	
//MASCARA DATA
$(document).ready(function() {
	//$("#telefone").mask('(99)99999-9999');
	//$("#cpf").mask('999.999.999-99');
	
	$(".inputValor").mask("000.000.000.000.000,00", {reverse: true})
	$('.datas_cal').datepicker();	
});

<!-- DATA TABLE TABELA DE ABASTECIMENTO -->	

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


   	<!-- DATA TABLE DA TABELA DE MANUTENÇÃO -->	
   	
   	$(document).ready(function() {
    
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
   	