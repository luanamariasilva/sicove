
<!-- CABEÇALHO -->	

<div class="row">
	<div class="col-md-8 col-md-offset-2">
		<div class="panel  panel-success text-center">
			<div class="panel-heading "><strong><?php echo $title;?></strong></div>
				<div class="panel-body">
				<?php echo form_open_multipart('manutencao/cadastrar_manutencao', array('class' => 'form-horizontal'));?>
				
				<!-- SELEÇÃO DO VEÍCULO -->	
				
				<div class="form-group <?php echo (form_error('veiculo_id') != '')? 'has-error':''; ?>">
					<label for="veiculo_id" class="col-md-3 control-label">Placa</label>
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
					<label for="data" class="col-md-3 control-label">Data</label>
					<div class="col-md-3">
						<input type="text" name ="data" autocomplete="off" class="form-control form_datetime datas_cal" id="data" value="<?php echo set_value('data')?>">
						<span id="erro"><?php echo form_error('data');?></span>
					</div>
				</div>
				
				<!-- SELEÇÃO DO RESPONSÁVEL PELO TRANSPORTE -->	
				
				<div class="form-group <?php echo (form_error('resp_trans') != '')? 'has-error':''; ?>">
					<label for="resp_trans" class="col-md-3 control-label">Responsável/Transporte</label>
					<div class="col-md-3">
						<input type="text" autocomplete="off" name="resp_trans" class="form-control" id="resp_trans" onkeyup="this.value = this.value.toUpperCase();" value="<?php echo set_value('resp_trans')?>">
						<span id="erro"><?php echo form_error('resp_trans');?></span>
					</div>
				</div>
				
				<!-- SELEÇÃO DA OFICINA -->	
									
				<div class="form-group <?php echo (form_error('oficina') != '')? 'has-error':''; ?>">
					<label for="oficina" class="col-md-3 control-label">Oficina</label>
					<div class="col-md-3">
						<input type="text" autocomplete="off" name="oficina" class="form-control" id="oficina" onkeyup="this.value = this.value.toUpperCase();" value="<?php echo set_value('oficina')?>">
						<span id="erro"><?php echo form_error('oficina');?></span>
					</div>
				</div>
				
				<!-- SELEÇÃO DO RESPONSÁVEL DA OFICINA -->	
				
				<div class="form-group <?php echo (form_error('resp_oficina') != '')? 'has-error':''; ?>">
					<label for="resp_oficina" class="col-md-3 control-label">Responsável/Oficina</label>
					<div class="col-md-3">
						<input type="text" name="resp_oficina" autocomplete="off" class="form-control" id="resp_oficina" onkeyup="this.value = this.value.toUpperCase();" value="<?php echo set_value('resp_oficina')?>">
						<span id="erro"><?php echo form_error('resp_oficina');?></span>
					</div>
				</div>
							
				<!-- DESCRIÇÃO DO SERVIÇO -->							
											 			
				<div class="form-group <?php echo (form_error('descricao') != '')? 'has-error':''; ?>">
					<label for="descricao" class="col-md-3 control-label">Descrição</label>
					<div class="col-md-8">
						<textarea type="text" name="descricao" class="form-control" id="descricao" rows="4" maxlength="200" onkeyup="this.value = this.value.toUpperCase();"><?php echo set_value('descricao')?></textarea>
						
						<span id="erro"><?php echo form_error('descricao');?></span>
					</div>
				</div>
					
				<!-- ANEXO DE COMPROVANTE -->		
					
				<div class="form-group <?php echo (form_error('userfile') != '')? 'has-error':''; ?>">
					<label for="userfile" class="col-sm-3 control-label">Anexo</label>
					<div class="col-sm-7 text-left">
						<input type="file" id="userfile" name="userfile" class="form-control">
					</div>
				</div>
					
				<!-- PAINEL DE SELEÇÃO DE SERVIÇO/PEÇA -->		
				 
				 <div id="painel-atividade">
						<div class="row">
							<div class="col-md-12 text-left"  style="margin-bottom:2%;  border-bottom: 0.1px solid #337AB7;" >
							<h4><span style="color: #666666;"><i class="fa fa-calendar-plus-o" aria-hidden="true"></i></span> Registro de Peças e Serviços</h4>
						</div>
					</div>	
					<div class="table-responsive">
						<table class="table table-striped table-hover table-condensed" id="table-atividade">
							<tbody>
								<tr>
									<td style="width:20%">										
										<select class="form-control" name="inputTipo[]" required >
											<option value="" selected="selected">Selecione...</option>
											<option value="1">Peça</option>
											<option value="2">Serviço</option>
										</select>										
									</td>
									<td style="width:40%"><input type="text" class="form-control" id="inputDescricao" name="inputDescricao[]" placeholder="Peça ou Serviço" autocomplete="off" onkeyup="this.value = this.value.toUpperCase();" required></td>
									<td style="width:7%"><input type="text" class="form-control" id="inputQtde" name="inputQtde[]" placeholder="QTDE" autocomplete="off" onkeyup="this.value = this.value.toUpperCase();" required></td>
									<td style="width:15%" ><input type="text" class="inputValor form-control" id="inputValor" name="inputValor[]" placeholder="Valor" autocomplete="off" onkeyup="this.value = this.value.toUpperCase();" required></td>
									<td style="width:15%" ><input type="text" class="inputValor form-control" id="inputdesconto" name="inputdesconto[]" placeholder="Desconto" autocomplete="off" onkeyup="this.value = this.value.toUpperCase();" ></td>
									<td class="actions"></td>
								</tr> 
							</tbody>
							
							 <tfoot>
								<tr>
									<td colspan="5" style="text-align: left;">
										<button class="btn btn-large btn-default" onclick="conferirData(this)" type="button"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Adicionar</button>
										</td>
									</tr>
								</tfoot>
								
							</table>
						</div>
				</div>
					
					
		  </div>
		  
		  <!-- RODAPÉ DO PAINEL -->	
		  
		  <div class="panel-footer">
		  
		  <!-- BOTÃO CADASTRAR -->	
		  
		  <button  type="button" value="Voltar" onClick="JavaScript: window.history.back();" class="btn btn-warning">Voltar</button>
				      <button type="submit" class="btn btn-success">Cadastrar</button>
		  </div>
		  	<?php echo form_close();?>
		</div>
	</div>
