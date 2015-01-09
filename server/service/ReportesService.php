<?php

#require_once "../conf/constantes.conf";
require_once PROYECT_PATH . "/lib/common.php";
require_once PROYECT_PATH . "/lib/arraytoxml.php"; 
require_once PROYECT_PATH . "/service/CommonService.php";
class ReportesService
{
	var $uid;
	var $pwd;	
	var $obj;
	
	function __construct($uid, $pwd)
	{
		$this->uid = $uid;
		$this->pwd = $pwd;
		$this->obj = new MainObject();
	}

	function obtener_datos_reporte($empresa, $fiscalyear_id, $period_start_id, $period_end_id, $reporte, $params=null)
	{
		$model = "gl.reportes";	
		$params_custom = array();

		switch ($reporte) {
				case 'balanza':
				case 'balance':
				case 'resultados':
					$params_custom["version"] = model($params["version"], "string");
					$method = "obtener_balanza";				
					break;

				case 'polizas':
					$params_custom["version"] = model($params["version"], "string");
					$method = "obtener_polizas";
					break;
				
				case 'diot':
					$model = 'account.diot.report'; 
					$method = "obtener_diot";
					break;

				default:
					$method = "obtener_catalogo";					
					$params_custom["version"] = model($params["version"], "string");
					break;
		}		

		$params = array(				
				"report" => model($reporte, "string"),				
				"fiscalyear_id" => model($fiscalyear_id, "int"),
				"period_start_id" => model($period_start_id, "int"),
				"period_end_id" => model($period_end_id, "int"));

		#logg($params, 1);

		if(count($params_custom) > 0)
		{
			$params = array_merge($params, $params_custom);
		}

		#logg($params, 1);

		$response = $this->obj->call($this->uid, $this->pwd, $model, $method, null, $params);	
		
		$vals = array();
		if ($response["success"])
		{	
			foreach ($response["data"] as $index => $value) {
								
				if (isset($value->me["array"])){
					$value = $value->me["array"];
					$vals[$index] = prepare_response($value);				
				}

				else if (isset($value->me["struct"])){
					$value = $value->me["struct"];
					$vals[$index] = prepare_response($value);				
				}
				
				else
				{						
					$vals[$index] = prepare_response($value);
					// logg($vals[$index]);
					// logg($value);
					// exit();
				}
				
			}

		}	
		#logg($vals,1);
		$response["data"] = $vals;
		#$response = json_encode($response);
		#logg($response["data"], 1);
		// $response["data"] = $vals;
		return $response;
	}

	function render_txt($report, $data)
	{
		switch ($report)
		{
			case "diot": 
			default:
				$text = $this->prepare_diot($report, $data);			
			break;
		}

		return $text;
	}

	function render_html($report_type, $res){	

		switch ($report_type)
		{
			case "polizas": 
				$html = $this->prepare_polizas($report_type, $res);			
			break;

			case "catalogo": 
				$html = $this->prepare_catalogo($report_type, $res);			
			break;

			default:
				$html = $this->prepare_balance($report_type, $res);
			break;
		}

		return $html;
	}

	function render_xml($report_type, $res)
	{
		switch ($report_type)
		{
			case "catalogo": 
				$xml = $this->prepare_catalogo_xml($report_type, $res);	
				#logg($xml);
			break;

			case "balanza": 
				$xml = $this->prepare_balanza_xml($report_type, $res);	
			break;

			case "polizas": 
				$xml = $this->prepare_polizas_xml($report_type, $res);	
			break;
			
			default:
				$xml = $this->prepare_catalogo_xml($report_type, $res);	
			break;
		}

		return $xml;	
	}


