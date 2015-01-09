<?php	

require_once "conf/constantes.conf";
require_once PROYECT_PATH . "/service/EmpresaService.php";
require_once PROYECT_PATH . "/service/AccountTplService.php";
require_once PROYECT_PATH . "/service/InvoiceService.php";

function get_complemento_timbrado_fiscal($xml, $isCFDIFormat, $isCFDFormat)
{
    $data = null;
    
    if($isCFDIFormat)
    {
        $data = $xml->children('cfdi', true)->Complemento->children("tfd",true)->attributes();     
    }
    else if($isCFDFormat)
    {
        $data = $xml->children('cfd', true)->Complemento->children("tfd",true)->attributes();      
    }
    else
    {
        $data = $xml->Complemento->children("tfd",true)->attributes(); 
    }
    
    #logg($data,1);
    return $data;
}

function get_emisor($xml, $isCFDIFormat, $isCFDFormat)
{
    $data = null;
    
    if($isCFDIFormat)
    {
        $data = $xml->children('cfdi', true)->Emisor->attributes();        
    }
    else if($isCFDFormat)
    {
        $data = $xml->children('cfd', true)->Emisor->attributes();        
    }
    else
    {
        $data = $xml->Emisor->attributes();   
    }
    
    return $data;
}

function get_emisor_domicilio_fiscal($xml, $isCFDIFormat, $isCFDFormat)
{
    $data = null;
    
    if($isCFDIFormat)
    {
        $data = $xml->children('cfdi', true)->Emisor->DomicilioFiscal->attributes();       
    }
    else if($isCFDFormat)
    {
        $data = $xml->children('cfd', true)->Emisor->DomicilioFiscal->attributes();       
    }
    else
    {
        $data = $xml->Emisor->DomicilioFiscal->attributes();   
    }
    
    return $data;
}

function get_emisor_regimen_fiscal($xml, $isCFDIFormat, $isCFDFormat)
{
    $data = null;
    
    if($isCFDIFormat)
    {
        $data = $xml->children('cfdi', true)->Emisor->RegimenFiscal->attributes();       
    }
    else if($isCFDFormat)
    {
        $data = $xml->children('cfd', true)->Emisor->RegimenFiscal->attributes();       
    }
    else
    {
        $data = $xml->Emisor->RegimenFiscal->attributes();   
    }
    
    return $data;    
}

function get_receptor($xml, $isCFDIFormat, $isCFDFormat)
{
    $data = null;
    
    if($isCFDIFormat)
    {
        $data = $xml->children('cfdi', true)->Receptor->attributes();      
    }
    else if($isCFDFormat)
    {
        $data = $xml->children('cfd', true)->Receptor->attributes();       
    }
    else
    {
        $data = $xml->Receptor->attributes();   
    }
    
    return $data;    
}

function get_receptor_domicilio_fiscal($xml, $isCFDIFormat, $isCFDFormat)
{
    $data = null;
    
    if($isCFDIFormat)
    {
        $data = $xml->children('cfdi', true)->Receptor->Domicilio->attributes();      
    }
    else if($isCFDFormat)
    {
        $data = $xml->children('cfd', true)->Receptor->Domicilio->attributes();       
    }
    else
    {
        $data = $xml->Receptor->Domicilio->attributes();   
    }
    
    return $data;    
}

function get_impuestos($xml, $isCFDIFormat, $isCFDFormat)
{
    $data = null;
    
    if($isCFDIFormat)
    {
        $data = $xml->children('cfdi', true)->Impuestos->attributes();      
    }
    else if($isCFDFormat)
    {
        $data = $xml->children('cfd', true)->Impuestos->attributes();      
    }
    else
    {
        $data = $xml->Impuestos->attributes(); 
    }
    
    return $data;    
}

function get_conceptos($xml, $isCFDIFormat, $isCFDFormat)
{
    $data = null;
    
    if($isCFDIFormat)
    {
        $data = $xml->children('cfdi', true)->Conceptos;
    }
    else if($isCFDFormat)
    {
        $data = $xml->children('cfd', true)->Conceptos;       
    }
    
    if(count($data) == 0)
    {
        $data = $xml->Conceptos;   
    }
    
    return $data;  
}

function get_all_conceptos($conceptosParent, $isCFDIFormat, $isCFDFormat)
{
    $data = null;
    
    if($isCFDIFormat)
    {
        $data = $conceptosParent->children("cfdi",true);
    }
    else if($isCFDFormat)
    {
        $data = $conceptosParent->children("cfd",true);       
    }
    else
    {
    }
    
    return $data;
}

