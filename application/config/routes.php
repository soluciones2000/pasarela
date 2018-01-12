<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
//$route['default_controller'] = 'welcome';

// LR->controlador principal, por default
$route['default_controller'] = 'menu';

/* otros parametros que trae el framework */
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// LR->controladores de la aplicación
$route['login'] = 'auth/login'; //aqui es el controlador y el metodo
$route['entrar'] = 'auth/entrar'; //aqui es el controlador y el metodo
$route['contacto'] = 'cont/contacto'; //aqui es el controlador y el metodo
$route['email_contacto'] = 'cont/email_contacto'; //aqui es el controlador y el metodo

$route['registro'] = 'auth/registro'; //aqui es el controlador y el metodo
$route['crea_user'] = 'auth/crea_user'; //aqui es el controlador y el metodo

$route['cambio'] = 'auth/cambio'; //aqui es el controlador y el metodo
$route['passchange'] = 'auth/passchange'; //aqui es el controlador y el metodo
$route['recuperar'] = 'auth/recuperar'; //aqui es el controlador y el metodo
$route['pregunta'] = 'auth/pregunta'; //aqui es el controlador y el metodo
$route['respuesta'] = 'auth/respuesta'; //aqui es el controlador y el metodo
$route['passretrieve'] = 'auth/passretrieve'; //aqui es el controlador y el metodo
$route['hint'] = 'auth/hint'; //aqui es el controlador y el metodo

$route['reinicio'] = 'auth/reinicio'; //aqui es el controlador y el metodo
$route['reset'] = 'auth/reset'; //aqui es el controlador y el metodo

$route['logout'] = 'auth/logout'; //aqui es el controlador y el metodo

$route['monto'] = 'pago/monto'; //aqui es el controlador y el metodo
$route['formamonto_ip'] = 'pago/formamonto_ip'; //aqui es el controlador y el metodo
$route['formulario_ip'] = 'pago/formulario_ip'; //aqui es el controlador y el metodo
$route['validacion_ip'] = 'pago/validacion_ip'; //aqui es el controlador y el metodo

$route['formamonto_mp'] = 'pago/formamonto_mp'; //aqui es el controlador y el metodo
$route['formulario_mp'] = 'pago/formulario_mp'; //aqui es el controlador y el metodo
$route['validacion_mp'] = 'pago/validacion_mp'; //aqui es el controlador y el metodo

$route['formamonto_pf'] = 'pago/formamonto_pf'; //aqui es el controlador y el metodo
$route['formulario_pf'] = 'pago/formulario_pf'; //aqui es el controlador y el metodo
$route['validacion_pf'] = 'pago/validacion_pf'; //aqui es el controlador y el metodo

$route['reporte'] = 'report/reporte'; //aqui es el controlador y el metodo
$route['parametros'] = 'report/parametros'; //aqui es el controlador y el metodo
$route['numpagina/(:num)'] = 'report/numpagina/$1'; //aqui es el controlador y el metodo