	function prepare_catalogo_xml($report_type, $res)
	{
		if ($res["success"])
		{
			$data = $res["data"];
			#logg($data,1);
			$catalogo = array(
				"@attributes" => array(
					"Version" => $data["Version"],
					"RFC" => $data["RFC"], 
					"TotalCtas" => $data["TotalCtas"],
					"Mes" => $data["Mes"],
					"Ano" => $data["Ano"]),
				"catalogocuentas" => array("Cta" => array()));				
			
			foreach ($data["Cuentas"] as $index => $cuenta) {								
				$catalogo["catalogocuentas"]["Cta"][] = array(
					"@attributes" => array(
						"CodAgrup" => $cuenta["CodAgrup"],
						"NumCta" => $cuenta["NumCta"],
						"Desc" => $cuenta["Desc"],
						"SubCtaDe" => $cuenta["SubCtaDe"],
						"Nivel" => $cuenta["Nivel"],
						"Natur" => $cuenta["Natur"],));
			}
			
			$xml = Array2XML::createXML('Catalogo', $catalogo);	
			return	$xml->saveXML();		
		}
		return false;
	}

	function prepare_balanza_xml($report_type, $res)
	{
		if ($res["success"])
		{
			$data = $res["data"];

			$balanza = array(
				"@attributes" => array(
					"Version" => $data["Version"],
					"RFC" => $data["RFC"], 
					"TotalCtas" => $data["TotalCtas"],
					"Mes" => $data["Mes"],
					"Ano" => $data["Ano"]),
				"BCE" => array("Ctas" => array()));				
			
			foreach ($data["Cuentas"] as $index => $cuenta) {								
				$balanza["BCE"]["Ctas"][] = array(
					"@attributes" => array(
						"NumCta" => $cuenta["NumCta"],
						"SaldoIni" => $cuenta["SaldoIni"],
						"Debe" => $cuenta["Debe"],
						"Haber" => $cuenta["Haber"],
						"SaldoFin" => $cuenta["SaldoFin"],
				));
			}
			
			$xml = Array2XML::createXML('Balanza', $balanza);			
			return	$xml->saveXML();		
		}
		return false;
	}

	function prepare_polizas_xml($report_type, $res)
	{
		if ($res["success"])
		{
			$data = $res["data"];
			#logg($data, 1);
			$polizas = array(
				"@attributes" => array(
					"Version" => $data["Version"],
					"RFC" => $data["RFC"], 					
					"Mes" => $data["Mes"],
					"Ano" => $data["Ano"]),
				"PLZ" => array("Poliza" => array()));				
			
			foreach ($data["Movimientos"] as $index => $movimiento) {								
				
				$trans = array();
				foreach ($movimiento["Polizas"] as $idx => $poliza) {					

					$asientos = array();
					if (count($poliza["Asientos"]) > 0)
					{
						$asientos = array("@attributes" => array());
						foreach ($poliza["Asientos"] as $i => $asiento) 
						{
							$asientos["@attributes"][$i] = $asiento; 
						}
					}
					#$comprobantes = array("Comprobante" => $asientos);

					$trans[] = array(
						"@attributes" => array(
							"NumCta" => $poliza["NumCta"],
							"Concepto" => $poliza["Concepto"],
							"Debe" => $poliza["Debe"],
							"Haber" => $poliza["Haber"],
							"Moneda" => $poliza["Moneda"],
							"TipCamb" => $poliza["TipCamb"],
						));
					
					if (count($asientos) > 0)
					{	
						$tmp = array_pop($trans);						
						$tmp["Comprobante"] = $asientos;
						$trans[] = $tmp;
					}
				}
				/*logg($tmp);
				logg($trans, 1);*/

				$polizas["PLZ"]["Poliza"][] = array(
					"@attributes" => array(
						"Tipo" => $movimiento["Tipo"],
						"Num" => $movimiento["Num"],
						"Fecha" => $movimiento["Fecha"],
						"Concepto" => $movimiento["Concepto"],
						),
					"Transaccion" => $trans,
				);
			}

			#logg($polizas["PLZ"]["Poliza"], 1);
			
			$xml = Array2XML::createXML('Polizas', $polizas);			
			return	$xml->saveXML();		
		}
		return false;
	}