</div>

<!-- FUNÇÕES E BIBLIOTECAS -->	

<script>
var cnt_atividade = 1;


<!-- FUNÇÃO QUE CONFERE A DATA INSERIDA -->	

function conferirData(contexto){ //Verifica se a data de termino é posterior a data de inicio

	AddTableRow(contexto);
}

(function($) {

	  RemoveTableRow = function(handler) {
	    var tr = $(handler).closest('tr');

	    tr.fadeOut(400, function(){ 
	      tr.remove(); 
	    }); 

	    return false;
	  };
	  
	 AddTableRow = function() {

	      
		var newRow = $('<tr>');
		var cols = "";
		var restricao = "required";
         
	      cols += '<td style="width:20%">';
	      cols += '<select class="form-control" name="inputTipo[]" id="inputTipo'+cnt_atividade+' required >';
	      cols += '<option value="" selected="selected">Selecione...</option>';
	      cols += '<option value="1">Peça</option>';
	      cols += '<option value="2">Serviço</option>';
	      cols += '</select>';
     	  cols += '</td>';
	      cols += '<td style="widht=58%"><input type="text" class="form-control" name="inputDescricao[]" onkeyup="this.value = this.value.toUpperCase();" autocomplete="off" id="inputDescricao'+cnt_atividade+'"placeholder="Peça ou Serviço"'+restricao+'></td>';
	      cols += '<td style="widht=7%"><input type="text" class="form-control" name="inputQtde[]" onkeyup="this.value = this.value.toUpperCase();" autocomplete="off" id="inputQtde'+cnt_atividade+'"placeholder="QTDE"'+restricao+'></td>';
	      cols += '<td style="widht=15%"><input type="text" class="inputValor form-control" name="inputValor[]" onkeyup="this.value = this.value.toUpperCase();" autocomplete="off"  id="inputValor'+cnt_atividade+'" placeholder="Valor"'+restricao+'></td>';	      
	      cols += '<td class="actions">';
	      cols += '<span style="color: red;"><a onclick="RemoveTableRow(this)"><i class="icon-white glyphicon glyphicon-remove"></i></a></span>';
	      cols += '</td>';

	      newRow.append(cols);
	      
	      $("#table-atividade").append(newRow);


	      cnt_atividade++;

	      return false;
	  };
	  
	})(jQuery);


<!-- PADRONIZAÇÃO DOS DADOS NA INSERÇÃO -->	

//MASCARA DATA
$(document).ready(function() {
	//$("#telefone").mask('(99)99999-9999');
	//$("#cpf").mask('999.999.999-99');
	
	$(".inputValor").mask("000.000.000.000.000,00", {reverse: true})
	$('.datas_cal').datepicker();	
});

</script>
