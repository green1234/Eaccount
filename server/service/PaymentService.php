<?php

require_once PROYECT_PATH . "/server/Main.php";

class PaymentService
{
	var $uid;
	var $pwd;
	var $model = "account.voucher";
	var $obj;

	function __construct($uid, $pwd)
	{
		$this->uid = $uid;
		$this->pwd = $pwd;
		$this->obj = new MainObject();
	}

	function obtener_bancos()
	{
		$model = "res.bank";
		$domain = array();
		$res = $this->obj->search($this->uid, $this->pwd, $model, $domain);

		if ($res["success"])
		{
			$ids = $res["data"]["id"];
			if (count($ids)>0)
			{
				$params = array(
						model("name", "string"),
						model("bic", "string"));

				$res = $this->obj->read($this->uid, $this->pwd, $model, $ids, $params);
				$bancos = array();
				if ($res["success"])
				{
					foreach ($res["data"] as $index => $banco) {
						$id = $banco["id"];
						$bancos[$id] = $banco;
					}
					$res["data"] = $bancos;
					return $res;
				}
			}
		}

		return array(
			"success"=>false, 
			"data"=>array(
				"description" => "No se encontraron registros"));
	}

	function obtener_pagos($partner_id = 0)
	{		
		$model = $this->model;
		$empresa_id = 1;
		$domain = array();
		
		$filter_company = array(
			model("company_id", "string"),
			model("=", "string"),
			model($empresa_id, "int"),
		);
		$domain[] = $filter_company;
		#logg($partner_id);
		if ($partner_id != 0)
		{
			$filter_partner = array(
				model("partner_id", "string"),
				model("=", "string"),
				model($partner_id, "int"),
			);

			$domain[] = $filter_partner;	
			#logg($domain,1);		
		}
		#$domain = array();
		#logg($domain);
		$res = $this->obj->search($this->uid, $this->pwd, $model, $domain);
		// logg($res["data"]);
		if ($res["success"])
		{
			$payments_id = $res["data"]["id"];
			
			if (count($payments_id) > 0)
			{
				$params = array(
						model("type", "string"),
						model("number", "string"),
						model("reference", "string"),
						model("name", "string"),
						model("date", "string"),
						model("journal_id", "string"),
						model("account_id", "string"),
						model("period_id", "string"),
						model("amount", "string"),
						model("gl_payment_form", "string"),
						model("gl_ban_origen", "string"),
						model("gl_ban_destino", "string"),
						model("gl_cta_origen", "string"),
						model("gl_cta_destino", "string"),
						model("gl_num_cheque", "string"),
						model("state", "string")
					);

				$res = $this->obj->read($this->uid, $this->pwd, $model, $payments_id, $params);
				if($res["success"])
					return $res;
			} 
		}

		return array("success"=>false);
	}
	
}

?>