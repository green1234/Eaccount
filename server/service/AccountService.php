<?php

require_once PROYECT_PATH . "/server/Main.php";
require_once PROYECT_PATH . "/service/InvoiceService.php";

class AccountService
{
	var $uid;
	var $pwd;
	var $model = "account.account";
	var $obj;	

	function __construct($uid, $pwd)
	{
		$this->uid = $uid;
		$this->pwd = $pwd;
		$this->obj = new MainObject();		
	}

	/*
	* Esta funcion sirve para copiar una poliza ya existente por medio de su folio fiscal
	* UUID, los asientos copiados se registraran en una nueva poliza pero con los montos
	* de debito en credito y viceversa.
	*/
	function generar_poliza_cp($uuid, $id_pago)
	{
		$model = "account.move";
		$method = "generar_poliza_cp";
		$data = array(
			"cfdi" => model($uuid, "int"),
			"pago" => model($id_pago, "int"),			
		);		
		$res = $this->obj->call(USER_ID, md5(PASS), $model, $method, null, $data);
		if ($res["success"])
		{
			$pid = $res["data"][0];
			$poliza = $this->obtener_datos_poliza($pid);
			return $poliza;
		}	
		return $res;
	}

	function registrar_cuenta($params, $cid)
	{
		$model = "account.account";
		$method = "registrar_nueva_cuenta";
		$data = array(
			"code" => model($params["accnew_code"], "string"),
			"name" => model($params["accnew_des"], "string"),
			"parent_id" => model($params["accnew_mayor"], "int"),
			"nature" => model($params["accnew_nature"], "string"),
			"codesat" => model($params["accnew_codesat"], "int"),
			"subcuenta" => model($params["accnew_sub"], "int"),
			"company_id" => model($cid, "int")
		);		
		//exit();
		$res = $this->obj->call(USER_ID, md5(PASS), $model, $method, null, $data);
		//return $res;
		if ($res["success"])
		{
			$values = array();

			$res["data"] = prepare_response($res["data"]);

			/*foreach ($res["data"] as $index => $value) {

				logg($value,1);

				$me = $value->me;
				if (isset($me["string"]))
				{
					$values[$index] = $me["string"];
				}
				else if (isset($me["int"]))
				{
					$values[$index] = $me["int"];	
				}
				else if (isset($me["boolean"]))
				{
					$values[$index] = $me["boolean"];	
				}
			}
			$res["data"] = $values;*/
		}
		//logg($res,1);
		return $res;
	}

	function procesar_poliza($pid)
	{
		$model = "account.move";
		$method = "procesar_poliza";
		$data = array(
			"move_id" => model($pid, "int")			
		);		
		$res = $this->obj->call(USER_ID, md5(PASS), $model, $method, null, $data);
		return $res;
	}	

	function registrar_poliza($params, $cid)
	{
		$model = "account.move";
		$method = "registrar_poliza_manual";
		$data = array(
			"date" => model($params["p_fecha"], "string"),
			"name" => model($params["p_concepto"], "string"),
			"company_id" => model($cid, "int")
			);		
		$res = $this->obj->call(USER_ID, md5(PASS), $model, $method, null, $data);
		
		return $res;
	}

	function registrar_poliza_line($params, $cid)
	{
		$model = "account.move";
		$method = "registrar_poliza_line";
		$data = array(		
			"name" => model($params["concepto"], "string"),
			"debit" => model($params["debit"], "int"),
			"credit" => model($params["credit"], "int"),
			"account_id" => model($params["cuenta"], "int"),
			"uuid" => model($params["uuid"], "string"),
			"notes" => model($params["notes"], "string"),
			"move_id" => model($params["poliza"], "int"),
			"company_id" => model($cid, "int"),
			);		
		$res = $this->obj->call(USER_ID, md5(PASS), $model, $method, null, $data);
		return $res;	
	}

