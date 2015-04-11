<?php

#require_once "../conf/constantes.conf";
require_once PROYECT_PATH . "/service/CommonService.php";
require_once PROYECT_PATH . "/service/EmpresaService.php";
require_once PROYECT_PATH . "/service/AccountService.php";

class AccountTplService
{
	var $uid;
	var $pwd;
	var $model = "account.account.template";	
	var $obj;
	var $sat;
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

	function obtener_codigos_sat()
	{
		$service = new AccountService(USER_ID, md5(PASS));
		$res = $service->obtener_sat_ids();
		if ($res["success"])
			return $res["data"];
		else return array();
	}

	function __construct($uid, $pwd, $cid)
	{
		$this->uid = $uid;
		$this->pwd = $pwd;
		$this->cid = $cid;
		$this->sat = $this->obtener_codigos_sat();
		$this->obj = new MainObject();
	}

	function obtener_sat_id($code)
	{
		//return $this->sat;
		return $this->sat[$code];
	}

	function obtener_tipo_cuenta($registro)
	{	
		$grupo_cuenta = $registro["Genero"];	
		//$tipo_cuenta = $registro["tipo"];//$tipo_cuenta = $registro["type"];
		//$clase_cuenta = $registro["clase"];//$clase_cuenta = $registro["class"];
		$mayor = $registro["Cuenta_mayor"];

		$tipos = $this->tipos;
		$result = array();

		if ($mayor == "SI")
		{
			$result["type"] = "view";
			switch ($grupo_cuenta) {				//switch ($clase_cuenta) {				
				case 'A':
					$result["user_type"] = $tipos["Vista de Activo"];
					break;
				case 'P':
				case 'K':
					$result["user_type"] = $tipos["Vista de Pasivo"];
					break;
				case 'I':
					$result["user_type"] = $tipos["Vista de Ingreso"];
					break;
				case 'C':
				case 'G':
				case 'F':
				case 'O':
					$result["user_type"] = $tipos["Vista de Gasto"];
					break;
			}
		}
		else
		{
			$result["type"] = "other";
			switch ($grupo_cuenta) { //switch ($tipo_cuenta) {				
				
				case 'A':
					$result["user_type"] = $tipos["Activo"];
					break;
				case 'P':
				case 'K':
					$result["user_type"] = $tipos["Pasivo"];
					break;
				case 'I':
					$result["user_type"] = $tipos["Ingreso"];
					break;
				case 'C':
				case 'G':
				case 'F':
				case 'O':
					$result["user_type"] = $tipos["Gasto"];
					break;

				// case 'caja':
				// 	$result["user_type"] = $tipos["Caja"];
				// 	$result["type"] = "liquidity";
				// 	break;
				// case 'banco':
				// 	$result["user_type"] = $tipos["Banco"];
				// 	$result["type"] = "liquidity";
				// 	break;
				// case 'cliente':
				// 	$result["user_type"] = $tipos["Cliente"];
				// 	$result["type"] = "receivable";
				// 	break;
				// case 'proveedor':
				// 	$result["user_type"] = $tipos["Proveedor"];
				// 	$result["type"] = "payable";
				// 	break;
				// default:
				// 	$result["type"] = "other";					
				// 	if ($clase_cuenta == "A")
				// 		$result["user_type"] = $tipos["Activo"];				
				// 	else if ($clase_cuenta == "P")
				// 		$result["user_type"] = $tipos["Pasivo"];					
				// 	else if ($clase_cuenta == "I")
				// 		$result["user_type"] = $tipos["Ingreso"];
				// 	else
				// 		$result["user_type"] = $tipos["Gasto"];					
				// 	break;
			}
		}
		return $result;		
	}

	// Funcion que va registrando las cuentas en el template
	// el parametro chart es un array que va guardando los registros 
	// cada vez que se crea unn nuevo registro, se agrega al chart
	function crear_cuenta_template($account, $chart)
	{
		$model = $this->model;
		$name = $account["code"];
		$account_tpl = array(
			"code" => model($account["code"], "string"),
			"name" => model($account["name"], "string"),
			// "parent_id" => model($account["parent_id"], "int"),
			"type" => model($account["type"], "string"),
			"user_type" => model($account["user_type"], "int")
		);

		if(isset($account["parent_id"]))
			$account_tpl["parent_id"] = model($account["parent_id"], "int");

		if(isset($account["codagrup"]))
			$account_tpl["codagrup"] = model($account["codagrup"], "int");

		if(isset($account["nature"]))
			$account_tpl["nature"] = model($account["nature"], "string");

		if(isset($account["default"]))
			$account_tpl["default"] = model($account["default"], "boolean");

		$response = $this->obj->create($this->uid, $this->pwd, $model, $account_tpl);
		$result = array();

		if ($response["success"])
		{
			$chart[$name] = $response["data"]["id"];
			$response = array("id" => $chart[$name], "name" => $account["code"], "code"=>$name, "chart" => $chart);
		}		
		
		return $response;
	}

