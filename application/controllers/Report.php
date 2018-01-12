<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Report_model');
	}

	public function reporte(){
		$orden = (isset($_SESSION['orden'])) ? $_SESSION['orden'] : "" ;
		$filtro = (isset($_SESSION['filtro'])) ? $_SESSION['filtro'] : "" ;
		$desde = (isset($_SESSION['desde'])) ? $_SESSION['desde'] : "" ;
		$hasta = (isset($_SESSION['hasta'])) ? $_SESSION['hasta'] : "" ;

		$pagina = (isset($_SESSION['pagina'])) ? $_SESSION['pagina'] : 0 ;
		$totpages = (isset($_SESSION['totpages'])) ? $_SESSION['totpages'] : 1 ;

		$grupo = (isset($_SESSION['grupo'])) ? $_SESSION['grupo'] : 0 ;
		$totgroup = (isset($_SESSION['totgroup'])) ? $_SESSION['totgroup'] : 1 ;
		$prev = (isset($_SESSION['prev'])) ? $_SESSION['prev'] : 0 ;
		$next = (isset($_SESSION['next'])) ? $_SESSION['next'] : 0 ;


		$_SESSION['orden'] = $orden;
		$_SESSION['filtro'] = $filtro;
		$_SESSION['desde'] = $desde;
		$_SESSION['hasta'] = $hasta;
		$_SESSION['pagina'] = $pagina;
		$_SESSION['grupo'] = $grupo;

		$usr = array();
		$fec = array();
		$con = array();
		$mon = array();
		$ref = array();
		$lpp = 5;
		$ppg = 3;

		$query = $this->Report_model->getdata($orden,$filtro,$desde,$hasta,$lpp,$ppg,$pagina); // 5 lineas por pagina y 3 paginas por grupo

		$pg = $_SESSION['pagina']+1;

		foreach ($query->result() as $fila) {
			$usr[] = $fila->name_user;
			$fec[] = $fila->fecha;
			$con[] = $fila->concepto;
			$mon[] = $fila->monto;
			$ref[] = $fila->reference;
		} 

		$data = new stdClass();

		$data->title = "Reporte de transacciones";
		$data->panel_title = "Reporte de transacciones";
		$data->contenido = "apl/report/reporte"; //aqui es la dirección física del controlador
		$data->name_user = $usr;
		$data->fecha = $fec;
		$data->concepto = $con;
		$data->monto = $mon;
		$data->reference = $ref;
		$data->pg = $pg;
		$data->lpp = $lpp;
		$data->ppg = $ppg;

		if ($pg>$ppg) {
			$_SESSION['grupo'] = floor($pg/$ppg);
			$_SESSION['prev'] = floor($pg/$ppg)*$ppg;
		} else {
			$_SESSION['grupo'] = 0;
			$_SESSION['prev'] = 0;			
		}
		if ($_SESSION['prev']+$ppg>=$_SESSION['totpages']) {
			$_SESSION['next'] = $_SESSION['totpages'];
		} else {
			$_SESSION['next'] = $_SESSION['prev']+$ppg+1;
		}


		$data->grp = $_SESSION['grupo'];
		$data->prev = $_SESSION['prev'];
		$data->next = $_SESSION['next'];


		if ($_SESSION['totpages']>$ppg) {
			if ($pg<=$ppg) {
				$data->totpages = $ppg;
				$data->first = TRUE;
				$data->last = FALSE;
			} else {
				$data->totpages = $_SESSION['totpages']-($ppg*$_SESSION['grupo']);
				$data->first = FALSE;
				if ($_SESSION['totpages']-$ppg<$pg) {
					$data->last = TRUE;
				} else {
					$data->last = FALSE;
				}
			}
		} else {
			$data->totpages = $_SESSION['totpages'];
			$data->first = TRUE;
			$data->last = TRUE;
		}
		
		$this->load->view('menu',$data);

/*		$_SESSION['orden'] = "";
		$_SESSION['filtro'] = "";
		$_SESSION['desde'] = "";
		$_SESSION['hasta'] = "";
*///		$_SESSION['pagina'] = 0;
//		unset($_SESSION['numpages']);
	}

	public function parametros(){
		$_SESSION['orden'] = $this->input->post('orden');
		$_SESSION['filtro'] = $this->input->post('filtro');
		$_SESSION['desde'] = $this->input->post('desde');
		$_SESSION['hasta'] = $this->input->post('hasta');
		if ($this->input->post('cambio')==TRUE) {
			$_SESSION['pagina'] = 0;
		}
		redirect(base_url() . 'reporte');

		//$this->reporte();
	}


	public function numpagina($pag){
		$_SESSION['pagina'] = $this->uri->segment(2)-1;
		redirect(base_url() . 'reporte');
	}
}
