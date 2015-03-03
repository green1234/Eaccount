<?php
	
	require_once "conf/constantes.conf";
	require_once PROYECT_PATH . "/service/PartnerService.php";
	require_once PROYECT_PATH . "/service/InvoiceService.php";
	require_once PROYECT_PATH . "/service/PaymentService.php";

	$usuario = $password = "admin";	
	$service = new PartnerService(1, "admin");
	$invoiceService = new InvoiceService(1, "admin");
	$paymentService = new PaymentService(1, "admin");
	/*$_GET["section"] = "clientes";*/
	if (isset($_GET["section"]))
	{			
		$res = $service->obtener_partner($_GET["section"]);	
		// if ($res["success"])			
		// 	logg($res["data"],1);
		echo json_encode($res);		
	}

	

?>