	function validar_catalogo($registros)
	{
		//return true;
		$catalogo = array();
		for ($i = 1; $i < count($registros); $i++)
		{	
			$codigo = $registros[$i]["Numero_de_ Cuenta"];

			if (count($catalogo) > 0)
			{
				if (isset($catalogo[$codigo]))
					return array("error"=>"El numero de la cuenta debe ser unico, fila " . $i + 1, "row"=> $i+1);

				$catalogo[$codigo] = true;
			}
			else
			{
				$catalogo[$codigo] = true;	
			}

			if (!isset($registros[$i]["Codigo_SAT"]))			
				return array("error"=>"El valor de la Columna Codigo_SAT no es correcto, fila " . $i + 1, "row"=> $i+1);
			
			if (!isset($registros[$i]["Nivel_de_Cuenta"]) || ((int)$registros[$i]["Nivel_de_Cuenta"]) < 1 )			
				return array("error"=>"El valor de la Columna Nivel_de_Cuenta no es correcto, fila " . $i + 1, "row"=> $i+1);
			
			if (!isset($registros[$i]["Numero_de_ Cuenta"]) || $registros[$i]["Numero_de_ Cuenta"] == "")			
				return array("error"=>"El valor de la columna Numero_de_ Cuenta no es correcto, fila " . $i + 1, "row"=> $i+1);
			
			if (!isset($registros[$i]["Nombre_cuenta"]) || $registros[$i]["Nombre_cuenta"] == "")			
				return array("error"=>"El valor de la columna Nombre_cuenta Cuenta no es correcto, fila " . $i + 1, "row"=> $i+1);				
			
			if (!isset($registros[$i]["Genero"])) 
				if($registros[$i]["Genero"] != "Activo" 
					&& $registros[$i]["Genero"] != "Pasivo"
					&& $registros[$i]["Genero"] != "Capital"
					&& $registros[$i]["Genero"] != "Ingreso"
					&& $registros[$i]["Genero"] != "Gasto")				
				return array("error"=>"El valor de la columna Genero Cuenta no es correcto, fila " . $i + 1, "row"=> $i+1);				
			
			if (!isset($registros[$i]["Naturaleza"]) || ($registros[$i]["Naturaleza"] != "A" 
				&& $registros[$i]["Naturaleza"] != "D"))
				return array("error"=>"El valor de la columna Naturaleza Cuenta no es correcto, fila " . $i + 1, "row"=> $i+1);								
			
			if (!isset($registros[$i]["SubCuentaDe"]) || $registros[$i]["SubCuentaDe"] == "")			
				return array("error"=>"El valor de la columna SubCuentaDe Cuenta no es correcto, fila " . $i + 1, "row"=> $i+1);			 	
			
			if (!isset($registros[$i]["Cuenta_mayor"]) || ($registros[$i]["Cuenta_mayor"] != "SI" 
				&& $registros[$i]["Cuenta_mayor"] != "NO"))			
				return array("error"=>"El valor de la columna Cuenta_mayor Cuenta no es correcto, fila " . $i + 1, "row"=> $i+1);				
			
			if (!isset($registros[$i]["Afectable"]) || ($registros[$i]["Afectable"] != "SI" 
				&& $registros[$i]["Afectable"] != "NO"))			
				return array("error"=>"El valor de la columna Afectable Cuenta no es correcto, fila " . $i + 1, "row"=> $i+1);				
			
			if (!isset($registros[$i]["Moneda"]) || $registros[$i]["Moneda"] != "1")			
				return array("error"=>"El valor de la columna Moneda Cuenta no es correcto, fila " . $i + 1, "row"=> $i+1);								
		}
		return true;
	}

