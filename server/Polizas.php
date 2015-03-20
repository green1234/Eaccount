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

//var_dump($_GET);

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
			$res = $service->obtener_datos_poliza($_GET["pid"]);

			/*if ($res["success"])
			{
				$polizas = array();
				foreach ($res["data"] as $index => $poliza) {
					$polizas[$poliza["id"]] = $poliza;
				}
				$res["data"] = $polizas;
			}
			else
				$res = get_error();*/
		}
		else if($_GET["action"] == "update" && isset($_GET["id"]))
		{
			$id = $_GET["id"];
			$data = array();
			if(isset($_GET["account_id"]))
			{
				$data["account_id"] = intval($_GET["account_id"]);
			}

			$res = $service->update_poliza_line($id, $data);

			if ($res["success"])
			{
				$res = $res;
			}
			else
				$res = get_error();
		}
		else if($_GET["action"] == "new")
		{
			$keys = array("p_concepto", "p_fecha");
			$data = verificar_datos($_GET, $keys);
			//logg($data,1);
			if ($data)
			{
				$res = $service->registrar_poliza($data, $cid[0]);
			}
			else
				$res = get_error();
		}
		else if($_GET["action"] == "newline")
		{
			$keys = array("poliza", "concepto", "cuenta", "monto", "uuid", "notas");
			$data = verificar_datos($_GET, $keys);
			if ($data)
			{
				if (isset($_GET["debit"]) && isset($_GET["monto"]))
				{
					$data["debit"] = $_GET["monto"];
					$data["credit"] = 0;
				}
				else if (isset($_GET["credit"]) && isset($_GET["monto"]))
				{
					$data["credit"] = $_GET["monto"];
					$data["debit"] = 0;
				}

				$res = $service->registrar_poliza_line($data, $cid[0]);
				unset($data["monto"]);
			}
			else
				$res = get_error();		
			
		}
		else if ($_GET["action"] == "process")
		{
			if (isset($_GET["pid"]))
				$res = $service->procesar_poliza($_GET["pid"]);
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