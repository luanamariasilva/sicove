<?php 
$CI = & get_instance();
$CI->load->library(array('datas'));

setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');


?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="Sistema de Controle de Veículos da AESP">
    <link rel="shortcut icon" href="<?php echo base_url();?>images/localhost.ico" type="image/x-icon" />

    <title>SISCOVE</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/select/dist/css/bootstrap-select.min.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/style.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/dataTables.bootstrap.css"/>
	
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/font-awesome/css/font-awesome.min.css" />
    
    <!-- Custom styles for this template -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/sticky-footer-navbar.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/bootstrap-multiselect.css" /><!-- CSS Multiselect --> 
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>js/datepicker/dist/css/bootstrap-datepicker3.css" /><!-- CSS Multiselect --> 
    
    <script type="text/javascript" src="<?php echo base_url();?>js/jquery-1.12.4.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>js/jquery.mask.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>js/bootstrap-filestyle.js"></script>
    
<!-- <script type="text/javascript" src="<?php //echo base_url();?>js/jquery-ui-1.10.1.custom.js"></script> -->
    
	<script type="text/javascript" charset="utf8" src="<?php echo base_url();?>js/jquery.dataTables.js"></script>
	<script type="text/javascript" charset="utf8" src="<?php echo base_url();?>js/dataTables.bootstrap.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>js/bootstrap-multiselect.js"></script><!-- JS Multiselect --> 
     <script type="text/javascript" src="<?php echo base_url();?>js/datepicker/js/bootstrap-datepicker.js"></script>
<!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script type="text/javascript" src="<?php echo base_url();?>js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    
    <?php
    if (isset($js)) {
    	echo "<script type='text/javascript' src=". base_url() ."js/". $js ."></script>";
    }
    if (isset($js1)) {
    	echo $js1;
   	}
	
   	if (isset($js2)) {
   		echo $js2;
   	}
   	?>
    <style type="text/css">

.dropdown-submenu {
  position: relative;  
}
.dropdown-submenu .dropdown-menu {
  top: 0;
  left: 100%;
  margin-top: -1px;  
}
.navbar-nav li:hover > ul.dropdown-menu {
    display: block;   
}
    
</style>

</head>
  
