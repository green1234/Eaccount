<?php	

require_once "conf/constantes.conf";
require_once PROYECT_PATH . "/service/InvoiceService.php";
// var_dump ($_FILES);
if(count($_FILES) > 0)
{    
	$uid = 1;
	$pwd = "admin";
	$empresa_name = "MI EMPRESA";

	$uploaddir = '/tmp/';
	$uploadfile = $uploaddir . basename($_FILES['userfile']['name']);

	if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {	

        $type = 1;
        $service = new InvoiceService($uid, $pwd);      	
        $response = $service->importar_xml($_FILES['userfile']['name'], $uploadfile, 1);
        // $response = json_decode($response);
        // logg($response["success"],1);
        if ($response["success"])
        {
            $msj = "Cargada"; 
        }
        else
        {
            $msj = $response["data"]["description"];
        }

        header('Location: ../inbox_nuevo_conta.php?msj=' . $msj);


        // var_dump($response); exit();
        echo json_encode($response);
		/*
		$xml = simplexml_load_file($uploadfile, "SimpleXMLElement", LIBXML_PARSEHUGE | LIBXML_NOEMPTYTAG);
		
		$dom = new DOMDocument();
        $dom->load($uploadfile);

        $dom_output = new DOMDocument();
        $dom_output->formatOutput = true;

        $dom_sxe = dom_import_simplexml($xml);
        $dom_sxe = $dom_output->importNode($dom_sxe, true);
        $dom_sxe = $dom_output->appendChild($dom_sxe);

        $dom_output_string = $dom_output->saveXML($dom_output, LIBXML_NOEMPTYTAG);

        $xml = simplexml_load_string($dom_output_string);
        $uid = 1;
        $pwd = "admin";
        $isCfdi = false;
        $isNomina = false;
        $version = $xml->attributes()['version'];

        if($version >= 3.2)
        {
            if(strpos($dom_output_string, "cfdi:Emisor") !== false)
            {               
                $isCfdi = true;                
            }       
            
            if(strpos($dom_output_string, "<nomina") !== false)
            {
                $isNomina = true;
            }

            if ($isNomina || $isCfdi)
            {            
                $type = 1;
                $service = new InvoiceService($uid, $pwd);
                
                if ($isNomina)
                {
                    $type = 2;
                }
                
                $response = $service->importar_xml($_FILES['userfile']['name'], $uploadfile, $type);
            }
        }*/
	}	
}

?>