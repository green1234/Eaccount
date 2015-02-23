<?php
	
	require_once "conf/constantes.conf";
	require_once PROYECT_PATH . "/service/InvoiceService.php";

	if (isset($_GET["uid"]) && isset($_GET["pwd"]) && isset($_GET["cid"]))
	{	
		$uid = $_GET["uid"];
		$pwd = $_GET["pwd"];
		$cid = $_GET["cid"];
		
		$service = new InvoiceService($uid, $pwd);
		$params = array("cid" => $cid);
		 
		if (isset($_GET["type"]))
		{
			$params["type"] = $_GET["type"];
		}		

		//exit();
		$res = $service->obtener_facturas($params);
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

	//echo json_encode("LOL");

	


?>