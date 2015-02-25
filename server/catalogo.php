<?php
session_start();
require_once "conf/constantes.conf";
require_once PROYECT_PATH . "/service/AccountTplService.php";

if (isset($_SESSION["login"]))
{
	if(count($_FILES) > 0)
	{		
		$uid = $_SESSION["login"]["uid"];
		$pwd = $_SESSION["login"]["pwd"];
		$cid = $_SESSION["login"]["cid"][0];
		$cname = $_SESSION["login"]["cid"][1];

		$uploaddir = PROYECT_PATH . '/tmp/';
		$uploadfile = $uploaddir . basename($_FILES['userfile']['name']);

		if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {			
			$service = new AccountTplService($uid, $pwd, $cid);
			$response = $service->crear_catalogo_template($cname, $uploadfile);		
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
	else
	{
		echo json_encode(array(
			"success"=>false, 
			"data"=>array(
				"description"=>"No se recibieron datos")
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