<?php

require_once "conf/constantes.conf";
require_once PROYECT_PATH . "/vendor/autoload.php";
require_once PROYECT_PATH . "/service/ReportesService.php";

use mikehaertl\wkhtmlto\Pdf;

$pdf = new Pdf;

$company_id = 1;
$fiscalyear_id = 1;
$period_start_id = 1;
$period_end_id = 13;
$report_type = "balanza";
$params = array("month" => "Enero", "year" => "2014", "version" => "1.0");

$service = new ReportesService(1, "admin");
$data = $service->obtener_datos_reporte($company_id, $fiscalyear_id, $period_start_id, $period_end_id, $report_type, $params);

if ($data["success"])
{
	#echo render_html($report_type, $data); exit();
	$html = $service->render_html($report_type, $data);
	$pdf->addPage($html);
	$pdf->setOptions(array("user-style-sheet" => "reportes/balanza.css"));

	if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
		$pdf->setOptions(
			array(
			    'commandOptions' => array(
			        'escapeArgs' => false,
			        'procOptions' => array(
			            'bypass_shell' => true,
			            'suppress_errors' => true,
		    		)
			    ),
			    'orientation' => "Landscape",
			    'disable-smart-shrinking',
		    )
		);
	}

	if (!$pdf->send()) {
	    throw new Exception('Could not create PDF: '.$pdf->getError());
	}
}
else
{
	echo "No se encontraron datos";
}


?>