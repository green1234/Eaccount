<?php
	
	require_once "conf/constantes.conf";
	require_once PROYECT_PATH . "/service/InvoiceService.php";

	if (isset($_GET["uid"]) && isset($_GET["pwd"]) && isset($_GET["pwd"]))
	{
		$uid = $_GET["uid"];
		$pwd = $_GET["pwd"];
		$cid = $_GET["cid"];
		
		$service = new InvoiceService($uid, $pwd);
		$res = $service->obtener_facturas($cid);
		echo json_encode($res);
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