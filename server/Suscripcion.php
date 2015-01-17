<?php

require_once "conf/constantes.conf";
require_once PROYECT_PATH . "/service/LoginService.php";
require_once PROYECT_PATH . "/service/SuscriptionService.php";

$usuario_name = "admin";
$usuario_pw = "admin";
$usuario_id = 0;

$loginService = new LoginService();
$res = $loginService->acceder($usuario_name, $usuario_pw);

function registrar($data, $service)
{
	$empresa_id = 0;
	$usuario_nombre = $data["nombre"] . " " . $data["apellido"];
	$empresa_nombre = $usuario_nombre;
	$empresa_rfc = "XAXX010101000";
	$usuario_email = $data["email"];
	$usuario_password = $data["password"];
	// $usuario_password2 = $data["password2"];
	// $terminos_condiciones = $_POST["tyc"];

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

	return $service->registrar_suscripcion($usuario, $empresa);	
}

if ($res["success"])
{
	$usuario_id = $res["data"][0]["id"];
	$suscriptionService = new SuscriptionService($usuario_id, $usuario_pw);

	if (isset($_GET["action"]))
	{
		$res = array();
		switch($_GET["action"])
		{
			case "registro": 

				$verificacion = verificar_datos($_POST, 
					array("nombre", "apellido", "email", "password"));

				if (!$verificacion)
				{
					$res = array("success"=>false, 
							"data"=>array(								
								"description" => "Todos los datos son requeridos"
								));
				}
				else				
					$res = registrar($_POST, $suscriptionService);
								
			break;

			case "activacion": 
				if (!verificar_datos($_GET, array("fk")))
				{
					$res = array("success"=>false,
							"data" => array(
								"description" => "No hay ningun registro previo")
							);
				}
				else
					$res = $suscriptionService->confirmar_suscripcion($_GET["fk"]);
			break;

			case "compra": 

				if (!verificar_datos($_POST, 
					array("plan", "period", "discount")))
				{
					$res = array("success"=>false,
							"data" => array(
								"description" => "Ocurrio un error al verificar los datos de la compra.")
							);
				}

				$res = array("plan" => $_POST["plan"], "period" => $_POST["period"]);				
			break;
		}

		echo json_encode($res);
	}
	else
	{		
		$suscService = new SuscriptionService($usuario_id, $usuario_pw);
		$res = $suscService->obtener_planes_suscription();
		echo json_encode($res);
	}
}
else
{
	echo json_encode(array(
		"success"=>false, 
		"data"=>array(
			"description"=>"No hay sesion activa")
		));
}

?>