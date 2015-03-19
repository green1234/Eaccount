<?
session_start();
require_once "conf/constantes.conf";
require_once PROYECT_PATH . "/service/InvoiceService.php";

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

function obtener_cuentas($cid)
{
	$model = "res.company";		
	$method = "obtener_cuentas_bancarias";
	$params = array("cid" => model($cid, "int"));

	$obj = new MainObject();
	$response = $obj->call(USER_ID, md5(PASS), $model, $method, null, $params);
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
		else if($_GET["cat"] == "codesat")
		{
			$res = obtener_sat_codes();
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