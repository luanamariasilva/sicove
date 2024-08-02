
<div class="row" >
	<div class="col-md-8 col-md-offset-2" style="padding-top: 5%">
	 <div class="panel  panel-success text-center">
	 	<?php if($this->session->userdata('alert') != ''){
			echo $this->session->userdata('alert');
			$this->session->set_userdata('alert', '');
		}?>
	 			<div class="panel-heading "><strong><?php echo $title;?></strong></div>
	 
	 			<?php echo form_open('motorista/pesquisar_motoristas', array('class' => 'form-horizontal'));?>
	

					<div class="panel-body">
					
						<div class="form-group <?php echo (form_error('nome') != '')? 'has-error':''; ?>">
						  <label for="nome" class="col-md-3 control-label">Nome</label>
							<div class="col-md-6">
								<input name="nome" class="form-control" id="nome" value="<?php echo set_value('nome')?>">
								<span id="erro"><?php echo form_error('nome');?></span>
							</div>
						</div>
					</div>
					<div class="panel-footer">
						<button class="btn btn-success" type="submit"> Pesquisar</button>
						<button class="btn btn-danger" onclick="history.back();"> Voltar</button>
					</div>
					<?php echo form_close()?>
					
			</div>
	</div>
</div>	
			
   <?php  if(count($motorista) == 0){?>
						
						<div class="panel-body">
							<?php echo '<div class="alert alert-danger text-center"><h5><b>Não foi possível encontrar um motorista com esse Nome, tente novamente!</b></h5></div>';?>
						</div>	
						
<?php }else{?>
				
				
					<div class="panel-body">
						<table id="example" class="table table-striped">
							<tr>
								<td><b>Nome</b></td>
								<td><b>CPF</b></td>
								<td><b>CNH</b></td>
								<td><b>Validade Habilitação</b></td>
								<td><b>Excluir</b></td>
								<td><b>Editar</b></td>
							</tr>
							<tr>
								<td><?php echo $motorista['nome']?></td>
								<td><?php echo $motorista['cpf']?></td>
								<td><?php echo $motorista['cnh']?></td>
								<td><?php echo $motorista['validade_habilitacao']?></td>
								<td><a href="<?php echo base_url().'index.php/motorista/editar_motorista/'.$motorista['cpf']?>" class="btn btn-warning"><i class="fa fa-pencil"></i> Editar</a></td>
								<td><a href="<?php echo base_url().'index.php/motorista/excluir_motorista/'.$motorista['cpf']?>" class="btn btn-danger"><i class="fa fa-times"></i> Excluir</a></td>
							</tr>
						</table>
					</div>	
				<?php }?>


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

 
 