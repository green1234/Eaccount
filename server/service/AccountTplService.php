<?php

#require_once "../conf/constantes.conf";
require_once PROYECT_PATH . "/service/CommonService.php";

class AccountTplService
{
	var $uid;
	var $pwd;
	var $model = "account.account.template";	
	var $obj;
	var $tipos = array(
					"Raiz"      => 1,
					"Cliente"   => 2,
					"Proveedor" => 3,
					"Banco"   => 4,
					"Caja"    => 5,
					"Activo"  => 6,
					"Pasivo"  => 7,
					"Ingreso" => 8,
					"Gasto"   => 9,
					"Vista de Ingreso" => 10,
					"Vista de Gasto"   => 11,
					"Vista de Activo"  => 12,
					"Vista de Pasivo"  => 13,
					);

	function __construct($uid, $pwd)
	{
		$this->uid = $uid;
		$this->pwd = $pwd;
		$this->obj = new MainObject();
	}

	function obtener_tipo_cuenta($registro)
	{		
		$tipo_cuenta = $registro["type"];
		$clase_cuenta = $registro["class"];
		$mayor = $registro["mayor"];

		$tipos = $this->tipos;
		$result = array();

		if ($mayor == "1")
		{
			$result["type"] = "view";
			switch ($clase_cuenta) {				
				case 'A':
					$result["user_type"] = $tipos["Vista de Activo"];
					break;
				case 'P':
					$result["user_type"] = $tipos["Vista de Pasivo"];
					break;
				case 'I':
					$result["user_type"] = $tipos["Vista de Ingreso"];
					break;
				case 'G':
					$result["user_type"] = $tipos["Vista de Gasto"];
					break;
			}
		}
		else
		{
			switch ($tipo_cuenta) {				
				case 'caja':
					$result["user_type"] = $tipos["Caja"];
					$result["type"] = "liquidity";
					break;
				case 'banco':
					$result["user_type"] = $tipos["Banco"];
					$result["type"] = "liquidity";
					break;
				case 'cliente':
					$result["user_type"] = $tipos["Cliente"];
					$result["type"] = "receivable";
					break;
				case 'proveedor':
					$result["user_type"] = $tipos["Proveedor"];
					$result["type"] = "payable";
					break;
				default:
					$result["type"] = "other";					
					if ($clase_cuenta == "A")
						$result["user_type"] = $tipos["Activo"];				
					else if ($clase_cuenta == "P")
						$result["user_type"] = $tipos["Pasivo"];					
					else if ($clase_cuenta == "I")
						$result["user_type"] = $tipos["Ingreso"];
					else
						$result["user_type"] = $tipos["Gasto"];					
					break;
			}
		}
		return $result;		
	}

	function crear_cuenta_template($empresa, $account, $chart)
	{
		$model = $this->model;
		$name = $account["name"];
		$account_tpl = array(
			"code" => model($account["code"], "string"),
			"name" => model($account["name"], "string"),
			// "parent_id" => model($account["parent_id"], "int"),
			"type" => model($account["type"], "string"),
			"user_type" => model($account["user_type"], "int")
		);

		if(isset($account["parent_id"]))
			$account_tpl["parent_id"] = model($account["parent_id"], "int");

		$response = $this->obj->create($this->uid, $this->pwd, $model, $account_tpl);
		$result = array();

		if ($response["success"])
		{
			$chart[$name] = $response["data"]["id"];
			$result = array("id" => $chart[$name], "name" => $name, "chart" => $chart);
		}		
		
		return $result;
	}

	function crear_catalogo_template($empresa, $uploadfile)
	{
		$registros = CommonService::leer_catalogo_csv($uploadfile);
		#var_dump($registros); exit();
		if(count($registros) > 0)
		{
			$chart = array();
			$main_account = array(
				"code" => "0", #model("0", "string"),
	        	"name" => $empresa, #model($empresa, "string"),
	        	"type" => "view", #model("view", "string"),
	        	"user_type" => 1); #model(1, "int"));
				// "parent_id" => null);
			
			$response = $this->crear_cuenta_template($empresa, $main_account, $chart);
			$chart = $response["chart"];
			$defaults = array();

			for ($i = 0; $i < count($registros); $i++)
			{				
				$name = $registros[$i]["name"];
				$parent = $registros[$i]["parent"];				

				if (isset($chart[$parent]))
					$parent_id = $chart[$parent];
				else
					$parent_id = $chart[$empresa];			


				// logg($parent_id);

				$result = $this->obtener_tipo_cuenta($registros[$i]);
				$account = array(
		        	"code" => $registros[$i]["code"], #model($registros[$i]["code"], "string"),
		        	"name" => $name, #model($name, "string"),
		        	"type" => $result["type"], #model($result["type"], "string"),
		        	"user_type" => $result["user_type"], #model($result["user_type"], "int"),
		        	"parent_id" => $parent_id #model($parent_id, "int")
		        );

		        $response = $this->crear_cuenta_template($empresa, $account, $chart);
		        $chart = $response["chart"];

		        if ($registros[$i]["default"] != "")
	    		{		   
	    			$default_type = $registros[$i]["default"];
	    			$defaults[$default_type] = $response["id"];
	    		}
			}
			$this->crear_account_chart_tpl($chart[$empresa], $empresa, $defaults);
		}
		return $chart;
	}

