
<!-- BIBLIOTECA DE PADRONIZAÇÃO DE DATA  -->	

<?php 
$CI = & get_instance();
$CI->load->library(array('Datas'));
?>
<div class="row">
	<div class="col-md-8 col-md-offset-2">
		<div class="panel  panel-success text-center">
			<div class="panel-heading "><strong></strong></div>
		  	<div class="panel-body">		 
					
				<table class="table table-bordered table-striped">
				   <thead>
				   		<tr> 
						  	<td>Modelo:</td>
						  	<td><?php echo $veiculo['modelo'];?></td>								  	  
					  	</tr>
					  	<tr> 
						  	<td>Placa:</td>
						  	<td><?php echo $veiculo['placa'];?></td>								  	  
					  	</tr>
					  	<tr> 
						  	<td>Cor:</td>
						  	<td><?php echo $veiculo['cor'];?></td>								  	  
					  	</tr>
					  	<tr> 
						  	<td>Ano:</td>
						  	<td><?php echo $veiculo['ano'];?></td>								  	  
					  	</tr>
					  	<tr> 
						  	<td>Tipo de Combustível:</td>
						  	<td><?php echo $veiculo['combustivel'];?></td>								  	  
					  	</tr>
					  	<tr> 
						  	<td>Data do Emplacamento:</td>
						  	<td><?php echo $CI->datas->dateToBR($veiculo['data_emplacamento']);?></td>								  	  
					  	</tr>
					  	<tr> 
						  	<td>Próximo Licenciamento:</td>
						  	<td><?php echo $CI->datas->dateToBR($veiculo['prox_licenciamento']);?></td>	
					  	</tr>
						
				  </thead> 
	 			</table>

			</div>
		  
		  	<div class="panel-footer text-center ">
      			<a href="<?php echo base_url();?>index.php/veiculo/editar_dados_veiculos/<?php echo $veiculo['veiculo_id'];?>" class="btn btn-success">Editar</a>
			</div>	
		</div>
	</div>
</div>

