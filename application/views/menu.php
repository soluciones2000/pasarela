<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$this->load->view('plantillas/menu/head');
$this->load->view('plantillas/menu/header');
$this->load->view($contenido);
$this->load->view('plantillas/menu/footer');

?>
