<?php
session_start();
require_once "conf/constantes.conf";
require_once PROYECT_PATH . "/service/LoginService.php";

if (isset($_GET["username"]) && isset($_GET["password"]))
{
	$username = $_GET["username"];
	$password = $_GET["password"];	
	
	$loginService = new LoginService();
	$res = $loginService->acceder($username, md5($password));
	

	if ($res["success"])
	{
		$company_name = utf8_decode($res["data"][0]["company_id"][1]);
		$res["data"][0]["company_id"][1] = $company_name;
		
		$_SESSION["login"] = array(
			"uid" => $res["data"][0]["id"],
			"cid" => $res["data"][0]["company_id"],
			"username" => $username,
			"pwd" => md5($password),
			"config" => $res["data"][0]["empresa"]["config"]
			);
	}
	else
	{
		session_destroy();
		$res = array("success"=>false, "data"=>array("description"=>"Datos de acceso Incorrectos"));
	}
	

	echo json_encode($res);
}
else
{
	echo json_encode(
		array(
			"success"=>false, 
			"data"=>array(
				"description" => "Todos los datos son necesarios"
				)));
}

?>