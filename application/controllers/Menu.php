<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Param_model');

	}

	public function index()
	{
/*
		$data = new stdClass();

		$data->title = "Pasarela de pagos";
		$data->contenido = "holamundo/hola";
		
		$this->load->view('menu',$data);
		*/
//		$this->load->view('prueba');
//		session_destroy();

	    $param = $this->Param_model->getParam();
    	if (!$param) {
	      $this->session->set_flashdata("mensaje_error","Parmetros de la empresa incorrectos, comuniquese con soporte");
    	  redirect();
	    }
	    $_SESSION['emp_id'] = $param->id;
	    $_SESSION['emp_nombre'] = $param->emp_nombre;
    	$_SESSION['emp_rif'] = $param->emp_rif;
    	$_SESSION['emp_web'] = $param->emp_web;
    	$_SESSION['emp_email'] = $param->emp_email;
    	$_SESSION['emp_direccion'] = $param->emp_direccion;
    	$_SESSION['emp_logo'] = $param->emp_logo;
    	$_SESSION['emp_ip_pukey'] = $param->emp_ip_pukey;
    	$_SESSION['emp_ip_prkey'] = $param->emp_ip_prkey;
    	$_SESSION['emp_mp_ci'] = $param->emp_mp_ci;
    	$_SESSION['emp_mp_cs'] = $param->emp_mp_cs;
    	$_SESSION['emp_mp_at'] = $param->emp_mp_at;
	   	$_SESSION['emp_mp_pukey'] = $param->emp_mp_pukey;
    	$_SESSION['emp_pf_tkkey'] = $param->emp_mp_at;
	   	$_SESSION['emp_pf_kskey'] = $param->emp_mp_pukey;

		date_default_timezone_set('America/Caracas');
		if ($param->emp_hoy < date('Y-m-d')) {
			$this->load->model('Session_model');
			$this->Session_model->borrar();
			$this->Param_model->act_fecha(date('Y-m-d'));
    	} 

		$data = new stdClass();

		$data->title = "Pasarela de pagos";
		$data->contenido = "holamundo/hola";
//    	$data->emp_nombre = $_SESSION['emp_nombre'];
		
		$this->load->view('menu',$data);

	}
}
