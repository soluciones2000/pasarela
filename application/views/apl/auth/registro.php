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
				<?php echo form_open('crea_user','class="form-horizontal"'); ?>
					<div class="form-group">
						<label for="email" class="col-sm-5 control-label">Correo Electrónico</label>
						<div class="col-sm-6">
							<input type="email" name="correo" value="<?php echo set_value('çorreo') ?>" class="form-control" id="email" placeholder="Correo electrónico">
						</div>
					</div>
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
						<label for="nombre" class="col-sm-5 control-label">Nombre completo</label>
						<div class="col-sm-6">
							<input type="text" name="nombre" value="<?php echo set_value('nombre') ?>" class="form-control" placeholder="Nombre completo">
						</div>
					</div>
					<div class="form-group">
						<label for="pregunta" class="col-sm-5 control-label">Pregunta de seguridad</label>
						<div class="col-sm-6">
							<input type="text" name="pregunta" value="<?php echo set_value('pregunta') ?>" class="form-control"  placeholder="Pregunta de seguridad">
						</div>
					</div>
					<div class="form-group">
						<label for="respuesta" class="col-sm-5 control-label">Respuesta a la pregunta de seguridad</label>
						<div class="col-sm-6">
							<input type="password" name="respuesta" value="<?php echo set_value('respuesta') ?>" class="form-control"  placeholder="Respuesta a la pregunta de seguridad">
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-5 col-sm-6">
							<button type="submit" class="btn btn-default">Registro</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