	function obtener_datos_poliza($pid)
	{
		$model = "account.move";
		$polizas_id = array($pid);
			
		$params = array(
			model("name", "string"),
			model("state", "string"),
			model("ref", "string"),
			model("journal_id", "string"),
			model("period_id", "string"),
			model("date", "string"),
			model("partner_id", "string"),						
			model("gl_journal_type", "string"),
			model("gl_ban", "string"),
			model("gl_cta", "string"),
			model("gl_ban2", "string"),
			model("gl_cta2", "string"),
			model("gl_uuid", "string"),
			model("gl_num_cheque", "string"),
			model("invoice_id", "string"),
		);				

		$res = $this->obj->read($this->uid, $this->pwd, $model, $polizas_id, $params);			
		
		$cfdi_id = $res["data"][0]["invoice_id"]; 
		if (is_array($cfdi_id))
		{
			$invoiceService = new InvoiceService(USER_ID, md5(PASS));
			$cfdi_data = $invoiceService->obtener_datos_factura($cfdi_id[0]);
			$res["data"][0]["invoice_id"] = $cfdi_data["data"][0];						
		}

		$line_moves = $this->obtener_poliza_lines($res["data"][0]["id"]);

		if ($line_moves["success"])
		{	
			$debit = 0;
			$credit = 0;
			foreach ($line_moves["data"] as $id => $line) {
				$debit = $debit + $line["debit"];
				$credit = $credit + $line["credit"];
			}
			//if ($debit == $credit)
			$res["data"][0]["lines"] = $line_moves["data"];
			$res["data"][0]["total"] = $debit;
			$res["data"][0]["currency_id"] = array(34, "MXN");

		}		
	
		return $res;
	}

	function update_poliza_line($line_id, $data)
	{
		$model = "account.move.line";
		//$method = "actualizar_poliza_line";
		$attrs = prepare_params($data);

		/*$params = array(
			"cid" => model($cid, "int"),
			"banco" => model(94, "int"),
			"cuenta" => model("755", "string"));*/

		/*$obj = new MainObject();
		$response = $obj->call(USER_ID, md5(PASS), $model, $method, null, $params);	*/

		$response = $this->obj->write(USER_ID, md5(PASS), 
			$model, array($line_id), $attrs);
		return $response;	
	}

	function obtener_sat_ids()
	{
		$tipo = array(
				model("tipo", "string"),
				model("=", "string"),
				model("account", "string"),
			);

		$model = "gl.cat.sat";
		$domain = array($tipo);	
		$res = $this->obj->search($this->uid, $this->pwd, $model, $domain);

		if ($res["success"])
		{
			$sat_ids = $res["data"]["id"];
			//return $sat_ids;
			if (count($sat_ids) > 0)
			{
				$params = array(
					model("code","string"), 
				);

				$res = $this->obj->read($this->uid, $this->pwd, $model, $sat_ids, $params);
				if ($res["success"])
				{
					// Genero array asociativo de Ids con Code SAT.
					$codes = array();
					foreach ($res["data"] as $idx => $sat) {
						$codes[$sat["code"]] = $sat["id"];
					}
					$res["data"] = $codes;
				}
				return $res;
			}
		}

		return array(
			"success" => false, 
			"data" => array(
				"id" => 0,
				"description" => "No se encontraron datos"));
	}

	// Devuelve el Id de un codigo SAT a partir de su codigo.
	function obtener_codesat_id($codesat)
	{		
		$name = array(
				model("code", "string"),
				model("=", "string"),
				model($codesat, "string"),
			);

		$tipo = array(
				model("tipo", "string"),
				model("=", "string"),
				model("account", "string"),
			);

		$model = "gl.cat.sat";
		$domain = array($name, $tipo);
		//$domain = array($name);
		//$domain = array($tipo);
		$res = $this->obj->search($this->uid, $this->pwd, $model, $domain);
		
		if ($res["success"])
		{
			$sat_ids = $res["data"]["id"];

			if (count($sat_ids) > 0)
			{
				return array(
					"success" => true, 
					"data" => array(
						"id" => $sat_ids[0],
						"description" => "No se encontraron datos"));
			}
		}

		return array(
			"success" => false, 
			"data" => array(
				"id" => 0,
				"description" => "No se encontraron datos"));
	}

