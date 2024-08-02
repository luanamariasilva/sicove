
<!-- BIBLIOTECA DE FORMATAÇÃO DE DATA E TEMPO -->	

<?php 
$CI = & get_instance();
$CI->load->library(array('Datas'));
?>

<!-- CABEÇALHO -->	

<div class="row">
	<div class="col-md-8 col-md-offset-2">
		<div class="panel  panel-success text-center">
			<div class="panel-heading "><strong><?php echo $title;?></strong></div>
			<div class="panel-body">
		   		<?php echo form_open_multipart('manutencao/editar_manutencao/'.$manutencao['id_manutencao'], array('class' => 'form-horizontal'));?>
				
				<!-- EDIÇÃO DA DATA INSERIDA  -->	
				
				<div class="form-group <?php echo (form_error('data') != '')? 'has-error':''; ?>">
					<label for="data" class="col-md-3 control-label">Data</label>
					<div class="col-md-3">
						<input type="text" name="data" class="form-control datas_cal" id="data" value="<?php echo $CI->datas->dateToBR(set_value('data',$manutencao['data']));?>">
						<span id="erro"><?php echo form_error('data');?></span>
					</div>
				</div>
				
				<!-- EDIÇÃO DO RESPONSÁVEL PELO TRANSPORTE -->	
				
				<div class="form-group <?php echo (form_error('resp_trans') != '')? 'has-error':''; ?>">
					<label for="resp_trans" class="col-md-3 control-label">Responsável/Transporte</label>
					<div class="col-md-3">
						<input type="text" name="resp_trans" class="form-control" id="resp_trans" onkeyup="this.value = this.value.toUpperCase();" value="<?php echo set_value('resp_trans',$manutencao['resp_trans'])?>">
						<span id="erro"><?php echo form_error('resp_trans');?></span>
					</div>
				</div>
				
				<!-- EDIÇÃO DA OFICINA -->	
						
				<div class="form-group <?php echo (form_error('oficina') != '')? 'has-error':''; ?>">
					<label for="oficina" class="col-md-3 control-label">Oficina</label>
					<div class="col-md-3">
						<input type="text" name="oficina" class="form-control" id="oficina" onkeyup="this.value = this.value.toUpperCase();" value="<?php echo set_value('oficina',$manutencao['oficina'])?>">
						<span id="erro"><?php echo form_error('oficina');?></span>
					</div>
				</div>
				
				<!-- EDIÇÃO DO RESPONSÁVEL DA OFICINA -->	
				
				<div class="form-group <?php echo (form_error('resp_oficina') != '')? 'has-error':''; ?>">
					<label for="resp_oficina" class="col-md-3 control-label">Responsável/Oficina</label>
					<div class="col-md-3">
						<input type="text" name="resp_oficina" class="form-control" id="resp_oficina" onkeyup="this.value = this.value.toUpperCase();" value="<?php echo set_value('resp_oficina',$manutencao['resp_oficina'])?>">
						<span id="erro"><?php echo form_error('resp_oficina');?></span>
					</div>
				</div>
				
				<!-- EDIÇÃO DA DESCRIÇÃO DO SERVIÇO/PEÇA -->	
							
	   			<div class="form-group <?php echo (form_error('descricao') != '')? 'has-error':''; ?>">
					<label for="descricao" class="col-md-3 control-label">Descrição</label>
					<div class="col-md-8">
						<textarea type="text" name="descricao" class="form-control" id="descricao" onkeyup="this.value = this.value.toUpperCase();"  rows="4" maxlength="200"><?php echo set_value('descricao',$manutencao['descricao'])?></textarea>
						<span id="erro"><?php echo form_error('descricao');?></span>
					</div>
				</div>
				
				<!-- EDIÇÃO DO ARQUIVO ANEXADO -->	
				
	<?php 
	
	$caminho_solicitante = base_url('./uploads/'.$manutencao['veiculo_id'].'/manutencao/'.$manutencao['id_manutencao']);
	$file_headers = @get_headers($caminho_solicitante);
	
	if ($file_headers[0] == "HTTP/1.1 404 Not Found") {?>
	
	<hr>
		<div id="verificardoc" class="form-group <?php echo (form_error('userfile') != '')? 'has-error':''; ?>">
		     <div class=" row">
			      <div class="col-md-8 col-md-offset-2" >
					<div class="alert alert-warning alert-dismissible fade in" role="alert-js">
					    <p>Não possui documento <strong>Cadastrado.</strong></p>
					</div>
				 </div>	
			</div>
		<label for="userfile" class="col-sm-3 control-label">Anexo</label>
			<div class="col-sm-7 text-left">
				<input type="file" id="userfile" name="userfile" class="form-control">	
			</div>
	   </div>
	<hr> 
		
	<?php } else{ ?>
		<hr>
			<div id="verificardoc" class="form-group <?php echo (form_error('userfile') != '')? 'has-error':''; ?>">
				<div><iframe src="<?= base_url('./uploads/'.$manutencao['veiculo_id'].'/manutencao/'.$manutencao['id_manutencao']) ?>.pdf" width="90%" height="400" style="border:1px solid black;"></iframe></div>
				  <label style="margin-top: 2%;" for="userfile" class="col-sm-3 control-label">Anexo</label>
				     <div class="col-sm-7 text-left">
				         <input type="file" id="userfile" name="userfile" class="form-control">	
				      </div>   
				</div>         
		<hr>
	<?php 	
	}
	?>	



				<!-- PAINEL DE EDIÇÃO DOS DADOS DE SERVIÇO/PEÇA -->	
				
				<div id="painel-atividade">
					<div class="row">
						<div class="col-md-12 text-left"  style="margin-bottom:2%;  border-bottom: 0.1px solid #337AB7;" >
							<h4><span style="color: #666666;"><i class="fa fa-calendar-plus-o" aria-hidden="true"></i></span> Registro de Peças e Serviços</h4>
						</div>
					</div>
					
					<div class="table-responsive">
						<table class="table table-striped table-hover table-condensed" id="table-atividade">
							
							<tbody>
							
								<?php foreach ($servicos_realizados as $key => $servico_realizado){
									
										$item = explode(';', $servico_realizado);
					                    $item[4]=isset($item[4])? $item[4] : "0"; 
									
								
									if ($item[0] != 1){
											$tipo = "Serviço";												
										}else{
											$tipo = "Peça";
										}
										
										echo '
										  <tr>
												<td style="width:20%"><input  type="text" class="form-control" value="'.$tipo.'" id="inputTipo" name="inputTipo[]" placeholder="Valor" autocomplete="off" readonly></td>										
												<td style="width:40%"><input type="text" class="form-control"  value="'.$item[1].'" id="inputDescricao" name="inputDescricao[]" placeholder="Peça ou Serviço" autocomplete="off" readonly></td>
												<td style="width:7%"><input type="text" class="form-control"  value="'.$item[2].'" id="inputQtde" name="inputQtde[]" placeholder="QTDE" autocomplete="off" readonly></td>
												<td style="width:15%" ><input  type="text" class="inputValor form-control" value="'.$item[3].'"id="inputValor" name="inputValor[]" placeholder="Valor" autocomplete="off" readonly></td>
												<td style="width:15%" ><input  type="text" class="inputValor form-control" value="'.$item[4].'"id="inputdesconto" name="inputdesconto[]" placeholder="Desconto" autocomplete="off" readonly></td>
				                     		</tr>
	
											';
									}?>
							</tbody>
							
							
							 <tfoot>
								<tr>
									<td colspan="5" style="text-align: left;">
										<button class="btn btn-large btn-default" onclick="conferirData(this)" type="button"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span>Adicionar</button>
									</td>
								</tr>
							</tfoot>
							
						</table>
					</div>
				</div>
			 	</div>
			 	
			 	<!-- RODAPÉ DO PAINEL -->	
			 	
				<div class="panel-footer">
				
					<!-- BOTÃO VOLTAR -->	
				
				      <button  type="button" value="Voltar" onClick="JavaScript: window.history.back();" class="btn btn-warning">Voltar</button>
				      
				   <!-- BOTÃO PARA SALVAR ALTERAÇÕES -->	   
				      
				      <button type="submit" class="btn btn-success">Salvar Aterações</button>
		  		</div>
		  
		  	<?php echo form_close();?>
		</div>
	</div>
</div>


<!-- FUNÇOES E BIBLIOTECAS -->	

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

<!-- PADRONIZAÇÃO DOS DADOS INSERIDOS -->	

//MASCARA DATA
$(document).ready(function() {
	//$("#telefone").mask('(99)99999-9999');
	//$("#cpf").mask('999.999.999-99');
	$("#data").mask('99/99/9999');
	$(".inputValor").mask("000.000.000.000.000,00", {reverse: true})
	$('.datas_cal').datepicker();	
});

</script>
