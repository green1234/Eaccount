<?php
session_start();	
require_once "conf/constantes.conf";
require_once PROYECT_PATH . "/service/AccountService.php";

if (isset($_SESSION["login"]))
{
	$uid = $_SESSION["login"]["uid"];
	$cid = $_SESSION["login"]["cid"];
	$pwd = $_SESSION["login"]["pwd"];

	$res = array();

	if (isset($_GET["action"]))
	{
		if ($_GET["action"] == "get")
		{
			$service = new AccountService($uid, $pwd);
			$res = $service->obtener_cuentas($cid[0]);

			if ($res["success"])
			{
				$cuentas = array();
				foreach ($res["data"] as $index => $cta) {
					$cuentas[$cta["id"]] = $cta;
				}
				$res["data"] = $cuentas;
			}
			else
			{
				$res = array(
					"success"=>false, 
					"data"=>array(
						"description" => "No se encontraron datos"));
			}
		}
	}

	echo json_encode($res);
}
else
{
	echo json_encode(
		array(
			"success"=>false, 
			"data"=>array(
				"description" => "Datos de Acceso incorrectos")));
}

	/*$usuario = $password = "admin";	
	$service = new AccountService(1, "admin");			
	$res = $service->obtener_cuentas();	*/
	/*logg($res["data"],1);*/
	/*echo json_encode($res);	*/	
	

	

?>