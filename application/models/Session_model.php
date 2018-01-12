<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Session_model extends CI_Model {

	public function borrar(){
		return $this->db->empty_table('ci_sessions');
	}
}