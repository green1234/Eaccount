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

	function obtener_cuentas()
	{
		$empresa_id = 1;
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

	function obtener_polizas()
	{
		$move_model = "account.move";
		$move_line_model = "account.move.line";

		$empresa_id = 1;
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

					$domain = array(
						array(
							model("move_id", "string"),
							model("=", "string"),
							model($move_line["id"], "int"),
							));

					$line_move_ids = $this->obj->search($this->uid, $this->pwd, $move_line_model, $domain);

					$params = array(
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

					$line_moves = $this->obj->read($this->uid, $this->pwd, $move_line_model, $line_move_ids["data"]["id"], $params);
					
					/*logg($line_move_ids["data"]["id"], 1);*/


					if ($line_moves["success"])
						$res["data"][$index]["lines"] = $line_moves["data"];
				}

				logg($res["data"][0]["lines"],1);
			} 
		}
		/*logg($res,1);*/
		return $res;

		logg($res["data"],1);
	}
}

?>