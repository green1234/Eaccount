<?
session_start();
require_once "conf/constantes.conf";
require_once PROYECT_PATH . "/service/InvoiceService.php";

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
		return $vals;
	}

	return array(
		"success"=>false, 
		"data"=>array(
			"description" => "Datos de Acceso incorrectos"));
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