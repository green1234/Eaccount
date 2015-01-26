<?php

require_once "conf/constantes.conf";
require_once PROYECT_PATH . "/service/ReportesService.php";

$RFC = "LOVG880408E79";
$company_id = 1;
$fiscalyear_id = 1;
$period_start_id = 1;
$period_end_id = 13;
$report_type = "catalogo";
$params = array("version" => "1.0");

$service = new ReportesService(1, "admin");
$data = $service->obtener_datos_reporte($company_id, $fiscalyear_id, $period_start_id, $period_end_id, $report_type, $params);
#logg($data, 1);
if ($data["success"])
{
	#echo render_html($report_type, $data); exit();
	$xml = $service->render_xml($report_type, $data);
	

	// $file_path = PROYECT_PATH . "/tmp/";
	$file_path = "/tmp/";	
	$filename = $data["data"]["RFC"] . $data["data"]["Ano"] . $data["data"]["Mes"];

	if ($report_type == "catalogo")
	{
		$filename = $filename . "CT.xml"; 	
	}
	else if($report_type == "balanza")
	{
		$filename = $filename . "BN.xml"; 	
		// $file_path = PROYECT_PATH . "/tmp/" . $filename . "BN.xml";	
	}
	else if($report_type == "polizas")
	{
		$filename = $filename . "PL.xml"; 	
		// $file_path = PROYECT_PATH . "/tmp/" . $filename . "PL.xml";	
	}
	
	$file_path = $file_path . $filename;

	$file=fopen($file_path,"w") or die("Problemas al construir el archivo");
	fputs($file, $xml);	

	if (file_exists($file_path)) {
	    header('Content-Description: File Transfer');
	    header('Content-Type: text/plain');
	    header('Content-Disposition: attachment; filename='.basename($file_path));
	    header('Expires: 0');
	    header('Cache-Control: must-revalidate');
	    header('Pragma: public');
	    header('Content-Length: ' . filesize($file_path));
	    readfile($file_path);
	    exit;
	}

	fclose($file);
	



}
else
{
	echo "No se encontraron datos";
}


?>