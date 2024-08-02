
<!-- BIBLIOTECA DE PADRONIZAÇÃO DA DATA E TEMPO -->

<?php 
$CI = & get_instance();
$CI->load->library(array('Datas'));
?>
<?php if(($veiculos_cadastrados) == ''){ ?>
<?php }else{ ?>
<?php if(count($veiculos_cadastrados) > 0){ ?>

<div class="row">
	<div class="col-md-10 col-md-offset-1" style="padding-top: 5%">

<!-- TABELA COM DADOS DE PESQUISA -->

	<div class="panel panel-success text-center">
			<div class="panel-heading "><strong><?php echo $title;?></strong></div>
			<div class="panel-body">
			
			<div class="table-responsive">
			
					<table id="example" class="table table-striped table-bordered" style="width:100%;" >
					
					<!-- CABEÇALHO DA TABELA -->
						
					    <thead>
					         <tr>
					            <th>Ordem</th>
					            <th style="text-align: center"> Placa</th>
					            <th style="text-align: center">Renavan</th>
					            <th style="text-align: center">Chassi</th>
					            <th style="text-align: center">Modelo</th>
					            <th style="text-align: center">Cor</th>
								<th style="text-align: center">Ano</th>
								<th style="text-align: center">Combustível</th>
								<th style="text-align: center">Emplacamento</th>
								<th style="text-align: center">Licenciamento</th>
					            <th style="text-align: center">Editar</th>
					            <th style="text-align: center">Excluir</th>
					        </tr>
					    </thead>
					    
					    <!-- CORPO DA TABELA -->
					    
					    <tbody>
					
					<?php 
						$cnt = 1;
						foreach ($veiculos_cadastrados as $veiculo){
					?>
					
					<!-- LINHA COM DADOS DE PESQUISA -->
						
					    <tr align="center">
					        <td style="width:35px; text-align: center;"><?php echo $cnt;?></td>
					        <td style="width:120px;" ><?php echo $veiculo['placa']?></td>
					        <td><?php echo $veiculo['renavan']?></td>
					        <td style="width:120px;"><?php echo $veiculo['chassi']?></td>
							<td style="width:200px;"><?php echo $veiculo['modelo'];?></td>
					        <td><?php echo $veiculo['cor'];?></td>
					        <td style="text-align: center;"><?php echo $veiculo['ano'];?></td>
					        <td style="width:150px;"><?php echo $veiculo['combustivel'];?></td>
					        <td style="text-align: center; width:150px"><?php echo $CI->datas->dateToBR($veiculo['data_emplacamento']);?></td>
					        <td style="text-align: center; width:150px"><?php echo $CI->datas->dateToBR($veiculo['prox_licenciamento']);?></td>
					        <td style="width:45px; text-align: center;"><a class="btn btn-warning btn-sm" href="<?php echo base_url();?>index.php/veiculo/editar_dados_veiculos/<?php echo $veiculo['veiculo_id'];?>" role="button">Editar</a></td>
					        <td style="width:60px; text-align: center"><a class="btn btn-danger btn-sm" href="<?= base_url('index.php/veiculo/excluir/' . $veiculo['veiculo_id']) ?>" onclick="return confirm('Deseja realmente excluir o o registro?');">Remover</a></td>
					    </tr>
					           
					<?php $cnt = $cnt+1; }?>
					 
					 
					
					        </tbody>
							
							<!-- RODAPÉ DA TABELA -->
					    </table>
				</div>
			</div>
		</div>
	</div>
</div>

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