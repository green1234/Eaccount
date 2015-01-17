<?php
require_once "conf/constantes.conf";
require_once PROYECT_PATH . "/service/ClienteService.php";

$_SESSION["ui"] = 1;
$_SESSION["pw"] = "admin";

if (isset($_SESSION["ui"]) && isset($_SESSION["pw"]))
{
	$admin_id = $_SESSION["ui"];
	$admin_pw = $_SESSION["pw"];	
}

$clienteService = new ClienteService($admin_id, $admin_pw);
$res = "";
// $_POST["nombre"] = "Laura";
// $_POST["apellido"] = "Laura";
// $_POST["email"] = "mcgalv@gmail.com";
// $_POST["email"] = "contacto@webandmovil.com";
// $_POST["password"] = $_POST["password2"] = "123";
$_POST["tyc"] = 1;

if (!isset($_POST["nombre"]) || !$_POST["apellido"] || !$_POST["email"] 
	|| !$_POST["password"] || !$_POST["password2"] || !$_POST["tyc"])
{
	return json_encode(
		array(
			"success"=>false, 
			"data"=>array(
				"error" => -1, 
				"description" => "Todos los datos son requeridos")));	
}	

$empresa_id = 0;
$empresa_rfc = "XAXX010101000";
$usuario_nombre = $_POST["nombre"] . " " . $_POST["apellido"];
$empresa_nombre = $usuario_nombre;
$usuario_email = $_POST["email"];
$usuario_password = $_POST["password"];
$usuario_password2 = $_POST["password2"];
$terminos_condiciones = $_POST["tyc"];

$empresa_default = 0;
$registrado = false;

$empresa = array(
	"name" => $empresa_nombre, 
	"gl_rfc" => $empresa_rfc, 
	"currency_id" => 34, 
	);

$usuario = array(
		"name" => $usuario_nombre, 
		"login" => $usuario_email,
		"email" => $usuario_email,	
		"password" => $usuario_password,		
	);

$res = $clienteService->registrar_suscripcion($usuario, $empresa);
echo json_encode($res);
?>