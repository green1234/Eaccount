<?php

require_once "conf/constantes.conf";
require_once PROYECT_PATH . "/service/LoginService.php";
require_once PROYECT_PATH . "/service/SuscriptionService.php";

$usuario_name = "admin";
$usuario_pw = "admin";
$usuario_id = 0;

$loginService = new LoginService();
$res = $loginService->acceder($usuario_name, $usuario_pw);

if ($res["success"])
{
	$usuario_id = $res["data"][0]["id"];

	$suscService = new SuscriptionService($usuario_id, $usuario_pw);

	$res = $suscService->obtener_planes();
	// logg($res,1);
	if ($res["success"])
	{
		echo json_encode($res);
		// logg($res["data"],1);
		// logg(utf8_decode($res["data"][0]["description"]),1);
	}
	else
	{
		echo json_encode(array("success"=>false));
	}

}
else
{
	echo json_encode(array("success"=>false));
}
// logg($res,1);
// echo json_encode($res);

?>