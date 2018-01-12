<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<br>
<div class="container">
	<div class="col-md-4 center-block no-float">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title"><?php echo $panel_title ?></h3>
			</div>
			<div class="panel-body">
				<!--<form action="<?php echo base_url(); ?>entrar" method="POST">-->
				<?php if(validation_errors()){ echo '<div class="alert alert-danger" role="alert">' . validation_errors() . '</div>'; } ?>
				<?php echo form_open('passchange'); ?>
					<div class="form-group">
						<label for="passact">Contraseña actual</label>
						<input type="password" name="passact" class="form-control" id="passact" placeholder="Contraseña actual">
					</div>
					<div class="form-group">
						<label for="passnew">Contraseña nueva</label>
						<input type="password" name="passnew" class="form-control" id="passnew" placeholder="Contraseña nueva">
					</div>
					<div class="form-group">
						<label for="passconfnew">Confirmar contraseña nueva</label>
						<input type="password" name="passconfnew" class="form-control" id="passconfnew" placeholder="Confirmar contraseña nueva">
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-default">Cambiar</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
