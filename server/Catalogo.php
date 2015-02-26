<?php
session_start();
require_once "conf/constantes.conf";
require_once PROYECT_PATH . "/service/AccountService.php";
require_once PROYECT_PATH . "/service/AccountTplService.php";
//var_dump("LOL"); exit();
if (isset($_SESSION["login"]))
{	
	$uid = $_SESSION["login"]["uid"];
	$pwd = $_SESSION["login"]["pwd"];
	$cid = $_SESSION["login"]["cid"][0];
	$cname = $_SESSION["login"]["cid"][1];

	if(count($_FILES) > 0)
	{	
		$uploaddir = PROYECT_PATH . '/tmp/';
		$uploadfile = $uploaddir . basename($_FILES['userfile']['name']);

		if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {			
			$service = new AccountTplService($uid, $pwd, $cid);
			$response = $service->crear_catalogo_template($cname, $uploadfile);		
			if ($response["success"])
			{
				$_SESSION["login"]["config"] = $cid;
			}
			echo json_encode($response);
		}
		else
		{
			echo json_encode(array(
				"success"=>false, 
				"data"=>array(
					"description"=>"Error al subir el archivo")
				));	
		}	

		//var_dump($response);
	}	
	else{

		echo json_encode(array(
			"success"=>false, 
			"data"=>array(
				"description"=>"No se recibieron datos")
			));			
	}	
}

else if (isset($_GET["uid"]) && isset($_GET["pwd"]) && isset($_GET["cid"]))
{
	$uid = $_GET["uid"];
	$pwd = $_GET["pwd"];
	$cid = $_GET["cid"];
	
	if (isset($_GET["get"])){		
		$service = new AccountService($uid, $pwd);
		$cuentas = $service->obtener_cuentas($cid);
		echo json_encode($cuentas);
	}
	else
	{
		echo json_encode(array(
			"success"=>false, 
			"data"=>array(
				"description"=>"La opcion solicitada no esta disponible.")
			));	
	}
}	

else
{
	echo json_encode(array(
		"success"=>false, 
		"data"=>array(
			"description"=>"Datos de Acceso Incorrectos")
		));	
}

?>