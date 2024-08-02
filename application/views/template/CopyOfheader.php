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
	<meta name="description" content="Sistema de gerenciamento de Contratos da AESP">
    <meta name="author" content="Paccelli Bittencourt">
	<link rel="shortcut icon" href="<?php echo base_url();?>images/localhost.ico" type="image/x-icon" />
	
	<title>Sistema</title>
	
	<!-- Bootstrap core CSS -->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/select/dist/css/bootstrap-select.min.css" />
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

<body>
	<div class="container-fluid">
	
		<div class="row" id="topo">
			<!--  Topo -->
			<div id="topo_center" class="text-left">
				<div class="col-md-3 visible-md visible-lg">
					<strong><?php echo $today; ?></strong>
				</div>
				<div class="col-sm-6 col-md-5 col-lg-4 text-center"></div>
				<div class="col-sm-2 col-md-2 col-lg-2 visible-md visible-lg text-center"></div>
				<div class="col-sm-3 col-md-3 col-lg-3 visible-sm visible-md visible-lg text-center"></div>
			</div>
			<!-- Fim da topo_center -->
			<div class="text-right" style="position: absolute; top: 0px; right: 0px;">
				 <a href="http://www.ceara.gov.br/">
			      	<img src="<?php echo base_url();?>images/logo_govCe.jpg" alt="logo_ceara">
			     </a>
			</div>
		</div><!-- Fim da topo -->
		
		<!--  Logo -->
        <div class="row">
        	<div class="col-md-6 col-lg-6 visible-md visible-lg">
            	<img src="<?php echo base_url();?>images/logo_left.jpg">
            </div>
        
	        <div class="col-sm-12 col-md-6 col-lg-6 text-right" id="logo_right" style="padding-right: 25px;">
	        	<div>Sistema de Pós-Graduaçãoo<br />
	        		<div style='font-size:10pt; text-align:right; margin-right:30px;'> Versão 1.0</div>
	        	</div>
	        </div>
        </div>
		
					<div class="row" id="linha"></div>
		
	</div><!-- Fim do container -->
	
	<nav class="navbar navbar-default">
		<div class="container-fluid">
		
		
		
		
			
			
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Toggle navigation</span> 
					<span class="icon-bar"></span> 
					<span class="icon-bar"></span> 
					<span class="icon-bar"></span>
				</button>
				
				<?php  
				
				if($this->uri->segment(2) != null){
				
					if($this->uri->segment(2) == 'ficha_contrato'){?>
					
						<div class="navbar-brand">
							<a href="<?php echo base_url('')?>index.php/home/" class="btn btn-primary"><span class="glyphicon glyphicon-home" aria-hidden="true"></span> Início</a>
						</div>
				
				<?php }elseif ($this->uri->segment(2) == 'ficha_acao'){ ?>

						<div class="navbar-brand">
						
							<a href="<?php echo base_url('')?>index.php/home/" class="btn btn-primary"><span class="glyphicon glyphicon-home" aria-hidden="true"></span> Início</a>
							
							<a href="<?php echo base_url('')?>index.php/home/" class="btn btn-primary"><span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span> Voltar</a>
						</div>
				
				<?php 
					} 
				}
				?>

			</div>
			<!-- Collect the nav links, forms, and other content for toggling -->
			
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav navbar-right">
					<li>
						<div class="row" style="padding: 15px;">
							<?php
							echo form_open('login/efetuar_login', array('class' => 'form-inline'));
							?>
								<div class="form-group" <?php echo (form_error('inputCPF') != '')? 'has-error':''; ?>>
									 <label for="InputCPF">CPF</label>
									 <input class="form-control" value="<?php echo set_value("inputCPF"); ?>" id="inputCPF" name="inputCPF" placeholder="CPF" style="width: 170px;">
								</div>
								<div class="form-group" <?php echo (form_error('inputSenha') != '')? 'has-error':''; ?>>
									 <label for="InputCPF">Senha</label>
									<input type="password" value="<?php echo set_value("inputSenha"); ?>" class="form-control" id="inputSenha" name="inputSenha" placeholder="Senha" style="width: 170px;">
								</div>
								<div class="form-group">
									 <button type="submit" class="btn btn-success">Entrar</button>
									 <button type="button" data-toggle="modal" data-target="#recupera_senha" class="btn btn-danger">Recuperar Senha</button>
								</div>
							<?php
							echo form_close();
							?>
						</div>
						
						<div class="row">
							<div class="col-md-4 ">
								<span id="erro"><?php echo form_error('inputCPF');?></span>
							</div>
							<div class="col-md-4">
								<span id="erro"><?php echo form_error('inputSenha');?></span>
							</div>
						</div>
					</li>
				</ul>
			</div><!-- /.navbar-collapse -->

		</div>
	</nav>
				
	<!-- Begin page content -->
	<div class="container" style="width:100%; padding-top:1%">
	
	

      <form class="form-signin">
        <h2 class="form-signin-heading">Please sign in</h2>
        <label for="inputEmail" class="sr-only">Email address</label>
        <input type="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" id="inputPassword" class="form-control" placeholder="Password" required>
        <div class="checkbox">
          <label>
            <input type="checkbox" value="remember-me"> Remember me
          </label>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
      </form>

    </div> <!-- /container -->
	
	
	
<?php
		$alert_sessao = $this->session->userdata('alert');
					
		if(isset($alert_sessao)) {
			echo $this->session->userdata('alert');
			$this->session->unset_userdata('alert');
		} 
		?>
