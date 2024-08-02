
<div class="row" >
	<div class="col-md-8 col-md-offset-2" style="padding-top: 5%">
	 <div class="panel panel-success text-center">
	 	<?php if($this->session->userdata('alert') != ''){
			echo $this->session->userdata('alert');
			$this->session->set_userdata('alert', '');
		}?>
		
		<?php echo form_open('relatorio/relatorio_uso_veiculo', array('class' => 'form-horizontal'));?>
	  <div class="panel-heading"><strong><?php echo $title;?></strong></div>

			<div class="panel-body">
			
						<?php if($dados_uso == ""){?>
			   			<div class="form-group <?php echo (form_error('veiculo') != '')? 'has-error':''; ?>">
						  <label for="veiculo" class="col-md-3 control-label">Veículo</label>
							<div class="col-md-4">
								<select class="form-control" name="veiculo" >
								<option value="" selected="selected">Selecione...</option>
								<option value="todos">Todos os Veículos</option>
								   <?php foreach ($veiculos as $veiculo){?>
								 <option value="<?php echo $veiculo['veiculo_id']?>"><?php echo $veiculo['modelo'].' - '.$veiculo['placa']?></option><?php }?>
								</select>
								<span id="erro"><?php echo form_error('veiculo');?></span>
							</div>
						</div>
						
						<div class="form-group <?php echo (form_error('data_inicial') != '')? 'has-error':''; ?>">
						  <label for="data_inicial" class="col-md-3 control-label">Data Inicial</label>
							<div class="col-md-3">
								<input type="datetime-local" name="data_inicial" class="form-control" id="data_inicial" value="<?php echo set_value('data_inicial')?>">
								<span id="erro"><?php echo form_error('data_inicial');?></span>
							</div>
						</div>
						
						<div class="form-group <?php echo (form_error('data_final') != '')? 'has-error':''; ?>">
						  <label for="data_final" class="col-md-3 control-label">Data Final</label>
							<div class="col-md-3">
								<input type="datetime-local" name="data_final" class="form-control" id="data_final" value="<?php echo set_value('data_final')?>">
								<span id="erro"><?php echo form_error('data_final');?></span>
							</div>
						</div>
						<?php }else{
							if(count($dados_uso) > 0){
							?>
							<div class="table-responsive">
								<table class="table table-striped">
									<thead class="text-center">
										<tr>
											<td>Veículo</td>
											<td>Motorista</td>
											<td>Kilometragem na Saída</td>
											<td>Kilometragem no Retorno</td>
											<td>Horário de Saída</td>
											<td>Horário de Retorno</td>
										</tr>
									</thead>
									<tbody>
										<?php foreach($dados_uso as $key => $item){?>
											<tr>
												<td><?php echo $item['nome_veiculo'].' - '.$item['placa']?></td>
												<td><?php echo $item['nome']?></td>
												<td><?php echo $item['km_saida']?></td>
												<td><?php echo $item['km_retorno']?></td>
												<td><?php echo $item['horario_saida']?></td>
												<td><?php echo $item['horario_retorno']?></td>
											</tr>
										<?php }?>
									</tbody>
								</table>
							</div>
						<?php }else{?>
								<div class="alert alert-danger"><h5><b>Não há nenhum registro para esse período!</b></h5></div>
						<?php }}?>
	               </div>					
			<div class="panel-footer">
				<?php if($dados_uso == ""){?>
					<button class="btn btn-success" type="submit"><i class="fa fa-search"></i> Pequisar</button>
					<button class="btn btn-danger" onclick="history.back();"><i class="fa fa-times"></i> Voltar</button>
				<?php }else{?>
					<a class="btn btn-warning" href="<?php echo base_url()?>index.php/relatorio/gerar_relatorio_uso_veiculo/<?php echo $data_inicial."/".$data_final."/".$veiculo?>"><i class="fa fa-file-pdf-o"></i> Gerar PDF</a>
					<a class="btn btn-danger" href="<?php echo base_url()?>index.php/relatorio/relatorio_uso_veiculo"><i class="fa fa-times"></i> Voltar</a>
				<?php }?>
			</div>
		<?php echo form_close()?>
	</div>
</div>

</div>

 