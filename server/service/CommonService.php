<?php

require_once PROYECT_PATH . "/server/Main.php";

class CommonService
{
	static function leer_catalogo_csv($uploadfile)
	{
		$registros = array();
		if (($fichero = fopen($uploadfile, "r")) !== FALSE)
		{
			$nombres_campos = fgetcsv($fichero, 0, ",", "\"", "\"");
		    $num_campos = count($nombres_campos);
		    
		    while (($datos = fgetcsv($fichero, 0, ",", "\"", "\"")) !== FALSE) 
		    {   
		        for ($i=0; $i<$num_campos; $i++) 
		        {
		        	$campo = $nombres_campos[$i];
		            $registro[$campo] = $datos[$i];
		        }	        
		        $registros[] = $registro;
		    }
		    fclose($fichero);
		}
		return $registros;
	}
}



?>