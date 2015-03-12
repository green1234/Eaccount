<?php
	session_start();
	require_once "conf/constantes.conf";
	require_once PROYECT_PATH . "/service/InvoiceService.php";

	//if (isset($_GET["uid"]) && isset($_GET["pwd"]) && isset($_GET["cid"]))
	if (isset($_SESSION["login"]))
	{	
		/*$uid = $_GET["uid"];
		$pwd = $_GET["pwd"];
		$cid = $_GET["cid"];*/
		
		$uid = $_SESSION["login"]["uid"];
		$pwd = $_SESSION["login"]["pwd"];
		$cid = $_SESSION["login"]["cid"];

		$service = new InvoiceService($uid, $pwd);
		//$params = array("cid" => $cid);
		$params = array("cid" => $cid[0]);
		 
		if (isset($_GET["type"]))
		{
			$params["type"] = $_GET["type"];
		}	
		if (isset($_GET["estatus"]))
		{
			$params["estatus"] = $_GET["estatus"];
		}		
		
		//exit();		
		if (isset($_GET["action"]) && isset($_GET["cfdi"]))
		{
			$action = $_GET["action"];
			$id = $_GET["cfdi"];

			switch ($action) {
				case 'payment':
					$fields = array(
						"pgo_fecha",
						"pgo_metodo",
						"pgo_fechacheque",
						"pgo_nocheque",
						"pgo_ctadestino",
						"pgo_ctaorigen",
						"pgo_banorigen",
						"pgo_transaccion");

					$params = array(
						"pago_fecha",
						"pago_metodo",
						"pago_fecha_cheque",
						"pago_no_cheque",
						"pago_ctadep",
						"pago_cta",
						"pago_banco",
						"pago_trans");

					$data = array();
					foreach ($params as $index => $value) {
						if (isset($_GET[$value]))
						{
							$field = $fields[$index];
							$data[$field] = $_GET[$value];
						}
					}
					$res = $service->registrar_infopago($id, $data);
					echo json_encode($res);

					break;
				case "conta" : 					
					$res = $service->contabilizar($id);
					echo json_encode($res);
					break;
				default:
					# code...
					break;
			}
		}
		else
		{
			$res = $service->obtener_facturas($params);
			echo json_encode($res);	
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