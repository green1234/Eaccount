<?php
	
	session_start();
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
	else if ($_GET["cuentaban"] && isset($_SESSION["login"]))
	{
		$cid = $_SESSION["login"]["cid"][0];
		
		if ($_GET["cuentaban"] == "crear")
		{			
			$model = "res.company";
			$method = "registrar_cuenta_bancaria";
			$params = array(
				"cid" => model($cid, "int"),
				"cuenta" => model($_GET["cta_numero"], "string"),
				"banco" => model($_GET["cta_banco"], "int"),);

			$obj = new MainObject();
			$res = $obj->call(USER_ID, md5(PASS), $model, $method, null, $params);	
			echo json_encode($res);	
		}
	}

	

?>