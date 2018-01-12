<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pago extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Auth_model');
		$this->load->model('Trans_model');
	}

	public function monto(){
			$data = new stdClass();

			$data->title = "Pasarela de pagos";
			$data->panel_title = "Concepto a pagar";
			$data->contenido = "apl/pago/monto"; //aqui es la dirección física del controlador

			$this->load->view('menu',$data);
	}

	public function formamonto_ip(){
		$this->form_validation->set_rules('monto', 'Monto', 'required|callback_validanumero|callback_validamonto');
		$this->form_validation->set_rules('concepto', 'Concepto', 'required|max_length[150]');
		
		$this->form_validation->set_message('required', 'El campo {field} es obligatorio, pulse atrás para volver');
		$this->form_validation->set_message('validanumero', 'El campo {field} sólo debe contener números, pulse atrás para volver');
		$this->form_validation->set_message('validamonto', 'Debe incluir un monto mayor que 0, pulse atrás para volver');
		$this->form_validation->set_message('max_length', 'El campo {field} no debe exceder de {param} caracteres, pulse atrás para volver');
		if ($this->form_validation->run() == FALSE){
			$this->session->set_flashdata("mensaje_error",validation_errors());
			redirect(base_url() . 'monto');
        }
		$data = new stdClass();

		$_SESSION['monto'] = $this->input->post('monto');
		$_SESSION['concepto'] = $this->input->post('concepto');
		$_SESSION['envio'] = TRUE;

		$data->title = "Pasarela de pagos";
		$data->panel_title = "Procesamiento de pagos";
		$data->monto = $this->input->post('monto'); //aqui es la dirección física del controlador
		$data->contenido = "apl/pago/formulario_ip"; //aqui es la dirección física del controlador
		
		$this->load->view('menu',$data);
	}

	public function formulario_ip(){
			$data = new stdClass();

			$data->title = "Pasarela de pagos";
			$data->panel_title = "Procesamiento de pagos";
			$data->contenido = "apl/pago/formulario_ip"; //aqui es la dirección física del controlador
			$data->monto = $_SESSION['monto']; //aqui es la dirección física del controlador
		
			$this->load->view('menu',$data);
	}

	public function validacion_ip(){
		if ($_SESSION['envio']) {
			$this->form_validation->set_rules('monto', 'Monto', 'required|callback_validamonto');
			$this->form_validation->set_rules('card_nombre', 'Nombre', 'required|min_length[8]|max_length[150]|callback_validatexto');
			$this->form_validation->set_rules('card_cedula', 'Cédula', 'required|min_length[6]|max_length[8]');
			$this->form_validation->set_rules('card_tipo', 'Tipo de tarjeta', 'required|callback_validatipotarjeta['.$_POST["card_numero"].']');
			$this->form_validation->set_rules('card_numero', 'Numero de tarjeta', 'required|exact_length[16]|callback_validanumtarjeta');
			$this->form_validation->set_rules('card_mes', 'Mes de vencimiento', 'required');
		

			$this->form_validation->set_rules('card_year', 'Año de vencimiento', 'required|callback_validafecha['.$_POST["card_mes"].']');
			$this->form_validation->set_rules('card_cvv', 'CVV2 / CVC2', 'required|exact_length[3]|callback_validanumero');
			$this->form_validation->set_message('required', 'El campo {field} es obligatorio, pulse atrás para volver');
			$this->form_validation->set_message('validamonto', 'Debe incluir un monto mayor que 0, pulse atrás para volver');
			$this->form_validation->set_message('validatexto', 'El campor {field} sólo puede contener caracteres alfabéticos, pulse atrás para volver');
			$this->form_validation->set_message('min_length', 'El campo {field} debe tener al menos {param} caracteres, pulse atrás para volver');
			$this->form_validation->set_message('max_length', 'El campo {field} no debe exceder de {param} caracteres, pulse atrás para volver');
			$this->form_validation->set_message('validatipotarjeta', 'El número de tarjeta con concuerda con el tipo, pulse atrás para volver');
			$this->form_validation->set_message('exact_length', 'El campo {field} debe tener {param} caracteres, pulse atrás para volver');
			$this->form_validation->set_message('validanumtarjeta', 'El numero de la tarjeta es invalido, pulse atrás para volver');
			$this->form_validation->set_message('validanumero', 'El campo {field} sólo debe contener números, pulse atrás para volver');
			$this->form_validation->set_message('validafecha', 'La fecha de vencimiento no puede ser menor a la actual, pulse atrás para volver');
			if ($this->form_validation->run() == FALSE){
				$this->session->set_flashdata("mensaje_error",validation_errors());
				redirect(base_url() . 'formulario_ip');
	        }
			$datos = array(
				'monto' => $this->input->post('monto'),
				'card_nombre' => $this->input->post('card_nombre'),
				'card_cedula' => $this->input->post('card_cedula'),
				'card_tipo' => $this->input->post('card_tipo'),
				'card_numero' => $this->input->post('card_numero'),
				'card_mes' => $this->input->post('card_mes'),
				'card_year' => $this->input->post('card_year'),
				'card_cvv' => $this->input->post('card_cvv')
			);
			$resultado = $this->transaccion_ip($datos);
			$transaccion = $resultado['tran'];

			$data = new stdClass();

			$data->title = "Pasarela de pagos";
			if ($resultado['exito']) {
				// registrar transaccion
				$regtran = array(
					'id_emp' => $_SESSION['emp_id'],
					'id_user' => $_SESSION['userid'],
	//				'fecha' => $transaccion['datetime'],
					'fecha' => date('Y-m-d G:i:s'),
		
					'concepto' => $_SESSION['concepto'],
					'monto' => $_SESSION['monto'],
	//				'reference' => $transaccion['reference'],
	//				'aprobacion' => $transaccion['approval']
					'reference' => '1',
					'aprobacion' => '1',
					'name_user' => $_SESSION['userid'],
					'plataforma' => 'ip'
				);

				$this->Trans_model->regtran($regtran);

				//
				$data->contenido = "apl/pago/voucher_ip"; //aqui es la dirección física del controlador
				$data->panel_title = "Pago exitoso";
				$data->datetime = $transaccion['datetime'];
				$data->card_numero = $datos['card_numero'];
				$data->reference = $transaccion['reference'];
				$data->lote = $transaccion['lote'];
				$data->approval = $transaccion['approval'];
				$data->sequence = $transaccion['sequence'];
				$data->amount = $datos['monto'];
				$data->card_tipo = $datos['card_tipo'];
				$data->id = $transaccion['id'];
				$data->voucher = $transaccion['voucher'];
				// envía voucher por email
				$config = array(
					'mailtype' => 'html',
					'charset' => 'utf-8'
				);
				$this->email->initialize($config);
				$this->email->from($_SESSION['emp_email'],$_SESSION['emp_nombre']);
				$this->email->to($_SESSION['user_email']);
				$this->email->subject('Compra aprobada');
	//			$this->email->message('<h3>TRANSACCION APROBADA</h3>'. print($transaccion['voucher']));
				$comprobante= array(
					'emp_nombre' => $_SESSION['emp_nombre'],
					'emp_rif' => $_SESSION['emp_rif'],
					'emp_web' => $_SESSION['emp_web'],
					'emp_direccion' => $_SESSION['emp_direccion'],
					'datetime' => $transaccion['datetime'],
					'card_numero' => $datos['card_numero'],
					'reference' => $transaccion['reference'],
					'lote' => $transaccion['lote'],
					'approval' => $transaccion['approval'],
					'sequence' => $transaccion['sequence'],
					'amount' => $datos['monto'],
					'card_tipo' => $datos['card_tipo'],
					'id' => $transaccion['id']
				);
				$this->email->message('<h3>TRANSACCION APROBADA</h3>'.$this->mensaje_ip($comprobante));
				if ($this->email->send()) {
					$this->session->set_flashdata("mensaje_success","Se ha enviado la confirmación al email: " . $_SESSION['user_email']);
				} else {
					echo $this->email->print_debugger();
				}
				// fin envío email
	           	$_SESSION['envio'] = FALSE;
	           	$_SESSION['is_logged_in'] = FALSE;
			} else {
				$data->contenido = "apl/pago/rechazo"; //aqui es la dirección física del controlador
				$data->panel_title = "Pago rechazado";
			}
			
			$this->load->view('menu',$data);
		} else {
			redirect(base_url() . 'logout');
		}
	}

	function validanumero($numero){
		$valores = '0123456789';
		$valido = true;
		for ($i=0; $i < strlen(strval($numero)); $i++) { 
			$pos = strpos($valores, substr(strval($numero),$i,1));
			if ($pos === false) {
				$valido = false;
				break;
			}
		}
		return $valido;
	}

	function validamonto($monto){
		if ($monto>0) {
			return true;
		} else {
			return false;
		}
	}

	function validatexto($texto){
		$valido = true;
		for ($i=0; $i < 10; $i++) { 
			$pos = strpos($texto, strval($i));
			if ($pos !== false) {
				$valido = false;
				break;
			}
		}
		return $valido;
	}

	function validatipotarjeta($tipo,$tarjeta){
		if ($tipo=="Visa") {
			$pos = strpos($tarjeta,"4"); //las tarjetas visa empiezan con 4
			if ($pos === false) {
				return false;
			} elseif ($pos!=0) {
				return false;
			}
		} else {
			$val = substr($tarjeta,0,2); //las tarjetas master empiezan con 21,22,23,24,25,26,27,51,52,53,54 ó 55
			if ( !(($val>="51" && $val<="55") || ($val>="21" && $val<="27")) )  {
				return false;
			}
		}
		return true;
	}

	function validanumtarjeta($tarjeta){
		$primero=true;
   		$sum1=0;
   		$sum2=0;
   		for ($i=strlen($tarjeta)-1; $i>=0 ; $i--) { 
			$va2 = substr($tarjeta,$i,1); //las tarjetas master empiezan con 21,22,23,24,25,26,27,51,52,53,54 ó 55
	   		if ($primero){
	   			$sum1+=$va2*1;
	   		} else {
	   			$aux=$va2*2;
	   			if ($aux>=10){
   					$aux=$aux-9;
	   			}
	   			$sum2+=$aux;
	   		}
   			$primero=!$primero;
   		}
   		if (($sum1+$sum2)%10!=0){
	   		// tareta invalida
	   		return false;
   		}
   		return true;
   	}

	function validafecha($year,$mes){
		date_default_timezone_set('America/Caracas');
		$hoy=getdate();
		$valida = false;
		if ($year<$hoy['year']){
			$valida = false;
		} elseif ($year>$hoy['year']) {
			$valida = true;
		} elseif ($mes<$hoy['mon']) {
			$valida = false;
		} else {
			$valida = true;
		}
   		return $valida;
	}

	function transaccion_ip($datos){

	    $emp_prkey = $_SESSION['emp_ip_prkey'];
	    $emp_pukey = $_SESSION['emp_ip_pukey'];


		$url = 'https://api.instapago.com/payment';
    	$fields = array("KeyID" => $emp_prkey ,
            "PublicKeyId" => $emp_pukey,
            "Amount" => $datos['monto'],
            "Description" => "Servicio a " . $datos['card_nombre'],
            "CardHolder"=> $datos['card_nombre'],
            "CardHolderId"=> $datos['card_cedula'],
            "CardNumber" => $datos['card_numero'],
            "CVC" => $datos['card_cvv'],
            "ExpirationDate" => $datos['card_mes'] . "/" . $datos['card_year'],
            "StatusId" => "2",
            "IP" => $_SERVER['REMOTE_ADDR'],
            "Address" => " ",
            "City" => " ",
            "ZipCode" => " ",
            "State" => " " 
        );
		$ch = curl_init();
    	curl_setopt($ch, CURLOPT_URL,$url );
    	curl_setopt($ch, CURLOPT_POST, true);
    	curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($fields));
    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    	$server_output = curl_exec($ch);
    	curl_close ($ch);

    	if (isset($server_output)) {
	        $tran=json_decode($server_output,true);
			$valores = array('exito' => true, 'tran' => $tran);
     	} else{
			$valores = array('exito' => false, 'tran' => '');
    	} 
		return $valores;
	}

	function mensaje_ip($comprobante){
		$emp_nombre = $comprobante['emp_nombre'];
		$emp_rif = $comprobante['emp_rif'];
		$emp_web = $comprobante['emp_web'];
		$emp_direccion = $comprobante['emp_direccion'];
		$datetime = $comprobante['datetime'];
		$card_numero = $comprobante['card_numero'];
		$reference = $comprobante['reference'];
		$lote = $comprobante['lote'];
		$approval = $comprobante['approval'];
		$sequence = $comprobante['sequence'];
		$amount = $comprobante['amount'];
		$card_tipo = $comprobante['card_tipo'];
		$id = $comprobante['id'];
		$texto = 
			'
			<div class="panel-body">
				<table style="background-color: white;" align="center">
				    <tbody>
				        <tr>
	                        <td>
								<div style="border: 1px solid #222; padding: 9px; text-align: left; max-width:255px" id="voucher">
									<style type="text/css">
										.normal-left {
											font-family: Tahoma;
											font-size: 7pt;
											text-align: left;
										}
				                        .normal-right {
				                        	font-family: Tahoma;
				                        	font-size: 7pt;
				                        	text-align: right;
				                        }
				                        .big-center {
				                        	font-family: Tahoma;
				                        	font-size: 9pt;
				                        	text-align: center;
				                        	font-weight: 900;
				                        } 
				                        .big-center-especial {
				                        	font-family: Tahoma;
				                        	font-size: 9pt;
				                        	text-align: center;
				                        	font-weight: 900;
				                        	letter-spacing: .9em;
				                        } 
				                        .big-left {
				                        	font-family: Tahoma;
				                        	font-size: 9pt;
				                        	text-align: left;
				                        	font-weight: 900;
				                        }
				                        .big-right {
				                        	font-family: Tahoma;
				                        	font-size: 9pt;
				                        	text-align: right;
				                        	font-weight: 900;
				                        }
				                        .normal-center {
				                        	font-family: Tahoma;
				                        	font-size: 7pt;
				                        	text-align: center;
				                        }
				                        #voucher td {
				                        	padding: 0;
				                        	margin: 0;
				                        } 
				                	</style>
				                    <div id="voucher">
                                        <table>
                                            <tr>
	                                            <td colspan="4" class="normal-center" align="center">
													COPIA - CLIENTE
												</td>
                                            </tr>
                                            <tr>
	                                            <td colspan="4" class="big-center-especial" align="center">
	                                                <br />
		                                            BANESCO
                                                </td>
                                            </tr>

                                            <tr>
                                                <td colspan="4" class="big-center">
                                                    <br />
                                                    
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" style="height: 8px;"></td>
                                            </tr>

                                            <tr>
                                                <td colspan="4" class="normal-left">TECNOLOGIA INSTAPAGO</td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" class="normal-left">DEMOSTRACI&#211;N</td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" class="normal-left">J-000000000</td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" style="height: 8px;"></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" class="normal-left">000000000000</td>
                                                <td colspan="2" class="normal-right">000000000000</td>
                                            </tr>
                                            <tr>
                                                <td colspan="1" class="normal-left">FECHA:</td>
                                                <td colspan="3" class="normal-left">00/00/00 00:00:00 PM</td>
                                            </tr>
                                            <tr>
                                                <td colspan="1" class="normal-left">NRO CUENTA:</td>
                                                <td colspan="2" class="normal-left">000000******0000    </td>
                                                <td class="normal-right">"0"</td>
                                            </tr>
                                            <tr>
                                                <td class="normal-left">NRO. REF.:</td>
                                                <td class="normal-left">000000</td>
                                                <td class="normal-right">LOTE:</td>
                                                <td class="normal-right">000</td>
                                            </tr>
                                            <tr>
                                                <td colspan="1" class="normal-left">APROBACION: </td>
                                                <td colspan="3" class="normal-left">000000</td>
                                            </tr>
                                            <tr>
                                                <td colspan="1" class="normal-left">SECUENCIA:</td>
                                                <td colspan="3" class="normal-left"></td>
                                            </tr>

                                            <tr>
                                                <td colspan="4" style="height: 8px;"></td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" class="big-center" align="center">
                                                    <br />
                                                    MONTO BS.  0,00
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" style="height: 8px;"></td>
                                            </tr>
                                            <tr style="margin-top: 10px;">
                                                <td colspan="4" class="big-center" align="center">RIF: J-000000000</td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" style="height: 8px;"></td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" class="normal-left">
                                                    <b>
                                                        <br />
                                                    </b>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" class="normal-left">
                                                    <br />debito
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="1" class="normal-left">ID:</td>
                                                <td colspan="3" class="normal-left">000000000000000000</td>
                                            </tr>
                                        </table>
                                    </div> 
								</div> 
				            </td> 
				        </tr> 
				    </tbody> 
				</table>
				<br>
			</div>';
		return $texto;
	}

	public function formamonto_mp(){
		$this->form_validation->set_rules('monto', 'Monto', 'required|callback_validanumero|callback_validamonto');
		$this->form_validation->set_rules('concepto', 'Concepto', 'required|max_length[150]');
		
		$this->form_validation->set_message('required', 'El campo {field} es obligatorio, pulse atrás para volver');
		$this->form_validation->set_message('validanumero', 'El campo {field} sólo debe contener números, pulse atrás para volver');
		$this->form_validation->set_message('validamonto', 'Debe incluir un monto mayor que 0, pulse atrás para volver');
		$this->form_validation->set_message('max_length', 'El campo {field} no debe exceder de {param} caracteres, pulse atrás para volver');
		if ($this->form_validation->run() == FALSE){
			$this->session->set_flashdata("mensaje_error",validation_errors());
			redirect(base_url() . 'monto');
        }
		$data = new stdClass();

		$_SESSION['monto'] = $this->input->post('monto');
		$_SESSION['concepto'] = $this->input->post('concepto');
		$_SESSION['envio'] = TRUE;

		$data->title = "Pasarela de pagos";
		$data->panel_title = "Procesamiento de pagos";
		$data->monto = $this->input->post('monto'); //aqui es la dirección física del controlador
		$data->contenido = "apl/pago/formulario_mp"; //aqui es la dirección física del controlador
		
		$this->load->view('menu',$data);
	}

	public function formulario_mp(){
			$data = new stdClass();

			$data->title = "Pasarela de pagos";
			$data->panel_title = "Procesamiento de pagos";
			$data->contenido = "apl/pago/formulario_mp"; //aqui es la dirección física del controlador
			$data->monto = $_SESSION['monto']; //aqui es la dirección física del controlador
		
			$this->load->view('menu',$data);
	}

	public function validacion_mp(){
		if ($_SESSION['envio']) {
			$this->form_validation->set_rules('monto', 'Monto', 'required|callback_validamonto');
			$this->form_validation->set_rules('card_nombre', 'Nombre', 'required|min_length[8]|max_length[150]|callback_validatexto');
			$this->form_validation->set_rules('card_cedula', 'Cédula', 'required|min_length[6]|max_length[8]');
			$this->form_validation->set_rules('card_tipo', 'Tipo de tarjeta', 'required|callback_validatipotarjeta['.$_POST["card_numero"].']');
			$this->form_validation->set_rules('card_numero', 'Numero de tarjeta', 'required|exact_length[16]|callback_validanumtarjeta');
			$this->form_validation->set_rules('card_mes', 'Mes de vencimiento', 'required');
		

			$this->form_validation->set_rules('card_year', 'Año de vencimiento', 'required|callback_validafecha['.$_POST["card_mes"].']');
			$this->form_validation->set_rules('card_cvv', 'CVV2 / CVC2', 'required|exact_length[3]|callback_validanumero');
			$this->form_validation->set_message('required', 'El campo {field} es obligatorio, pulse atrás para volver');
			$this->form_validation->set_message('validamonto', 'Debe incluir un monto mayor que 0, pulse atrás para volver');
			$this->form_validation->set_message('validatexto', 'El campor {field} sólo puede contener caracteres alfabéticos, pulse atrás para volver');
			$this->form_validation->set_message('min_length', 'El campo {field} debe tener al menos {param} caracteres, pulse atrás para volver');
			$this->form_validation->set_message('max_length', 'El campo {field} no debe exceder de {param} caracteres, pulse atrás para volver');
			$this->form_validation->set_message('validatipotarjeta', 'El número de tarjeta con concuerda con el tipo, pulse atrás para volver');
			$this->form_validation->set_message('exact_length', 'El campo {field} debe tener {param} caracteres, pulse atrás para volver');
			$this->form_validation->set_message('validanumtarjeta', 'El numero de la tarjeta es invalido, pulse atrás para volver');
			$this->form_validation->set_message('validanumero', 'El campo {field} sólo debe contener números, pulse atrás para volver');
			$this->form_validation->set_message('validafecha', 'La fecha de vencimiento no puede ser menor a la actual, pulse atrás para volver');
			if ($this->form_validation->run() == FALSE){
				$this->session->set_flashdata("mensaje_error",validation_errors());
				redirect(base_url() . 'formulario_mp');
	        }
			$datos = array(
				'monto' => $this->input->post('monto'),
				'card_nombre' => $this->input->post('card_nombre'),
				'card_cedula' => $this->input->post('card_cedula'),
				'card_tipo' => $this->input->post('card_tipo'),
				'card_numero' => $this->input->post('card_numero'),
				'card_mes' => $this->input->post('card_mes'),
				'card_year' => $this->input->post('card_year'),
				'card_cvv' => $this->input->post('card_cvv')
			);
			$resultado = $this->transaccion_mp($datos);

//			$transaccion = $resultado['tran'];

			$data = new stdClass();

			$data->title = "Pasarela de pagos";
			$data->contenido = "apl/pago/validacion"; //aqui es la dirección física del controlador
			$data->resultado = $resultado;
/*			if ($resultado['exito']) {
				// registrar transaccion
				$regtran = array(
					'id_emp' => $_SESSION['emp_id'],
					'id_user' => $_SESSION['userid'],
	//				'fecha' => $transaccion['datetime'],
					'fecha' => date('Y-m-d G:i:s'),
		
					'concepto' => $_SESSION['concepto'],
					'monto' => $_SESSION['monto'],
	//				'reference' => $transaccion['reference'],
	//				'aprobacion' => $transaccion['approval']
					'reference' => '1',
					'aprobacion' => '1',
					'name_user' => $_SESSION['userid'],
					'plataforma' => 'mp'
				);

				$this->Trans_model->regtran($regtran);

				//
				$data->contenido = "apl/pago/voucher_mp"; //aqui es la dirección física del controlador
				$data->panel_title = "Pago exitoso";
				$data->datetime = $transaccion['datetime'];
				$data->card_numero = $datos['card_numero'];
				$data->reference = $transaccion['reference'];
				$data->lote = $transaccion['lote'];
				$data->approval = $transaccion['approval'];
				$data->sequence = $transaccion['sequence'];
				$data->amount = $datos['monto'];
				$data->card_tipo = $datos['card_tipo'];
				$data->id = $transaccion['id'];
				$data->voucher = $transaccion['voucher'];
				// envía voucher por email
				$config = array(
					'mailtype' => 'html',
					'charset' => 'utf-8'
				);
				$this->email->initialize($config);
				$this->email->from($_SESSION['emp_email'],$_SESSION['emp_nombre']);
				$this->email->to($_SESSION['user_email']);
				$this->email->subject('Compra aprobada');
	//			$this->email->message('<h3>TRANSACCION APROBADA</h3>'. print($transaccion['voucher']));
				$comprobante= array(
					'emp_nombre' => $_SESSION['emp_nombre'],
					'emp_rif' => $_SESSION['emp_rif'],
					'emp_web' => $_SESSION['emp_web'],
					'emp_direccion' => $_SESSION['emp_direccion'],
					'datetime' => $transaccion['datetime'],
					'card_numero' => $datos['card_numero'],
					'reference' => $transaccion['reference'],
					'lote' => $transaccion['lote'],
					'approval' => $transaccion['approval'],
					'sequence' => $transaccion['sequence'],
					'amount' => $datos['monto'],
					'card_tipo' => $datos['card_tipo'],
					'id' => $transaccion['id']
				);
/*				$this->email->message('<h3>TRANSACCION APROBADA</h3>'.$this->mensaje_mp($comprobante));
				if ($this->email->send()) {
					$this->session->set_flashdata("mensaje_success","Se ha enviado la confirmación al email: " . $_SESSION['user_email']);
				} else {
					echo $this->email->print_debugger();
				}
				// fin envío email
	           	$_SESSION['envio'] = FALSE;
	           	$_SESSION['is_logged_in'] = FALSE;*
			} else {
				$data->contenido = "apl/pago/rechazo"; //aqui es la dirección física del controlador
				$data->panel_title = "Pago rechazado";
			}*/
			
			$this->load->view('menu',$data);
		} else {
			redirect(base_url() . 'logout');
		}
	}

	function transaccion_mp($datos){

//		require_once(base_url().'recursos/lib/mercadopago.php');
		$this->load->helper('mercadopago');

		echo '<script type="text/javascript" language="javascript">';
		echo "<pre>";
		var_dump($_POST);		
		$mp = new MP($_SESSION['emp_mp_at']);

		$ct = $mp->get(
				array(
					"uri" => "/v1/card_tokens/:id?public_key=".$_SESSION['emp_mp_pukey']
				)
			);
		return $ct;
	/*
		$ch = curl_init();																		// abrimos la sesión cURL
		curl_setopt($ch, CURLOPT_URL,"/v1/card_tokens?public_key=".$_SESSION['emp_mp_pukey']);	// definimos la URL a la que hacemos la petición
		curl_setopt($ch, CURLOPT_HTTPGET, TRUE);													// indicamos el tipo de petición: POST
		//curl_setopt($ch, CURLOPT_POSTFIELDS, "postvar1=value1&postvar2=value2&postvar3=value3");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);											// definimos los parámetros
		$respuesta = curl_exec($ch);															// recibimos la respuesta
		curl_close ($ch);																		// cerramos la sesión cURL
		// hacemos lo que queramos con los datos recibidos
		return $respuesta;
	*/
	}

	public function formamonto_pf(){
		$this->form_validation->set_rules('monto', 'Monto', 'required|callback_validanumero|callback_validamonto');
		$this->form_validation->set_rules('concepto', 'Concepto', 'required|max_length[150]');
		
		$this->form_validation->set_message('required', 'El campo {field} es obligatorio, pulse atrás para volver');
		$this->form_validation->set_message('validanumero', 'El campo {field} sólo debe contener números, pulse atrás para volver');
		$this->form_validation->set_message('validamonto', 'Debe incluir un monto mayor que 0, pulse atrás para volver');
		$this->form_validation->set_message('max_length', 'El campo {field} no debe exceder de {param} caracteres, pulse atrás para volver');
		if ($this->form_validation->run() == FALSE){
			$this->session->set_flashdata("mensaje_error",validation_errors());
			redirect(base_url() . 'monto');
        }
		$data = new stdClass();

		$_SESSION['monto'] = $this->input->post('monto');
		$_SESSION['concepto'] = $this->input->post('concepto');
		$_SESSION['envio'] = TRUE;

		$data->title = "Pasarela de pagos";
		$data->panel_title = "Procesamiento de pagos";
		$data->monto = $this->input->post('monto'); //aqui es la dirección física del controlador
		$data->contenido = "apl/pago/formulario_pf"; //aqui es la dirección física del controlador
		
		$this->load->view('menu',$data);
	}

	public function formulario_pf(){
			$data = new stdClass();

			$data->title = "Pasarela de pagos";
			$data->panel_title = "Procesamiento de pagos";
			$data->contenido = "apl/pago/formulario_pf"; //aqui es la dirección física del controlador
			$data->monto = $_SESSION['monto']; //aqui es la dirección física del controlador
		
			$this->load->view('menu',$data);
	}

	public function validacion_pf(){
		if ($_SESSION['envio']) {
			$this->form_validation->set_rules('monto', 'Monto', 'required|callback_validamonto');
			$this->form_validation->set_rules('card_nombre', 'Nombre', 'required|min_length[8]|max_length[150]|callback_validatexto');
			$this->form_validation->set_rules('card_cedula', 'Cédula', 'required|min_length[6]|max_length[8]');
//			$this->form_validation->set_rules('card_tipo', 'Tipo de tarjeta', 'required|callback_validatipotarjeta['.$_POST["card_numero"].']');
			$this->form_validation->set_rules('card_tipo', 'Tipo de tarjeta', 'required');
//			$this->form_validation->set_rules('card_numero', 'Numero de tarjeta', 'required|exact_length[16]|callback_validanumtarjeta');
			$this->form_validation->set_rules('card_numero', 'Numero de tarjeta', 'required|exact_length[16]');
			$this->form_validation->set_rules('card_mes', 'Mes de vencimiento', 'required');
		

			$this->form_validation->set_rules('card_year', 'Año de vencimiento', 'required|callback_validafecha['.$_POST["card_mes"].']');
			$this->form_validation->set_rules('card_cvv', 'CVV2 / CVC2', 'required|exact_length[3]|callback_validanumero');
			$this->form_validation->set_message('required', 'El campo {field} es obligatorio, pulse atrás para volver');
			$this->form_validation->set_message('validamonto', 'Debe incluir un monto mayor que 0, pulse atrás para volver');
			$this->form_validation->set_message('validatexto', 'El campor {field} sólo puede contener caracteres alfabéticos, pulse atrás para volver');
			$this->form_validation->set_message('min_length', 'El campo {field} debe tener al menos {param} caracteres, pulse atrás para volver');
			$this->form_validation->set_message('max_length', 'El campo {field} no debe exceder de {param} caracteres, pulse atrás para volver');
			$this->form_validation->set_message('validatipotarjeta', 'El número de tarjeta con concuerda con el tipo, pulse atrás para volver');
			$this->form_validation->set_message('exact_length', 'El campo {field} debe tener {param} caracteres, pulse atrás para volver');
			$this->form_validation->set_message('validanumtarjeta', 'El numero de la tarjeta es invalido, pulse atrás para volver');
			$this->form_validation->set_message('validanumero', 'El campo {field} sólo debe contener números, pulse atrás para volver');
			$this->form_validation->set_message('validafecha', 'La fecha de vencimiento no puede ser menor a la actual, pulse atrás para volver');
			if ($this->form_validation->run() == FALSE){
				$this->session->set_flashdata("mensaje_error",validation_errors());
				redirect(base_url() . 'formulario_pf');
	        }
			$datos = array(
				'monto' => $this->input->post('monto'),
				'card_nombre' => $this->input->post('card_nombre'),
				'card_cedula' => $this->input->post('card_cedula'),
				'card_tipo' => $this->input->post('card_tipo'),
				'card_numero' => $this->input->post('card_numero'),
				'card_mes' => $this->input->post('card_mes'),
				'card_year' => $this->input->post('card_year'),
				'card_cvv' => $this->input->post('card_cvv')
			);
			$resultado = $this->transaccion_pf($datos);
			$transaccion = $resultado['tran'];

			$data = new stdClass();

			$data->title = "Pasarela de pagos";
			if ($resultado['exito']) {
				// registrar transaccion
				$regtran = array(
					'id_emp' => $_SESSION['emp_id'],
					'id_user' => $_SESSION['userid'],
	//				'fecha' => $transaccion['datetime'],
					'fecha' => date('Y-m-d G:i:s'),
		
					'concepto' => $_SESSION['concepto'],
					'monto' => $_SESSION['monto'],
	//				'reference' => $transaccion['reference'],
	//				'aprobacion' => $transaccion['approval']
					'reference' => '1',
					'aprobacion' => '1',
					'name_user' => $_SESSION['userid'],
					'plataforma' => 'pf'
				);

				$this->Trans_model->regtran($regtran);

				//
				$data->contenido = "apl/pago/voucher_pf"; //aqui es la dirección física del controlador
				$data->panel_title = "Pago exitoso";
				$data->datetime = $transaccion['datetime'];
				$data->card_numero = $datos['card_numero'];
				$data->reference = $transaccion['reference'];
				$data->lote = $transaccion['lote'];
				$data->approval = $transaccion['approval'];
				$data->sequence = $transaccion['sequence'];
				$data->amount = $datos['monto'];
				$data->card_tipo = $datos['card_tipo'];
				$data->id = $transaccion['id'];
				$data->voucher = $transaccion['voucher'];
				// envía voucher por email
				$config = array(
					'mailtype' => 'html',
					'charset' => 'utf-8'
				);
				$this->email->initialize($config);
				$this->email->from($_SESSION['emp_email'],$_SESSION['emp_nombre']);
				$this->email->to($_SESSION['user_email']);
				$this->email->subject('Compra aprobada');
	//			$this->email->message('<h3>TRANSACCION APROBADA</h3>'. print($transaccion['voucher']));
				$comprobante= array(
					'emp_nombre' => $_SESSION['emp_nombre'],
					'emp_rif' => $_SESSION['emp_rif'],
					'emp_web' => $_SESSION['emp_web'],
					'emp_direccion' => $_SESSION['emp_direccion'],
					'datetime' => $transaccion['datetime'],
					'card_numero' => $datos['card_numero'],
					'reference' => $transaccion['reference'],
					'lote' => $transaccion['lote'],
					'approval' => $transaccion['approval'],
					'sequence' => $transaccion['sequence'],
					'amount' => $datos['monto'],
					'card_tipo' => $datos['card_tipo'],
					'id' => $transaccion['id']
				);
				$this->email->message('<h3>TRANSACCION APROBADA</h3>'.$this->mensaje_ip($comprobante));
				if ($this->email->send()) {
					$this->session->set_flashdata("mensaje_success","Se ha enviado la confirmación al email: " . $_SESSION['user_email']);
				} else {
					echo $this->email->print_debugger();
				}
				// fin envío email
	           	$_SESSION['envio'] = FALSE;
	           	$_SESSION['is_logged_in'] = FALSE;
			} else {
				$data->contenido = "apl/pago/rechazo"; //aqui es la dirección física del controlador
				$data->panel_title = "Pago rechazado";
			}
			
			$this->load->view('menu',$data);
		} else {
			redirect(base_url() . 'logout');
		}
	}

	function transaccion_pf($datos){

	    $emp_prkey = $_SESSION['emp_pf_tkkey'];
	    $emp_pukey = $_SESSION['emp_pf_kskey'];
/////////////////////////////////////////////////////////////////////////////////////////////////////////
		include_once('pagoflash.api.client.php');
		// url de tu sitio donde deberás procesar el pago
		$urlCallbacks = "";
		// cadena de 32 caracteres generada por la aplicación, Ej. aslkasjlkjl2LKLKjkjdkjkljlk&as87
		$key_public = $emp_prkey;
		// cadena de 20 caracteres generado por la aplicación. Ej. KJHjhKJH644GGr769jjh
		$key_secret = $emp_pukey;
		// Si deseas ejecutar en el entorno de producción pasar (false) en el 4to parametro
		$api = new apiPagoflash($key_public,$key_secret, $urlCallbacks,true);
		//Cabecera de la transacción
		$cabeceraDeCompra = array(
			// Código de la orden (Alfanumérico de máximo 45 caracteres).
			"pc_order_number" => "001",
			// Monto total de la orden, número decimal sin separadores de miles,
			// utiliza el punto (.) como separadores de decimales. Máximo dos decimales
			// Ej. 9999.99
			"pc_amount" => $_SESSION["monto"]
		);
		//Producto o productos que serán el motivo de la transacción
		$ProductItems = array();
		$product_1 = array(
			// Id. de tu porducto. Ej. 1
			'pr_id' => 1,
			// Nombre. 127 caracteres máximo.
			'pr_name' => $_SESSION["concepto"],
			// Descripción . Maximo 230 caracteres.
			'pr_desc' => $_SESSION["concepto"],
			// Precio individual del producto. sin separadores de miles,
			// utiliza el punto (.) como separadores de decimales. Máximo dos decimales
			// Ej. 9999.99
			'pr_price' => $_SESSION["monto"],
			// Cantidad, Entero sin separadores de miles
			'pr_qty' => '1',
			// Dirección de imagen. debe ser una dirección (url) válida para la imagen.
			'pr_img' => '',
		);
		array_push($ProductItems, $product_1);
		//La información conjunta para ser procesada
		$pagoFlashRequestData = array(
			'cabecera_de_compra' => $cabeceraDeCompra,
			'productos_items' => $ProductItems,
			"additional_parameters" => array(
				"url_ok_redirect" =>"https://pasarela.sgc-consultores.com.ve/application/views/apl/pago/voucher_ip.php", // en esta url le muestas a tu cliente que el pago fue exit
				"url_ok_request" => "https://pasarela.sgc-consultores.com.ve/application/views/apl/pago/rechazo.php" // en esta url debes verificar la transaccion
			)
		);
		echo '<pre>';
		var_dump($cabeceraDeCompra);
		var_dump($ProductItems);
		var_dump($pagoFlashRequestData);
		echo '</pre>';		
		//Se realiza el proceso de pago, devuelve JSON con la respuesta del servidor
		$response = $api->procesarPago($pagoFlashRequestData, $_SERVER['HTTP_USER_AGENT']);
		$pfResponse = json_decode($response);
		//Si es exitoso, genera y guarda un link de pago en (url_to_buy) el cual se usará para redirigir al formulario de pago
		var_dump($pfResponse);
		if($pfResponse->success){
			$valores = array('exito' => true, 'tran' => $$pfResponse);
		} else {
			$valores = array('exito' => false, 'tran' => '');
		}
		return $valores;
	}

}
/*		
		$ch = curl_init();																		// abrimos la sesión cURL
		curl_setopt($ch, CURLOPT_URL,"/v1/card_tokens?public_key=".$_SESSION['emp_mp_pukey']);	// definimos la URL a la que hacemos la petición
		curl_setopt($ch, CURLOPT_POST, TRUE);													// indicamos el tipo de petición: POST
		//curl_setopt($ch, CURLOPT_POSTFIELDS, "postvar1=value1&postvar2=value2&postvar3=value3");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);											// definimos los parámetros
		$respuesta = curl_exec($ch);															// recibimos la respuesta
		curl_close ($ch);																		// cerramos la sesión cURL
		// hacemos lo que queramos con los datos recibidos
//		return $mp;
    	if (isset($respuesta)) {
	        $aresp=json_decode($respuesta,true);
	        $token = $aresp['id'];
	        if (is_object($respuesta)) {
	        	return "array";
	        } else {
	        	return "no array";
	        }
	        return $aresp;

/*
			$payment_data = array(
				"transaction_amount" => $datos['monto'],
				"token" => $token,
				"description" => "Servicio a " . $datos['card_nombre'],
				"installments" => 1,
				"payment_method_id" => "visa",
				"payer" => array ( "email" => $_SESSION['user_email'] )
			);
		} else {
			return "no";
		}
	}	*/