	function crear_account_chart_tpl($empresa_account_id, $empresa_account_name, $defaults)
	{		
		$response = $this->crear_tax_code_tpl($empresa_account_name);

		if($response["success"])
		{
			$tax_code_tpl_id = $response["data"]["id"];
			$account_chart_tpl = array(
				"name" => model($empresa_account_name, "string"),	
				"account_root_id" => model($empresa_account_id, "int"),
				"bank_account_view_id" => model($empresa_account_id, "int"),
				"tax_code_root_id" => model($tax_code_tpl_id, "int"),
				"visible" => model(true, "boolean"),					
			);

			$model = "account.chart.template";
			$response = $this->obj->create($this->uid, $this->pwd, $model, $account_chart_tpl);

			if ($response["success"])
			{
				$account_chart_tpl_id = $response["data"]["id"];
				$this->crear_tax_tpl($account_chart_tpl_id, $defaults);
			}
		}

		return true;
	}	

	function obtener_account_chart_tpl($empresa_name)
	{
		$model = "account.chart.template";

		$domain = array(
					array(
						model("name", "string"),
						model("=", "string"),
						model($empresa_name, "string")
						)
					);

		$response = $this->obj->search($this->uid, $this->pwd, $model, $domain);		
		return $response;
	}

	function obtener_impuestos_template($template_id){

		$model = "account.chart.template";

		$ids = array($template_id);
		$params = array(
			model("tax_template_ids", "string")
			);

		$response = $this->obj->read($this->uid, $this->pwd, $model, $ids, $params);		
		// var_dump($response); exit();
		$tax_template_ids = array();
		if ($response["success"])
		{
			$ids = $response["data"][0]["tax_template_ids"];
			$model = "account.tax.template";
			$params = array(
				model("name", "string"),
				model("amount", "string"),
				model("type_tax_use", "string")
				);

			$tax_template_ids = $this->obj->read($this->uid, $this->pwd, $model, $ids, $params);
		}
		// logg($tax_template_ids, 1);
		return $tax_template_ids;
	}

	function crear_tax_tpl($chart_tpl_id, $defaults)
	{
		$iva_venta = $defaults["iva_venta"];
		$iva_compra = $defaults["iva_compra"];

		$tax_tpl_model = "account.tax.template";
		$tax_tpl_sale = array(
			"name" => model("IVA DE VENTA 16%", "string"),
			"chart_template_id" => model($chart_tpl_id, "int"),
			"type" => model("percent", "string"),
			"type_tax_use" => model("sale", "string"),
			"applicable_type" => model("true", "string"),
			"amount" => model(16, "int"),
			"sequence" => model(1, "int"),
			"account_collected_id" => model($iva_venta, "int"),
			"account_paid_id" => model($iva_venta, "int"),
		);

		$tax_tpl_purchase = array(
			"name" => model("IVA DE COMPRA 16%", "string"),
			"chart_template_id" => model($chart_tpl_id, "int"),
			"type" => model("percent", "string"),
			"type_tax_use" => model("purchase", "string"),
			"applicable_type" => model("true", "string"),
			"amount" => model(16, "int"),
			"sequence" => model(1, "int"),
			"account_collected_id" => model($iva_compra, "int"),
			"account_paid_id" => model($iva_compra, "int"),
		);

		$response = $this->obj->create($this->uid, $this->pwd, $tax_tpl_model, $tax_tpl_sale);					
		$response = $this->obj->create($this->uid, $this->pwd, $tax_tpl_model, $tax_tpl_purchase);

		return true;
	}

	function crear_tax_code_tpl($empresa)
	{
		$model = "account.tax.code.template";
	    $tax_code_tpl = array(
			"name" => model($empresa, "string"),
			"sign" => model(1, "int")
			);
		$response = $this->obj->create($this->uid, $this->pwd, $model, $tax_code_tpl);		
		return $response;
	}

	
}

?>