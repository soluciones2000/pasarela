<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="container">
	<div class="col-md-8 center-block no-float">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title"><?php echo $panel_title ?></h3>
			</div>
			<div class="panel-body">
				<!--<form action="<?php echo base_url(); ?>entrar" method="POST">-->
				<?php if(validation_errors()){ echo '<div class="alert alert-danger" role="alert">' . validation_errors() . '</div>'; } ?>
				<?php echo form_open('formamonto','class="form-horizontal"'); ?>
					<div class="form-group">
						<label for="monto" class="col-sm-5 control-label">Monto a cancelar </label>
						<div class="col-sm-3">
							<input type="currency" name="monto" value="<?php echo set_value('monto') ?>" class="form-control" placeholder="Monto en Bs."  maxlength="10" required>
						</div>
					</div>
					<div class="form-group">
						<label for="concepto" class="col-sm-5 control-label">Concepto</label>
						<div class="col-sm-6">
							<input type="text" name="concepto" value="<?php echo set_value('concepto') ?>" class="form-control" placeholder="Concepto del pago" maxlength="150" required>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-5 col-sm-10">
							<!--<button onclick="javasrcipt:ejecuta()" type="submit" class="btn btn-default">Procesar pago</button>-->
							<button type="submit" class="btn btn-default" onclick=this.form.action="formamonto_ip">Instapago</button>
							<button type="submit" class="btn btn-default" onclick=this.form.action="formamonto_mp">Mercadopago</button>
							<button type="submit" class="btn btn-default" onclick=this.form.action="formamonto_pf">PagoFlash</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
