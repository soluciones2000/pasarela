<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//var_dump($_SESSION);
$emp_nombre = $_SESSION['emp_nombre'];
$emp_rif = $_SESSION['emp_rif'];
$emp_web = $_SESSION['emp_web'];
$emp_direccion = $_SESSION['emp_direccion'];
$_SESSION['is_logged_in'] = FALSE;

?>
<div class="container">
	<div class="col-md-8 center-block no-float">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title"><?php echo $panel_title ?></h3>
			</div>
			<div class="panel-body">
                <table style="background-color: white;" align="center">
                    <tbody>
                        <tr>
                            <td>
                                <div style="border: 1px solid #222; padding: 9px; text-align: center; max-width:255px" id="voucher">
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
                                                <td colspan="4" class="big-center-especial">
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
                                                <td class="normal-right">'0'</td>
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
                                                <td colspan="4" class="big-center">
                                                    <br />
                                                    MONTO BS.  0,00
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" style="height: 8px;"></td>
                                            </tr>
                                            <tr style="margin-top: 10px;">
                                                <td colspan="4" class="big-center">RIF: J-000000000</td>
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
            </div>
		</div>
	</div>
</div>
