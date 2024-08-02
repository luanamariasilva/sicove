<?php 
$CI = & get_instance();
$CI->load->library(array('Datas'));
?>
     <!-- CABEÇALHO -->
<div class="row">
	<div class="col-md-8 col-md-offset-2">
		<div class="panel  panel-success text-center">
			<div class="panel-heading "><strong><?php echo $title;?></strong></div>
			<div class="panel-body">
				<?php echo form_open_multipart('abastecimento/pesquisar_abastecimento', array('class' => 'form-horizontal'));?>
				<div class="form-group <?php echo (form_error('veiculo_id') != '')? 'has-error':''; ?>">
					<label for="veiculo_id" class="col-md-3 control-label">Placa</label>
					<div class="col-md-3">
					
						 <!-- SELECIONAR O ID DA PLACA -->
						
						<select class="form-control" name="veiculo_id" >
							<option value="" selected="selected">Selecione...</option>
							<?php 
								foreach ($veiculos_dropdown as $value){
									echo "<option value=".$value['veiculo_id']." ".set_select('veiculo_id', $value['veiculo_id'])." >".$value['placa']."</option>"; 
								}
							?>
						</select>
						<span id="erro"><?php echo form_error('veiculo_id');?></span>
					</div>
				</div>
			</div>	
			
			<!-- BOTÃO PESQUISAR -->	
							
			<div class="panel-footer">
			<button  type="button" value="Voltar" onClick="location.href='<?php echo base_url('index.php/home_sessao');?>'" class="btn btn-warning">Voltar</button>
			    <button type="submit" class="btn btn-success">Pesquisar</button>
			</div>	
		</div>		
			
				<?php echo form_close();?>
	</div>
</div>



<?php if(($veiculos) == ''){ ?>
<?php }else{ ?>
<?php if(count($veiculos) > 0){ ?>

	
	<!-- TABELA DE DADOS -->	
	
	<table id="example" class="table table-striped table-bordered" style="width:device-width">
	
	<!-- CABEÇALHO DA TABELA -->	
	
        <thead>
             <tr>
                <th style="text-align:center">Ordem</th>
                <th style="text-align:center">Data</th> 
                <th style="text-align:center">Veículo</th>
                <th style="text-align:center">Valor Total</th> 
 				<th style="text-align:center">Anexo</th>
                <th style="text-align:center">Editar</th>
                <th style="text-align:center">Excluir</th>
            </tr>
        </thead>



		<!-- CORPO DA TABELA -->	

        <tbody>

<?php
    $cnt = 1;
    
// 	FUNÇÃO QUE BUSCA OS DADOS E PREENCHE A TABELA
    
    foreach ($veiculos as $veiculo){  
    	
      $caminho_solicitante =  base_url('./uploads/'.$veiculo['veiculo_id'].'/abastecimento/'.$veiculo['id_abastecimento']);
      $file_headers = @get_headers($caminho_solicitante);
?>

			<!-- LINHAS DA TABELA PREENCHIDAS COM OS DADOS DO BANCO -->	
			
            <tr align="center">
                <td style="width:5%;"><?php echo $cnt;?></td>
                <td style="width:10%;"><?php echo $CI->datas->dateToBR2($veiculo['data']);?></td>
				<td style="width:15%;"><?php echo $veiculo['placa'];?></td>
                <td style="width:15%;"><?php echo number_format($veiculo['valor'],2,',','.');?></td>
                
             <?php   if ($file_headers[0] == "HTTP/1.1 404 Not Found") {?>  
                <td style="width:15%;"><strong style="color: red">Documento não Cadastrado</strong></td>
               
              <?php }else {?> 
                <td style="width:15%;"><a target="_blank"  href="<?= base_url('./uploads/'.$veiculo['veiculo_id'].'/abastecimento/'.$veiculo['id_abastecimento']) ?>.pdf" role="button">Documento</a></td>
               <?php }?>                 
               
                <td style="width:10%;"><a class="btn btn-warning btn-sm" href="<?php echo base_url();?>index.php/abastecimento/editar_abastecimento/<?php echo $veiculo['id_abastecimento'];?>" role="button">Editar</a></td>
                <td style="width:10%;"><a class="btn btn-danger btn-sm" href="<?= base_url('index.php/abastecimento/excluir_abastecimento/' . $veiculo['id_abastecimento']) ?>" onclick="return confirm('Deseja realmente excluir o registro?');">Remover</a></td>
            </tr>
           
 
<?php $cnt = $cnt+1; }?>

        </tbody>

       </tbody>

    </table>

<?php }else{?>
        <div class="alert alert-warning text-center" role="alert"><strong>Nenhum registro encontrado!</strong></div>    
<?php }?> 

<?php }?>

<!-- FUNÇÕES EM JAVASCRIPT-->	

<script type="text/javascript">
   	$(document).ready(function() {

   	<!-- BIBLIOTECA DATA TABLE -->	
   	
    $('#example').DataTable({
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
