<?php
session_start();	
require_once "conf/constantes.conf";
require_once PROYECT_PATH . "/service/AccountService.php";

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

	$res = array();

	if (isset($_GET["action"]))
	{
		$service = new AccountService($uid, $pwd);

		if ($_GET["action"] == "add")
		{
			$keys = array(
				"accnew_code", 
				"accnew_des", 
				"accnew_mayor",
				"accnew_sub", 
				"accnew_nature", 
				"accnew_codesat");

			$data = verificar_datos($_GET, $keys);
			//$res = $data;
			if ($data)
			{
				$res = $service->registrar_cuenta($data, $cid[0]);
			}
			else
				$res = get_error();
		}
		else if ($_GET["action"] == "get")
		{
			if (isset($_GET["parent_id"]))
			{
				$res = $service->obtener_sub_cuentas($_GET["parent_id"]);				
/*
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
				}*/
			}
			else
			{
				$res = $service->obtener_cuentas($cid[0]);
				$res2 = $service->obtener_subcuentas($cid[0]);

				if ($res["success"]/* && $res2["success"]*/)
				{
					$cuentas = array();
					foreach ($res["data"] as $index => $cta) {
						$cuentas[$cta["id"]] = $cta;
					}
					$res["data"] = array("mayor" => $cuentas);

					$subcuentas = array();
					foreach ($res2["data"] as $index => $cta) {
						$subcuentas[$cta["id"]] = $cta;
					}
					$res["data"]["subctas"] = $subcuentas;
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