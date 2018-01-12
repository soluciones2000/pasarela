<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="container">
	<div class="panel panel-default">
		<!-- Default panel contents -->
		<div class="panel-heading">
			<h3 class="panel-title"><?php echo $panel_title ?></h3>
		</div>
		<div class="panel-body">
			<?php $hidden = array( 'cambio' => TRUE ); ?>
			<?php echo form_open('parametros','',$hidden); ?>
<!--			<form action="parametros"> -->
				<div class="form-horizontal col-md-5">
					Ordenar por:<br> 
					<input type="radio" name="orden" value="usuario" <?php if ($_SESSION['orden']=="usuario" || $_SESSION['orden']=="") { echo "checked";} ?>> Usuario
					<input type="radio" name="orden" value="fecha" <?php if ($_SESSION['orden']=="fecha") { echo "checked";} ?>> Fecha
					<input type="radio" name="orden" value="concepto" <?php if ($_SESSION['orden']=="concepto") { echo "checked";} ?>> Concepto 
					<input type="radio" name="orden" value="monto" <?php if ($_SESSION['orden']=="monto") { echo "checked";} ?>> Monto 
					<input type="radio" name="orden" value="referencia" <?php if ($_SESSION['orden']=="referencia") { echo "checked";} ?>> Referencia 
				</div>
				<div class="form-group col-md-6">
					Filtrar por:<br>
					<input type="radio" name="filtro" value="ninguno" <?php if ($_SESSION['filtro']=="ninguno" || $_SESSION['filtro']=="") { echo "checked";} ?>> Ninguno 
					<input type="radio" name="filtro" value="usuario" <?php if ($_SESSION['filtro']=="usuario") { echo "checked";} ?>> Usuario
					<input type="radio" name="filtro" value="fecha" <?php if ($_SESSION['filtro']=="fecha") { echo "checked";} ?>> Fecha
					<input type="radio" name="filtro" value="concepto" <?php if ($_SESSION['filtro']=="concepto") { echo "checked";} ?>> Concepto 
					<input type="radio" name="filtro" value="monto" <?php if ($_SESSION['filtro']=="monto") { echo "checked";} ?>> Monto 
					<input type="radio" name="filtro" value="referencia" <?php if ($_SESSION['filtro']=="referencia") { echo "checked";} ?>> Referencia 
					<br>
<!--					Desde <input type="text" name="desde" value="<?php echo set_value('desde') ?>">
					Hasta <input type="text" name="hasta" value="<?php echo set_value('hasta') ?>">-->
					<?php if ($_SESSION['filtro']=="ninguno" || $_SESSION['filtro']=="") {
						unset($_SESSION['desde']);
					} ?>
					Que contenga: <input type="text" name="desde" value="<?php if (isset($_SESSION['desde'])) { echo $_SESSION['desde'];} ?>">
					
				</div>
				<br>
				<button type="submit" class="btn btn-default">Actualizar</button>
			</form>
		</div>
		<!-- Table -->
		<table class="table table-striped">
			<tr>
				<th align="center">Usuario</th>
				<th align="center">Fecha</th>
				<th align="center">Concepto</th>
				<th align='right'>Monto</th>
				<th align="right">Referencia</th>
			</tr>
			<?php 
				for ($i=0; $i < count($name_user); $i++) { 
					echo "<tr>";
						echo "<td>".$name_user[$i]."</td>";
						echo "<td align='center'>".$fecha[$i]."</td>";
						echo "<td>".$concepto[$i]."</td>";
						echo "<td align='right'>".number_format($monto[$i],2,',','.')."</td>";
						echo "<td align='right'>".$reference[$i]."</td>";
					echo "</tr>";
				} 
			?>
		</table>
		<nav aria-label="Page navigation">
			<ul class="pagination">
				<?php 
					if ($pg==1) {
					   	echo '<li class="disabled"><a href="#" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>';
					} else {
						$num = $pg - 1;
					   	echo '<li><a href='.base_url().'numpagina/'.$num.' aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>';
					}
				   	for ($i=0; $i < $totpages; $i++) {
				   		$num = $i+1;
				   		if ($num==$pg) {
					   		echo '<li class="active"><a href="#">'.$num.'</a></li>';
				   		} else {
					   		echo '<li><a href='.base_url().'numpagina/'.$num.'>'.$num.'</a></li>';
					   	}
				   	} 
					if ($pg==$totpages) {
					   	echo '<li class="disabled"><a href="#" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>';
					} else {
						$num = $pg + 1;
					   	echo '<li><a href='.base_url().'numpagina/'.$num.' aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>';
					}
				?>
			</ul>
		</nav>
	</div>
</div>
