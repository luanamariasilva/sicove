<?php 
$CI = & get_instance();
$CI->load->library(array('datas'));
$today = $CI->datas->getFullDateExtenso();

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	<meta name="description" content="Sistema de Controle de Veículo da AESP">
    <meta name="author" content="CETIC AESP">
	<link rel="shortcut icon" href="<?php echo base_url();?>images/localhost.ico" type="image/x-icon" />
	
	<title>SISCOVE</title>
	
	<!-- Bootstrap core CSS -->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/select/dist/css/bootstrap-select.min.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/signin.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/style.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/font-awesome/css/font-awesome.min.css" />
	<!-- 
	<link rel="stylesheet" type="text/css" href="<?php echo base_url().'css/dataTables.bootstrap.css';?>" />
	 -->
	
	<!-- Custom styles for this template -->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/sticky-footer-navbar.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/bootstrap-multiselect.css" /><!-- CSS Multiselect -->
	<!-- CSS Multiselect -->
	
	<script type="text/javascript" src="<?php echo base_url();?>js/jquery.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>js/jquery-1.11.2.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>js/jquery.mask.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>js/bootstrap-filestyle.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>css/select/dist/js/bootstrap-select.min.js"></script>
	
	<!-- 
	<script type="text/javascript" charset="utf8" src="<?php echo base_url();?>js/jquery.dataTables.js"></script>
	<script type="text/javascript" charset="utf8" src="<?php echo base_url();?>js/dataTables.bootstrap.js"></script>
	 -->
	 <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>js/datatables_1_10_16/datatables.min.css" />
	 <script type="text/javascript" charset="utf8" src="<?php echo base_url();?>js/datatables_1_10_16/datatables.min.js"></script>
	
	<script type="text/javascript" src="<?php echo base_url();?>js/bootstrap-multiselect.js"></script>

	<!-- JS Multiselect -->
	
	<!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
	<!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
	<script type="text/javascript" src="<?php echo base_url();?>js/ie-emulation-modes-warning.js"></script>
	
	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	    <![endif]-->
	
	<!-- <link href="http://netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet"> -->
		<style type="text/css">
		#login-nav input {
			margin-bottom: 15px;
		}
		</style>
	<!-- <script src="http://netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script> -->
		
	<script type="text/javascript">
		$(document).ready(function(){
		    $("#inputCPF").mask('000.000.000-00', {reverse: true});
		});
		
	</script>
</head>

<body  class="text-center">

	<?php echo form_open('login/efetuar_login', array('class' => 'form-signin')) ?>
    <img class="mb-4" src="<?php echo base_url();?>images/aesp_logo_peq.png" alt="" width="72" height="69">
    <h1 class="h3 mb-3 fw-normal"><strong>Login</strong></h1>
    
    <div class="form-floating" <?php echo (form_error('inputCPF') != '')? 'has-error':''; ?>>
      <input value="<?php echo set_value("inputCPF"); ?>" class="form-control inputCPF" id="floatingInput" name="inputCPF" placeholder="Seu CPF">
      <label for="floatingInput" class="sr-only">CPF</label>
    </div>
    
    <div class="form-floating" <?php echo (form_error('inputSenha') != '')? 'has-error':''; ?>>
      <input type="password" value="<?php echo set_value("inputSenha"); ?>" class="form-control" id="floatingPassword" name="inputSenha" placeholder="Sua Senha">
      <label for="floatingPassword" class="sr-only">Senha</label>
    </div>

    
    
    <button class="btn btn-lg btn-success btn-block" type="submit">Entrar</button>
    
    
<?php echo form_close() ?>			
	<!-- Begin page content -->

	
<?php
		$alert_sessao = $this->session->userdata('alert');
					
		if(isset($alert_sessao)) {
			echo $this->session->userdata('alert');
			$this->session->unset_userdata('alert');
		} 
		?>
