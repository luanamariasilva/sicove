<div class="row text-center">
	<div class="col-md-10 col-md-offset-1">
		<?php
		$alert_sessao = $this->session->userdata('alert');
					
		if(isset($alert_sessao)) {
			echo $this->session->userdata('alert');
			$this->session->unset_userdata('alert');
		} 
		?>
	</div>
</div>

<div class="row text-center">
		<div class="div_bg_normal"></div>	
	</div>		
 
<!-- <div class="row text-center">
	<div class="col-md-12" style="margin-top: 2%">
			<img width="30%" src="<?php echo base_url();?>images/aesp_logo.png" alt="logo_ceara">
	</div>
</div>		 -->
