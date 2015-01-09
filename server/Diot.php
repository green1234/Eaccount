<?php

require_once "conf/constantes.conf";
require_once PROYECT_PATH . "/service/ReportesService.php";

$company_id = 1;
$fiscalyear_id = 1;
$period_start_id = 1;
$period_end_id = 12;
$report = "diot";

$service = new ReportesService(1, "admin");
$data = $service->obtener_datos_reporte($company_id, $fiscalyear_id, $period_start_id, $period_end_id, $report);

$texto = $service->render_txt($report, $data);

if ($data["success"])
{
	$file_path = "tmp/diot_" . date("YdmHis") . ".txt"; 
	$file=fopen($file_path,"a") or die("Problemas al construir el archivo");
	
	foreach ($texto as $index => $value) {

		fputs($file, $value);
		fputs($file, "\n");
	}

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

logg($data, 1);


?>