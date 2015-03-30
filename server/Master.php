<?
session_start();
require_once "conf/constantes.conf";
require_once PROYECT_PATH . "/service/InvoiceService.php";
require_once PROYECT_PATH . "/service/AccountService.php";

function obtener_datos_bancos($ids)
{
	$model = "res.partner.bank";
	$obj = new MainObject();

	$params = array(
		model("acc_number", "string"),
		model("bank", "string"),
		model("tipo", "string"),		
	);
	$res = $obj->read(USER_ID, md5(PASS), $model, $ids, $params);
	return $res;
}

function obtener_datos_producto($prod_id)
{
	$model = "product.template";
	$obj = new MainObject();

	$params = array(
		model("name", "string"),		
		model("list_price", "string"),
		model("standard_price", "string"),
		model("sale_ok", "string"),
		model("purchase_ok", "string"),
	);
	$res = $obj->read(USER_ID, md5(PASS), $model, array($prod_id), $params);
	return $res;	
}

function obtener_productos($cid)
{
	$model = "product.product";
	$domain = array();
	$domain[] = array(
		model("company_id", "string"),
		model("=", "string"),
		model($cid, "int"));
	
	$obj = new MainObject();
	$res = $obj->search(USER_ID, md5(PASS), $model, $domain);
	//return $res;

	if ($res["success"])
	{
		$ids = $res["data"]["id"];
		if (count($ids)>0)
		{
			$params = array(
				model("name", "string"),				
			);

			$res = $obj->read(USER_ID, md5(PASS), $model, $ids, $params);
			$productos = array();
			if ($res["success"])
			{
				foreach ($res["data"] as $index => $producto) {
					$id = $producto["id"];
					$prodata = obtener_datos_producto($id);
					//logg($prodata,1);
					$producto["tpl"] = $prodata["data"][0];
					$productos[$id] = $producto;
				}
				$res["data"] = $productos;
				return $res;
			}
		}
	}

	return array(
		"success"=>false, 
		"data"=>array(
			"description" => "No se encontraron registros"));
}

function obtener_partners($cid)
{
	$model = "res.partner";
	$domain = array();
	$domain[] = array(
		model("company_id", "string"),
		model("=", "string"),
		model($cid, "int"));
	
	$obj = new MainObject();
	$res = $obj->search(USER_ID, md5(PASS), $model, $domain);
	//return $res;

	if ($res["success"])
	{
		$ids = $res["data"]["id"];
		if (count($ids)>0)
		{
			$params = array(
					model("name", "string"),
					model("ref", "string"),
					model("bank_ids", "string"),
					model("customer", "string"),
					model("supplier", "string"));

			$res = $obj->read(USER_ID, md5(PASS), $model, $ids, $params);
			$partners = array();
			if ($res["success"])
			{
				foreach ($res["data"] as $index => $partner) {
					$id = $partner["id"];
					$partners[$id] = $partner;
					$bancos = obtener_datos_bancos($partners[$id]["bank_ids"]);
					$partners[$id]["bank_ids"] = $bancos["data"];
				}
				$res["data"] = $partners;
				return $res;
			}
		}
	}

	return array(
		"success"=>false, 
		"data"=>array(
			"description" => "No se encontraron registros"));
}


function obtener_paises()
{
	$model = "res.country";
	$domain = array();	
	
	$obj = new MainObject();
	$res = $obj->search(USER_ID, md5(PASS), $model, $domain);

	if ($res["success"])
	{
		$ids = $res["data"]["id"];
		if (count($ids)>0)
		{
			$params = array(
					model("name", "string"),
					model("code", "string"));

			$res = $obj->read(USER_ID, md5(PASS), $model, $ids, $params);
			$paises = array();
			if ($res["success"])
			{
				foreach ($res["data"] as $index => $pais) {
					$id = $pais["id"];
					$paises[$id] = $pais;
				}
				$res["data"] = $paises;
				return $res;
			}
		}
	}

	return array(
		"success"=>false, 
		"data"=>array(
			"description" => "No se encontraron registros"));
}

function obtener_estados()
{
	$model = "res.country.state";
	$domain = array();	
	
	$obj = new MainObject();
	$res = $obj->search(USER_ID, md5(PASS), $model, $domain);

	if ($res["success"])
	{
		$ids = $res["data"]["id"];
		if (count($ids)>0)
		{
			$params = array(
					model("name", "string"));

			$res = $obj->read(USER_ID, md5(PASS), $model, $ids, $params);
			$estados = array();
			if ($res["success"])
			{
				foreach ($res["data"] as $index => $estado) {
					$id = $estado["id"];
					$estados[$id] = $estado;
				}
				$res["data"] = $estados;
				return $res;
			}
		}
	}

	return array(
		"success"=>false, 
		"data"=>array(
			"description" => "No se encontraron registros"));
}

