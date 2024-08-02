
<div class="row" >
	<div class="col-md-8 col-md-offset-2" style="padding-top: 5%">
	 <div class="panel  panel-success text-center">
	 	<?php if($this->session->userdata('alert') != ''){
			echo $this->session->userdata('alert');
			$this->session->set_userdata('alert', '');
		}?>
	  <div class="panel-heading "><strong><?php echo $title;?></strong></div>
	 	<?php echo form_open('motorista/editar_motorista/'.$cpf, array('class' => 'form-horizontal'));?>

				<div class="panel-body">
				
					<?php if($this->session->userdata('alert') != ''){
						echo $this->session->userdata('alert');
						$this->session->set_userdata('alert', '');
					}?>
				
		   			<div class="form-group <?php echo (form_error('nome') != '')? 'has-error':''; ?>">
					  <label for="nome" class="col-md-3 control-label">Nome do Motorista</label>
						<div class="col-md-6">
							<input name="nome" class="form-control" id="nome" value="<?php echo set_value('nome', $motorista['nome'])?>">
							<span id="erro"><?php echo form_error('nome');?></span>
						</div>
					</div>
					
					<div class="form-group <?php echo (form_error('cpf') != '')? 'has-error':''; ?>">
					  <label for="cpf" class="col-md-3 control-label">CPF</label>
						<div class="col-md-3">
							<input name="cpf" class="form-control" id="cpf" value="<?php echo set_value('cpf', $motorista['cpf'])?>">
							<span id="erro"><?php echo form_error('cpf');?></span>
						</div>
					</div>
					
					<div class="form-group <?php echo (form_error('cnh') != '')? 'has-error':''; ?>">
					  <label for="cnh" class="col-md-3 control-label">CNH</label>
						<div class="col-md-3">
							<input name="cnh" class="form-control" id="cnh" value="<?php echo set_value('cnh', $motorista['cnh'])?>">
							<span id="erro"><?php echo form_error('cnh');?></span>
						</div>
					</div>
					
					<div class="form-group <?php echo (form_error('validade_habilitacao') != '')? 'has-error':''; ?>">
					  <label for="validade_habilitacao" class="col-md-3 control-label">Validade da Habilitação</label>
						<div class="col-md-3">
							<input type="date" name="validade_habilitacao" class="form-control" id="validade_habilitacao" value="<?php echo set_value('validade_habilitacao', $motorista['validade_habilitacao'])?>">
							<span id="erro"><?php echo form_error('validade_habilitacao');?></span>
						</div>
					</div>
               </div>	
               	
				<div class="panel-footer">
					<button class="btn btn-success" type="submit"><i class="fa fa-check"></i> Salvar</button>
					<button class="btn btn-danger" onclick="history.back();"><i class="fa fa-times"></i> Voltar</button>
				</div>
		<?php echo form_close()?>
	</div>
</div>

</div>

<script type="text/javascript">
		$(document).ready(function(){
		    $("#cpf").mask('000.000.000-00', {reverse: true});
		});
		
</script> 
 
 
 