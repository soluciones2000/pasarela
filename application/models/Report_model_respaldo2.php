<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report_model extends CI_Model {

	public function getdata($orden,$filtro,$desde,$hasta){
		$this->db->select('usuarios.name_user,transacciones.fecha,transacciones.concepto,transacciones.monto,transacciones.reference');
		$this->db->from('transacciones');
		$this->db->join('usuarios', 'transacciones.id_user = usuarios.id');
		if ($orden!="") {
			if ($filtro!="" && $filtro!="ninguno") {
				if ($desde!="") {
					$sentencia .= ' and ';
					switch ($filtro) {
						case 'usuario':
							$this->db->like('name_user',$desde);
							break;
						case 'fecha':
							$this->db->like('fecha',$desde);
							break;
						case 'concepto':
							$this->db->like('concepto',$desde);
							break;
						case 'monto':
							$this->db->like('monto',$desde);
							break;
						case 'referencia':
							$this->db->like('reference',$desde);
							break;
					}
				}
			}
			switch ($orden) {
				case 'usuario':
					$this->db->order_by('name_user', 'ASC');
					$this->db->order_by('fecha', 'ASC');
					$this->db->order_by('concepto', 'ASC');
					break;
				case 'fecha':
					$this->db->order_by('fecha', 'ASC');
					$this->db->order_by('name_user', 'ASC');
					$this->db->order_by('concepto', 'ASC');
					break;
				case 'concepto':
					$this->db->order_by('concepto', 'ASC');
					$this->db->order_by('name_user', 'ASC');
					$this->db->order_by('fecha', 'ASC');
					break;
				case 'monto':
					$this->db->order_by('monto', 'ASC');
					$this->db->order_by('fecha', 'ASC');
					$this->db->order_by('name_user', 'ASC');
					$this->db->order_by('concepto', 'ASC');
					break;
				case 'referencia':
					$this->db->order_by('reference', 'ASC');
					break;
				default:
					$this->db->order_by('name_user', 'ASC');
					$this->db->order_by('fecha', 'ASC');
					$this->db->order_by('concepto', 'ASC');
					break;
			}
		}
		$this->db->limit(10);
/*		$sentencia .= ' limit 7';
		if ($_SESSION['numpages']>1 && $_SESSION['pagina']!=0) {
			$sentencia .= ', '.$_SESSION['pagina']*7;
		}
*/		return $this->db->get();
	}


	public function numpages($orden,$filtro,$desde,$hasta){
		if ($orden=="") {
			$sentencia = 'select count(transacciones.fecha) as filas  from usuarios,transacciones where usuarios.id=transacciones.id_user order by name_user,fecha,concepto';
		} else {
			$sentencia = 'select count(transacciones.fecha) as filas from usuarios,transacciones where usuarios.id=transacciones.id_user';
			if ($filtro!="" && $filtro!="ninguno") {
				if ($desde!="") {
					$sentencia .= ' and ';
					switch ($filtro) {
						case 'usuario':
							$sentencia .= 'name_user like "%'.$desde.'%"';
							break;
						case 'fecha':
							$sentencia .= 'fecha like "%'.$desde.'%"';
							break;
						case 'concepto':
							$sentencia .= 'concepto like "%'.$desde.'%"';
							break;
						case 'monto':
							$sentencia .= 'monto like "%'.$desde.'%"';
							break;
						case 'referencia':
							$sentencia .= 'reference like "%'.$desde.'%"';
							break;
					}
				}
			}
		}
		$query = $this->db->query($sentencia);
		if ($query->num_rows() > 0)	{
	        $filas = $query->row();
			return $filas->filas;
		} else {
			return 0;
		}
	}


}
/*
	public function numpages($orden,$filtro,$desde,$hasta){
		if ($orden=="") {
			$sentencia = 'select count(transacciones.fecha) as filas  from usuarios,transacciones where usuarios.id=transacciones.id_user order by name_user,fecha,concepto';
		} else {
			$sentencia = 'select count(transacciones.fecha) as filas from usuarios,transacciones where usuarios.id=transacciones.id_user';
			if ($filtro!="" && $filtro!="ninguno") {
				if ($desde!="") {
					$sentencia .= ' and ';
					switch ($filtro) {
						case 'usuario':
							$sentencia .= 'name_user like "%'.$desde.'%"';
							break;
						case 'fecha':
							$sentencia .= 'fecha like "%'.$desde.'%"';
							break;
						case 'concepto':
							$sentencia .= 'concepto like "%'.$desde.'%"';
							break;
						case 'monto':
							$sentencia .= 'monto like "%'.$desde.'%"';
							break;
						case 'referencia':
							$sentencia .= 'reference like "%'.$desde.'%"';
							break;
					}
				}
			}
		}
		$query = $this->db->query($sentencia);
		if ($query->num_rows() > 0)	{
	        $filas = $query->row();
			return $filas->filas;
		} else {
			return 0;
		}
	}
*/


/*
	public function numpages($orden,$filtro,$desde,$hasta){
		$this->db->select('*');
		$this->db->from('transacciones');
		$this->db->join('usuarios', 'usuarios.id = transacciones.id_user','left');
		if ($orden=="") {
			return $this->db->count_all_results();
		} else {
			if ($filtro!="" && $filtro!="ninguno") {
				if ($desde!="") {
					switch ($filtro) {
						case 'usuario':
							$this->db->like('name_user',$desde);
							break;
						case 'fecha':
							$this->db->like('fecha',$desde);
							break;
						case 'concepto':
							$this->db->like('concepto',$desde);
							break;
						case 'monto':
							$this->db->like('monto',$desde);
							break;
						case 'referencia':
							$this->db->like('reference',$desde);
							break;
					}
				}
			}
		}
		$this->db->get();
		return $this->db->count_all_results();
	}
*/


/*
		if ($orden=="") {
			$sentencia = 'select count(transacciones.fecha) from usuarios,transacciones where usuarios.id=transacciones.id_user';
		} else {
			$sentencia = 'select count(transacciones.fecha) from usuarios,transacciones where usuarios.id=transacciones.id_user';
//			if ($filtro!="" && $filtro!="ningunno" && $desde!="" && $hasta!="") {
			if ($filtro!="" && $filtro!="ninguno") {
				if ($desde!="") {
					$sentencia .= ' and ';
					switch ($filtro) {
						case 'usuario':
							$sentencia .= 'name_user like "%'.$desde.'%"';
							break;
						case 'fecha':
							$sentencia .= 'fecha like "%'.$desde.'%"';
							break;
						case 'concepto':
							$sentencia .= 'concepto like "%'.$desde.'%"';
							break;
						case 'monto':
							$sentencia .= 'monto like "%'.$desde.'%"';
							break;
						case 'referencia':
							$sentencia .= 'reference like "%'.$desde.'%"';
							break;
					}
				}
			}
		}
		$this->db->query($sentencia);
		return $this->db->count_all_results();
	}
}*/
/*
				switch ($filtro) {
					case 'usuario':
						$sentencia .= 'name_user >= "'.$desde.'" and name_user <= "'.$hasta.'"';
						break;
					case 'fecha':
						$sentencia .= 'fecha >= "'.$desde.'" and fecha <= "'.$hasta.'"';
						break;
					case 'concepto':
						$sentencia .= 'concepto >= "'.$desde.'" and concepto <= "'.$hasta.'"';
						break;
					case 'monto':
						$sentencia .= 'monto >= '.$desde.' and monto <= '.$hasta;
						break;
					case 'referencia':
						$sentencia .= 'reference >= '.$desde.' and reference <= '.$hasta;
						break;
				}
*/