/*
			$payment = $mp->post("/v1/payments", $payment_data);

/////////////////////////////////////////////      voy por aqui


		$url = 'https://api.instapago.com/payment';
    	$fields = array("KeyID" => $emp_prkey ,
            "PublicKeyId" => $emp_pukey,
            "Amount" => $datos['monto'],
            "Description" => "Servicio a " . $datos['card_nombre'],
            "CardHolder"=> $datos['card_nombre'],
            "CardHolderId"=> $datos['card_cedula'],
            "CardNumber" => $datos['card_numero'],
            "CVC" => $datos['card_cvv'],
            "ExpirationDate" => $datos['card_mes'] . "/" . $datos['card_year'],
            "StatusId" => "2",
            "IP" => $_SERVER['REMOTE_ADDR'],
            "Address" => " ",
            "City" => " ",
            "ZipCode" => " ",
            "State" => " " 
        );
		$ch = curl_init();
    	curl_setopt($ch, CURLOPT_URL,$url );
    	curl_setopt($ch, CURLOPT_POST, true);
    	curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($fields));
    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    	$server_output = curl_exec($ch);
    	curl_close ($ch);

    	if (isset($server_output)) {
	        $tran=json_decode($server_output,true);
			$valores = array('exito' => true, 'tran' => $tran);
     	} else{
			$valores = array('exito' => false, 'tran' => '');
    	} 
		return $valores;
	}


}
/*
		$mp = new MP ($_SESSION['emp_mp_ci'], $_SESSION['emp_mp_cs']);

		$at = $mp->get_access_token();


		$url = "https://api.mercadolibre.com/collections/notifications/".$_REQUEST['id']."?access_token=".$at; //checkout API
		// START Request
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); //return the transference value like a string
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json', 'Content-Type: application/json'));//sets the header
		curl_setopt($ch, CURLOPT_URL, $url); //Preference API
		curl_setopt($ch, CURLOPT_SSLVERSION, 3);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
		$datos = curl_exec($ch);//execute the conection
		$datosHttpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);//status
		if($datosHttpcode != 201) {
			$err=1;
		}
		curl_close($ch); //conection close
		// Request OK
		$datos=json_decode(($datos),true);
		if(isset($datos['collection']['id']) && isset($datos['collection']['status'])  && ($datos['collection']['status']=='pending' || $datos['collection']['status']=='in_process') ) {
    		//pago pendiente, hago lo que necesite hacer, uso este dato que customicé en mi formulario de pago
    		$idp=$datos['collection']['external_reference'];
		}elseif(isset($datos['collection']['id']) && isset($datos['collection']['status'])  && $datos['collection']['status']=='approved') {
			$idp=$datos['collection']['external_reference'];
		    //pago completado, hago lo que necesite hacer, uso este dato que customicé en mi formulario de pago
		} else {
    		header('HTTP/1.1 404 Not Found');
    		exit;
		}
*/