	/*DEVUELVE LAS SUB CTAS DE UN PADRE EN ESPECIFICO*/
	function obtener_sub_cuentas($parent_id)
	{
		//return "LOL";
		$domain = array(					
					array(
						model("type", "string"),
						model("!=", "string"),
						model("view", "string"),
						),
					array(
						model("parent_id", "string"),
						model("=", "string"),
						model(intval($parent_id), "int"),
						));

		$res = $this->obj->search($this->uid, $this->pwd, $this->model, $domain);
		/*logg($res,1);*/
		if ($res["success"])
		{
			$account_ids = $res["data"]["id"];
			#logg($facturas_id, 1);
			if (count($account_ids) > 0)
			{
				$params = array(
						model("name", "string"),
						model("code", "string"),
						model("codagrup", "string"),
						model("level", "string"),
						model("nature", "string"),
						model("parent_id", "string"),
						model("type", "string"),						
						model("user_type", "string"),
						model("reconcile", "string"),										
					);

				$res = $this->obj->read($this->uid, $this->pwd, $this->model, $account_ids, $params);
				
				/*logg($res["data"],1);*/
			} 
		}
		/*logg($res,1);*/
		return $res;
	}

	/* Devuelve Cuentas de la empresa*/
	function obtener_all_cuentas($empresa_id, $offset, $limit)
	{		
		$domain = array(
					array(
						model("company_id", "string"),
						model("=", "string"),
						model($empresa_id, "int"),
						),
					array(
						model("default", "string"),
						model("=", "string"),
						model(false, "boolean"),
						),				
					array(
						model("parent_id", "string"),
						model("!=", "string"),
						model(false, "boolean"),
						));

		$res = $this->obj->search($this->uid, $this->pwd, $this->model, $domain, $offset, $limit);
		//logg($res,1);
		if ($res["success"])
		{
			$account_ids = $res["data"]["id"];
			#logg($facturas_id, 1);
			if (count($account_ids) > 0)
			{
				$params = array(
						model("name", "string"),
						model("code", "string"),
						model("codagrup", "string"),
						model("level", "string"),
						model("nature", "string"),
						model("parent_id", "string"),
						model("type", "string"),						
						model("user_type", "string"),
						model("reconcile", "string"),										
					);

				$res = $this->obj->read($this->uid, $this->pwd, $this->model, $account_ids, $params);
				
				/*logg($res["data"],1);*/
			} 
		}
		/*logg($res,1);*/
		return $res;
	}

	/* Devuelve Cuentas de la empresa*/
	function obtener_cuentas($empresa_id)
	{		
		$domain = array(
					array(
						model("company_id", "string"),
						model("=", "string"),
						model($empresa_id, "int"),
						),
					array(
						model("type", "string"),
						model("=", "string"),
						model("view", "string"),
						),
					array(
						model("parent_id", "string"),
						model("!=", "string"),
						model(false, "boolean"),
						));

		$res = $this->obj->search($this->uid, $this->pwd, $this->model, $domain);
		/*logg($res,1);*/
		if ($res["success"])
		{
			$account_ids = $res["data"]["id"];
			#logg($facturas_id, 1);
			if (count($account_ids) > 0)
			{
				$params = array(
						model("name", "string"),
						model("code", "string"),
						model("codagrup", "string"),
						model("level", "string"),
						model("nature", "string"),
						model("parent_id", "string"),
						model("type", "string"),						
						model("user_type", "string"),
						model("reconcile", "string"),										
					);

				$res = $this->obj->read($this->uid, $this->pwd, $this->model, $account_ids, $params);
				
				/*logg($res["data"],1);*/
			} 
		}
		/*logg($res,1);*/
		return $res;
	}
	/*Devuelve Sub Ctas de la empresa*/
	function obtener_subcuentas($empresa_id)
	{		
		$domain = array(
					array(
						model("company_id", "string"),
						model("=", "string"),
						model($empresa_id, "int"),
						),
					array(
						model("type", "string"),
						model("!=", "string"),
						model("view", "string"),
						)
					);

		$res = $this->obj->search($this->uid, $this->pwd, $this->model, $domain);
		/*logg($res,1);*/
		if ($res["success"])
		{
			$account_ids = $res["data"]["id"];
			#logg($facturas_id, 1);
			if (count($account_ids) > 0)
			{
				$params = array(
						model("name", "string"),
						model("code", "string"),
						model("codagrup", "string"),
						model("level", "string"),
						model("nature", "string"),
						model("parent_id", "string"),
						model("type", "string"),						
						model("user_type", "string"),
						model("reconcile", "string"),										
					);

				$res = $this->obj->read($this->uid, $this->pwd, $this->model, $account_ids, $params);
				
				/*logg($res["data"],1);*/
			} 
		}
		/*logg($res,1);*/
		return $res;
	}