function verificaFactura($userRFC, $emisorRFC, $receptorRFC)
{
    $response = 0;
//        _log($userRFC . " == " . $emisorRFC . " == " . $receptorRFC);
    if($userRFC == $emisorRFC || $userRFC == $receptorRFC)
    {
        $response = 1;
    }
    else
    {
        $response = -1;
    }
    return $response;
}

function validaFactura($rfcEmisor, $rfcReceptor, $total, $folio)
{
    try {
        $client = new SoapClient("https://consultaqr.facturaelectronica.sat.gob.mx/ConsultaCFDIService.svc?wsdl");
    } catch (Exception $e) {
        _log($e->getMessage());
    }

    $cadena = "re=$rfcEmisor&rr=$rfcReceptor&tt=$total&id=$folio";

    $param = array(
        'expresionImpresa' => $cadena
    );

    return $client->Consulta($param);
}

function procesar_cfdi($file, $xml, $isCFDIFormat, $isCFDFormat){

	$cfdi_data = array();

	$timbradoFiscal = get_complemento_timbrado_fiscal($xml, $isCFDIFormat, $isCFDFormat);
    #logg($timbradoFiscal);
	$emisor = get_emisor($xml, $isCFDIFormat, $isCFDFormat);
    #logg($emisor);
	$emisorDomicilioFiscal = get_emisor_domicilio_fiscal($xml, $isCFDIFormat, $isCFDFormat);
    #logg($emisorDomicilioFiscal);
    $emisorRegimenFiscal = get_emisor_regimen_fiscal($xml, $isCFDIFormat, $isCFDFormat);
    #logg($emisorRegimenFiscal);
    $receptor = get_receptor($xml, $isCFDIFormat, $isCFDFormat);
    #logg($receptor);
    $receptorDomicilioFiscal = get_receptor_domicilio_fiscal($xml, $isCFDIFormat, $isCFDFormat);
    #logg($receptorDomicilioFiscal);
    $impuestos = get_impuestos($xml, $isCFDIFormat, $isCFDFormat);
    #logg($impuestos);
    $conceptos = get_conceptos($xml, $isCFDIFormat, $isCFDFormat);
    #logg($conceptos);
    $all_conceptos = get_all_conceptos($conceptos, $isCFDIFormat, $isCFDFormat);
    #logg($all_conceptos);

    $conceptos = array();
    $i=0;
    foreach ($all_conceptos as $index => $concepto) {
        $data = $concepto->attributes();
        $conceptos[$i]["cantidad"] = (string)$data["cantidad"];
        $conceptos[$i]["unidad"] = (string)$data["unidad"];
        $conceptos[$i]["noIdentificacion"] = (string)$data["noIdentificacion"];
        $conceptos[$i]["descripcion"] = (string)$data["descripcion"];
        $conceptos[$i]["valorUnitario"] = (string)$data["valorUnitario"];
        $conceptos[$i]["importe"] = (string)$data["importe"];
        $i++;
    }

    $cfdi_data["uuid"] = (string)$timbradoFiscal["UUID"]; #$uuid = $timbradoFiscal["UUID"];
	$cfdi_data["version"] = ($xml["version"] == null) ? 0 : (float)$xml["version"]; #$version = $xml["version"];
    $cfdi_data["folio"] = ($xml["folio"] == null) ? 0 : (string)$xml["folio"]; #$folio = $xml["folio"];
    $cfdi_data["serie"] = (string)$xml["serie"]; #$serie = $xml["serie"];
    $cfdi_data["fecha"] = (string)$xml["fecha"]; #$fecha_hora = $xml["fecha"];
    $cfdi_data["formaDePago"] = (string)$xml["formaDePago"]; #$formaDePago = $xml["formaDePago"];
    $cfdi_data["subTotal"] = (string)$xml["subTotal"]; #$subTotal = $xml["subTotal"];
    $cfdi_data["subTotalOriginal"] = (string)$xml["subTotal"]; #$subTotalOriginal = $xml['subTotal'];
    $cfdi_data["total"] = (string)$xml["total"]; #$total = $xml["total"];
    $cfdi_data["totalOriginal"] = (string)$xml["total"]; #$totalOriginal = $xml["total"];
    $cfdi_data["moneda"] = ($xml["Moneda"] != null) ? (string)$xml["Moneda"] : ""; #$moneda = $xml["Moneda"];
    $cfdi_data["peso"] = false; #$peso = false;
    $cfdi_data["monedaForanea"] = false; #$monedaForanea = false;
    $cfdi_data["TipoCambio"] = ($xml["TipoCambio"] == null) ? 1 : (string)$xml["TipoCambio"]; #$tipoCambio = $xml["TipoCambio"];
    $cfdi_data["NumCtaPago"] = (string)$xml["NumCtaPago"]; #$numCtaPago = $xml["NumCtaPago"];
    $cfdi_data["descuento"] = ($xml["descuento"] != null) ? $xml["descuento"] : 0; #$descuento = 0;
    $cfdi_data["metodoDePago"] = (string)$xml["metodoDePago"]; #$metodoDePago = $xml["metodoDePago"];
    $cfdi_data["tipoComprobante"] = (string)$xml["tipoComprobante"]; #$tipoComprobante = $xml["tipoComprobante"];
    $cfdi_data["LugarExpedicion"] = (string)$xml["LugarExpedicion"]; #$lugarExpedicion = $xml["LugarExpedicion"];
    $cfdi_data["emisorRFC"] = (string)$emisor["rfc"]; #$emisorRFC = $emisor["rfc"];
    $cfdi_data["emisorNombre"] = ucfirst(strtolower($emisor["nombre"])); #$emisorNombre = ucfirst(strtolower($emisor["nombre"]));
    $cfdi_data["emisorDomicilioCalle"] = (string)$emisorDomicilioFiscal["calle"]; #$emisorDomicilioCalle = $emisorDomicilioFiscal["calle"];
    $cfdi_data["emisorDomicilioNoExterior"] = (string)$emisorDomicilioFiscal["noExterior"]; #$emisorDomicilioNoExterior = $emisorDomicilioFiscal["noExterior"];
    $cfdi_data["emisorDomicilioNoInterior"] = (string)$emisorDomicilioFiscal["noInterior"]; #$emisorDomicilioNoInterior = $emisorDomicilioFiscal["noInterior"];
    $cfdi_data["emisorDomicilioColonia"] = (string)$emisorDomicilioFiscal["colonia"];#$emisorDomicilioColonia = $emisorDomicilioFiscal["colonia"];
    $cfdi_data["emisorDomicilioMunicipio"] = (string)$emisorDomicilioFiscal["municipio"]; #$emisorDomicilioMunicipio = $emisorDomicilioFiscal["municipio"];
	$cfdi_data["emisorDomicilioEstado"] = (string)$emisorDomicilioFiscal["estado"];  # $emisorDomicilioEstado = $emisorDomicilioFiscal["estado"];
    $cfdi_data["emisorDomicilioPais"] = (string)$emisorDomicilioFiscal["pais"]; #$emisorDomicilioPais = $emisorDomicilioFiscal["pais"];
    $cfdi_data["emisorDomicilioLocalidad"] = (string)$emisorDomicilioFiscal["localidad"]; #$emisorDomicilioLocalidad = $emisorDomicilioFiscal["localidad"];
    $cfdi_data["emisorDomicilioCP"] = (string)$emisorDomicilioFiscal["codigoPostal"]; #$emisorDomicilioCP = $emisorDomicilioFiscal["codigoPostal"];
    $cfdi_data["receptorRFC"] = (string)$receptor["rfc"]; #$receptorRFC = $receptor["rfc"];
    $cfdi_data["receptorNombre"] = (string)$receptor["nombre"]; #$receptorNombre = $receptor["nombre"];
    $cfdi_data["receptorDomicilioCalle"] = (string)$receptorDomicilioFiscal["calle"]; #$receptorDomicilioCalle = $receptorDomicilioFiscal["calle"];
    $cfdi_data["receptorDomicilioNoExterior"] = (string)$receptorDomicilioFiscal["noExterior"]; #$receptorDomicilioNoExterior = $receptorDomicilioFiscal["noExterior"];
    $cfdi_data["receptorDomicilioNoInterior"] = (string)$receptorDomicilioFiscal["noInterior"]; #$receptorDomicilioNoInterior = $receptorDomicilioFiscal["noInterior"];
    $cfdi_data["receptorDomicilioColonia"] = (string)$receptorDomicilioFiscal["colonia"]; #$receptorDomicilioColonia = $receptorDomicilioFiscal["colonia"];
    $cfdi_data["receptorDomicilioMunicipio"] = (string)$receptorDomicilioFiscal["municipio"]; #$receptorDomicilioMunicipio = $receptorDomicilioFiscal["municipio"];
    $cfdi_data["receptorDomicilioEstado"] = (string)$receptorDomicilioFiscal["estado"]; #$receptorDomicilioEstado = $receptorDomicilioFiscal["estado"];
    $cfdi_data["receptorDomicilioPais"] = (string)$receptorDomicilioFiscal["pais"]; #$receptorDomicilioPais = $receptorDomicilioFiscal["pais"];
    $cfdi_data["receptorDomicilioLocalidad"] = (string)$receptorDomicilioFiscal["localidad"]; #$receptorDomicilioLocalidad = $receptorDomicilioFiscal["localidad"];
    $cfdi_data["receptorDomicilioCP"] = (string)$receptorDomicilioFiscal["codigoPostal"]; #$receptorDomicilioCP = $receptorDomicilioFiscal["codigoPostal"];
    $cfdi_data["totalImpuestosTrasladados"] = (string)$impuestos["totalImpuestosTrasladados"]; #$totalImpuestosTrasladados = $impuestos["totalImpuestosTrasladados"];
    $cfdi_data["totalImpuestosTrasladadosOriginal"] = (string)$impuestos["totalImpuestosTrasladados"]; #$totalImpuestosTrasladadosOriginal = $impuestos["totalImpuestosTrasladados"];
    $cfdi_data["totalImpuestosRetenidos"] = (string)$impuestos["totalImpuestosRetenidos"]; #$totalImpuestosRetenidos = $impuestos["totalImpuestosRetenidos"];
    $cfdi_data["totalImpuestosRetenidosOriginal"] = (string)$impuestos["totalImpuestosRetenidos"]; #$totalImpuestosRetenidosOriginal = $impuestos["totalImpuestosRetenidos"];
    $cfdi_data["selloCFD"] = (string)$timbradoFiscal["selloCFD"]; #$selloCFD = $timbradoFiscal["selloCFD"];
    $cfdi_data["fechaTimbrado"] = (string)$timbradoFiscal["FechaTimbrado"]; #$fechaTimbrado = $timbradoFiscal["FechaTimbrado"];
    $cfdi_data["versionTimbrado"] = (string)$timbradoFiscal["version"]; #$versionTimbrado = $timbradoFiscal["version"];
    $cfdi_data["noCertificadoSAT"] = (string)$timbradoFiscal["noCertificadoSAT"]; #$noCertificadoSAT = $timbradoFiscal["noCertificadoSAT"];
    $cfdi_data["selloSAT"] = (string)$timbradoFiscal["selloSAT"]; #$selloSAT = $timbradoFiscal["selloSAT"];
    $cfdi_data["satValido"] = -1; #$satValido = -1;
    $cfdi_data["comprobanteVerificado"] = false; #$comprobanteVerificado = verificaFactura($userRFC, $emisorRFC, $receptorRFC);
    $cfdi_data["respuestaSAT"] = ""; #$respuestaSAT = "";	
    $cfdi_data["conceptos"] = $conceptos;

    $userRFC = "LOVG880408E79";
    $userRFC = "MAFM5901031L8";
    $cfdi_data["comprobanteVerificado"] = verificaFactura($userRFC, $cfdi_data["emisorRFC"], $cfdi_data["receptorRFC"]);
    #logg("Comprobante Verificado");
    #logg($cfdi_data["comprobanteVerificado"]);

    if ($cfdi_data["totalImpuestosRetenidos"] == null) {
        $cfdi_data["totalImpuestosRetenidos"] = 0;
        $cfdi_data["totalImpuestosRetenidosOriginal"] = 0;
    }

    if ($cfdi_data["totalImpuestosTrasladados"] == null) {
        $cfdi_data["totalImpuestosTrasladados"] = 0;
        $cfdi_data["totalImpuestosTrasladadosOriginal"] = 0;
    }
   
    if ($cfdi_data["emisorDomicilioNoInterior"] == null) {
        $cfdi_data["emisorDomicilioNoInterior"] = "";
    }
    if ($cfdi_data["emisorDomicilioColonia"] == null) {
        $cfdi_data["emisorDomicilioColonia"] = "";
    }
    if ($cfdi_data["emisorDomicilioCP"] == null) {
        $cfdi_data["emisorDomicilioCP"] = 0;
    }
    if ($cfdi_data["receptorDomicilioNoInterior"] == null) {
        $cfdi_data["receptorDomicilioNoInterior"] = "";
    }
    if ($cfdi_data["receptorDomicilioColonia"] == null) {
        $cfdi_data["receptorDomicilioColonia"] = "";
    }
    if ($cfdi_data["receptorDomicilioCP"] == null) {
        $cfdi_data["receptorDomicilioCP"] = 0;
    }
    $moneda = $cfdi_data["moneda"];

    if((stristr($moneda, 'm') !== FALSE && ((stristr($moneda, 'x') !== FALSE) || (stristr($moneda, 'n') !== FALSE))) && ($tipoCambio != "1"))
    {
        $cfdi_data["peso"] = true;
        $cfdi_data["monedaForanea"] = false;
    }
    else if($moneda === "")
    {
        $cfdi_data["peso"] = true;
        $cfdi_data["monedaForanea"] = false;   
    }
    else
    {
        $cfdi_data["peso"] = false;
        $cfdi_data["monedaForanea"] = true;
    }
    $emisorRFC = $cfdi_data["emisorRFC"];
    $receptorRFC = $cfdi_data["receptorRFC"];
    $total = $cfdi_data["total"];
    $uuid = $cfdi_data["uuid"];
    // $respuestaSAT = $cfdi_data["respuestaSAT"];
    $cfdi_data["respuestaSAT"] = validaFactura($emisorRFC, $receptorRFC, $total, $uuid)->ConsultaResult->CodigoEstatus;
    $found = strpos($cfdi_data["respuestaSAT"], "S");
    //echo print_r($found);
    if ($found === false) {
        $cfdi_data["satValido"] = -1;
    } else {
        $cfdi_data["satValido"] = 1;
    }

    $monedaForanea = $cfdi_data["monedaForanea"];
    $tipoCambio = $cfdi_data["TipoCambio"];
    $totalImpuestosRetenidos = $cfdi_data["totalImpuestosRetenidos"];
    $totalImpuestosTrasladados = $cfdi_data["totalImpuestosTrasladados"];

    //Check for foreign currency
    if($monedaForanea === true)
    {
        $cfdi_data["total"] = floatval($total) * floatval($tipoCambio);
        $cfdi_data["subTotal"] = floatval($subTotal) * floatval($tipoCambio);
        $cfdi_data["totalImpuestosRetenidos"] = floatval($totalImpuestosRetenidos) * floatval($tipoCambio);
        $cfdi_data["totalImpuestosTrasladados"] = floatval($totalImpuestosTrasladados) * floatval($tipoCambio);
    }

    logg("Valida Factura SAT");

    logg($cfdi_data, 1);



}

