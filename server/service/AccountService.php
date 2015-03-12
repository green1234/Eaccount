<?php

require_once PROYECT_PATH . "/server/Main.php";

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

	// Devuelve el Id de un codigo SAT a paartir de su codigo.
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

	function obtener_cuentas($empresa_id)
	{		
		$domain = array(
					array(
						model("company_id", "string"),
						model("=", "string"),
						model($empresa_id, "int"),
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

	function obtener_polizas($empresa_id)
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

		$res = $this->obj->search($this->uid, $this->pwd, $move_model, $domain);

		if ($res["success"])
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
					);

				$res = $this->obj->read($this->uid, $this->pwd, $move_model, $acc_move_ids, $params);

				foreach ($res["data"] as $index => $move_line) {

					/*$domain = array(
						array(
							model("move_id", "string"),
							model("=", "string"),
							model($move_line["id"], "int"),
							));*/

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
		}
		/*logg($res,1);*/
		return $res;

		//logg($res["data"],1);
	}
}

?>