<body>
	<div class="container-fluid">
		<hr class="hr_tit" />
		<hr class="hr_tit2" />
		<!--  Topo -->
		<div class="row" id="topo">		
			<div id="topo_center" class="text-left">
				<div class="col-md-3 visible-md visible-lg">
					<strong><?php echo utf8_encode (strftime('%A, %d de %B de %Y', strtotime('today')));  ?></strong>
				</div>
				<div class="col-sm-6 col-md-5 col-lg-4 text-center"></div>
				<div class="col-sm-2 col-md-2 col-lg-2 visible-md visible-lg text-center"></div>
				<div class="col-sm-3 col-md-3 col-lg-3 visible-sm visible-md visible-lg text-center"></div>
			</div>
			<!-- Fim da topo_center -->
			<div class="text-right" style="position: absolute; top: 7px; right: 0px;">
				<a href="http://www.ceara.gov.br/">
					<img src="<?php echo base_url();?>images/logo_govCe.png" alt="logo_ceara">
				</a>
			</div>
		</div>
		<!-- Fim da topo -->

        <!--  Logo -->
        <div class="row">
        	<div class="col-md-6 col-lg-6 visible-md visible-lg">
            	<img src="<?php echo base_url();?>images/logo_left.png">
            </div>
        
	        <div class="col-sm-12 col-md-6 col-lg-6 text-right" id="logo_right" style="padding-right: 25px;">
	        	<div>Sistema de Controle de Veículos<br />
	        		<div style='font-size:10pt; text-align:right; margin-right:30px;'>SISCOVE 2.0</div>
	        	</div>
	        </div>
        </div>
        <div class="row linha_separa" ></div>
        
	</div>

	<nav class="navbar navbar-default">
		<div class="container-fluid">
		<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
       				<span class="icon-bar"></span>
      			</button>
    		</div>
			<?php
			if ($this->session->userdata('logado') == TRUE) {
			?>
		    <!-- Collect the nav links, forms, and other content for toggling -->
    		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
    			
    			<ul class="nav navbar-nav navbar-left">
    				<li>
      					<a href="<?php echo base_url('index.php/home_sessao');?>"><i class="fa fa-home fa-lg" aria-hidden="true"></i> INÍCIO</a>
      				</li>
	      		</ul>
	      		
	      		<ul class="nav navbar-nav navbar-left">
	        		<li class="dropdown">
		          		<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true"><i class="fa fa-wrench" aria-hidden="true"></i> MANUTENÇÃO <span class="caret"></span></a>
		          		<ul class="dropdown-menu">		          		    
		          		    <li><a href="<?php echo base_url('index.php/manutencao/cadastrar_manutencao');?>" >Cadastrar Manutenção</a></li>
		          		    <li><a href="<?php echo base_url('index.php/manutencao/pesquisar_manutencao');?>" >Pesquisar Manutenção</a></li>
		 		      </ul>
	        		</li>
	      		</ul>
	      		
	      	    <ul class="nav navbar-nav navbar-left">
	        		<li class="dropdown">
		          		<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true"><i class="fa fa-credit-card" aria-hidden="true"></i> ABASTECIMENTO <span class="caret"></span></a>
		          		<ul class="dropdown-menu">		          		    
		          		    <li><a href="<?php echo base_url('index.php/abastecimento/cadastrar_abastecimento');?>" >Cadastrar Abastecimento</a></li>
		          		    <li><a href="<?php echo base_url('index.php/abastecimento/pesquisar_abastecimento');?>">Pesquisar Abastecimento</a></li>
		 		        </ul>
	        		</li>
	      		</ul> 
	      		
	      		<ul class="nav navbar-nav navbar-left">
	        		<li class="dropdown">
		          		<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-car" aria-hidden="true"></i> VEÍCULO <span class="caret"></span></a>
		          		<ul class="dropdown-menu">		          		    
		          		    <li><a href="<?php echo base_url('index.php/veiculo/cadastrar');?>" >Cadastrar Veículo</a></li>
		          		    <li><a href="<?php echo base_url('index.php/veiculo/pesquisar');?>">Pesquisar Veículo</a></li>
		 		        </ul>
	        		</li>
	      		</ul> 
	      		
	      		<ul class="nav navbar-nav navbar-left">
	        		<li class="dropdown">
		          		<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true"><i class="fa fa-user" aria-hidden="true"></i> MOTORISTA <span class="caret"></span></a>
		          		<ul class="dropdown-menu">	
		          			<?php if($this->session->userdata('motorista') == 1){?>
		          		    	<li><a href="<?php echo base_url('index.php/motorista/uso_veiculo');?>" >Registrar Uso de Veículos</a></li>
		          		   	<?php }?>
		          		   	<?php if($this->session->userdata('motorista') == 0){?>
		          		    	<li><a href="<?php echo base_url('index.php/motorista/cadastrar_motoristas');?>" >Cadastrar Motoristas</a></li>
		          		    	<li><a href="<?php echo base_url('index.php/motorista/pesquisar_motoristas');?>" >Pequisar Motoristas</a></li>
		          		   	<?php }?>
		 		      	</ul>
	        		</li>
	      		</ul>

	      		
	      		<ul class="nav navbar-nav navbar-left">
	        		<li class="dropdown">
		          		<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-book" aria-hidden="true"></i> RELATÓRIOS <span class="caret"></span></a>
		          		<ul class="dropdown-menu">		          		    
		          		    <li><a href="<?php echo base_url('index.php/relatorio/relatorio_manutencao');?>" >Manutenção</a></li>
		          		    <li><a href="<?php echo base_url('index.php/relatorio/relatorio_abastecimento');?>">Abastecimento</a></li>
		          		    <li><a href="<?php echo base_url('index.php/relatorio/relatorio_operacional');?>">Global</a></li>
		          		    <li><a href="<?php echo base_url('index.php/relatorio/relatorio_uso_veiculo');?>">Uso do Veículo</a></li>
		 		        </ul>
	        		</li>
	      		</ul>
	      		
	      		<?php if($this->session->userdata('motorista') == 0){?>
	      		<ul class="nav navbar-nav navbar-left">
	        		<li class="dropdown">
		          		<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-users" aria-hidden="true"></i> USUÁRIOS <span class="caret"></span></a>
		          		<ul class="dropdown-menu">
		          		    
		          		    <li><a href="<?php echo base_url('index.php/usuario/novo');?>" >Novo</a></li>
		          		    <li><a href="<?php echo base_url('index.php/usuario/pesquisar');?>">Pesquisar</a></li>
		 		        </ul>
	        		</li>
	      		</ul>
	      		<?php }?>
	      		
	      		<ul class="nav navbar-nav navbar-right">
	        		<li class="dropdown">
		          		<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user-circle-o " aria-hidden="true"></i> Olá <?php echo $this->session->userdata('usuario')?> <span class="caret"></span></a>
		          		<ul class="dropdown-menu">
		          		    <li><a href="<?php echo base_url("#");?>" data-toggle="modal" data-target="#trocar_senha">Alterar senha</a></li>
		          		    <!--<li><a href="<?php echo base_url('index.php/home_sessao');?>">Trocar Perfil</a></li>-->
		          		    <li><a href="<?php echo base_url('index.php/login/logout');?>">Sair</a></li>
		 		        </ul>
	        		</li>
	      		</ul>
    		</div><!-- /.navbar-collapse -->
    		<?php 
			}
    		?>
  		</div><!-- /.container-fluid -->
	</nav>
	
	<!-- Begin page content -->
    <div class="" style="padding-bottom: 2%; padding-top: 0; margin-left: 2%; margin-right: 2%;">
    