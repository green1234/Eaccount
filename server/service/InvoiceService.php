<?php

require_once PROYECT_PATH . "/server/Main.php";

class InvoiceService
{
	var $uid;
	var $pwd;
	var $model = "invoice.import";
	var $obj;

	function __construct($uid, $pwd)
	{
		$this->uid = $uid;
		$this->pwd = $pwd;
		$this->obj = new MainObject();
	}

	function leer_facturas_lines($line_ids)	
	{
		$model = "invoice.import.line";
		$params = array(							
					model("name", "string"),
					model("price_unit", "string"),
					model("account_expense_income", "string"),
					model("price_subtotal", "string"),
					model("discount", "string"),
					model("product_uom_id", "string"),
					model("quantity", "string"),
					model("product_id", "string"),
					
				);		
		$res = $this->obj->read($this->uid, $this->pwd, $model, $line_ids, $params);
		return $res;		
	}

	function obtener_facturas_lines($factura_id)	
	{
		$model = "invoice.import.line";
		$domain = array(
					array(
						model("invoice_id", "string"),
						model("=", "string"),
						model($factura_id, "int"),
					));

		$res = $this->obj->search($this->uid, $this->pwd, $model, $domain);
		//return $res;
		if ($res["success"])
		{
			$res = $this->leer_facturas_lines($res["data"]["id"]);
			return $res;			
		}	

		return array("success"=>false);
	}

	function obtener_datos_factura($cfdi)
	{
		$model = "invoice.import";
			//$model = "account.invoice";
		$domain = array();
		$domain[] = array(
			model("id", "string"),
			model("=", "string"),
			model($cfdi, "int"),
		);

		$res = $this->obj->search($this->uid, $this->pwd, $model, $domain);
			#logg($res, 1);
		if ($res["success"])
		{
			$facturas_id = $res["data"]["id"];
			#logg($facturas_id, 1);
			if (count($facturas_id) > 0)
			{
				$params = array(
					model("partner_id", "string"),
					model("date_invoice", "string"),
					model("currency_id", "string"),
					model("amount_tax", "string"),
					model("amount_untaxed", "string"),
					model("amount_total", "string"),
					model("type", "string"),					
					model("state", "string"),
					model("folio", "string"),
					model("serie", "string"),
					model("discount", "string"),
					model("uuid", "string"),
					model("state", "string"),
					model("error_sat", "string"),
					model("amount_untaxed", "string"),
					model("pgo_fecha", "string"),
					model("pgo_metodo", "string"),
					model("pgo_banorigen", "string"),
					model("pgo_ctaorigen", "string"),
					model("pgo_ctadestino", "string"),
					model("pgo_transaccion", "string"),
					model("pgo_fechacheque", "string"),
					model("pgo_nocheque", "string"),
					model("error_sat", "string")
				);				

				$res = $this->obj->read($this->uid, $this->pwd, $model, $facturas_id, $params);				
				$res["data"][0]["currency_id"] = array(1, "MXN");
				
				$line_facturas = $this->obtener_facturas_lines($res["data"][0]["id"]);
				//return $line_facturas;		
				if ($line_facturas["success"])
					$res["data"][0]["lines"] = $line_facturas["data"];
			}
		}

		return $res;		
	}