	function leer_poliza_lines($line_move_ids)
	{
		$model = "account.move.line";
		$params = array(
			model("account_id", "string"),
			model("statement_id", "string"),
			model("journal_id", "string"),
			model("currency_id", "string"),
			model("partner_id", "string"),
			model("credit", "string"),
			model("debit", "string"),
			model("tax_code_id", "string"),
			model("state", "string"),
			model("ref", "string"),
			model("date", "string"),
			model("name", "string"),
			model("move_id", "string"),
			model("tax_amount", "string"),
			model("product_id", "string"),
			model("account_tax_id", "string"),
			model("product_uom_id", "string"),
			model("amount_currency", "string"),
			model("quantity", "string"),
			model("amount_base", "string"),
			model("tax_id_secondary", "string"),
			model("tax_id", "string"),
			model("tax_voucher_id", "string"),
		);

		$res = $this->obj->read($this->uid, $this->pwd, $model, $line_move_ids, $params);
		
		return $res;
	}

	function obtener_poliza_lines($poliza_id)
	{
		$model = "account.move.line";
		$domain = array(
					array(
						model("move_id", "string"),
						model("=", "string"),
						model($poliza_id, "int"),
						));

		$res = $this->obj->search($this->uid, $this->pwd, $model, $domain);

		if ($res["success"])
		{
			$res = $this->leer_poliza_lines($res["data"]["id"]);			
			return $res;			
		}	

		return array("success"=>false);

	}

	function obtener_poliza($cfdi)
	{
		$move_model = "account.move";
		$move_line_model = "account.move.line";
		
		$domain = array(
					array(
						model("invoice_id", "string"),
						model("=", "string"),
						model($cfdi, "int"),
						));		

		$res = $this->obj->search($this->uid, $this->pwd, $move_model, $domain);

		if ($res["success"] && count($res["data"]["id"]) > 0)
		{
			$acc_move_ids = $res["data"]["id"];			
			
			$params = array(
				model("name", "string"),
				model("state", "string"),
				model("ref", "string"),
				model("journal_id", "string"),
				model("period_id", "string"),
				model("date", "string"),
				model("partner_id", "string"),						
				model("gl_journal_type", "string"),
				model("gl_ban", "string"),
				model("gl_cta", "string"),
				model("gl_ban2", "string"),
				model("gl_cta2", "string"),
				model("gl_num_cheque", "string"),				
			);

			$res = $this->obj->read($this->uid, $this->pwd, $move_model, $acc_move_ids, $params);

			foreach ($res["data"] as $index => $move_line) {				
				
				$invoiceService = new InvoiceService(USER_ID, md5(PASS));
				$cfdi_data = $invoiceService->obtener_datos_factura($cfdi);
				$res["data"][$index]["invoice_id"] = $cfdi_data["data"][0];		

				$line_moves = $this->obtener_poliza_lines($move_line["id"]);					

				if ($line_moves["success"])
				{				
					$debit = 0;
					$credit = 0;
					foreach ($line_moves["data"] as $id => $line) 
					{
						$debit = $debit + $line["debit"];
						$credit = $credit + $line["credit"];
					}
					$res["data"][$index]["total"] = $debit;
					$res["data"][$index]["lines"] = $line_moves["data"];
					//$res["data"][$index]["lines"]["uuid"] = $cfdi_data["data"][0]["uuid"];
				}
			}
			return $res;
		}
		
		return array("success" => false, "data" => array("description" => "No se encontraron datos."));		
	}

