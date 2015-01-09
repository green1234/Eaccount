<?php
	
	require_once "conf/constantes.conf";
	require_once PROYECT_PATH . "/service/InvoiceService.php";

	$usuario = $password = "admin";	
	$service = new InvoiceService(1, "admin");
	$res = $service->obtener_facturas();

	echo json_encode($res);

?>