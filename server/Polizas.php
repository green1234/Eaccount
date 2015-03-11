<?php
	session_start();
	require_once "conf/constantes.conf";
	require_once PROYECT_PATH . "/service/AccountService.php";

/*	$usuario = $password = "admin";	
	$service = new AccountService(1, "admin");			
	$res = $service->obtener_polizas();	*/
	/*logg($res["data"],1);*/
	/*echo json_encode($res);	*/	

function get_error()
{
	return array(
		"success"=>false, 
		"data"=>array(
				"description" => "No se encontraron datos"));
}

if (isset($_SESSION["login"]))
{
	$uid = $_SESSION["login"]["uid"];
	$cid = $_SESSION["login"]["cid"];
	$pwd = $_SESSION["login"]["pwd"];
	$service = new AccountService($uid, $pwd);

	$res = array();

	if (isset($_GET["action"]))
	{
		if ($_GET["action"] == "get")
		{
			$res = $service->obtener_polizas($cid[0]);

			if ($res["success"])
			{
				$polizas = array();
				foreach ($res["data"] as $index => $poliza) {
					$polizas[$poliza["id"]] = $poliza;
				}
				$res["data"] = $polizas;
			}
			else			
				$res = get_error();
			
		}
		else if($_GET["action"] == "lines")
		{
			$res = $service->obtener_poliza_lines($_GET["pid"]);

			if ($res["success"])
			{
				$polizas = array();
				foreach ($res["data"] as $index => $poliza) {
					$polizas[$poliza["id"]] = $poliza;
				}
				$res["data"] = $polizas;
			}
			else
				$res = get_error();
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

	

?>