	function prepare_diot($report_type, $res){
		
		if ($res["success"])
		{
			$lineas = $res["data"];
			$diot = array();

			foreach ($lineas as $index => $value) {

				$lineas_txt = array("", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "");
				$lineas_txt[0] = $value[0];
				$lineas_txt[1] = $value[1];
				$lineas_txt[2] = $value[2];
				$lineas_txt[3] = $value[3];
				$lineas_txt[4] = $value[4];
				$lineas_txt[5] = $value[5];
				$lineas_txt[6] = $value[6];
				$lineas_txt[7] = $value[7];
				$lineas_txt[10] = $value[8];
				$lineas_txt[17] = $value[9];
				$lineas_txt[19] = $value[10];
				$lineas_txt[20] = $value[11];
				
				$row = "";
				foreach ($lineas_txt as $idx => $val) {
					$row .= $val . "|";					
				}

				$diot[] = $row;
			}
			#logg($diot, 1);

			return $diot;
		}

		return false;
	}

	function prepare_catalogo($report_type, $res){

		if ($res["success"])
		{
			$cuentas = $res["data"]["Cuentas"];
			$html = "<html><header></header><body>";
			$html .= "<h1>Catalogo</h1>";		
			
			$html .= "<h3>Catalogo de Cuentas</h3>";	
			
			$html .= "<table>";
			$html .= "<tr>";				
			$html .= "<th>Codigo</th>";
			$html .= "<th>Nombre</th>";
			$html .= "<th>Padre</th>";
			$html .= "<th>Naturaleza</th>";		
			$html .= "<th>Nivel</th>";		
			$html .= "<th>SAT</th>";		
			$html .= "</tr>";
			/*$html .= "</table>";
			$html .= "</body></html>";
			return $html;*/
			foreach ($cuentas as $index => $cuenta){

				$html .= "<tr>";				
				$html .= "<td>" . $cuenta["NumCta"] .  "</td>";
				$html .= "<td>" . $cuenta["Desc"] .  "</td>";
				$html .= "<td>" . $cuenta["SubCtaDe"] .  "</td>";
				$html .= "<td>" . $cuenta["Natur"] .  "</td>";
				$html .= "<td>" . $cuenta["Nivel"] .  "</td>";
				$html .= "<td>" . $cuenta["CodAgrup"] .  "</td>";
				$html .= "</tr>";
			}

			$html .= "</table>";
			$html .= "</body></html>";

			return $html;
		}
		return false;
	}	

	function prepare_polizas($report_type, $res){

		if ($res["success"])
		{
			$html = "<html><header></header><body>";
			$html .= "<h1>Polizas</h1>";		
									
			$movimientos = array();

			foreach ($res["data"]["Movimientos"] as $index => $movimiento) {				
				
				$movimientos = array_merge($movimientos, $movimiento["Polizas"]);
			}						
			
			$moves = array();

			foreach ($movimientos as $index => $poliza) {
			
				$code = $poliza["NumCta"] . "-" . $poliza["Cta"];
				
				if (isset($moves[$code]))
				{
					$moves[$code][] = $poliza;	
				}
				else
				{
					$moves[$code] = array($poliza);	
				}
			}


			foreach ($moves as $index => $poliza){

				$html .= "<h3>" . $index . "</h3>";	
				$html .= "<table>";
				$html .= "<tr>";
				$html .= "<th>Concepto</th>";
				$html .= "<th>Fecha</th>";
				$html .= "<th>NumCta</th>";
				$html .= "<th>Debe</th>";
				$html .= "<th>Haber</th>";
				$html .= "<th>Acumulado</th>";		
				$html .= "<th>Moneda</th>";		
				$html .= "<th>TipoCambio</th>";		
				$html .= "</tr>";

				$acumulado = 0;

				foreach ($poliza as $idx => $asiento) {

					$debit = $asiento["Debe"];
					$credit = $asiento["Haber"];

					$acumulado = $acumulado + $debit - $credit;

					$html .= "<tr>";
					$html .= "<td>" . $asiento["Concepto"] . "</td>";
					$html .= "<td>" . $asiento["Fecha"] . "</td>";
					$html .= "<td>" . $asiento["NumCta"] . "</td>";
					$html .= "<td>" . $debit . "</td>";
					$html .= "<td>" . $credit . "</td>";
					$html .= "<td>" . $acumulado . "</td>";
					$html .= "<td>" . $asiento["Moneda"] . "</td>";
					$html .= "<td>" . $asiento["TipCamb"] . "</td>";
					$html .= "</tr>";				
				}

				$html .= "</table>";
				#logg($html, 1);
			}

			$html .= "</body></html>";

			return $html;
		}
		return false;
	}

