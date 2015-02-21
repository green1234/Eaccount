<?php

require_once PROYECT_PATH . "/server/Main.php";
require_once PROYECT_PATH . "/service/UsuarioService.php";
require_once PROYECT_PATH . "/service/PartnerService.php";
require_once PROYECT_PATH . "/service/AccountTplService.php";

class EmpresaService
{
	var $uid;
	var $pwd;
	var $model = "res.company";
	var $obj;
	var $usuarioService;
	var $partnerService;

	function __construct($uid, $pwd)
	{
		$this->uid = $uid;
		$this->pwd = $pwd;
		$this->obj = new MainObject();
		$this->usuarioService = new UsuarioService($uid, $pwd);
		$this->partnerService = new PartnerService($uid, $pwd);

	}

	function obtener_empresa_id($empresa)
	{		
		//logg($empresa_name);
		$domain = array(
					array(
						model("name", "string"),
						model("=", "string"),
						model($empresa["name"], "string"),
						));

		$res = $this->obj->search($this->uid, $this->pwd, $this->model, $domain);
		return $res;		
	}

	function obtener_datos_empresa($empresa_id)
	{
		#return $empresa_id;		
		$ids = array($empresa_id);
		$params = array(				
				model("name", "string"),
				model("gl_razon_social", "string"),
				model("gl_regimen", "string"),
				model("gl_giro", "string"),
				model("gl_rfc", "string"),
				model("street", "string"),
				model("street2", "string"),
				model("city", "string"),
				model("state_id", "string"),
				model("country_id", "string"),
				model("zip", "string"),
				model("phone", "string"),
				model("email", "string"),
				model("gl_rlegal_name", "string"),
				model("gl_rlegal_rfc", "string"),
				model("gl_rlegal_curp", "string"),
				model("gl_rpatronal", "string"),
				model("gl_restatal", "string"),
				model("gl_curp", "string"),
				model("gl_imss", "string"),
				model("gl_acta_constitutiva", "string"),
				model("gl_cer", "string"),
				model("gl_key", "string"),
				model("gl_fiel", "string"),
		);
		$res = $this->obj->read($this->uid, $this->pwd, $this->model, $ids, $params);
		
		if ($res["success"])
		{

			$res["data"] = $res["data"][0];
			return $res;
			// $partner = $data["partner_id"];
			// $partner = $this->partnerService->obtener_datos_partner($partner[0], true);
			
			// if ($partner["success"])
			// 	$res["data"][0]["partner_id"] = $partner["data"][0];
			// logg($partner,1);
		}
	 	return $res;
		// logg($res,1);
	}

	function obtener_usuarios($empresa_id)
	{
		$model = "res.users";
		$domain = array(
					array(
						model("company_id", "string"),
						model("=", "string"),
						model($empresa_id, "int"),
						),
					array(
						model("id", "string"),
						model("!=", "string"),
						model($this->uid, "int"),
						));

		$res = $this->obj->search($this->uid, $this->pwd, $model, $domain);		
		
		if ($res["success"])
		{
			$params = array(
				model("login", "string"),
				model("password", "string"),
				#model("email", "string"),
				#model("phone", "string"),
				model("partner_id", "string"),
			);
			
			$ids = $res["data"]["id"];
			$res = $this->obj->read($this->uid, $this->pwd, $model, $ids, $params);			
			// logg($res,1);
			$result = array();
			foreach ($res["data"] as $index => $value) {		
				$partner_id = $res["data"][$index]["partner_id"][0];
				$partner = $this->partnerService->obtener_datos_partner($partner_id);				
				if ($partner["success"])
				{
					$result[$index] = $partner["data"];
					$res["data"][$index]["partner_id"] = $partner["data"][0];
				}
				unset($res["data"][$index]["groups_id"]);
			}		
			#$res["data"] = $result;
			#logg($res["data"],1);			
			return $res;	
		}
		return array("success"=>false);
	}

