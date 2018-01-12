<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Auth_model');
	}

	public function login(){
		$data = new stdClass();

		$data->title = "Pasarela de pagos";
		$data->contenido = "apl/auth/login"; //aqui es la dirección física del controlador
		$data->panel_title = "Inicio de sesión";
		$data->active = "login";
		
		$this->load->view('menu',$data);
	}

	public function entrar(){
		$this->form_validation->set_rules('correo', 'Email', 'required|valid_email|max_length[150]');
		$this->form_validation->set_rules('pass', 'Password', 'required|min_length[8]|max_length[16]');

		$this->form_validation->set_message('required', 'El campo {field} es obligatorio, pulse atrás para volver');
		$this->form_validation->set_message('valid_email', 'Debe incluir un correo electrónico válido, pulse atrás para volver');
		$this->form_validation->set_message('max_length', 'El campo {field} no debe exceder de {param} caracteres, pulse atrás para volver');
		$this->form_validation->set_message('min_length', 'El campo {field} debe tener al menos {param} caracteres, pulse atrás para volver');

		if ($this->form_validation->run() == FALSE){
			$this->login();
        } else {
            $correo = $this->input->post('correo');
            $pass = $this->input->post('pass');

            $user = $this->Auth_model->getUser($correo);
            if (!$user) {
            	$this->session->set_flashdata("mensaje_error","Datos de usuario incorrectos, pulse atrás para volver");
            	redirect(base_url() . 'login');
            }
            if ($user->user_pass != sha1(md5($pass))) {
            	$this->session->set_flashdata("mensaje_error","Datos de usuario incorrectos, pulse atrás para volver");
            	redirect(base_url() . 'login');
            }
            $_SESSION['userid'] = $user->id;
           	$_SESSION['user_email'] = $user->user_email;
           	$_SESSION['nombre'] = $user->name_user;
           	$_SESSION['is_logged_in'] = TRUE;
            redirect(base_url().'monto');
        }
	}

	public function registro(){
		$data = new stdClass();

		$data->title = "Pasarela de pagos";
		$data->contenido = "apl/auth/registro"; //aqui es la dirección física del controlador
		$data->panel_title = "Registro de usuario";
		$data->active = "registro";
		
		$this->load->view('menu',$data);
	}

	public function crea_user(){
		$this->form_validation->set_rules('correo', 'Correo electrónico', 'required|valid_email|max_length[150]');
		$this->form_validation->set_rules('pass', 'Contraseña', 'required|min_length[8]|max_length[16]');
		$this->form_validation->set_rules('passconf', 'Confirmar contraseña', 'required|min_length[8]|max_length[16]|matches[pass]');
		$this->form_validation->set_rules('nombre', 'Nombre completo', 'required|min_length[8]|max_length[150]');
		$this->form_validation->set_rules('pregunta', 'Pregunta de seguridad', 'required|max_length[150]');
		$this->form_validation->set_rules('respuesta', 'Respuesta a la pregunta de seguridad', 'required|max_length[150]');

		$this->form_validation->set_message('required', 'El campo {field} es obligatorio, pulse atrás para volver');
		$this->form_validation->set_message('valid_email', 'Debe incluir un correo electrónico válido, pulse atrás para volver');
		$this->form_validation->set_message('max_length', 'El campo {field} no debe exceder de {param} caracteres, pulse atrás para volver');
		$this->form_validation->set_message('min_length', 'El campo {field} debe tener al menos {param} caracteres, pulse atrás para volver');
		$this->form_validation->set_message('matches', 'El campo {field} debe coincidir con {param}, pulse atrás para volver');

		if ($this->form_validation->run() == FALSE){
            $this->registro();
        } else {
        	$correo = $this->input->post('correo');
           	$pass = $this->input->post('pass');
           	$passconf = $this->input->post('passconf');
           	$nombre = $this->input->post('nombre');
           	$pregunta = $this->input->post('pregunta');
           	$respuesta = $this->input->post('respuesta');

           	$user = $this->Auth_model->getUser($correo);
			if (!$user) {
				$registro = array(
					'name_user' => $nombre,
					'user_email' => $correo,
					'user_pass' => sha1(md5($pass)),
					'pista' => $pregunta,
					'respuesta' => sha1(md5(strtoupper($respuesta)))
				);
				if($this->Auth_model->registro($registro)){
		            $user = $this->Auth_model->getUser($correo);
		           	$_SESSION['userid'] = $user->id;
		           	$_SESSION['user_email'] = $user->user_email;
		           	$_SESSION['nombre'] = $user->name_user;
		           	$_SESSION['is_logged_in'] = TRUE;
		           	$this->session->set_flashdata('mensaje_success','Bienvenido ' . $_SESSION['nombre']);
					$data = new stdClass();

					$data->title = "Pasarela de pagos";
					$data->panel_title = "Procesamiento de pagos";
					$data->contenido = "apl/pago/formulario"; //aqui es la dirección física del controlador
				
					$this->load->view('menu',$data);
				}
			} else {
            	$this->session->set_flashdata("mensaje_error","Usuario ya registrado, pulse atrás para volver");
           		redirect(base_url() . 'registro');
			}
        }
	}

	public function cambio(){
		$data = new stdClass();

		$data->title = "Pasarela de pagos";
		$data->contenido = "apl/auth/cambio"; //aqui es la dirección física del controlador
		$data->panel_title = "Cambio de clave";
		$data->active = "cambio";
		
		$this->load->view('menu',$data);
	}

	public function passchange(){
		$this->form_validation->set_rules('passact', 'Contraseña actual', 'required|min_length[8]|max_length[16]');
		$this->form_validation->set_rules('passnew', 'Contraseña nueva', 'required|min_length[8]|max_length[16]');
		$this->form_validation->set_rules('passconfnew', 'Confirmar contraseña nueva', 'required|min_length[8]|max_length[16]|matches[passnew]');

		$this->form_validation->set_message('required', 'El campo {field} es obligatorio, pulse atrás para volver');
		$this->form_validation->set_message('max_length', 'El campo {field} no debe exceder de {param} caracteres, pulse atrás para volver');
		$this->form_validation->set_message('min_length', 'El campo {field} debe tener al menos {param} caracteres, pulse atrás para volver');
		$this->form_validation->set_message('matches', 'El campo {field} debe coincidir con {param}, pulse atrás para volver');
		if ($this->form_validation->run() == FALSE){
            $this->cambio();
        } else {
        	$correo = $_SESSION['user_email'];
            $passact = $this->input->post('passact');
           	$passnew = $this->input->post('passnew');
           	$passconfnew = $this->input->post('passconfnew');

           	$user = $this->Auth_model->getUser($correo);
			if (!$user) {
            	$this->session->set_flashdata("mensaje_error","Datos de usuario incorrectos, pulse atrás para volver");
            	redirect(base_url() . 'logout');
            }
            if ($user->user_pass != sha1(md5($passact))) {
            	$this->session->set_flashdata("mensaje_error","Contrseña actual incorrecta, pulse atrás para volver");
            	redirect(base_url() . 'cambio');
            }
			$registro = array(
				'user_email' => $correo,
				'user_pass' => sha1(md5($passnew))
			);
			if($this->Auth_model->passcambio($registro)){
				$this->session->set_flashdata('mensaje_success','Cambio de clave exitoso');
				$data = new stdClass();

				$data->title = "Pasarela de pagos";
				$data->panel_title = "Procesamiento de pagos";
				$data->contenido = "apl/pago/formulario"; //aqui es la dirección física del controlador
				
				$this->load->view('menu',$data);
			}
        }
	}

	public function recuperar(){
		$data = new stdClass();

		$data->title = "Pasarela de pagos";
		$data->contenido = "apl/auth/recuperar"; //aqui es la dirección física del controlador
		$data->panel_title = "Recuperación de contraseña";
		$data->active = "recuperar";
		
		$this->load->view('menu',$data);
	}

	public function pregunta(){
		$this->form_validation->set_rules('correo', 'Email', 'required|valid_email|max_length[150]');

		$this->form_validation->set_message('required', 'El campo {field} es obligatorio, pulse atrás para volver');
		$this->form_validation->set_message('valid_email', 'Debe incluir un correo electrónico válido, pulse atrás para volver');
		$this->form_validation->set_message('max_length', 'El campo {field} no debe exceder de {param} caracteres, pulse atrás para volver');

		if ($this->form_validation->run() == FALSE){
			$this->recuperar();
        } else {
            $correo = $this->input->post('correo');
            $user = $this->Auth_model->getUser($correo);
            if (!$user) {
            	$this->session->set_flashdata("mensaje_error","Datos de usuario incorrectos, pulse atrás para volver");
            	redirect(base_url() . 'recuperar');
            }
            $this->respuesta();
		}
	}

	public function respuesta(){
        $correo = $_POST['correo'];
        $user = $this->Auth_model->getUser($correo);
        $pista = $user->pista;
        $respuesta = $user->respuesta;
		$data = new stdClass();

		$data->title = "Pasarela de pagos";
		$data->panel_title = "Pregunta de seguridad";
		$data->correo = $correo;
		$data->respuesta = $respuesta;
		$data->label = $pista;
		$data->contenido = "apl/auth/pregunta"; //aqui es la dirección física del controlador
				
		$this->load->view('menu',$data);
	}

	public function passretrieve(){
        $correo = $_POST['correo'];
		$this->form_validation->set_rules('answer', 'Respuesta a la pregunta de seguridad', 'required|max_length[150]');

		$this->form_validation->set_message('required', 'El campo {field} es obligatorio');
		$this->form_validation->set_message('max_length', 'El campo {field} no debe exceder de {param} caracteres');
		if ($this->form_validation->run() == FALSE){
			$this->respuesta();
        } elseif ($this->input->post('respuesta') != sha1(md5(strtoupper($this->input->post('answer'))))) {
        	$this->session->set_flashdata("mensaje_error","Respuesta incorrecta");
//        	redirect(base_url().'logout');

			$data = new stdClass();

			$data->correo = $correo;
			$data->title = "Pasarela de pagos";
			$data->panel_title = "Respuesta equivocada";
			$data->contenido = "apl/auth/norespuesta"; //aqui es la dirección física del controlador
				
			$this->load->view('menu',$data);
        } else {
			$this->session->set_flashdata('mensaje_success','Respuesta correcta, establezca de nuevo su contraseña');
			$data = new stdClass();

			$data->title = "Pasarela de pagos";
			$data->correo = $this->input->post('correo');
			$data->panel_title = "Reinicio de clave";
			$data->contenido = "apl/auth/respuesta"; //aqui es la dirección física del controlador
				
			$this->load->view('menu',$data);

        }
	}

	public function hint(){
        $correo = $_POST['correo'];
        $this->Auth_model->eliminar($correo);
        redirect(base_url() . 'logout');
	}

	public function reset(){
        print_r($_POST);
		$data = new stdClass();

		$data->title = "Pasarela de pagos";
		$data->panel_title = "Reinicio de clave";
		$data->contenido = "apl/auth/respuesta"; //aqui es la dirección física del controlador
				
		$this->load->view('menu',$data);
	}

	public function reinicio(){
		$this->form_validation->set_rules('pass', 'Contraseña', 'required|min_length[8]|max_length[16]');
		$this->form_validation->set_rules('passconf', 'Confirmar contraseña', 'required|min_length[8]|max_length[16]|matches[pass]');

		$this->form_validation->set_message('required', 'El campo {field} es obligatorio, pulse atrás para volver');
		$this->form_validation->set_message('max_length', 'El campo {field} no debe exceder de {param} caracteres, pulse atrás para volver');
		$this->form_validation->set_message('min_length', 'El campo {field} debe tener al menos {param} caracteres, pulse atrás para volver');
		$this->form_validation->set_message('matches', 'El campo {field} debe coincidir con {param}, pulse atrás para volver');
		if ($this->form_validation->run() == FALSE){
            $this->reset();
        } else {
        	$correo = $this->input->post('correo');
           	$pass = $this->input->post('pass');
           	$passconf = $this->input->post('passconf');

           	$user = $this->Auth_model->getUser($correo);
			if (!$user) {
            	$this->session->set_flashdata("mensaje_error","Datos de usuario incorrectos, pulse atrás para volver");
            	redirect(base_url() . 'logout');
            }
			$registro = array(
				'user_email' => $correo,
				'user_pass' => sha1(md5($pass))
			);
			if($this->Auth_model->passcambio($registro)){
				$this->session->set_flashdata('mensaje_success','Cambio de clave exitoso');
				redirect(base_url().'login');
			}
        }
	}

	public function logout(){
		session_destroy();
		redirect();
	}

}
