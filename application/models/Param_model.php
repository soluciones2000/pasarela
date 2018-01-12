<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Param_model extends CI_Model {

	public function getParam(){
		$query = $this->db->get('empresa');
		return $query->row();
	}

	public function act_fecha($hoy){
		$this->db->set('emp_hoy', $hoy);
		$success = $this->db->update('empresa'); // gives UPDATE mytable SET field = field+1 WHERE id = 2
		return $success;
	}

}


/*
	public function eliminar($email){
		$this->db->where('user_email', $email);
		$success = $this->db->delete('usuarios');
		return $success;
	}
*/