	function crear_catalogo_template($empresa_id, $uploadfile)
	{
		$registros = CommonService::leer_catalogo_csv($uploadfile);
		
		if(count($registros) > 0)
		{
			$validacion = $this->validar_catalogo($registros);
		
			if ($validacion!==true)
			{
				// return $a; 
				return array(
					"success"=>false, 
					"data"=>array(
						"description"=>"El Archivo no cumple con el formato",
						"error" => $validacion["error"],
						"row" => $validacion["row"]),
					);
			}

			//logg("LOL",1);

			$empresaService = new EmpresaService(USER_ID, md5(PASS));
			$empresaData = $empresaService->obtener_datos_empresa($empresa_id)["data"];
			//logg($empresaData,1);
			$e_name = $empresaData["name"];
			$e_rfc = $empresaData["gl_rfc"];
			$chart = array();
			$main_account = array(
				"code" => "0", #model("0", "string"),
	        	"name" => $e_rfc, #model($empresa, "string"),
	        	"type" => "view", #model("view", "string"),
	        	"user_type" => 1); #model(1, "int"));
				// "parent_id" => null);
			
			// Crear Primera Cuenta del Template
			$response = $this->crear_cuenta_template($main_account, $chart);
			//return $response;
			//logg($response,1);
			$chart = $response["chart"];
			$defaults = array();

			for ($i = 0; $i < count($registros); $i++)
			{				
				$name = $registros[$i]["Nombre_cuenta"];//$name = $registros[$i]["name"];
				$parent = $registros[$i]["SubCuentaDe"];	//$parent = $registros[$i]["parent"];	
				$sat_code = $registros[$i]["Codigo_SAT"];			

				if (isset($chart[$parent]))
					$parent_id = $chart[$parent];
				else
					$parent_id = $chart[0];			


				// logg($parent_id);

				$result = $this->obtener_tipo_cuenta($registros[$i]);
				$code_id = $this->obtener_sat_id($sat_code);

				$account = array(
		        	"code" => $registros[$i]["Numero_de_ Cuenta"], //"code" => $registros[$i]["code"], 
		        	"name" => $name, 
		        	"type" => $result["type"], 
		        	"user_type" => $result["user_type"], 
		        	"parent_id" => $parent_id, 
		        	"nature" => $registros[$i]["Naturaleza"],//"nature" => $registros[$i]["nature"],
		        	"codagrup" => $code_id,
		        );

		        $response = $this->crear_cuenta_template($account, $chart);
		        //logg($response);
		        //return $response;
		        $chart = $response["chart"];

		     //    if ($registros[$i]["default"] != "")
	    		// {		   
	    		// 	$default_type = $registros[$i]["default"];
	    		// 	$defaults[$default_type] = $response["id"];
	    		// }
			}
			
			//logg($chart,1);
			$defaults = $this->crear_defaults($e_rfc, $chart);
			$response = $this->crear_account_chart_tpl($chart[0], $e_name, $defaults);

			if ($response["success"])
			{				
				$chart_id = $response["data"]["id"];
				$tax_tpl_ids = $this->crear_tax_tpl($chart_id, $defaults);

				$eService = new EmpresaService($this->uid, $this->pwd);
				$res = $eService->contabilidad_empresa($chart_id, $this->cid, $tax_tpl_ids);
				return $res;
			}


		}
		return $chart;
	}

