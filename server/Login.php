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
	
	$_SESSION["login"] = array(
		"uid" => $res["data"][0]["id"],
		"username" => $username,
		"pwd" => $password
		);

	echo json_encode($res);
}
else
{
	echo json_encode(
		array(
			"success"=>false, 
			"data"=>array(
				"description" => "Todos los datos son necesario"
				)));
}

?>