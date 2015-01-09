<?php

require_once "conf/constantes.conf";
require_once PROYECT_PATH . "/service/ReportesService.php";

$service = new ReportesService(1, "admin");

$res = $service->obtener_datos_reporte();
if ($res["success"])
{
	$cuentas = $res["data"];

	foreach ($cuentas as $index => $value){
		echo "LOL";
	}
}


?>