<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth_model extends CI_Model {

	public function getUser($email){
		$this->db->where('user_email',$email);
		$query = $this->db->get('usuarios');
		return $query->row();
	}

	public function registro($data){
		$success = $this->db->insert('usuarios',$data);
		return $success;
	}

	public function passcambio($data){
		$this->db->set('user_pass', $data['user_pass']);
		$this->db->where('user_email', $data['user_email']);
		$success = $this->db->update('usuarios'); // gives UPDATE mytable SET field = field+1 WHERE id = 2
		return $success;
	}

	public function eliminar($email){
		$this->db->where('user_email', $email);
		$success = $this->db->delete('usuarios');
		return $success;
	}

}