	function prepare_balance($report_type, $res){

		if ($res["success"])
		{

			$cuentas = $res["data"]["Cuentas"];
			// logg($res["data"]["Cuentas"],1);
			$html = "<html><header></header><body>";

			$html .= "<h1>Balanza de Comprobaci&oacute;n</h1>";


			$html .= "<table>";
			$html .= "<tr>";
			$html .= "<th>Codigo</th>";
			$html .= "<th>Descripcion</th>";
			#$html .= "<th>Padre</th>";
	#		$html .= "<th>Nivel</th>";
	#		$html .= "<th>Tipo</th>";
			$html .= "<th>Saldo Inicial</th>";
			$html .= "<th>Debe</th>";
			$html .= "<th>Haber</th>";
			$html .= "<th>Saldo Final</th>";
			$html .= "</tr>";

			$rootValue = array();
			$rootReport = array();
			$root = false;
			foreach ($cuentas as $index => $value){

				#logg($value["Tipo"], 1);

				if ($value["Tipo"] == "Root/View" && $value["Padre"] == ""){
					$root = true;
					$rootValue["SaldoIni"] = $value["SaldoIni"];
					$rootValue["Debe"] = $value["Debe"];
					$rootValue["Haber"] = $value["Haber"];
					$rootValue["SaldoFin"] = $value["SaldoFin"];
					continue;
				}

				if ($value["Tipo"] == "Root/View" && $value["Padre"] != ""){				

					if (count($rootReport) > 0){	
						/*var_dump("1");*/
						$rootReport[] = array(
							"SaldoIni" => $value["SaldoIni"],
							"Debe" => $value["Debe"],
							"Haber" => $value["Haber"],
							"SaldoFin" => $value["SaldoFin"]
						);
						if ($report_type != "resultados" && $report_type != "balanza")
							continue;
					}				
						
					else{				
						/*var_dump("0");*/
						$rootReport[] = array(
							"SaldoIni" => $value["SaldoIni"],
							"Debe" => $value["Debe"],
							"Haber" => $value["Haber"],
							"SaldoFin" => $value["SaldoFin"]
						);
						if ($report_type != "balance" && $report_type != "balanza")
							continue;
					}
				}

					
				$html .= "<tr>";
				$html .= "<td>" . $value["NumCta"] . "</td>";
				$html .= "<td class='left'>" . $value["Desc"] . "</td>";
	#			$html .= "<td>" . $value["Padre"] . "</td>";
	#			$html .= "<td>" . $value["Nivel"] . "</td>";
	#			$html .= "<td>" . $value["Tipo"] . "</td>";
				$html .= "<td>" . number_format($value["SaldoIni"], 2) . "</td>";
				$html .= "<td>" . number_format($value["Debe"], 2) . "</td>";
				$html .= "<td>" . number_format($value["Haber"], 2) . "</td>";
				$html .= "<td>" . number_format($value["SaldoFin"], 2) . "</td>";
				$html .= "</tr>";
			}
			/*exit();*/
			if($root)
			{
				$html .= "<tr>";
				$html .= "<td class='total' colspan='2'>Totales</td>";
				$html .= "<td class='total'>" . number_format($rootValue["SaldoIni"], 2) . "</td>";
				$html .= "<td class='total'>" . number_format($rootValue["Debe"], 2) . "</td>";
				$html .= "<td class='total'>" . number_format($rootValue["Haber"], 2) . "</td>";
				$html .= "<td class='total'>" . number_format($rootValue["SaldoFin"], 2) . "</td>";
				$html .= "</tr>";
			}
			$html .= "</table>";
			$html .= "</body></html>";

			return $html;
		}	
		return false;	
	}
}

?>