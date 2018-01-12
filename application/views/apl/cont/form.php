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
				<?php echo form_open('email_contacto'); ?>
					<div class="form-group">
						<label for="email">Correo Electrónico</label>
						<input type="email" name="email" value="<?php echo set_value('email') ?>" class="form-control" id="email" placeholder="Correo electrónico">
					</div>
					<div class="form-group">
						<label for="nombre">Nombre</label>
						<input type="text" name="nombre" value="<?php echo set_value('nombre') ?>" class="form-control" id="nombre" placeholder="Nombre">
					</div>
					<div class="form-group">
						<label for="asunto">Asunto</label>
						<input type="text" name="asunto" class="form-control" id="asunto" placeholder="Asunto">
					</div>
					<div class="form-group">
						<label for="mensaje">Mensaje</label>
						<textarea class="form-control" rows="5" name="mensaje"id="mensaje" placeholder="Escriba aqui el mensaje"></textarea>
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-default">Enviar mensaje</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
