<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
<!--
      <a class="navbar-brand" href="#">
        <div>
          <img src="<?php echo base_url(); ?>recursos/img/<?php echo $_SESSION['emp_logo'] ?>" class="img-responsive" alt="Responsive image" width="8%" height="auto" >
        </div>
        <div>
           <?php echo $_SESSION['emp_nombre'] ?> - Pasarela de pagos
        </div>
      </a>
-->
      <a class="navbar-brand" href="#">
        <?php echo $_SESSION['emp_nombre'] ?> - Pasarela de pagos
      </a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
<!--
      <ul class="nav navbar-nav">
        <li><a href="#">Archivos<span class="sr-only">(current)</span></a></li>
        <li><a href="#">Pasarela de pagos</a></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Reportes<span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="#">Transacciones autorizadas</a></li>
            <li><a href="#">Transacciones rechazadas</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="#">Usuarios</a></li>
          </ul>
        </li>
      </ul>
      <form class="navbar-form navbar-left">
        <div class="form-group">
          <input type="text" class="form-control" placeholder="Search">
        </div>
        <button type="submit" class="btn btn-default">Buscar</button>
      </form>
-->
      <ul class="nav navbar-nav navbar-right">
        <li <?php if(isset($active) && $active=="contacto"){ echo 'class="active"';} ?> ><a href="<?php echo base_url(); ?>contacto">Contactenos</a></li>
              <li><a href="<?php echo base_url(); ?>reporte">Reporte</a></li>
              <li><a href="<?php echo base_url(); ?>logout">Salir</a></li>
<!--        <li><a href="#">Contactenos</a></li>-->
        <?php if (!empty($_SESSION['is_logged_in'])): ?>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Bienvenido <?php echo $_SESSION['nombre']; ?> <span class="  caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="<?php echo base_url(); ?>cambio">Cambiar clave</a></li>
<!--              <li><a href="#">Another action</a></li>
              <li><a href="#">Something else here</a></li> -->
              <li role="separator" class="divider"></li>
<!--              <li><a href="<?php echo base_url(); ?>logout">Salir</a></li>-->
            </ul>
          </li>
        <?php else: ?>
<!--          <li><a href="#">Registrarse</a></li>-->
          <li <?php if(isset($active) && $active=="registro"){ echo 'class="active"';} ?> ><a href="<?php echo base_url(); ?>registro">Registrarse</a></li>
          <li <?php if(isset($active) && $active=="login"){ echo 'class="active"';} ?> ><a href="<?php echo base_url(); ?>login">Entrar</a></li>
        <?php endif; ?>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
<div class="container">
  <?php
    if ($this->session->flashdata('mensaje_error') != NULL) {
      echo '<div class="alert alert-danger" role="alert">' . $this->session->flashdata('mensaje_error') . '</div>';
    }
    if ($this->session->flashdata('mensaje_success') != NULL) {
      echo '<div class="alert alert-success" role="alert">' . $this->session->flashdata('mensaje_success') . '</div>';
    }
  ?>
</div>