<!-- CABEÇALHO DO SITE -->

<div class="row">
	<div class="col-md-8 col-md-offset-2">
		<div class="panel  panel-success text-center">
			<div class="panel-heading "><strong><?php echo $title;?></strong></div>
				<div class="panel-body">
				<?php echo form_open_multipart('abastecimento/cadastrar_abastecimento', array('class' => 'form-horizontal'));?>
				<div class="form-group <?php echo (form_error('veiculo_id') != '')? 'has-error':''; ?>">
					<label for="veiculo_id" class="col-md-3 control-label">Placa</label>
					
					<!-- SELEÇÃO DE VEICULO -->
					
					<div class="col-md-3">
						<select class="form-control" name="veiculo_id" >
						<option value="" selected="selected">Selecione...</option>
						 <?php foreach ($veiculos as $veiculo){?>
						 <option value="<?php echo $veiculo['veiculo_id']?>"><?php echo $veiculo['placa']?></option><?php }?>
						</select>
						<span id="erro"><?php echo form_error('veiculo_id');?></span>
					</div>
				</div>
				
				<!-- SELEÇÃO DA DATA -->
				
				
				<div class="form-group <?php echo (form_error('data') != '')? 'has-error':''; ?>">
					<label for="data" class="col-md-3 control-label">Mês de Cadastro</label>
					<div class="col-md-3">
						<input type="month" name="data" autocomplete="off" class="form-control form_datetime" id="data" value="<?php echo set_value('data')?>">
						<span id="erro"><?php echo form_error('data');?></span>
					</div>
				</div>
				
				<!-- INPUT DO VALOR ABASTECIDO -->
						
				<div class="form-group <?php echo (form_error('valor') != '')? 'has-error':''; ?>">
					<label for="valor" class="col-md-3 control-label">Valor Total</label>
					<div class="col-md-3">
						<input type="text" name="valor" class="inputValor form-control" id="valor" onkeyup="this.value = this.value.toUpperCase();" value="<?php echo set_value('valor')?>">
						<span id="erro"><?php echo form_error('valor');?></span>
					</div>
				</div>
				
				
				
				
				
				<!-- ANEXO DO COMPROVANTE DE ABASTECIENTO -->
				
				
				<div class="form-group <?php echo (form_error('userfile') != '')? 'has-error':''; ?>">
					<label for="userfile" class="col-sm-3 control-label">Comprovante de Abastecimento/Anexo</label>
					<div class="col-sm-7 text-left">
						<input type="file" id="userfile" name="userfile" class="form-control">
					</div>
				</div>
				
			    <!-- BOTÕES DE CADASTRO E DE VOLTAR -->		
				
		  </div>
		  <div class="panel-footer">
		  <button  type="button" value="Voltar" onClick="JavaScript: window.history.back();" class="btn btn-warning">Voltar</button>
				      <button type="submit" class="btn btn-success">Cadastrar</button>
		  </div>
		  	<?php echo form_close();?>
		</div>
	</div>
</div>

<script>

//MASCARA DATA -> PADRONIZAÇÃO DOS DADOS INSERIDOS
$(document).ready(function() {
	//$("#telefone").mask('(99)99999-9999');
	//$("#cpf").mask('999.999.999-99');
	
	$(".inputValor").mask("000.000.000.000.000,00", {reverse: true})
	$('.datas_cal').datepicker();	
});

</script>
