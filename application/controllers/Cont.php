<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cont extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function contacto(){
		$data = new stdClass();

		$data->title = "Pasarela de pagos";
		$data->contenido = "apl/cont/form"; //aqui es la dirección física del controlador
		$data->panel_title = "Formulario de contacto";
		$data->active = "contacto";
		
		$this->load->view('menu',$data);
	}

	public function email_contacto(){
		$this->form_validation->set_rules('email', 'Correo electrónico', 'required|valid_email|max_length[150]');
		$this->form_validation->set_rules('nombre', 'Nombre', 'required|min_length[5]|max_length[150]');
		$this->form_validation->set_rules('asunto', 'Asunto', 'required|min_length[5]|max_length[150]');
		$this->form_validation->set_rules('mensaje', 'Mensaje', 'required');

		$this->form_validation->set_message('required', 'El campo {field} es obligatorio, pulse atrás para volver');
		$this->form_validation->set_message('valid_email', 'Debe incluir un correo electrónico válido, pulse atrás para volver');
		$this->form_validation->set_message('max_length', 'El campo {field} no debe exceder de {param} caracteres, pulse atrás para volver');
		$this->form_validation->set_message('min_length', 'El campo {field} debe tener al menos {param} caracteres, pulse atrás para volver');
		if ($this->form_validation->run() == FALSE){
			$this->session->set_flashdata("mensaje_error",validation_errors());
			redirect(base_url() . 'contacto');
        }
			// envía voucher por email
		$config = array(
			'mailtype' => 'html',
			'charset' => 'utf-8'
		);
		$this->email->initialize($config);
		$this->email->from($this->input->post('email'),$this->input->post('nombre'));
		$this->email->to($_SESSION['emp_email']);
		$this->email->subject($this->input->post('asunto'));
		$this->email->message(nl2br($this->input->post('mensaje')));
		if ($this->email->send()) {
			$this->session->set_flashdata("mensaje_success","Se ha enviado el email, pronto será contactado");
		} else {
			echo $this->email->print_debugger();
		}
		// fin envío email

		$data = new stdClass();

		$data->title = "Pasarela de pagos";
		$data->contenido = "holamundo/hola";
//    	$data->emp_nombre = $_SESSION['emp_nombre'];
		
		$this->load->view('menu',$data);
	}

}
