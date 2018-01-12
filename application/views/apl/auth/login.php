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
				<?php echo form_open('entrar'); ?>
					<div class="form-group">
						<label for="email">Correo Electrónico</label>
						<input type="email" name="correo" value="<?php echo set_value('çorreo') ?>" class="form-control" id="email" placeholder="Email">
					</div>
					<div class="form-group">
						<label for="pass">Contraseña</label>
						<input type="password" name="pass" class="form-control" id="pass" placeholder="Password">
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-default">Entrar</button>
					</div>
					<div>
						<a href="<?php echo base_url(); ?>recuperar">¿Olvidó su contraseña?</a>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
