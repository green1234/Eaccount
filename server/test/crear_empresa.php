<?php

require_once "conf/constantes.conf";
require_once PROYECT_PATH . "/service/EmpresaService.php";
#require_once PROYECT_PATH . "/service/AccountTplService.php";

$service = new EmpresaService(1, "admin");
#$accountService = new AccountTplService(1, "admin");

$empresa_id = 0;
$empresa_name = "MI EMPRESA";
$empresa = array(
	"name" => $empresa_name, #model($empresa_name, "string"),
	"currency_id" => 34, #model(34, "int")
	);
#$chart_tpl_id = 0;
#$tax_template_ids = array();

$res = $service->crear_empresa($empresa);

if ($res["success"])
 	$empresa_id = $res["data"]["id"];
else
	echo "La empresa ya existe";

logg($res, 1);

#$empresa_id = 3;
/*if ($empresa_id > 0){
	$res = $accountService->obtener_account_chart_tpl($empresa_name);	
	if ($res["success"])
	 	$chart_tpl_id = $res["data"]["id"][0];
	else
		echo "No se pudo obtener la plantilla de cuentas";	
}

#$chart_tpl_id = 2;
if ($empresa_id > 0 && $chart_tpl_id > 0){
	$res = $accountService->obtener_impuestos_template($chart_tpl_id);
	if ($res["success"])
		$tax_template_ids = $res["data"];
	else
		echo "No se pudieron obtener las plantillas de impuestos";		
}

if (count($tax_template_ids) > 0 && $empresa_id > 0 && $chart_tpl_id > 0)
{
	$res = $service->contabilidad_empresa($chart_tpl_id, $empresa_id, $tax_template_ids);
	if ($res["success"])	
		$account_config_id = $res["data"]["id"];	
	else
		echo "No se pudo configurar la contabilidad de la empresa";		
}	
*/


?>