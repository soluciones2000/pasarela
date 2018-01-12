<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report_model extends CI_Model {

	public function getdata($orden,$filtro,$desde,$hasta,$lineas,$grupo,$pagina){
		switch ($orden) {
			case 'fecha':
				$this->db->order_by('fecha ASC,name_user ASC,monto ASC');
				break;
			case 'concepto':
				$this->db->order_by('concepto ASC,name_user ASC,fecha ASC,monto ASC');
				break;
			case 'monto':
				$this->db->order_by('monto ASC,name_user ASC,fecha ASC');
				break;
			case 'referencia':
				$this->db->order_by('reference ASC');
				break;
			default:
				$this->db->order_by('name_user ASC,fecha ASC,monto ASC');
				break;
		}
		switch ($filtro) {
			case 'usuario':
				if ($desde!="") {
					$this->db->like('name_user',$desde);
				}
				break;
			case 'fecha':
				if ($desde!="") {
					$this->db->like('fecha',$desde);
				}
				break;
			case 'concepto':
				if ($desde!="") {
					$this->db->like('concepto',$desde);
				}
				break;
			case 'monto':
				if ($desde!="") {
					$this->db->like('monto',$desde);
				}
				break;
			case 'referencia':
				if ($desde!="") {
					$this->db->like('reference',$desde);
				}
				break;
		}
		$query = $this->db->get('transacciones');
		if ($query->num_rows()>0) {
			$_SESSION['totpages'] = ceil($query->num_rows()/$lineas);
			$_SESSION['totgroup'] = ceil($query->num_rows()/($lineas*$grupo));
		} 

		switch ($orden) {
			case 'fecha':
				$this->db->order_by('fecha ASC,name_user ASC,monto ASC');
				break;
			case 'concepto':
				$this->db->order_by('concepto ASC,name_user ASC,fecha ASC,monto ASC');
				break;
			case 'monto':
				$this->db->order_by('monto ASC,name_user ASC,fecha ASC');
				break;
			case 'referencia':
				$this->db->order_by('reference ASC');
				break;
			default:
				$this->db->order_by('name_user ASC,fecha ASC,monto ASC');
				break;
		}
		switch ($filtro) {
			case 'usuario':
				if ($desde!="") {
					$this->db->like('name_user',$desde);
				}
				break;
			case 'fecha':
				if ($desde!="") {
					$this->db->like('fecha',$desde);
				}
				break;
			case 'concepto':
				if ($desde!="") {
					$this->db->like('concepto',$desde);
				}
				break;
			case 'monto':
				if ($desde!="") {
					$this->db->like('monto',$desde);
				}
				break;
			case 'referencia':
				if ($desde!="") {
					$this->db->like('reference',$desde);
				}
				break;
		}
		$this->db->limit($lineas,$pagina*$lineas);
		return $this->db->get('transacciones');
	}
}