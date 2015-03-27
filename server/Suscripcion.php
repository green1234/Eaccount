<?php

$a = session_id();
if(empty($a)) session_start();
// if (!isset($_SESSION["login"]))
// {
// 	echo json_encode(array("success"=>false, "data"=>array("description"=>"Datos de Acceso Incorrectos")));
// 	exit();	
// }

// $uid = $_SESSION["login"]["uid"];
// $pwd = $_SESSION["login"]["pwd"];
// $cid = $_SESSION["login"]["cid"];

require_once "conf/constantes.conf";
require_once PROYECT_PATH . "/service/LoginService.php";
require_once PROYECT_PATH . "/service/SuscriptionService.php";

function login($login_admin=false)
{
	$loginService = new LoginService();

	if ($login_admin)
	{
		$user = USER;
		$pass = PASS;

		$res = $loginService->acceder($user, md5($pass));
		
		if ($res["success"])
		{
			$res["data"][0]["pwd"] = md5(PASS);
			return $res;
		}		
	}	
	
	return false;
}

if (isset($_GET["action"]))
{	
	$res = array();
	$loginService = new LoginService();

	switch($_GET["action"])
	{
		case "registro": 

			$data = verificar_datos($_POST, 
				array("username", "email", "password"));

			if (!$data)
			{
				$res = array("success"=>false, 
						"data"=>array(								
							"description" => "Todos los datos son requeridos"
							));
			}
			else
			{	
				// $res = login();#$loginService->acceder(USER, md5(PASS));

				if ($res = login(1))
				{
					// var_dump(login(1));
					$usuario_id = $res["data"][0]["id"];
					$usuario_pwd = $res["data"][0]["pwd"];
					// $_SESSION["login"] = array(
					// 	"uid"=>$usuario_id,
					// 	"pwd"=>md5(PASS));
					$data["app"] = "EACCOUNT";
					$suscriptionService = new SuscriptionService($usuario_id, $usuario_pwd);
					$res = $suscriptionService->registrar_suscripcion($data);	
					$suscriptionService = NULL;			
				}
			}			
				// $res = registrar($_POST, $suscriptionService);

							
		break;

		case "activacion": 			
		
			$suscriptionService = new SuscriptionService(USER_ID, md5(PASS));

			if (!verificar_datos($_GET, array("fk")))
			{
				$res = array("success"=>false,
						"data" => array(
							"description" => "No hay ningun registro previo")
						);
			}
			else
			{
				$res = $suscriptionService->confirmar_suscripcion($_GET["fk"]);					
				$suscriptionService = NULL;
			}
			
			
		break;

		case "compra":

			if (!isset($_SESSION["login"]))
			{
				$res = array(
					"success"=>false, 
					"data"=>array(
						"description"=>"Datos de Acceso Incorrectos"));				
			}
			else
			{
				$uid = $_SESSION["login"]["uid"];
				$pwd = $_SESSION["login"]["pwd"];
				$cid = $_SESSION["login"]["cid"]; 			

				$suscriptionService = new SuscriptionService($uid, $pwd);

				if (!verificar_datos($_GET, array("plan", "period")))
				{
					$res = array("success"=>false,
							"data" => array(
								"description" => "Ocurrio un error al verificar los datos de la compra.")
						);
				}
				else
				{
						// $partner_id = $_GET["ptr"];
					$params = array(
						"application" => "EACCOUNT",
						"period" => $_GET["period"], 					
						"plan_id" => $_GET["plan"]);
							// "suscription_id" => $_GET["key"]); 
						
					if (isset($_GET["discount"]))
						$params["discount_id"] = array($_GET["discount"]);

					$res = $suscriptionService->comprar_plan($params);								
						// $res = $suscriptionService->comprar_plan($params, $partner_id);					
				}
			}

		break;
	}

	echo json_encode($res);
}

else if(isset($_GET["get"]))
{		
	$suscriptionService = new SuscriptionService(USER_ID, md5(PASS));

	switch($_GET["get"])
	{
		case "descuentos": 				
			$res = $suscriptionService->obtener_descuentos();
		break;
		case "planes":
			$res = $suscriptionService->obtener_planes_suscription("EACCOUNT");
		break;
	}

	echo json_encode($res);	
}

// else
// {	
	// echo json_encode($_SESSION["login"]); exit();		
	// session_destroy();

	// if (isset($_GET["uid"]) && isset($_GET["pwd"]))
	// {
	// 	// echo "XD";
	// 	$usuario_id = $_GET["uid"];
	// 	$usuario_pw = $_GET["pwd"];
		
	// 	$suscService = new SuscriptionService($usuario_id, $usuario_pw);
	// 	$res = $suscService->obtener_planes_suscription();
	// 	echo json_encode($res);	
	// }

	// echo "LOL";
	

// }
// }
// else
// {
// 	echo json_encode(array(
// 		"success"=>false, 
// 		"data"=>array(
// 			"description"=>"No hay sesion activa")
// 		));
// }

?>