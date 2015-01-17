<?php

require_once "conf/constantes.conf";
require_once PROYECT_PATH . "/service/SuscriptionService.php";

$usuario_uid = "1";
$usuario_name = "admin";
$usuario_pwd = "admin";
$fk = 0;
// logg("OK",1);
if (isset($_GET["fk"]))
{
	$fk = $_GET["fk"];
	$service = new SuscriptionService($usuario_uid, $usuario_pwd);

	$res = $service->confirmar_suscripcion($fk);

	echo json_encode($res);
}	
else
{
	echo json_encode(array(
		"success"=>false,
		"data" => array(
			"description" => "No hay ningun registro previo")
		));
}

?>