if(count($_FILES) > 0)
{    
	$uid = 1;
	$pass = "admin";
	$empresa_name = "MI EMPRESA";

	$uploaddir = PROYECT_PATH . '/tmp/';
	$uploadfile = $uploaddir . basename($_FILES['userfile']['name']);

	if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {		
		
		$xml = simplexml_load_file($uploadfile, "SimpleXMLElement", LIBXML_PARSEHUGE | LIBXML_NOEMPTYTAG);
		#logg($xml);	

		$dom = new DOMDocument();
        $dom->load($uploadfile);

        $dom_output = new DOMDocument();
        $dom_output->formatOutput = true;

        $dom_sxe = dom_import_simplexml($xml);
        $dom_sxe = $dom_output->importNode($dom_sxe, true);
        $dom_sxe = $dom_output->appendChild($dom_sxe);

        #logg($dom_sxe);

        $dom_output_string = $dom_output->saveXML($dom_output, LIBXML_NOEMPTYTAG);

        $xml = simplexml_load_string($dom_output_string);
        $uid = 1;
        $pwd = "admin";
        $isCFDIFormat = false;
        $isNomina = false;
        $version = $xml->attributes()['version'];

        if(strpos($dom_output_string, "cfdi:Emisor") !== false)
        {
            if($version >= 3.2)
            {               
                $isCFDIFormat = true;
                #$success = procesar_cfdi($uploadfile, $xml, $isCFDIFormat, $isCFDFormat);
            }            
        }       
        
        if(strpos($dom_output_string, "<nomina") !== false)
        {
            if($version >= 3.2)
            {
                $isNomina = true;            
                #$success = procesar_cfdi($uploadfile, $xml, $isCFDIFormat, $isCFDFormat);
            }
        }

        if ($isNomina || $isCFDIFormat)
        {            
            $type = 1;
            $service = new InvoiceService($uid, $pwd);
            
            if ($isNomina)
            {
                $type = 2;
            }
            
            $response = $service->importar_xml($_FILES['userfile']['name'], $uploadfile, $type);
        }

		logg($xml, 1);	
	}	

}
else
{

?>

<form enctype="multipart/form-data" action="" method="POST">
    <!-- MAX_FILE_SIZE debe preceder el campo de entrada de archivo -->
    <input type="hidden" name="MAX_FILE_SIZE" value="30000" />
    <!-- El nombre del elemento de entrada determina el nombre en el array $_FILES -->
    Enviar este archivo: <input name="userfile" type="file" />
    <input type="submit" value="Send File" />
</form>

<?php } ?>