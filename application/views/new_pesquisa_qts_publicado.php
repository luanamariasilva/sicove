<link rel="stylesheet" href="<?php echo base_url(); ?>css/jquery-ui.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>bootstrap/css/bootstrap-select.min.css">

<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/datepicker/js/datepicker-pt-BR.js"></script>

<div id="view_content">	

	<div class="row">
		<div class="col-md-12">
			<p class="bg-success lead text-center"><?php echo $titulo; ?></p>
		</div>
	</div>
	
	<div class="row">
		<div class="col-md-8 col-md-offset-2 text-center">
	    	<div class="alert alert-warning" role="alert">
	    		<p>
	    		Este é o <strong> Sistema Gerenciador de Quadros de Trabalhos Semanais</strong> dos cursos mantidos pela AESP-CE. <br> 
			    Durante o processo de consulta nenhuma informação é gravada. <br>
			    No painel abaixo, selecione o <strong>curso</strong> e o <strong>grupo</strong> do QTS que deseja consultar.
	    		</p>
	    		<br>
	    		<h4>
	    		<p class="text-danger">
	    			O QTS é um plano de trabalho <strong>sujeito a mudanças</strong> que podem ocorrer mediante conveniência da AESP/CE
	    		</p>
	    		</h4>
			</div>
			
			<?php
			
				if(isset($mensagem) and $mensagem != ''){

				echo $mensagem;

				} 
			
			
			?>
			
    	</div>
    </div>
    
    <div class="row">
    	<div class="col-md-8 col-md-offset-2 text-center">
    
    		<div class="panel panel-success">
				<div class="panel-heading">
					<h3 class="panel-title text-center">
						<strong>Selecione o curso e o grupo </strong>
					</h3>
				</div>
				<div class="panel-body">
				
					<form class="form-horizontal">

						<div class="form-group">
							<label for="inputCurso" class="col-sm-2 control-label">Curso:</label>
							
							<div class="col-sm-10">
								<?php
								$curso = array();
								
								foreach ($qts_publicado as $codigo => $valor){
									$curso[$valor['codcurso']] = mb_strtoupper($valor['nome'],'UTF-8');
								}		

								$curso = array(''=>'SELECIONE') + $curso;
											
								$parametros_curso = 'id="curso" class="form-control selectpicker" data-style="btn-default" data-live-search="true" onChange="carregarTurma();" required';
	
								echo form_dropdown('curso', $curso, '', $parametros_curso);
								?>
							</div>
						</div>

						<div class="form-group">
							<label for="inputEmail3" class="col-sm-2 control-label">Grupo:</label>
							
							<div class="col-sm-3">
								<?php
									$turmas_disponiveis = array();
									$parametros_turma = 'id="turma" class="form-control" data-style="btn-default" data-live-search="true" required';
									echo form_dropdown('turma', $turmas_disponiveis, '', $parametros_turma);
								?>
							</div>
						</div>
						<div class="form-group">
							<label for="inputEmail3" class="col-sm-2 control-label">Mês:</label>							
							<div class="col-sm-3">
								<td>									
									<select class="form-control" name="inputTipo[]" required >
										<option value="" selected="selected">Selecione...</option>
										<option value="01">Janeiro</option>
										<option value="02">Fevereiro</option>
										<option value="03">Março</option>
										<option value="04">Abril</option>
										<option value="05">Maio</option>
										<option value="06">Junho</option>
										<option value="07">Julho</option>
										<option value="08">Agosto</option>
										<option value="09">Setembro</option>
										<option value="10">Outubro</option>
										<option value="11">Novembro</option>
										<option value="12">Dezembro</option>
										
									</select>										
								</td>																
							</div>
						</div>
						<div class="form-group">
							<label for="inputEmail3" class="col-sm-2 control-label">Ano:</label>							
							<div class="col-sm-2">
								<td>									
									<select class="form-control" name="inputTipo[]" required >
										<option value="" selected="selected">Selecione...</option>
										<option value="<?php echo date("Y")-1 ?>"><?php echo date("Y")-1 ?></option>
										<option value="<?php echo date("Y") ?>"><?php echo date("Y") ?></option>
										<option value="<?php echo date("Y")+1 ?>"><?php echo date("Y")+1 ?></option>										
										
									</select>										
								</td>															
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-offset-2 col-sm-8 text-center">
								<button type="button" id="btn_visualizar" class="btn btn-success btn-lg" onclick="visualizarQts();">Pesquisar</button>
							</div>
						</div>
					</form>
				</div>
			</div>	
    	</div>
    </div>
</div>

<script>

jQuery(function($){

	carregarTurma();
});

function carregarTurma() {

		var codcurso = $("#curso").val();
		var base = "<?php echo base_url();?>index.php/";
		var controller = "publico";

		if (codcurso == '') {
			$('#turma').hide('');
			$('#turma').val('');  
		}else {
		
			$.ajax({
				type:	"POST",
				url:	base + controller + "/" + "dropdown_curso_turma_publicado/" + codcurso,
				data:	codcurso,

				beforeSend: function() {
				},

				success: function(retorno) {
					$('#turma').empty();
					$('#turma').fadeIn(''); 
					$('#turma').append(retorno);
				},

				error: function(txt) {
				}
			});
		}
}

function visualizarQts(){

	 var codcurso = $("#curso").val();
	 var turma = $("#turma").val();

	 var base = "<?php echo base_url();?>index.php/";
	 var controller = "publico";

	 document.location = base + controller + "/" + "visualiza_qts/" + codcurso + "/" + turma; 	
}

</script>