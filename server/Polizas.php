<?php
	
	require_once "conf/constantes.conf";
	require_once PROYECT_PATH . "/service/AccountService.php";

	$usuario = $password = "admin";	
	$service = new AccountService(1, "admin");			
	$res = $service->obtener_polizas();	
	/*logg($res["data"],1);*/
	echo json_encode($res);		
	

	

?>