	function crear_defaults($rfc, $chart)
	{
		$defaults = array();

		$def["bancos"] = array("name"=>"Bancos View Default", "code" => $rfc."_1_", "type"=>"view", "user_type"=>12, "parent_id"=>$chart[0], "default"=>true);
		$def["apertura"] = array("name"=>"Apertura Default", "code" => $rfc."_2_", "type"=>"other", "user_type"=>7, "parent_id"=>$chart[0], "default"=>true);
		// $banco = array("name"=>"Banco Default", "code" => $rfc."_2_", "type"=>"liquidity", "user_type"=>4, "parent_id"=>$chart[0], "default"=>true);
		// $caja = array("name"=>"Caja Default", "code" => $rfc."_3_", "type"=>"liquidity", "user_type"=>5, "parent_id"=>$chart[0], "default"=>true);
		$def["ingreso"] = array("name"=>"Ventas Default", "code" => $rfc."_3_", "type"=>"other", "user_type"=>8, "parent_id"=>$chart[0], "default"=>true);
		$def["gasto"] = array("name"=>"Compras Default", "code" => $rfc."_4_", "type"=>"other", "user_type"=>9, "parent_id"=>$chart[0], "default"=>true);
		$def["cliente"] = array("name"=>"Cliente Default", "code" => $rfc."_5_", "type"=>"receivable", "user_type"=>2, "parent_id"=>$chart[0], "default"=>true);
		$def["proveedor"] = array("name"=>"Proveedor Default", "code" => $rfc."_6_", "type"=>"payable", "user_type"=>3, "parent_id"=>$chart[0], "default"=>true);

		$def["iva_venta"] = array("name"=>"IVA Ventas Default", "code" => $rfc."_7_", "type"=>"other", "user_type"=>7, "parent_id"=>$chart[0], "default"=>true);
		$def["iva_compra"] = array("name"=>"IVA Compra Default", "code" => $rfc."_8_", "type"=>"other", "user_type"=>6, "parent_id"=>$chart[0], "default"=>true);
		$def["iva_ret"] = array("name"=>"IVA Retenido Default", "code" => $rfc."_9_", "type"=>"other", "user_type"=>6, "parent_id"=>$chart[0], "default"=>true);
		$def["isr_ret"] = array("name"=>"ISR Retenido Default", "code" => $rfc."_10_", "type"=>"other", "user_type"=>6, "parent_id"=>$chart[0], "default"=>true);


		foreach ($def as $key => $account) {
			$res = $this->crear_cuenta_template($account, $chart);
			$defaults[$key] = $res["id"];
		}

		return $defaults;
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
				"bank_account_view_id" => model($defaults["bancos"], "int"),
				"tax_code_root_id" => model($tax_code_tpl_id, "int"),
				"visible" => model(true, "boolean"),
				"property_account_receivable" => model($defaults["cliente"], "int"),
				"property_account_payable" => model($defaults["proveedor"], "int"),
				"property_account_expense_categ" => model($defaults["gasto"], "int"),
				"property_account_income_categ" => model($defaults["ingreso"], "int"),
				"property_account_income_opening" => model($defaults["apertura"], "int"),
				"property_account_expense_opening" => model($defaults["apertura"], "int"),
			);

			$model = "account.chart.template";
			$response = $this->obj->create($this->uid, $this->pwd, $model, $account_chart_tpl);

			return $response;
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
				model("type_tax_use", "string"),
				model("description", "string"),
				model("tax_type", "string"),
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
		$iva_ret = $defaults["iva_ret"];
		$isr_ret = $defaults["isr_ret"];

		$tax_tpl_model = "account.tax.template";
		$tax_tpl_sale = array(
			"name" => model("IVA DE VENTA 16%", "string"),
			"description" => model("IVA", "string"),
			"tax_type" => model("trasladado", "string"),
			"chart_template_id" => model($chart_tpl_id, "int"),
			"type" => model("percent", "string"),
			"type_tax_use" => model("sale", "string"),
			"applicable_type" => model("true", "string"),
			"amount" => model(0.16, "double"),
			"sequence" => model(1, "int"),
			"account_collected_id" => model($iva_venta, "int"),
			"account_paid_id" => model($iva_venta, "int"),
		);

		$tax_tpl_sale_0 = array(
			"name" => model("IVA DE VENTA 0%", "string"),
			"description" => model("IVA", "string"),
			"tax_type" => model("trasladado", "string"),
			"chart_template_id" => model($chart_tpl_id, "int"),
			"type" => model("percent", "string"),
			"type_tax_use" => model("sale", "string"),
			"applicable_type" => model("true", "string"),
			"amount" => model(0, "double"),
			"sequence" => model(1, "int"),
			"account_collected_id" => model($iva_venta, "int"),
			"account_paid_id" => model($iva_venta, "int"),
		);

		$tax_iva_sale_ret = array(
			"name" => model("IVA RETENIDO 10.66667%", "string"),
			"description" => model("IVA", "string"),
			"tax_type" => model("retenido", "string"),
			"chart_template_id" => model($chart_tpl_id, "int"),
			"type" => model("percent", "string"),
			"type_tax_use" => model("sale", "string"),
			"applicable_type" => model("true", "string"),
			"amount" => model(0.1066667, "double"),
			"sequence" => model(1, "int"),
			"account_collected_id" => model($iva_ret, "int"),
			"account_paid_id" => model($iva_ret, "int"),
		);

		$tax_iva_sale_ret_0 = array(
			"name" => model("IVA RETENIDO 0%", "string"),
			"description" => model("IVA", "string"),
			"tax_type" => model("retenido", "string"),
			"chart_template_id" => model($chart_tpl_id, "int"),
			"type" => model("percent", "string"),
			"type_tax_use" => model("sale", "string"),
			"applicable_type" => model("true", "string"),
			"amount" => model(0, "double"),
			"sequence" => model(1, "int"),
			"account_collected_id" => model($iva_ret, "int"),
			"account_paid_id" => model($iva_ret, "int"),
		);

