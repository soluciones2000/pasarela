<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pago extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Auth_model');
	}

	public function monto(){
			$data = new stdClass();

			$data->title = "Pasarela de pagos";
			$data->panel_title = "Concepto a pagar";
			$data->contenido = "apl/pago/monto"; //aqui es la dirección física del controlador

			$this->load->view('menu',$data);
	}

	public function formamonto(){
		$this->form_validation->set_rules('monto', 'Monto', 'required|callback_validamonto');
		$this->form_validation->set_rules('concepto', 'Concepto', 'required|max_length[150]');
		$this->form_validation->set_message('required', 'El campo {field} es obligatorio, pulse atrás para volver');
		$this->form_validation->set_message('validamonto', 'Debe incluir un monto mayor que 0, pulse atrás para volver');
		$this->form_validation->set_message('max_length', 'El campo {field} no debe exceder de {param} caracteres, pulse atrás para volver');
		if ($this->form_validation->run() == FALSE){
			$this->session->set_flashdata("mensaje_error",validation_errors());
			redirect(base_url() . 'monto');
        }
		$data = new stdClass();

		$data->title = "Pasarela de pagos";
		$data->panel_title = "Procesamiento de pagos";
		$data->monto = $this->input->post('monto'); //aqui es la dirección física del controlador
		$data->contenido = "apl/pago/formulario"; //aqui es la dirección física del controlador
		
		$this->load->view('menu',$data);
	}

	public function formulario(){
			$data = new stdClass();

			$data->title = "Pasarela de pagos";
			$data->panel_title = "Procesamiento de pagos";
			$data->contenido = "apl/pago/formulario"; //aqui es la dirección física del controlador
			$data->monto = "apl/pago/formulario"; //aqui es la dirección física del controlador
		
			$this->load->view('menu',$data);
	}

	public function validacion(){
		$this->form_validation->set_rules('monto', 'Monto', 'required|callback_validamonto');
		$this->form_validation->set_rules('card_nombre', 'Nombre', 'required|min_length[8]|max_length[150]');
		$this->form_validation->set_rules('card_cedula', 'Cédula', 'required|min_length[6]|max_length[8]');
		$this->form_validation->set_rules('card_tipo', 'Tipo de tarjeta', 'required|callback_validatipotarjeta['.$_POST["card_numero"].']');
		$this->form_validation->set_rules('card_numero', 'Numero de tarjeta', 'required|exact_length[16]|callback_validanumtarjeta');
		$this->form_validation->set_rules('card_mes', 'Mes de vencimiento', 'required');
		$this->form_validation->set_rules('card_year', 'Año de vencimiento', 'required|callback_validafecha['.$_POST["card_mes"].']');
		$this->form_validation->set_rules('card_cvv', 'CVV2 / CVC2', 'required|min_length[3]|max_length[4]');
		$this->form_validation->set_message('required', 'El campo {field} es obligatorio, pulse atrás para volver');
		$this->form_validation->set_message('validamonto', 'Debe incluir un monto mayor que 0, pulse atrás para volver');
		$this->form_validation->set_message('min_length', 'El campo {field} debe tener al menos {param} caracteres, pulse atrás para volver');
		$this->form_validation->set_message('max_length', 'El campo {field} no debe exceder de {param} caracteres, pulse atrás para volver');
		$this->form_validation->set_message('validatipotarjeta', 'El número de tarjeta con concuerda con el tipo, pulse atrás para volver');
		$this->form_validation->set_message('exact_length', 'El campo {field} debe tener {param} caracteres, pulse atrás para volver');
		$this->form_validation->set_message('validanumtarjeta', 'El numero de la tarjeta es invalido, pulse atrás para volver');
		$this->form_validation->set_message('validafecha', 'La fecha de vencimiento no puede ser menor a la actual, pulse atrás para volver');
		if ($this->form_validation->run() == FALSE){
			$this->session->set_flashdata("mensaje_error",validation_errors());
			redirect(base_url() . 'formulario');
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
		$resultado = $this->transaccion($datos);
		$transaccion = $resultado['tran'];

		$data = new stdClass();
		echo "<pre>";
		print($transaccion['voucher']);

		$data->title = "Pasarela de pagos";
		if ($resultado['exito']) {
			$data->contenido = "apl/pago/voucher"; //aqui es la dirección física del controlador
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
			$this->email->message('<h3>TRANSACCION APROBADA</h3>'.$this->mensaje($comprobante));
			if ($this->email->send()) {
				$this->session->set_flashdata("mensaje_success","Se ha enviado la confirmación al email: " . $_SESSION['user_email']);
			} else {
				echo $this->email->print_debugger();
			}
			// fin envío email
		} else {
			$data->contenido = "apl/pago/rechazo"; //aqui es la dirección física del controlador
			$data->panel_title = "Pago rechazado";
		}
		
		$this->load->view('menu',$data);
	}

	function validamonto($monto){
		if ($monto>0) {
			return true;
		} else {
			return false;
		}
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
		if ($year<$hoy['year']){ // año
			return false;
		} elseif ($mes<$hoy['mon']) { // mes
			return false;
		}
   		return true;
	}

	function transaccion($datos){

	    $emp_prkey = $_SESSION['emp_prkey'];
	    $emp_pukey = $_SESSION['emp_pukey'];


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

	function mensaje($comprobante){
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
				                    			<td colspan="4" class="normal-center">COPIA - CLIENTE</td>
				                            </tr> 
				                            <tr> 
				                            	<td colspan="4" class="big-center-especial"> <br /> BANESCO</td> 
				                            </tr> 
				                            <tr> 
				                                <td colspan="4" class="big-center"> <br /></td> 
				                            </tr> 
				                            <tr> 
				                                <td colspan="4" style="height: 8px;"></td> 
				                            </tr> 
				                            <tr> 
				                                <td colspan="4" class="normal-left">'.$emp_nombre.'<br>('.$emp_rif.')<br>'.$emp_web.'</td>
				                            </tr> 
				                            <tr> 
				                                <td colspan="4" class="normal-left">'.$emp_direccion.'</td>
				                            </tr> 
				                            <tr> 
				                                <td colspan="4" class="normal-left">'.substr($emp_rif,0,1)."-".substr($emp_rif,1,-1)."-".substr($emp_rif,-1).'</td> 
				                            </tr> 
				                            <tr> 
				                            	<td colspan="4" style="height: 8px;"></td> 
				                            </tr> 
				                            <!--
				                            <tr> 
				                    			<td colspan="2" class="normal-left">000000000000</td> 
				                                <td colspan="2" class="normal-right">000000000000</td> 
				                            </tr> 
				                            -->
				                            <tr>
				                                <td colspan="1" class="normal-left">FECHA:</td> 
				                                <td colspan="3" class="normal-left">'.$datetime.'</td>
				                            </tr> 
				                            <tr> 
				                                <td colspan="1" class="normal-left">NRO CUENTA:</td> 
				                                <td colspan="2" class="normal-left">'.substr($card_numero,0,6) . "******" . substr($card_numero,-4).'</td> 
				                            </tr> 
				                            <tr> 
				                                <td class="normal-left">NRO. REF.:</td> 
				                                <td class="normal-left">'.$reference.'</td> 
				                                <td class="normal-right">LOTE:</td> 
				                                <td class="normal-right">'.$lote.'</td> 
				                            </tr> 
				                            <tr> 
				                                <td colspan="1" class="normal-left">APROBACION:</td> 
				                                <td colspan="3" class="normal-left">'.$approval.'</td> 
				                            </tr> 
				                            <tr> 
				                                <td colspan="1" class="normal-left">SECUENCIA:</td> 
				                                <td colspan="3" class="normal-left">'.$sequence.'</td> 
				                            </tr> 
				                            <tr> 
				                                <td colspan="4" style="height: 8px;"></td> 
				                            </tr> 
				                            <tr> 
				                                <td colspan="4" class="big-center"> <br /> MONTO Bs. '.number_format($amount,2,',','.').'</td> 
				                            </tr> 
				                            <tr> 
				                                <td colspan="4" style="height: 8px;"></td> 
				                            </tr> 
				                            <tr style="margin-top: 10px;"> 
				                                <td colspan="4" class="big-center">RIF: '.substr($emp_rif,0,1)."-".substr($emp_rif,1,-1)."-".substr($emp_rif,-1).'</td> 
				                            </tr> 
				                            <tr> 
				                                <td colspan="4" style="height: 8px;"></td> 
				                            </tr> 
				                            <tr> 
				                                <td colspan="4" class="normal-left"> <b><br/></b></td> 
				                            </tr> 
				                            <tr> 
				                                                <td colspan="4" class="normal-left"> <br />'.$card_tipo.'</td> 
				                            </tr>
				                            <tr> 
				                                <td colspan="1" class="normal-left">ID:</td> 
				                                <td colspan="7" class="normal-left">'.$id.'</td> 
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
}
