
<!-- BIBLIOTECA DE PADRONIZAÇÃO DE DATA E TEMPO -->	

<?php 
$CI = & get_instance();
$CI->load->library(array('Datas'));
?>

<!-- CABEÇALHO -->	

<div class="row">
	<div class="col-md-8 col-md-offset-2">
		
		<!-- PAINEL DE EDIÇÃO -->	
		
		<div class="panel  panel-success text-center">
		
		<!-- CABEÇALHO DO PAINEL -->	
		
		 <div class="panel-heading "><strong><?php echo $title;?></strong></div>
		  
		  <!-- CORPO DO PAINEL -->	
		 
		  <div class="panel-body">
		   		<?php echo form_open('usuario/editar_usuario/'.$this->session->userdata('codusuario'), array('class' => 'form-horizontal'));?>
			
			<!-- SELEÇÃO DO CPF DO USUÁRIO -->	
		   			
					<div class="form-group <?php echo (form_error('cpf') != '')? 'has-error':''; ?>">
						<label for="cpf" class="col-md-3 control-label">CPF</label>
						<div class="col-md-3">
							<input type="text" name="cpf" class="form-control" id="cpf" value="<?php echo set_value('cpf')?>">
							<span id="erro"><?php echo form_error('cpf');?></span>
						</div>
					</div>
					
			<!-- SELEÇÃO DA MATRÍCULA DO USUÁRIO -->	
					
					<div class="form-group <?php echo (form_error('matricula') != '')? 'has-error':''; ?>">
						<label for="matricula" class="col-md-3 control-label">Matrícula</label>
						<div class="col-md-3">
							<input type="text" name="matricula" class="form-control" id="matricula" value="<?php echo set_value('matricula')?>">
							<span id="erro"><?php echo form_error('matricula');?></span>
						</div>
					</div>
					
			<!-- INSERÇÃO DO NOME DO USUÁRIO -->	
					
					<div class="form-group <?php echo (form_error('nome') != '')? 'has-error':''; ?>">
						<label for="nome" class="col-md-3 control-label">Nome</label>
						<div class="col-md-8">
							<input type="text" name="nome" class="form-control" id="nome" value="<?php echo set_value('nome')?>">
							<span id="erro"><?php echo form_error('nome');?></span>
						</div>
					</div>
					
			<!-- INSERÇÃO DO EMAIL DO USUÁRIO -->	
					
					<div class="form-group <?php echo (form_error('email') != '')? 'has-error':''; ?>">
						<label for="email" class="col-md-3 control-label">Email</label>
						<div class="col-md-5">
							<input type="email" name="email" class="form-control" id="email" value="<?php echo set_value('email')?>">
							<span id="erro"><?php echo form_error('email');?></span>
						</div>
					</div>
					
			<!-- INSERÇÃO DO TELEFONE DO USUÁRIO -->	
		   			
		   			<div class="form-group <?php echo (form_error('telefone') != '')? 'has-error':''; ?>">
						<label for="telefone" class="col-md-3 control-label">Telefone</label>
						<div class="col-md-5">
							<input type="text" name="telefone" class="form-control" required placeholder="(xx) xxxxx-xxxx" id="telefone" value="<?php echo set_value('telefone')?>">
							<span id="erro"><?php echo form_error('telefone');?></span>
						</div>
					</div>
		  </div>
		  
		  <!-- RODAPÉ DO PAINEL -->	
		  
		  <div class="panel-footer">
		  
		  			<!-- BOTÃO VOLTAR -->	
		  			
		  			<button  type="button" value="Voltar" onClick="JavaScript: window.history.back();" class="btn btn-warning">Voltar</button>
				    
				    <!-- BOTÃO CADASTRAR -->	
				    
				    <button type="submit" class="btn btn-success">Confirmar</button>
		  </div>
		  	<?php echo form_close();?>
		</div>
	</div>
</div>		


<!-- FUNÇÕES E BIBLIOTECAS -->	

<script type="text/javascript">
		$(document).ready(function(){
		    $("#cpf").mask('000.000.000-00', {reverse: true});
		    $("#telefone").mask('(00) 0 0000-0000', {reverse: false});
		});
		
</script>