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
				<?php $hidden = array( 'monto' => $_SESSION['monto'] ); ?>
				<?php echo form_open('validacion','class="form-horizontal"',$hidden); ?>
					<div class="form-group">
						<label for="monto" class="col-sm-5 control-label">Monto a cancelar </label>
						<div class="col-sm-7">
							<label for="monto" class="col-sm-6">
								<font color="red">Bs. <?php echo number_format($monto,2,',','.'); ?></font>
							</label>
						</div>
					</div>
					<div class="form-group">
						<label for="card_nombre" class="col-sm-5 control-label">Nombre como aparece en la tarjeta</label>
						<div class="col-sm-6">
							<input type="text" name="card_nombre" value="<?php echo set_value('card_nombre') ?>" class="form-control" placeholder="Nombre del tarjetahabiente" maxlength="150" required>
						</div>
					</div>
					<div class="form-group">
						<label for="card_cedula" class="col-sm-5 control-label">Cédula de identidad <sub>(del titular)</sub></label>
						<div class="col-sm-3">
							<input type="number" name="card_cedula" value="<?php echo set_value('card_cedula') ?>" class="form-control" placeholder="No. de cedula" maxlength="8" minlength="6" required>
						</div>
					</div>
					<div class="form-group">
						<label for="card_tipo" class="col-sm-5 control-label">Tipo de tarjeta</label>
						<!--<input type="text" name="card_tipo" value="<?php echo set_value('card_tipo') ?>" class="form-control">-->
						<div class="col-sm-6">
							<select name="card_tipo" value="<?php echo set_value('card_tipo') ?>" required>
								<option value="Visa">Visa</option>
								<option value="Master card">Master Card</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="card_numero" class="col-sm-5 control-label">Número de tarjeta <sub>(Sin guiones ni espacios)</sub></label>
						<div class="col-sm-4">
							<input type="text" name="card_numero" value="<?php echo set_value('card_numero') ?>" class="form-control" placeholder="No. de tareta"  maxlength="16" minlength="15" required>
						</div>
					</div>
					<div class="form-group">
						<label for="card_expira" class="col-sm-5 control-label">Fecha de vencimiento <sub>(Mes / Año)</sub> </label>
<!--						<input type="text" name="card_mes" value="<?php echo set_value('card_mes') ?>" class="form-control">
						<input type="text" name="card_year" value="<?php echo set_value('card_year') ?>" class="form-control">-->
						<div class="col-sm-6">
							<select name="card_mes" value="<?php echo set_value('card_mes') ?>" required>
    	                        <option value="01">01</option>
        	                    <option value="02">02</option>
            	                <option value="03">03</option>
                	            <option value="04">04</option>
                    	        <option value="05">05</option>
                        	    <option value="06">06</option>
                            	<option value="07">07</option>
	                            <option value="08">08</option>
    	                        <option value="09">09</option>
        	                    <option value="10">10</option>
            	                <option value="11">11</option>
                	            <option value="12">12</option>
							</select>
							/
							<select name="card_year" value="<?php echo set_value('card_year') ?>" required>
        	                    <option value="2017">2017</option>
            	                <option value="2018">2018</option>
                	            <option value="2019">2019</option>
                    	        <option value="2020">2020</option>
                        	    <option value="2021">2021</option>
                            	<option value="2022">2022</option>
	                            <option value="2023">2023</option>
    	                        <option value="2024">2024</option>
        	                    <option value="2025">2025</option>
            	                <option value="2026">2026</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="card_cvv" class="col-sm-5 control-label">CVV2 / CVC2 <sub>(Ult. 3 dígitos parte trasera)</sub></label>
						<div class="col-sm-2">
							<input type="password" name="card_cvv" class="form-control" id="card_cvv" placeholder="CVV" maxlength="3" minlength="3" required>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-5 col-sm-6">
							<!--<button onclick="javasrcipt:ejecuta()" type="submit" class="btn btn-default">Procesar pago</button>-->
							<button type="submit" class="btn btn-default">Procesar pago</button>
						</div>
					</div>
				</form>
			</div>
			<div class="panel-footer">
				Esta transacción será procesada de forma segura gracias a la plataforma de:<br>
				<div class="col-md-6 center-block no-float">
					<a href="https://instapago.com/" target="_blank">
						<img src="../recursos/img/medio.png" border="0" width="326" height="63">
					</a>
				</div>
			</div>
		</div>
	</div>
</div>