	function crear_empresa($params)
	{
		$keys = prepare_params($params);
		// $res = $this->obtener_empresa_id($params["name"]);

		// if ($res["success"] && count($res["data"]["id"]) > 0)
		// {			
		// 	$res["success"] = false;			
		// 	$res["data"]["description"] = "La empresa que quiere registrar ya existe";
		// 	$id = $res["data"]["id"];
		// 	$res["data"]["id"] = $id[0];			
		// 	return $res;
		// }			
		
		$res = $this->obj->create($this->uid, $this->pwd, 
			$this->model, $keys);

		if (!$res["success"]){						
			$res["data"]["description"] = "Ocurrio un error al registrar la empresa";
			return $res;
		}
		else
		{
			$empresa_id = $res["data"]["id"];
			// Asignamos la empresa que acabamos de crear 
			// al usuario de suscripciones
			$this->usuarioService->asociar_empresas($this->uid, $empresa_id);

			// El template de cuentas sera el de openerp
			// Esta funcionalidad por lo tanto no se utilizara
			// $params["catalogo"] = false;
			// if ($params["catalogo"])
			// {
			// 	$uploadfile = PROYECT_PATH . "/otros/csv/cuentas.csv";
			// 	$accTplService = new AccountTplService($this->uid, $this->pwd);
			// 	$accTplService->crear_catalogo_template($params["name"], $uploadfile);
			// }
		}

		return $res;
	}

	function empresa_configurada($empresa_id)
	{		
		$model = "account.config.settings";		
		$domain = array(
					array(
							model("company_id", "string"),
							model("=", "string"),
							model($empresa_id, "int")
						));	
		$res = $this->obj->search($this->uid, $this->pwd, $model, $domain);
		
		if($res["success"])
		{
			$id_empresa = $res["data"]["id"][0];
			$res["data"] = array("id" => $id_empresa);
			return $res;	
		}		

		return false;
	}

	function contabilidad_empresa($chart_template_id, $company_id, $tax_template_ids)
	{
		$model = "account.config.settings";
		$date_start = "2014-01-01";
		$date_stop = "2014-12-31";
		$currency_id = 34; #MXN
		$sale_tax_id;
		$purchase_tax_id;
		$config_id;			
		
		$response = $this->empresa_configurada($company_id);	
		// logg($response);
		if (!$response)
		{
			// logg("Configurando Empresa");			
			foreach ($tax_template_ids as $index => $value) 
			{			
				if($value["type_tax_use"] == "sale")			
					$sale_tax_id = $value["id"];			
				else
					$purchase_tax_id = $value["id"];
			}
			// logg("chart_template_id");
			// logg($chart_template_id);
			$config = array(
				"chart_template_id" => model($chart_template_id, "int"),
				"code_digits" => model(6, "int"),
				"company_id" => model($company_id, "int"),
				"complete_tax_set" => model(true, "boolean"),
				"currency_id" => model($currency_id, "int"),
				"date_start" => model($date_start, "string"),
				"date_stop" => model($date_stop, "string"),
				"decimal_precision" => model(2, "int"),
				"period" => model("month", "string"),
				"purchase_tax" => model($purchase_tax_id, "int"),
				"purchase_tax_rate" => model(16, "int"),
				"sale_tax" => model($sale_tax_id, "int"),
				"sale_tax_rate" => model(16, "int"),
				);

			$response = $this->obj->create($this->uid, $this->pwd, $model, $config);
		}		

		// logg("Account Config");
		// logg($response);
		if ($response["success"])
		{
			$config_id = $response["data"]["id"];
			// logg($config_id);
			#$config_id = 7;			
			$ids = array(
				model($config_id, "int"));

			$method = "set_chart_of_accounts";
			$res = $this->configurar_plan_contable($ids, $method);
			#$res["success"] = true;
			// logg($res, 1);
			if ($res["success"])
				$method = "set_fiscalyear";
				$res = $this->configurar_plan_contable($ids, $method);

				if ($res["success"])
					$method = "set_default_taxes";
					$res = $this->configurar_plan_contable($ids, $method);

					if ($res["success"])
						$method = "set_default_dp";
						$res = $this->configurar_plan_contable($ids, $method);
		}			

		return $response; 
	}

	function configurar_plan_contable($ids, $method)
	{
		$model = "account.config.settings";		
		$response = $this->obj->call($this->uid, $this->pwd, $model, $method, $ids);		

		//logg($response, 1);
		return $response;
	}	

}

?>