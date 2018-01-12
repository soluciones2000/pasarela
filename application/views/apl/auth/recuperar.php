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
				<?php echo form_open('pregunta','class="form-horizontal"'); ?>
					<div class="form-group">
						<label for="email" class="col-sm-5 control-label">Correo Electrónico</label>
						<div class="col-sm-6">
							<input type="email" name="correo" value="<?php echo set_value('çorreo') ?>" class="form-control" id="email" placeholder="Correo electrónico">
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-5 col-sm-6">
							<button type="submit" class="btn btn-default">Ver pregunta de seguridad</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