function obtener_monedas()
{
	$model = "gl.cat.sat";
	$domain = array();
	$domain[] = array(
		model("tipo", "string"),
		model("=", "string"),
		model("moneda", "string"));
	
	$obj = new MainObject();
	$res = $obj->search(USER_ID, md5(PASS), $model, $domain);

	if ($res["success"])
	{
		$ids = $res["data"]["id"];
		if (count($ids)>0)
		{
			$params = array(
					model("name", "string"),
					model("description", "string"));

			$res = $obj->read(USER_ID, md5(PASS), $model, $ids, $params);
			$monedas = array();
			if ($res["success"])
			{
				foreach ($res["data"] as $index => $moneda) {
					$id = $moneda["id"];
					$monedas[$id] = $moneda;
				}
				$res["data"] = $monedas;
				return $res;
			}
		}
	}

	return array(
		"success"=>false, 
		"data"=>array(
			"description" => "No se encontraron registros"));
}

function obtener_bancos()
{
	$model = "res.bank";
	$domain = array();

	$obj = new MainObject();
	$res = $obj->search(USER_ID, md5(PASS), $model, $domain);

	if ($res["success"])
	{
		$ids = $res["data"]["id"];
		if (count($ids)>0)
		{
			$params = array(
					model("name", "string"),
					model("bic", "string"));

			$res = $obj->read(USER_ID, md5(PASS), $model, $ids, $params);
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

function obtener_sat_codes()
{	
	$tipo = array(
			model("tipo", "string"),
			model("=", "string"),
			model("account", "string"),
		);

	$model = "gl.cat.sat";
	$domain = array($tipo);	
	$obj = new MainObject();
	$res = $obj->search(USER_ID, md5(PASS), $model, $domain);

	if ($res["success"])
	{
		$sat_ids = $res["data"]["id"];
		//return $sat_ids;
		if (count($sat_ids) > 0)
		{
			$params = array(
				model("code","string"), 
				model("description","string"), 
			);

			$res = $obj->read(USER_ID, md5(PASS), $model, $sat_ids, $params);
			/*if ($res["success"])
			{
				// Genero array asociativo de Ids con Code SAT.
				$codes = array();
				foreach ($res["data"] as $idx => $sat) {
					$codes[$sat["code"]] = array($sat["id"], $sat["description"]) ;
				}
				$res["data"] = $codes;
			}*/
			return $res;
		}
	}

	return array(
		"success" => false, 
		"data" => array(
			"id" => 0,
			"description" => "No se encontraron datos"));
	
}

function obtener_accounts($cid)
{
	$service = new AccountService(USER_ID, md5(PASS));
	$res = $cuentas = $service->obtener_cuentas($cid);
	return $res;
}

function obtener_cuentas($cid)
{
	$model = "res.company";		
	$method = "obtener_cuentas_bancarias";
	$params = array("cid" => model($cid, "int"));

	$obj = new MainObject();
	$response = $obj->call(USER_ID, md5(PASS), $model, $method, null, $params);
	//return $response;
	$vals = array();
	
	if ($response["success"])
	{
		foreach ($response["data"] as $index => $value) 
		{
			$data = $value->me["struct"];					
			$vals[$index] = prepare_response($data);										
		}
		$response["data"] = $vals;
		return $response;
	}

	return array(
		"success"=>false, 
		"data"=>array(
			"description" => "No se encontraron registros."));
}

if (isset($_SESSION["login"]))
{
	$uid = $_SESSION["login"]["uid"];
	$cid = $_SESSION["login"]["cid"];
	$pwd = $_SESSION["login"]["pwd"];

	$res = array();

	if (isset($_GET["cat"]))
	{
		if ($_GET["cat"] == "cuentas")
		{
			$res = obtener_cuentas($cid[0]);
		}
		else if($_GET["cat"] == "bancos")
		{
			$res = obtener_bancos();	
		}
		else if($_GET["cat"] == "monedas")
		{
			$res = obtener_monedas();	
		}
		else if($_GET["cat"] == "paises")
		{
			$res = obtener_paises();	
		}
		else if($_GET["cat"] == "estados")
		{
			$res = obtener_estados();	
		}
		else if($_GET["cat"] == "codesat")
		{
			$res = obtener_sat_codes();
		}
		else if($_GET["cat"] == "partners")
		{
			$res = obtener_partners($cid[0]);
		}
		else if($_GET["cat"] == "accounts")
		{
			$res = obtener_accounts($cid[0]);
		}
		else if($_GET["cat"] == "productos")
		{
			$res = obtener_productos($cid[0]);
		}
	}

	echo json_encode($res);
}
else
{
	echo json_encode(
		array(
			"success"=>false, 
			"data"=>array(
				"description" => "Datos de Acceso incorrectos")));
}

?>