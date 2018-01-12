<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu {

	private $arr_menu;
	public function __construct($arr){
		$this->arr_menu = $arr;
	}

	public function construirMenu(){
		$ret_menu = "<nav>";
		foreach ($this->arr_menu as $opcion){
			$ret_menu .= '<a href="/CodeIgniter/">' . $opcion . '</a> | ' ;
		}
		$ret_menu .= '<a href="/CodeIgniter/">Salir</a>' ;
		$ret_menu .= '</nav>';
		return $ret_menu;
	}

}
