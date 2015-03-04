<?php
	
	require_once "conf/constantes.conf";
	require_once PROYECT_PATH . "/service/PaymentService.php";

	if (isset($_GET["uid"]) && isset($_GET["pwd"]) && isset($_GET["action"]))
	{	
		$uid = $_GET["uid"];
		$pwd = $_GET["pwd"];		
		
		$service = new PaymentService($uid, $pwd);		
		
		$action = $_GET["action"];			

		switch ($action) {
			case 'bancos':					
				$res = $service->obtener_bancos();
				echo json_encode($res);
				break;
			
			default:
				# code...
				break;
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

	//echo json_encode("LOL");

	


?>