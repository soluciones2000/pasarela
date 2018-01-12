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
				<?php $hidden = array( 'correo' => $correo, 'respuesta' => $respuesta ); ?>
				<?php echo form_open('passretrieve','class="form-horizontal"',$hidden); ?>
					<div class="form-group">
						<label for="answer" class="col-sm-5 control-label"><?php echo $label ?></label>
						<div class="col-sm-6">
							<input type="password" name="answer" class="form-control"  placeholder="Respuesta a la pregunta de seguridad">
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-5 col-sm-6">
							<button type="submit" class="btn btn-default">Cambiar contraseña</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
