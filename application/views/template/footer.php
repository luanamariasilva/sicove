    
    </div> 
    <!--  FIM DO CONTAINER -->
    <hr class="hr_esp" />
    <footer class="footer">
    <hr class="hr_rod" />
    <hr class="hr_esp" />
		ACADEMIA ESTADUAL DE SEGURANÇA PÚBLICA DO CEARÁ - AESP/CE<br />
		Av. Presidente Costa e Silva, 1251, Mondubim, Cep: 60761-505<br />
		Fone/Fax: (85) 3296-0469 - Fortaleza, Ceará
		<hr class="hr_esp" />
		<hr class="hr_espfim2" />
		<hr class="hr_espfim1" />
		<hr class="hr_espfim" />
    </footer>


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script type="text/javascript" src="<?php echo base_url();?>js/ie-emulation-modes-warning.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script type="text/javascript" src="<?php echo base_url();?>js/ie10-viewport-bug-workaround.js"></script>
    
  </body>
</html>

<!-- Modal -->
  <div class="modal fade" data-backdrop="static" id="trocar_senha" role="dialog" style="top:25%;">
    <div class="modal-dialog modal-sm">
      <!-- Modal content-->
      <?php
      echo form_open('home/trocar_senha');
	  ?>
	  
	  <input type="hidden" id="id" name="id" value="<?php echo $this->session->userdata('codusuario')?>">
	  
      <div class="modal-content">
      		<div class="modal-header">
	     	<button type="button" class="close" data-dismiss="modal">&times;</button>
	     	<h4 class="modal-title">Trocar Senha</h4>
	     </div>
	     <div class="modal-body">
	     	<div class="form-group">
	     		<input type="password" id="nova_senha" name="nova_senha" required class="form-control" placeholder="nova senha">
	     	</div>
	     	<div class="form-group">
	     		<input type="password" id="re_nova_senha" name="re_nova_senha" required class="form-control" placeholder="repita a nova senha">
	     	</div>
	     </div>
	     <div class="modal-footer">
	     	<button type="button" class="btn btn-danger" data-dismiss="modal" class="btn btn-danger"><span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span> Cancelar</button>
	     	<button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-ok-sign" aria-hidden="true"></span> Ok</button>
	     </div>
	   </div>
	   <?php
       echo form_close();
       ?>
    </div>
  </div>
  
  <!-- Modal -->
  <div class="modal fade" data-backdrop="static" id="recupera_senha" role="dialog" style="top:25%;">
    <div class="modal-dialog modal-sm">
      <!-- Modal content-->
      <?php
      echo form_open("recupera_senha");
	  ?>
      <div class="modal-content">
	     <div class="modal-header">
	     	<button type="button" class="close" data-dismiss="modal">&times;</button>
	     </div>
	     <div class="modal-body">
	     	<div class="form-group">
	     		<input type="text" required class="form-control" id="inputCPF" name="inputCPF" placeholder="Informe seu CPF">
	     	</div>     	
		 </div>
		 <div class="modal-footer">
		 	 <button type="button" class="btn btn-danger" data-dismiss="modal" class="btn btn-danger"><span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span> Cancelar</button>
		     <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-ok-sign" aria-hidden="true"></span> Enviar</button>
		 </div>
	   </div>
	   <?php
       echo form_close();
       ?>
    </div>
  </div>