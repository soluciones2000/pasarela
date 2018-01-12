<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Trans_model extends CI_Model {

	public function regtran($data){
		$success = $this->db->insert('transacciones',$data);
		return $success;
	}

}