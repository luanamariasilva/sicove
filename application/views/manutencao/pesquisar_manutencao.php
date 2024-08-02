
<!-- BIBLIOTECA DE PADRONIZAÇÃO DA DATA E TEMPO -->	

<?php 
$CI = & get_instance();
$CI->load->library(array('Datas'));
?>

<!-- CABEÇALHO -->	

<div class="row">
	<div class="col-md-8 col-md-offset-2">
	
		<!-- PAINEL DE PESQUISA -->
			
		<div class="panel  panel-success text-center">
			<div class="panel-heading "><strong><?php echo $title;?></strong></div>
			<div class="panel-body">
				<?php echo form_open_multipart('manutencao/pesquisar_manutencao', array('class' => 'form-horizontal'));?>
				
				<!-- SELEÇÃO DA PLACA DO VEÍCULO -->	
				
				<div class="form-group <?php echo (form_error('veiculo_id') != '')? 'has-error':''; ?>">
					<label for="veiculo_id" class="col-md-3 control-label">Placa</label>
					<div class="col-md-3">
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
			
			<!-- RODAPÉ DO PAINEL DE PESQUISA -->	
							
			<div class="panel-footer">
			
			<!-- BOTÃO PESQUISAR -->	
			
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


	<!-- TABELA DE DADOS DE MANUTENÇÃO -->	
			  		 
	<table id="example" class="table table-striped table-bordered" style="width:device-width">
	
		<!-- CABEÇALHO DA TABELA -->	
		
        <thead>
             <tr>
                <th style="text-align: center">Ordem</th>
                <th style="text-align: center">Data</th>
                <th style="text-align: center">Responsável/Transporte</th>
                <th style="text-align: center">Oficina</th>
 				<th style="text-align: center">Responsável/Oficina</th>
				<th style="text-align: center">Anexo</th>
                <th style="text-align: center">Editar</th>
                <th style="text-align: center">Excluir</th>
            </tr>
        </thead>


		<!-- CORPO DA TABELA -->	

        <tbody>

<?php
    $cnt = 1;
    foreach ($veiculos as $veiculo){  
    	
    	$caminho_solicitante =  base_url('./uploads/'.$veiculo['veiculo_id'].'/manutencao/'.$veiculo['id_manutencao']);
    	$file_headers = @get_headers($caminho_solicitante);
    	
?>

<!-- LINHAS COM OS DADOS DE CADA MANUTENÇÃO -->	
            <tr style="text-align: center">
                <td style="width:5%;"><?php echo $cnt;?></td>
                <td style="width:10%;"><?php echo $CI->datas->dateToBR($veiculo['data']);?></td>
				<td style="width:15%;"><?php echo $veiculo['resp_trans'];?></td>
                <td style="width:20%;"><?php echo $veiculo['oficina'];?></td>
                <td style="width:15%;"><?php echo $veiculo['resp_oficina'];?></td>
              
              <?php   if ($file_headers[0] == "HTTP/1.1 404 Not Found") {?>
                <td style="width:10%;"><strong style="color: red">Documento não Cadastrado</strong></td>
               
               <?php }else {?>
                 <td style="width:10%;"><a target="_blank"  href="<?= base_url('./uploads/'.$veiculo['veiculo_id'].'/manutencao/'.$veiculo['id_manutencao']) ?>.pdf" role="button">Documento</a></td>		
               <?php }?>
               
                <td style="width:10%; text-align: center;"><a class="btn btn-warning btn-sm" href="<?php echo base_url();?>index.php/manutencao/editar_manutencao/<?php echo $veiculo['id_manutencao'];?>" role="button">Editar</a></td>
                <td style="width:10%; text-align: center"><a class="btn btn-danger btn-sm" href="<?= base_url('index.php/manutencao/excluir_manutencao/' . $veiculo['id_manutencao']) ?>" onclick="return confirm('Deseja realmente excluir o o registro?');">Remover</a></td>
            </tr>
           
 
<?php $cnt = $cnt+1; }?>

        </tbody>
    </table>

<?php }else{?>
        <div class="alert alert-warning text-center" role="alert"><strong>Nenhum registro encontrado!</strong></div>    
<?php }?> 

<?php }?>

<!-- FUNÇÕES E BIBLIOTECAS -->	

<script type="text/javascript">
   	$(document).ready(function() {


   		<!-- DATA TABLE -->	
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