	function obtener_polizas($empresa_id, $type = "all")
	{
		$move_model = "account.move";
		$move_line_model = "account.move.line";

		//$empresa_id = 1;
		$domain = array(
					array(
						model("company_id", "string"),
						model("=", "string"),
						model($empresa_id, "int"),
						));
		if ($type != "all")
		{			
			$domain[] = array(
							model("tipo_poliza", "string"),
							model("=", "string"),
							model($type, "string"),
						);
		}

		$res = $this->obj->search($this->uid, $this->pwd, $move_model, $domain);

		if ($res["success"] && count($res["data"]["id"]) > 0)
		{
			$acc_move_ids = $res["data"]["id"];
			#logg($facturas_id, 1);
			if (count($acc_move_ids) > 0)
			{
				$params = array(
						model("name", "string"),
						model("state", "string"),
						model("ref", "string"),
						model("journal_id", "string"),
						model("period_id", "string"),
						model("date", "string"),
						model("partner_id", "string"),						
						model("gl_journal_type", "string"),
						model("gl_ban", "string"),
						model("gl_cta", "string"),
						model("gl_ban2", "string"),
						model("gl_cta2", "string"),
						model("gl_num_cheque", "string"),
						model("invoice_id", "string"),
					);

				$res = $this->obj->read($this->uid, $this->pwd, $move_model, $acc_move_ids, $params);

				foreach ($res["data"] as $index => $move_line) {

					/*$domain = array(
						array(
							model("move_id", "string"),
							model("=", "string"),
							model($move_line["id"], "int"),							));*/
					
					if (is_array($cfdi_id))
					{
						$invoiceService = new InvoiceService(USER_ID, md5(PASS));
						$cfdi_data = $invoiceService->obtener_datos_factura($cfdi_id[0]);
						$res["data"][$index]["invoice_id"] = $cfdi_data["data"][0];						
					}

					//$line_move_ids = $this->obj->search($this->uid, $this->pwd, $move_line_model, $domain);
					$line_moves = $this->obtener_poliza_lines($move_line["id"]);
					//$line_moves = $this->leer_poliza_lines($line_move_ids);

					/*$params = array(
						model("statement_id", "string"),
						model("journal_id", "string"),
						model("currency_id", "string"),
						model("partner_id", "string"),
						model("credit", "string"),
						model("debit", "string"),
						model("tax_code_id", "string"),
						model("state", "string"),
						model("ref", "string"),
						model("date", "string"),
						model("name", "string"),
						model("tax_amount", "string"),
						model("product_id", "string"),
						model("account_tax_id", "string"),
						model("product_uom_id", "string"),
						model("amount_currency", "string"),
						model("quantity", "string"),
						model("amount_base", "string"),
						model("tax_id_secondary", "string"),
						model("tax_id", "string"),
						model("tax_voucher_id", "string"),
					);

					$line_moves = $this->obj->read($this->uid, $this->pwd, $move_line_model, $line_move_ids["data"]["id"], $params);*/
					
					/*logg($line_move_ids["data"]["id"], 1);*/

					if ($line_moves["success"])
					{
						//$res["data"][$index]["lines"] = $line_moves["data"];
						$debit = 0;
						$credit = 0;
						foreach ($line_moves["data"] as $id => $line) {
							$debit = $debit + $line["debit"];
							$credit = $credit + $line["credit"];
						}
						//if ($debit == $credit)
						$res["data"][$index]["total"] = $debit;
					}
				}

				//logg($res["data"][0]["lines"],1);
			} 

			return $res;
		}
		/*logg($res,1);*/
		return array("success" => false, "data" => array("description" => "No se encontraron datos."));

		//logg($res["data"],1);
	}
}

?>