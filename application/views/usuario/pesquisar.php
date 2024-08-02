
<!-- CABEÇALHO -->	

<div class="row">
	<div class="col-md-8 col-md-offset-2">
	
		<!-- PAINEL DE PESQUISA -->	
		
		<div class="panel  panel-success text-center">
		
		<!-- CABEÇALHO DO PAINEL -->	
		
		 <div class="panel-heading "><strong><?php echo $title;?></strong></div>
		 
		 <!-- CORPO DO PAINEL -->	
		 
		  <div class="panel-body">
		  		<?php echo form_open('usuario/pesquisar', array('class' => 'form-horizontal'));?>
		  		
		  			<!-- SELEÇÃO DO CPF -->	
		  		
					<div class="form-group <?php echo (form_error('nome') != '')? 'has-error':''; ?>">
						<label for="cpf" class="col-md-4 control-label">Nome</label>
						<div class="col-md-6">
							<input type="text" name="nome" class="form-control" id=nome value="<?php echo set_value('nome')?>">
							<span id="erro"><?php echo form_error('nome');?></span>
						</div>
					</div>
		  		 
		  </div>
		  
		  <!-- RODAPÉ DO PAINEL -->	
		 
		  <div class="panel-footer">
		 			<button  type="button" value="Voltar" onClick="JavaScript: window.history.back();" class="btn btn-warning">Voltar</button>
				    <button type="submit" class="btn btn-success">Pesquisar</button>
		  </div>
		  	<?php echo form_close();?>
		</div>
	</div>
</div>

<?php if(($servidores) == ''){ ?>


<?php }else{ ?>

<div class="row">
	<div class="col-md-8 col-md-offset-2 text-center" >
		<?php if(count($servidores) > 0){ ?>
	
			
			<!-- TABELA DE USUÁRIOS -->	
			
	  		<table class="table table-bordered table-striped">
				 
				 <!-- CABEÇALHO DA TABELA -->	
				 
				 <thead>
					  <tr>
						   <th class="text-center">Ordem</th> 
						   <th class="text-center">CPF</th> 
						   <th class="text-center">Nome</th> 
						   <th class="text-center">Email</th>
						   <th class="text-center">Matricula</th>
						   <th class="text-center">Ações</th> 
					   </tr> 
				  </thead> 
				  
				  <!-- CORPO DA TABELA -->	
				  
				  <tbody>
				  
				  	<?php
				  	
				  		$cnt = 1;
				  	
				  	foreach ($servidores as $servidor){  ?>
				  
					  <tr> 
						  	<th scope="row"><?php echo $cnt;?></th> 
						  	<td><?php echo $servidor['cpf'];?></td> 
						  	<td><?php echo $servidor['nome'];?></td>
						  	<td><?php echo $servidor['email'];?></td>
						  	<td><?php echo $servidor['matricula'];?></td>
						  	<td>
						  		<a class="btn btn-warning btn-sm" href="<?php echo base_url();?>index.php/usuario/editar_usuario/<?php echo $servidor['codservidor'];?>" role="button">Editar</a>
						  		<a class="btn btn-danger btn-sm" href="<?php echo base_url();?>index.php/usuario/deletar_usuario/<?php echo $servidor['codservidor'];?>" role="button">Excluir</a>	
						  	</td>  
					  </tr>
					  
					 <?php $cnt = $cnt+1; }?> 
					   
				  </tbody> 
				 </table>
				 
		<?php }else{?>
				<div class="alert alert-warning text-center" role="alert"><strong>Nenhum registro encontrado!</strong></div>	
		<?php }?>	
				  		 

	</div>
</div>

<?php }?>


<!-- FUNÇÕES E BIBLIOTECAS -->	

<script type="text/javascript">
		$(document).ready(function(){
		    $("#cpf").mask('000.000.000-00', {reverse: true});
		});
		
</script>
