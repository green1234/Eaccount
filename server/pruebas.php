<?
require_once "conf/constantes.conf";
require_once "lib/common.php";

require_once PROYECT_PATH . "/service/LoginService.php";
require_once PROYECT_PATH . "/service/ClienteService.php";
require_once PROYECT_PATH . "/service/UsuarioService.php";
require_once PROYECT_PATH . "/service/EmpresaService.php";
require_once PROYECT_PATH . "/service/AccountService.php";
require_once PROYECT_PATH . "/service/InvoiceService.php";
require_once PROYECT_PATH . "/service/PaymentService.php";

// $usuario = new UsuarioService(1, "21232f297a57a5a743894a0e4a801fc3");
// $res = $usuario->obtener_datos(58);
// logg($res,1);
$uid = USER_ID;
$pwd = md5(PASS);
$cid = 96;
#logg($uid, 1);
#$login = new LoginService();
#$res = $login->acceder("admin", $pwd);
#$uid = $res["data"][0]["id"];

$service = new AccountService($uid, $pwd);
$res = $service->obtener_polizas($cid);
logg($res,1);

$model = "invoice.import";		
$method = "contabilizar_factura";
$params = array(
	"id" => model(14, "int"));
$obj = new MainObject();
$response = $obj->call(USER_ID, md5(PASS), $model, $method, null, $params);

logg($response);

$service = new AccountService($uid, $pwd);
$res = $service->obtener_poliza_lines(1);
logg($res["data"][0],1);

$model = "res.company";		
$method = "registrar_cuenta_bancaria";
$params = array(
	"cid" => model($cid, "int"),
	"banco" => model(94, "int"),
	"cuenta" => model("755", "string"));

$obj = new MainObject();
$response = $obj->call(USER_ID, md5(PASS), $model, $method, null, $params);		

logg($response,1);

$model = "res.company";		
$method = "obtener_cuentas_bancarias";
$params = array("cid" => model($cid, "int"));

$obj = new MainObject();
$response = $obj->call(USER_ID, md5(PASS), $model, $method, null, $params);		
foreach ($response["data"] as $index => $value) 
{
	$data = $value->me["struct"];					
	$vals[$index] = prepare_response($data);					
	/*$vals[$index] = codificar_utf8($vals[$index]);*/
}
/*$vals = codificar_utf8($vals);*/
$response["data"] = $vals;

logg($response["data"],1);

$service = new PaymentService($uid, $pwd);
$r = $service->obtener_bancos();
logg($r,1);

$id = 41;
$params = array(
			"pgo_fecha"=>"2015-02-02",
			"pgo_metodo"=>"trans",
			//"pgo_fechacheque"=>"1",
			"pgo_nocheque"=>"2015-02-02",
			"pgo_ctadestino"=>"1",
			"pgo_ctaorigen"=>"1",
			"pgo_banorigen"=>100,
			"pgo_transaccion"=>"1",);
$service = new InvoiceService($uid, $pwd);
$r = $service->registrar_infopago($id, $params);
logg($r,1);

$service = new AccountService($uid, $pwd);

$params = array("cid" => $cid, "type" => "sale");

$service = new AccountService($uid, $pwd);
$res = $service->obtener_cuentas(39);
logg($res["data"],1);


$service = new AccountTplService($uid, $pwd, $cid);
$res = $service->obtener_sat_id("101");
logg($res);

$service = new EmpresaService($uid, $pwd);
$res = $service->empresa_configurada(13);

logg($res,1);

$params = array(model("company_id", "string"));
$obj = new MainObject();
$res = $obj->read($uid, $pwd, "res.users", array($uid), $params);
logg($res["data"][0]["company_id"],1);


logg($res["data"][0],1);


$suscription = new SuscriptionService($uid, $pwd);

$res = $suscription->obtener_planes_suscription("EACCOUNT");
logg($res,1);

// logg($res["data"][0]["id"], 1);

$params = array(
	"name"=>"Gerardo",
	"email" => "gera00win@hotmail.com",
	"phone" => "767656656",
	"mobile" => "767656656");
$usuario = new UsuarioService($uid, $pwd);
$res = $usuario->actualizar_perfil($params);

logg($res,1);


// $login = new LoginService();
// $res = $login->acceder(USER, md5(PASS));
// // logg($res);
// if ($res["success"])
// {
// 	$uid = $res["data"][0]["id"];
// 	$pwd = md5(PASS);
// }

// logg($uid);
// logg($pwd);

$obj = new MainObject();
$suscription = new SuscriptionService($uid, md5($pwd));

$res = $suscription->obtener_planes_suscription();
logg($res,1);

$data = array("username"=>"mcgalv", "email" => "mcgalv@gmail.com", "password" => md5(1));

$res = $suscription->registrar_suscripcion($data);

logg($res,1);

$res = $suscription->obtener_descuentos();
logg($res,1);

// Search Example
$model = "gl.descuentos.sucripcion";
$periodo = obtener_periodo();
$domain = array(
			array(
				model("periodo", "string"),
				model("=", "string"),
				model($periodo, "string")
			));

$res = $obj->search($uid, $pwd, $model, $domain);

// Read Example
$ids = $res["data"]["id"];
$params = array(
	model("name","string"), 
	model("description","string"),
	model("periodo","string"),
	model("porcentaje","string"));
$res = $obj->read($uid, $pwd, $model, $ids, $params);



logg($res);