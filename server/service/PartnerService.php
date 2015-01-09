<?php

require_once PROYECT_PATH . "/server/Main.php";
require_once PROYECT_PATH . "/service/InvoiceService.php";
require_once PROYECT_PATH . "/service/PaymentService.php";


class PartnerService
{
	var $uid;
	var $pwd;
	var $model = "res.partner";
	var $obj;	

	function __construct($uid, $pwd)
	{
		$this->uid = $uid;
		$this->pwd = $pwd;
		$this->obj = new MainObject();		
	}

	function obtener_datos_partner($partner_id, $fiscales=false)
	{
		$model = $this->model;
		$ids = array($partner_id);

		$params = array(
				model("name", "string"),
				model("email", "string"),
				model("phone", "string"),
				model("mobile", "string"),			
		);

		if ($fiscales)
		{
			$params[] = model("vat", "string");
			$params[] = model("gl_razon_social", "string");
		}

		$res = $this->obj->read($this->uid, $this->pwd, $model, $ids, $params);	
		
		return $res;
	}

	function obtener_partner($type)
	{
		$empresa_id = 1;

		switch($type){
			case "clientes" : 
				$cus = true;
				$sup = false;

				$tipo = array(
					model("customer", "string"),
					model("=", "string"),
					model($cus, "boolean"),
					);

				break;
			case "proveedores" :
				$cus = false;
				$sup = true; 

				$tipo = array(
					model("supplier", "string"),
					model("=", "string"),
					model($sup, "boolean"),
					);
				break;
			default: 
				return array("success" => false, "data" => array(
						"id" => "",
						"description" => "La opcion seleccionada no esta registrada",
					));
				break;
		}

		$domain = array(
					array(
						model("company_id", "string"),
						model("=", "string"),
						model($empresa_id, "int"),
						), $tipo);

		$res = $this->obj->search($this->uid, $this->pwd, $this->model, $domain);
			#logg($res,1);
		if ($res["success"])
		{
			$partner_ids = $res["data"]["id"];
			#logg($facturas_id, 1);
			if (count($partner_ids) > 0)
			{
				$params = array(
						model("name", "string"),
						model("vat", "string"),
						model("gl_razon_social", "string"),
						model("type", "string"),
						model("street", "string"),
						model("street2", "string"),
						model("gl_no_ext", "string"),						
						model("gl_no_int", "string"),
						model("city", "string"),					
						model("zip", "string"),
						model("state_id", "string"),
						model("country_id", "string"),
						model("email", "string"),
						model("phone", "string"),
						model("mobile", "string"),
					);

				$res = $this->obj->read($this->uid, $this->pwd, $this->model, $partner_ids, $params);
				if ($res["success"])
				{

					$invoiceService = new InvoiceService($this->uid, $this->pwd);
					$paymentService = new PaymentService($this->uid, $this->pwd);

					foreach ($res["data"] as $index => $partner) {
						
						$facturas = $invoiceService->obtener_facturas($partner["id"]);
						// logg("Facturas");
						// logg($facturas);

						if ($facturas["success"])
							$res["data"][$index]["facturas"] = $facturas["data"];
						else 
							$res["data"][$index]["facturas"] = array();

						$pagos = $paymentService->obtener_pagos($partner["id"]);						

						// logg("Pagos");
						// logg($pagos);

						if ($pagos["success"])
							$res["data"][$index]["pagos"] = $pagos["data"];
						else
							$res["data"][$index]["pagos"] = array();
					}

					return $res;
				}

				/*logg($res["data"],1);*/
			} 
		}
		/*logg($res,1);*/
		return array("success"=>false);
	}
}

?>