	function obtener_facturas($params)
	{		
		if (isset($params["cid"]))
		{
			$model = "invoice.import";
			//$model = "account.invoice";
			$domain = array();
			$domain[] = array(
				model("company_id", "string"),
				model("=", "string"),
				model($params["cid"], "int"),
			);

			if (isset($params["partner_id"]))
			{
				$domain[] = array(
					model("partner_id", "string"),
					model("=", "string"),
					model($params["partner_id"], "int"),
				);
			}

			if (isset($params["estatus"]))
			{
				$domain[] = array(
					model("savvy_estatus", "string"),
					model("=", "string"),
					model($params["estatus"], "string"),
				);
			}

			if (isset($params["type"]))
			{				
				if ($params["type"] == "sale")
				{
					$domain[] = array(
						model("type", "string"),
						model("=", "string"),
						model("out_invoice", "string"),
					);					
				}
				else if ($params["type"] == "purchase")
				{
					$domain[] = array(
						model("type", "string"),
						model("=", "string"),
						model("in_invoice", "string"),
					);	
				}				
			}			

			//logg($domain);

			/*$empresa_id = 1;*/
			/*$domain = array(
						array(
							model("company_id", "string"),
							model("=", "string"),
							model($company_id, "int"),
							));

			if ($partner_id != 0)
			{
				$filter_partner = array(
					model("partner_id", "string"),
					model("=", "string"),
					model($partner_id, "int"),
				);

				$domain[] = $filter_partner;	
				#logg($domain,1);		
			}*/

			$res = $this->obj->search($this->uid, $this->pwd, $model, $domain);
			#logg($res, 1);
			if ($res["success"])
			{
				$facturas_id = $res["data"]["id"];
				#logg($facturas_id, 1);
				if (count($facturas_id) > 0)
				{
					$params = array(
							model("partner_id", "string"),
							model("date_invoice", "string"),
							model("currency_id", "string"),
							model("amount_tax", "string"),
							model("amount_untaxed", "string"),
							model("amount_total", "string"),
							model("type", "string"),					
							model("state", "string"),
							model("folio", "string"),
							model("serie", "string"),
							model("discount", "string"),
							model("uuid", "string"),
							model("state", "string"),
							model("error_sat", "string"),
							model("amount_untaxed", "string"),
							model("pgo_fecha", "string"),
							model("pgo_metodo", "string"),
							model("pgo_banorigen", "string"),
							model("pgo_ctaorigen", "string"),
							model("pgo_ctadestino", "string"),
							model("pgo_transaccion", "string"),
							model("pgo_fechacheque", "string"),
							model("pgo_nocheque", "string"),
							model("error_sat", "string"),
							model("savvy_estatus", "string"),
						);

					$res = $this->obj->read($this->uid, $this->pwd, $model, $facturas_id, $params);
					/*$model = "account.invoice.line";
					$model = "invoice.import.line";*/

					foreach ($res["data"] as $idx => $factura) {
						$res["data"][$idx]["currency_id"] = array(1, "MXN");
						
						/*$domain = array(
							array(
								model("invoice_id", "string"),
								model("=", "string"),
								model($factura["id"], "int"),
								));*/


						/*$line_facturas_id = $this->obj->search($this->uid, $this->pwd, $model, $domain);
						//return $line_facturas_id;

						$params = array(							
							model("name", "string"),
							model("price_unit", "string"),
							model("account_expense_income", "string"),
							model("price_subtotal", "string"),
							model("discount", "string"),
							model("product_uom_id", "string"),
							model("quantity", "string"),
							model("product_id", "string"),
							
						);
						$line_ids = $line_facturas_id["data"]["id"];
						$line_facturas = $this->obj->read($this->uid, $this->pwd, $model, $line_ids, $params);*/
						$line_facturas = $this->obtener_facturas_lines($factura["id"]);
						//return $line_facturas;
						//logg($line_facturas["data"], 1);
						if ($line_facturas["success"])
							$res["data"][$idx]["lines"] = $line_facturas["data"];
					}			
				} 
			}

			return $res;
		}
		else
		{
			return array(
				"success" => false, 
				"data" => array(
					"description" => "Debe indicar los datos de la empresa.")
				);
		}
	}

	// $params incluye el id de la factura y la informacion del pago.
	function registrar_infopago($id, $params){

		// $attrs = prepare_params(
		// 	array(
		// 		"user_id" => $user_id, 
		// 		"company_id" => $company_id));
		$attrs = prepare_params($params);

		$response = $this->obj->write($this->uid, $this->pwd, 
					$this->model, array($id), $attrs);		
		
		return $response;
	}

	function contabilizar($cfdi_id)
	{
		$model = "invoice.import";		
		$method = "contabilizar_factura";
		$params = array(
			"id" => model($cfdi_id, "int"));
		
		$response = $this->obj->call(USER_ID, md5(PASS), $model, $method, null, $params);

		return $response;
	}

	function importar_xml($params, $type=1){	


		$model = "invoice.import";		
		$method = "importar_cfdi";

		$filename = $params["filename"];
		$file = $params["file"];
		$cid = $params["cid"];

		$file_data = fopen($file,'rb');
		$data = fread($file_data,filesize($file));
		fclose($file_data);

		$encodedFile = base64_encode($data);  

		$params = array(
			"string_file" => model($encodedFile, "string"),
			"file" => model($file, "string"),
			"type" => model($type, "int"),
			"cid" => model($cid, "int"));
		
		$response = $this->obj->call(USER_ID, md5(PASS), $model, $method, null, $params);

		return $response;

		$filename = $params["filename"];
		$file = $params["file"];
		$cid = $params["cid"];
		
		$file_data = fopen($file,'rb');
		$data = fread($file_data,filesize($file));
		fclose($file_data);

		$encodedFile = base64_encode($data);  
		//logg($encodedFile, 1);

		$params = array(
			"string_file" => model($encodedFile, "string"),
			"file" => model($file, "string"),
			"type" => model($type, "int"),
			"cid" => model($cid, "int")
		);

		$response = $this->obj->create($this->uid, $this->pwd, $this->model, $params);

		return $response;
	}
	
}

?>