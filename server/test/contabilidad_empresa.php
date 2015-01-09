<?php

require_once "conf/constantes.conf";
require_once PROYECT_PATH . "/service/EmpresaService.php";
require_once PROYECT_PATH . "/service/AccountTplService.php";

$service = new EmpresaService(1, "admin");
$accountService = new AccountTplService(1, "admin");

$empresa_id = 0;
$empresa_name = "MI EMPRESA";

#$empresa = array(
#	"name" => $empresa_name, #model($empresa_name, "string"),
#	"currency_id" => 34, #model(34, "int")
#	);

$chart_tpl_id = 0;
$tax_template_ids = array();

$res = $service->obtener_empresa_id($empresa_name);
logg("Obtener Empresa");
logg($res);
if ($res["success"])
{	
	$empresa_id = $res["data"]["id"][0];
	logg($empresa_id);
}
logg("Verificando ID Empresa");
if ($empresa_id > 0){
	logg("La Id de la empresa si existe");
	logg("Obteniendo Chart TPL");
	$res = $accountService->obtener_account_chart_tpl($empresa_name);	
	logg($res);
	if ($res["success"])
	{
		logg("Verificando ID Chart TPL");
	 	$chart_tpl_id = $res["data"]["id"][0];
	 	logg($chart_tpl_id);
	}			
}

if ($empresa_id > 0 && $chart_tpl_id > 0){
	$res = $accountService->obtener_impuestos_template($chart_tpl_id);
	if ($res["success"])
		$tax_template_ids = $res["data"];
	else
		echo "No se pudieron obtener las plantillas de impuestos";		
}
$account_config_id = 0;
if (count($tax_template_ids) > 0 && $empresa_id > 0 && $chart_tpl_id > 0)
{
	$res = $service->contabilidad_empresa($chart_tpl_id, $empresa_id, $tax_template_ids);

	if ($res["success"])	
		$account_config_id = $res["data"]["id"];	
	else
		echo "No se pudo configurar la contabilidad de la empresa";		
}	

logg($account_config_id, 1);

?>