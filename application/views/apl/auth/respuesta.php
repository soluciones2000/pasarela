<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<br>
<div class="container">
	<div class="col-md-8 center-block no-float">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title"><?php echo $panel_title ?></h3>
			</div>
			<div class="panel-body">
				<!--<form action="<?php echo base_url(); ?>entrar" method="POST">-->
				<?php if(validation_errors()){ echo '<div class="alert alert-danger" role="alert">' . validation_errors() . '</div>'; } ?>
				<?php $hidden = array( 'correo' => $correo ); ?>
				<?php echo form_open('reinicio','class="form-horizontal"', $hidden); ?>
					<div class="form-group">
						<label for="pass" class="col-sm-5 control-label">Contraseña</label>
						<div class="col-sm-6">
							<input type="password" name="pass" class="form-control" id="pass" placeholder="Contraseña">
						</div>
					</div>
					<div class="form-group">
						<label for="passconf" class="col-sm-5 control-label">Confirmar contraseña</label>
						<div class="col-sm-6">
							<input type="password" name="passconf" class="form-control" id="passconf" placeholder="Confirmar contraseña">
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-5 col-sm-6">
							<button type="submit" class="btn btn-default">Cambiar</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