		$tax_isr_sale_ret = array(
			"name" => model("ISR RETENIDO 10%", "string"),
			"description" => model("ISR", "string"),
			"tax_type" => model("retenido", "string"),
			"chart_template_id" => model($chart_tpl_id, "int"),
			"type" => model("percent", "string"),
			"type_tax_use" => model("sale", "string"),
			"applicable_type" => model("true", "string"),
			"amount" => model(0.10, "double"),
			"sequence" => model(1, "int"),
			"account_collected_id" => model($isr_ret, "int"),
			"account_paid_id" => model($isr_ret, "int"),
		);

		$tax_isr_sale_ret_0 = array(
			"name" => model("ISR RETENIDO 0%", "string"),
			"description" => model("ISR", "string"),
			"tax_type" => model("retenido", "string"),
			"chart_template_id" => model($chart_tpl_id, "int"),
			"type" => model("percent", "string"),
			"type_tax_use" => model("sale", "string"),
			"applicable_type" => model("true", "string"),
			"amount" => model(0, "double"),
			"sequence" => model(1, "int"),
			"account_collected_id" => model($isr_ret, "int"),
			"account_paid_id" => model($isr_ret, "int"),
		);

		$tax_isr_purchase_ret_0 = array(
			"name" => model("ISR RETENIDO 0% COMPRA", "string"),
			"description" => model("ISR", "string"),
			"tax_type" => model("retenido", "string"),
			"chart_template_id" => model($chart_tpl_id, "int"),
			"type" => model("percent", "string"),
			"type_tax_use" => model("purchase", "string"),
			"applicable_type" => model("true", "string"),
			"amount" => model(0, "double"),
			"sequence" => model(1, "int"),
			"account_collected_id" => model($isr_ret, "int"),
			"account_paid_id" => model($isr_ret, "int"),
		);

		$tax_tpl_purchase = array(
			"name" => model("IVA DE COMPRA 16%", "string"),
			"description" => model("IVA", "string"),
			"tax_type" => model("trasladado", "string"),
			"chart_template_id" => model($chart_tpl_id, "int"),
			"type" => model("percent", "string"),
			"type_tax_use" => model("purchase", "string"),
			"applicable_type" => model("true", "string"),
			"amount" => model(0.16, "double"),
			"sequence" => model(1, "int"),
			"account_collected_id" => model($iva_compra, "int"),
			"account_paid_id" => model($iva_compra, "int"),
		);

		$tax_tpl_purchase_0 = array(
			"name" => model("IVA DE COMPRA 0%", "string"),
			"description" => model("IVA", "string"),
			"tax_type" => model("trasladado", "string"),
			"chart_template_id" => model($chart_tpl_id, "int"),
			"type" => model("percent", "string"),
			"type_tax_use" => model("purchase", "string"),
			"applicable_type" => model("true", "string"),
			"amount" => model(0.16, "double"),
			"sequence" => model(1, "int"),
			"account_collected_id" => model($iva_compra, "int"),
			"account_paid_id" => model($iva_compra, "int"),
		);

		$this->obj->create($this->uid, $this->pwd, $tax_tpl_model, $tax_tpl_sale);
		$this->obj->create($this->uid, $this->pwd, $tax_tpl_model, $tax_tpl_sale_0);					
		$this->obj->create($this->uid, $this->pwd, $tax_tpl_model, $tax_tpl_purchase);
		$this->obj->create($this->uid, $this->pwd, $tax_tpl_model, $tax_tpl_purchase_0);
		$this->obj->create($this->uid, $this->pwd, $tax_tpl_model, $tax_iva_sale_ret);
		$this->obj->create($this->uid, $this->pwd, $tax_tpl_model, $tax_iva_sale_ret_0);
		$this->obj->create($this->uid, $this->pwd, $tax_tpl_model, $tax_isr_sale_ret);
		$this->obj->create($this->uid, $this->pwd, $tax_tpl_model, $tax_isr_sale_ret_0);
		$this->obj->create($this->uid, $this->pwd, $tax_tpl_model, $tax_isr_purchase_ret_0);

		return $this->obtener_impuestos_template($chart_tpl_id);
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
