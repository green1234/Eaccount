<?php
$a = session_id();
if(empty($a)) session_start();

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
					
					$suscriptionService = new SuscriptionService($usuario_id, $usuario_pwd);
					$res = $suscriptionService->registrar_suscripcion($data);	
					$suscriptionService = NULL;			
				}
			}			
				// $res = registrar($_POST, $suscriptionService);

							
		break;

		case "activacion": 
			// $res = login(); #$loginService->acceder(USER, md5(PASS));
			
			if ($res = login(1))
			{				
				$usuario_id = $res["data"][0]["id"];
				$usuario_pwd = $res["data"][0]["pwd"];
			
				$suscriptionService = new SuscriptionService($usuario_id, $usuario_pwd);

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
					// echo json_encode("json"); exit();
					$suscriptionService = NULL;

					// if ($res["success"])
					// {
						// $usuario_id = $res["data"]["uid"];
						// $usuario_pwd = $res["data"]["pwd"];

						// $_SESSION["login"] = array(
						// 	"uid"=>$usuario_id,
						// 	"pwd"=>$usuario_pwd);
						// unset($res["data"]["uid"]);
						// unset($res["data"]["pwd"]);
						// echo json_encode($_SESSION["login"]);exit();
					// 	$suscriptionService = NULL;
					// }
				}
			}
			
		break;

		case "compra": 

			if (isset($_GET["uid"]) && isset($_GET["pwd"]))
			{
				$uid = $_GET["uid"];
				$pwd = $_GET["pwd"];

				// $loginService = new LoginService();
				// $res = $loginService->acceder($uid, $pwd);
				// echo "<pre>";
				// var_dump($res); 
				// echo "</pre>";
			// }
			// if ($res = login(1))
			// {	
			// 	$usuario_id = $res["data"][0]["id"];
			// 	$usuario_pwd = $res["data"][0]["pwd"];

				$suscriptionService = new SuscriptionService($uid, $pwd);

				if (!verificar_datos($_GET, array("plan", "period", "discount")))
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
						"period" => $_GET["period"], 					
						"plan_id" => $_GET["plan"], 
						"discount_id" => array($_GET["discount"]));
						// "suscription_id" => $_GET["key"]); 
					
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
	// if(isset($_GET["uid"]) && isset($_GET["pwd"]))
	// {		
	// 	$usuario_id = $_GET["uid"];
	// 	$usuario_pw = $_GET["pwd"];

	if($res = login(1))
	{		
		$usuario_id = $res["data"][0]["id"];
		$usuario_pw = $res["data"][0]["pwd"];
		$suscriptionService = new SuscriptionService($usuario_id, $usuario_pw);

		switch($_GET["get"])
		{
			case "descuentos": 				
				$res = $suscriptionService->obtener_descuentos();
			break;
			case "planes":
				$res = $suscriptionService->obtener_planes_suscription();
			break;
		}

		echo json_encode($res);
	}
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