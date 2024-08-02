
<!-- CABEÇALHO -->	

<div class="row">
	<div class="col-md-8 col-md-offset-2">
	
		<!-- PAINEL DE CADASTRO -->	
		
		<div class="panel  panel-success text-center">
		
		<!-- CABEÇALHO DO PAINEL -->	
		
		 <div class="panel-heading "><strong><?php echo $title;?></strong></div>
		 
		 <!-- CORPO DO PAINEL -->	
		 
		  <div class="panel-body">
		   		<?php echo form_open('veiculo/cadastrar', array('class' => 'form-horizontal'));?>
					
					<!-- CADASTRO DO MODELO -->	
					
					<div class="form-group <?php echo (form_error('modelo') != '')? 'has-error':''; ?>">
						<label for="modelo" class="col-md-3 control-label">Modelo</label>
						<div class="col-md-3">
							<input type="text" name="modelo" class="form-control" id="modelo" onkeyup="this.value = this.value.toUpperCase();" value="<?php echo set_value('modelo')?>">
							<span id="erro"><?php echo form_error('modelo');?></span>
						</div>
					</div>
					
					<!-- CADASTRO DA PLACA -->	
					
					<div class="form-group <?php echo (form_error('placa') != '')? 'has-error':''; ?>">
						<label for="placa" class="col-md-3 control-label">Placa</label>
						<div class="col-md-3">
							<input type="text" name="placa" class="form-control" id="placa" value="<?php echo set_value('placa')?>">
							<span id="erro"><?php echo form_error('placa');?></span>
						</div>
					</div>
					
					<!-- cadastro do renavan -->	
					
					<div class="form-group <?php echo (form_error('renavan') != '')? 'has-error':''; ?>">
						<label for="renavan" class="col-md-3 control-label">Renavan</label>
						<div class="col-md-3">
							<input type=text name="renavan" class="form-control" id="renavan" value="<?php echo set_value('renavan')?>">
							<span id="erro"><?php echo form_error('renavan');?></span>
						</div>
					</div>
					
					<!-- cadastro do chassi -->	
					
					<div class="form-group <?php echo (form_error('chassi') != '')? 'has-error':''; ?>">
						<label for="chassi" class="col-md-3 control-label">Chassi</label>
						<div class="col-md-3">
							<input type=text name="chassi" class="form-control" id="chassi" value="<?php echo set_value('chassi')?>">
							<span id="erro"><?php echo form_error('chassi');?></span>
						</div>
					</div>
					
					<!-- CADASTRO DA COR -->	
					
					<div class="form-group <?php echo (form_error('cor') != '')? 'has-error':''; ?>">
						<label for="cor" class="col-md-3 control-label">Cor</label>
						<div class="col-md-8">
							<input type="text" name="cor" class="form-control" id="cor" onkeyup="this.value = this.value.toUpperCase();" value="<?php echo set_value('cor')?>">
							<span id="erro"><?php echo form_error('cor');?></span>
						</div>
					</div>
					
					<!-- CADASTRO DO ANO -->	
					
					<div class="form-group <?php echo (form_error('ano') != '')? 'has-error':''; ?>">
						<label for="senha" class="col-md-3 control-label">Ano</label>
						<div class="col-md-3">
							<input type="text" name="ano" class="form-control" id="ano" value="<?php echo set_value('ano')?>">
							<span id="erro"><?php echo form_error('ano');?></span>
						</div>
					</div>
					
					<!-- SELEÇÃO DO TIPO DE COMBUSTÍVEL -->	
					
					<div class="form-group <?php echo (form_error('combustivel') != '')? 'has-error':''; ?>">
						<label for="combustivel" class="col-md-3 control-label">Combustível</label>
						<div class="col-md-5">
							<select class="form-control" name="combustivel" id="combustivel" >
								<option value="" selected="selected">Selecione...</option>
								<option value="GASOLINA">GASOLINA</option>
								<option value="ALCOOL">ALCOOL</option>
								<option value="GASOLINA/ALCOOL">GASOLINA/ALCOOL</option>
								<option value="DIESEL">DIESEL</option>
								<option value="ELÉTRICO">ELÉTRICO</option>
							</select>
							<span id="erro"><?php echo form_error('combustivel');?></span>					
						</div>
					</div>
					
					<!-- SELEÇÃO DA DATA DE EMPLACAMENTO -->	
										
					<div class="form-group <?php echo (form_error('data_emplacamento') != '')? 'has-error':''; ?>">
						<label for="data_emplacamento" class="col-md-3 control-label">Data de emplacamento</label>
						<div class="col-md-5">
							<input type="text" name="data_emplacamento" class="form-control datas_cal" id="data_emplacamento" value="<?php echo set_value('data_emplacamento')?>">
							<span id="erro"><?php echo form_error('data_emplacamento');?></span>
						</div>
					</div>		   			
					
					<!-- SELEÇÃO DA DATA DO PRÓXIMO EMPLACAMENTO -->	
					
					<div class="form-group <?php echo (form_error('prox_licenciamento') != '')? 'has-error':''; ?>">
						<label for="prox_licenciamento" class="col-md-3 control-label">Próximo Licenciamento</label>
						<div class="col-md-5">
							<input type="text" name="prox_licenciamento" class="form-control datas_cal" id="prox_licenciamento" value="<?php echo set_value('prox_licenciamento')?>">
							<span id="erro"><?php echo form_error('prox_licenciamento');?></span>
						</div>
					</div>
		  </div>
		  
		  <!-- RODAPÉ DO PAINEL -->	
		  
		  <div class="panel-footer">
		  
		  			<!-- BOTÃO VOLTAR -->	
		  			
					<button  type="button" value="Voltar" onClick="JavaScript: window.history.back();" class="btn btn-warning">Voltar</button> 
					
					<!-- BOTÃO CADASTRAR -->	
					
					<button type="submit" class="btn btn-success">Cadastrar</button>

		  </div>
		  	<?php echo form_close();?>
		</div>
	</div>
</div>

<!-- FUNÇÕES E BIBLIOTECAS -->	

<script type="text/javascript">

<!-- PADRONIZAÇÃO DOS DADOS INSERIDOS -->	

//MASCARA DATA
$(document).ready(function() {
	//$("#telefone").mask('(99)99999-9999');
	//$("#cpf").mask('999.999.999-99');
	$("#data_emplacamento").mask('99/99/9999');
	$("#prox_licenciamento").mask('99/99/9999');
	$("#inputValor").mask("000.000.000.000.000,00", {reverse: true});
	$("#ano").mask("0000/0000", {reverse: false});
	$("#renavan").mask('99999999999');
	$("#chassi").mask('99999999999999999');
	$('.datas_cal').datepicker();	
});
		
$('input[name=placa]').mask('AAA 0U00', {
    translation: {
        'A': {
            pattern: /[A-Za-z]/
        },
        'U': {
            pattern: /[A-Za-z0-9]/
        },
    },
    onKeyPress: function (value, e, field, options) {
        // Convert to uppercase
        e.currentTarget.value = value.toUpperCase();

        // Get only valid characters
        let val = value.replace(/[^\w]/g, '');

        // Detect plate format
        let isNumeric = !isNaN(parseFloat(val[4])) && isFinite(val[4]);
        let mask = 'AAA 0U00';
        if(val.length > 4 && isNumeric) {
            mask = 'AAA 0000';
        }
        $(field).mask(mask, options);
    }
});

</script>

