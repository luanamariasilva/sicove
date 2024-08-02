
<div class="row" >
	<div class="col-md-8 col-md-offset-2" style="padding-top: 5%">
	 <div class="panel  panel-success text-center">
	 	<?php if($this->session->userdata('alert') != ''){
			echo $this->session->userdata('alert');
			$this->session->set_userdata('alert', '');
		}?>
	 	<?php echo form_open('motorista/uso_veiculo', array('class' => 'form-horizontal'));?>
	  <div class="panel-heading "><strong><?php echo $title;?></strong></div>

				<div class="panel-body">
						
			   			<div class="form-group <?php echo (form_error('motorista') != '')? 'has-error':''; ?>">
						  <label for="motorista" class="col-md-3 control-label">Motoristas</label>
							<div class="col-md-6">
								<select class="form-control" name="motorista" >
								<option value="" selected="selected">Selecione...</option>
								   <?php foreach ($motoristas as $motorista){?>
								 <option value="<?php echo $motorista['codmotorista']?>"><?php echo $motorista['nome']?></option><?php }?>
								</select>
								<span id="erro"><?php echo form_error('motorista');?></span>
							</div>
						</div>
						
						<div class="form-group <?php echo (form_error('horario_saida') != '')? 'has-error':''; ?>">
						  <label for="horario_saida" class="col-md-3 control-label">Horário de Saída</label>
							<div class="col-md-3">
								<input type="datetime-local" name="horario_saida" class="form-control" id="horario_saida" value="<?php echo set_value('horario_saida')?>">
								<span id="erro"><?php echo form_error('horario_saida');?></span>
							</div>
						</div>
						<div class="form-group <?php echo (form_error('horario_retorno') != '')? 'has-error':''; ?>">
						  <label for="horario_retorno" class="col-md-3 control-label">Horário de Retorno</label>
							<div class="col-md-3">
								<input type="datetime-local" name="horario_retorno" class="form-control" id="horario_retorno" value="<?php echo set_value('horario_retorno')?>">
								<span id="erro"><?php echo form_error('horario_retorno');?></span>
							</div>
						</div>
						
						<div class="form-group <?php echo (form_error('veiculo_id') != '')? 'has-error':''; ?>">
						  <label for="veiculo_id" class="col-md-3 control-label">Veículo</label>
							<div class="col-md-6">
								<select class="form-control" name="veiculo_id" >
								<option value="" selected="selected">Selecione...</option>
								   <?php foreach ($veiculos as $veiculo){?>
								 <option value="<?php echo $veiculo['veiculo_id']?>"><?php echo $veiculo['placa'].' - '.$veiculo['modelo']?></option><?php }?>
								</select>
								<span id="erro"><?php echo form_error('veiculo_id');?></span>
							</div>
						</div>
						
						<div class="form-group <?php echo (form_error('km_saida') != '')? 'has-error':''; ?>">
						  <label for="km_saida" class="col-md-3 control-label">Quilometragem na saída</label>
							<div class="col-md-3">
								<input type="number" name="km_saida" class="form-control" id="km_saida" value="<?php echo set_value('km_saida')?>">
								<span id="erro"><?php echo form_error('km_saida');?></span>
							</div>
						</div>
						
						<div class="form-group <?php echo (form_error('km_retorno') != '')? 'has-error':''; ?>">
						  <label for="km_retorno" class="col-md-3 control-label">Quilometragem no retorno</label>
							<div class="col-md-3">
								<input type="number" name="km_retorno" class="form-control" id="km_retorno" value="<?php echo set_value('km_retorno')?>">
								<span id="erro"><?php echo form_error('km_retorno');?></span>
							</div>
						</div>
						
						<div class="form-group <?php echo (form_error('observacoes') != '')? 'has-error':''; ?>">
						  <label for="observacoes" class="col-md-3 control-label">Observações</label>
							<div class="col-md-3">
								<textarea name="observacoes" class="form-control" id="observacoes" value="<?php echo set_value('observacoes')?>"></textarea>
								<span id="erro"><?php echo form_error('observacoes');?></span>
							</div>
						</div>
						
	               </div>					
			<div class="panel-footer">
				<button class="btn btn-success" type="submit"><i class="fa fa-check"></i> Registrar</button>
				<button class="btn btn-danger" onclick="history.back();"><i class="fa fa-times"></i> Voltar</button>
			</div>
		<?php echo form_close()?>
	</div>
</div>

</div>

 