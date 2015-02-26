<?
require_once "conf/constantes.conf";
require_once "lib/common.php";

require_once PROYECT_PATH . "/service/LoginService.php";
require_once PROYECT_PATH . "/service/ClienteService.php";
require_once PROYECT_PATH . "/service/UsuarioService.php";
require_once PROYECT_PATH . "/service/EmpresaService.php";

// $usuario = new UsuarioService(1, "21232f297a57a5a743894a0e4a801fc3");
// $res = $usuario->obtener_datos(58);
// logg($res,1);
$uid = USER_ID;
$pwd = md5(PASS);
#logg($uid, 1);
#$login = new LoginService();
#$res = $login->acceder("admin", $pwd);
#$uid = $res["data"][0]["id"];

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