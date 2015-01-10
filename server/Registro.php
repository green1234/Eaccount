<?php
#echo phpinfo(); exit();
require_once "conf/constantes.conf";
require_once PROYECT_PATH . "/service/ClienteService.php";
#require_once PROYECT_PATH . "/lib/phpmailer/PHPMailerAutoload.php";

$admin_id = 1;
$admin_pw = "admin";
$error = false;
$clienteService = new ClienteService($admin_id, $admin_pw);
$res = "LOL";
$_POST["nombre"] = "Laura";
$_POST["apellido"] = "Laura";
$_POST["email"] = "mcgalv@gmail.com";
$_POST["password"] = $_POST["password2"] = "123";
$_POST["tyc"] = 1;

if (!isset($_POST["nombre"]) || !$_POST["apellido"] || !$_POST["email"] 
	|| !$_POST["password"] || !$_POST["password2"] || !$_POST["tyc"])
{
	$res = json_encode(array("success"=>false, "data"=>array("error" => -1, "description" => "Todos los datos son requeridos")));
	$error = true;

	if (!$error)
	{
		if ($_POST["password"] != $_POST["password2"])
		{
			$res = json_encode(
				array("success"=>false, 
					"data"=>array(
						"error" => -1, 
						"description" => "El password no coincide"
						)
					)
				);
		}
	}
}

if ($error)
	return $res;

$empresa_id = 0;
$empresa_rfc = "XAXX010101000";
$empresa_name = $usuario_nombre = $_POST["nombre"];
$usuario_apellido = $_POST["apellido"];
$usuario_email = $_POST["email"];
$usuario_password = $_POST["password"];
$usuario_password2 = $_POST["password2"];
$terminos_condiciones = $_POST["tyc"];



$empresa_default = 0;
$registrado = false;

$empresa = array(
	"name" => $empresa_name, 
	"rfc" => $empresa_rfc, 
	"currency_id" => 34, 
	);

$usuario = array(
		"name" => $usuario_nombre, 
		"login" => $usuario_email,
		"email" => $usuario_email,		
	);


// logg($empresa);
// logg($usuario);

// $mail = get_mailer();
// if(!$mail->send()) {
//     echo 'Message could not be sent.';
//     echo 'Mailer Error: ' . $mail->ErrorInfo;
// } else {
//     echo 'Message has been sent';
// }



// logg($res,1);

$res = $clienteService->registrarCliente($usuario, $empresa);
if ($res["success"])
{
	// logg($res,1);
	echo json_encode($res);
}
else
{
	echo json_encode(array("success"=>false));	
}

// logg($res,1);

?>