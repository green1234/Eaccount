<?php	

require_once "conf/constantes.conf";
require_once PROYECT_PATH . "/service/InvoiceService.php";
// logg($_FILES); exit();
if(count($_FILES) > 0 && isset($_GET["uid"]) && isset($_GET["pwd"]) && isset($_GET["cid"]))
{    
    // logg($_FILES); exit();
	$uid = $_GET["uid"];
	$pwd = $_GET["pwd"];
    $cid = $_GET["cid"];
	// $empresa_name = "MI EMPRESA";


	//$uploaddir = '/tmp/';
    //$uploaddir = 'C:\wamp\tmp';

    $uploaddir = TEMP . "/"; //'/tmp/';
    $responses = array("success" => true, "data" => array());
    $success = true;
    foreach ($_FILES["userfile"]["name"] as $index => $file_name) 
    {
        //logg($file_name);
        $uploadfile = $uploaddir . basename($_FILES['userfile']['name'][$index]);        
        if (move_uploaded_file($_FILES['userfile']['tmp_name'][$index], $uploadfile)) { 
            $type = 1;
            $service = new InvoiceService($uid, $pwd); 
            $params = array(
                "filename" => $_FILES['userfile']['name'][$index],
                "file" => $uploadfile,
                "cid"=> $cid);
            //$response = $service->importar_xml($_FILES['userfile']['name'][$index], $uploadfile, 1);
            $response = $service->importar_xml($params, 1);            
            $responses["data"][] = $response;          
        }
        else
        {
            $responses["data"][] = array(
                "success" => false, 
                "data" => array(
                    "description" => "No se pudo subir el archivo"));
        }
    }

    echo json_encode($responses);

    exit();
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
