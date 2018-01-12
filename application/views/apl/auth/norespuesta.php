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
<!--			<h3>Respuesta equivocada</h3> -->
				<?php if(validation_errors()){ echo '<div class="alert alert-danger" role="alert">' . validation_errors() . '</div>'; } ?>
				<?php $hidden = array( 'correo' => $correo ); ?>
				<?php echo form_open('hint','',$hidden); ?>
					<div class="form-group">
						<label for="answer" class="col-sm-offset-1 col-sm-14 control-label">Respuesta equivocada. 
							Se eliminarán sus datos y deberá hacer un registro nuevo.
						</label>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-5 col-sm-6">
							<button type="submit" class="btn btn-default">Eliminar registro</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
