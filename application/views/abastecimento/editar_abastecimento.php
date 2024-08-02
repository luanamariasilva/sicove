<?php 
$CI = & get_instance();
$CI->load->library(array('Datas'));

?>

        <!-- CABEÇALHO DE EDITAR ABASTECIMENTO -->
        
<div class="row">
	<div class="col-md-8 col-md-offset-2">
		<div class="panel  panel-success text-center">
			<div class="panel-heading "><strong><?php echo $title;?></strong></div>
			<div class="panel-body">
		   		<?php echo form_open_multipart('abastecimento/editar_abastecimento/'.$abastecimento['id_abastecimento'], array('class' => 'form-horizontal'));?>
				
				<!-- ALTERAÇÃO DE DATA NO EDITAR -->
			
				<div class="form-group <?php echo (form_error('data') != '')? 'has-error':''; ?>">
					<label for="data" class="col-md-3 control-label">Mês de cadastro</label>
					<div class="col-md-3">
					    <?php 
					    
					    $data_abastecimento = $CI->datas->dateToBR($abastecimento['data']);
					    $data_abastecimento = explode("-", $abastecimento['data']);
					    $data_abastecimento = $data_abastecimento[1].$data_abastecimento[0];
// 					    echo "<pre>";
// 					    print_r( $data_abastecimento);
// 					    echo "<pre>";
// 					    exit;
					    
					    ?>
						<input type="text" name="data" class="form-control data_cal" id="data" value="<?php echo set_value('data',$data_abastecimento);?>">
						<span id="erro"><?php echo form_error('data');?></span>
					</div>
				</div>
				
				<!-- ALTERAR VALOR NO EDITAR -->
				
				<div class="form-group <?php echo (form_error('valor') != '')? 'has-error':''; ?>">
					<label for="text" class="col-md-3 control-label">Valor Total</label>
					<div class="col-md-3">
						<input type="text" name="valor" class="inputValor form-control" id="valor" onkeyup="this.value = this.value.toUpperCase();" value="<?php echo set_value('valor',$abastecimento['valor'])?>">
						<span id="erro"><?php echo form_error('valor');?></span>
					</div>
				</div>
								
				<hr>
				
<!-- ALTERAR PDF NO EDITAR -->				
				
<?php 
	$caminho_solicitante =  base_url('./uploads/'.$abastecimento['veiculo_id'].'/abastecimento/'.$abastecimento['id_abastecimento']);
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
		<label for="userfile" class="col-sm-3 control-label">Cadastrar Abastecimento/Anexo</label>
			<div class="col-sm-7 text-left">
				<input type="file" id="userfile" name="userfile" class="form-control">	
			</div>
	   </div>
<hr> 				
 
 <?php }else {?>				
				 
	<div class="form-group <?php echo (form_error('userfile') != '')? 'has-error':''; ?>">
		<div><iframe src="<?= base_url('./uploads/'.$abastecimento['veiculo_id'].'/abastecimento/'.$abastecimento['id_abastecimento']) ?>.pdf" width="90%" height="400" style="border:1px solid black;"></iframe></div>
	      <label style= "margin-top: 2%;" for="userfile" class="col-sm-3 control-label">Cadastrar Abastecimento/Anexo</label>	
            <div class="col-sm-7 text-left" style= "margin-top: 2%;">
               <input type="file" id="userfile" name="userfile" class="form-control">	
             </div> 
        </div>     
<hr>    
<?php }?>					
				<div id="painel-atividade">
					<div class="row">

					</div>
					
					<!-- TABELA DE EDIÇÃO DOS DADOS DE ABASTECIMENTO -->	
					
					<div class="table-responsive">
						<table class="table table-striped table-hover table-condensed" id="table-atividade">
							
							<tbody>
							
							</tbody>
							
							
							 <tfoot>
								<tr>
	
								</tr>
							</tfoot>
							
						</table>
					</div>
				</div>
			 	</div>
				<div class="panel-footer">
				      <button  type="button" value="Voltar" onClick="JavaScript: window.history.back();" class="btn btn-warning">Voltar</button>
				      <button type="submit" class="btn btn-success">Salvar Aterações</button>
		  		</div>
		  
		  	<?php echo form_close();?>
		</div>
	</div>
</div>

<script>
var cnt_atividade = 1;


// function conferirData(contexto){ //Verifica se a data de termino é posterior a data de inicio

// 	AddTableRow(contexto);
// }

// (function($) {

// 	  RemoveTableRow = function(handler) {
// 	    var tr = $(handler).closest('tr');

// 	    tr.fadeOut(400, function(){ 
// 	      tr.remove(); 
// 	    }); 

// 	    return false;
// 	  };
	  
// 	 AddTableRow = function() {

	      
// 		var newRow = $('<tr>');
// 		var cols = "";
// 		var restricao = "required";
         
// 	      cols += '<td style="width:20%">';
// 	      cols += '<select class="form-control" name="inputTipo[]" id="inputTipo'+cnt_atividade+' required >';
// 	      cols += '<option value="" selected="selected">Selecione...</option>';
// 	      cols += '<option value="1">Peça</option>';
// 	      cols += '<option value="2">Serviço</option>';
// 	      cols += '</select>';
//      	  cols += '</td>';
// 	      cols += '<td style="widht=58%"><input type="text" class="form-control" name="inputDescricao[]" onkeyup="this.value = this.value.toUpperCase();" autocomplete="off" id="inputDescricao'+cnt_atividade+'"placeholder="Peça ou Serviço"'+restricao+'></td>';
// 	      cols += '<td style="widht=7%"><input type="text" class="form-control" name="inputQtde[]" onkeyup="this.value = this.value.toUpperCase();" autocomplete="off" id="inputQtde'+cnt_atividade+'"placeholder="QTDE"'+restricao+'></td>';
// 	      cols += '<td style="widht=15%"><input type="text" class="inputValor form-control" name="inputValor[]" onkeyup="this.value = this.value.toUpperCase();" autocomplete="off"  id="inputValor'+cnt_atividade+'" placeholder="Valor"'+restricao+'></td>';	      
// 	      cols += '<td class="actions">';
// 	      cols += '<span style="color: red;"><a onclick="RemoveTableRow(this)"><i class="icon-white glyphicon glyphicon-remove"></i></a></span>';
// 	      cols += '</td>';

// 	      newRow.append(cols);
	      
// 	      $("#table-atividade").append(newRow);


// 	      cnt_atividade++;

// 	      return false;
// 	  };
	  
// 	})(jQuery);



//MASCARA DATA -> PADRONIZAÇÃO DOS DADOS INSERIDOS
$(document).ready(function() {
	//$("#telefone").mask('(99)99999-9999');
	//$("#cpf").mask('999.999.999-99');
	$("#data").mask('99/9999');
	$(".inputValor").mask("000.000.000.000.000,00", {reverse: true})
	$('.datas_cal').datepicker();	
});

</script>
