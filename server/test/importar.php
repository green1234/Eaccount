<?php

require_once "conf/constantes.conf";
require_once PROYECT_PATH . "/server/Main.php";

$uid = 1;
$pass = "admin";

$uploaddir = PROYECT_PATH . '/tmp/';
$uploadfile = $uploaddir . basename($_FILES['userfile']['name']);

if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {

	$uid = 1;
	$pass = "admin";
	$obj = new MainObject("object");

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

	    echo "Leidos " . count($registros) . " registros";
	    echo "<br><br>";	  
	    
	    #for ($i = 0; $i < 10; $i++) {

		$tipos = array(
			"Raiz"      => 1,
			"Cliente"   => 2,
			"Proveedor" => 3,
			"Banco"  => 4,
			"Caja"   => 5,
			"Activo" => 6,
			"Pasivo" => 7,
			"Ingreso" => 8,
			"Gasto"   => 9,
			"Vista de Ingreso" => 10,
			"Vista de Gasto"   => 11,
			"Vista de Activo"  => 12,
			"Vista de Pasivo"  => 13,
			);

		$main_account_name = "Mi Empresa Nueva";
		$main_account = array(
			"code" => model("0", "string"),
        	"name" => model($main_account_name, "string"),
        	"type" => model("view", "string"),
        	"user_type" => model(1, "int"));

		$response = $obj->create($uid, $pass, "account.account.template", $main_account);		
		$account_ids = array(); //Aqui se van a ir guardando los Ids de las cuentas indexados por el nombre

		if($response["success"])
		{
			// echo "<table style='border:1px solid gray;'>";
			// echo "<tr>";
			// echo "<th style='border:1px solid gray;'>Codigo</th>";
			// echo "<th style='border:1px solid gray;'>Descripcion</th>";
			// echo "<th style='border:1px solid gray;'>Padre</th>";	
			// echo "<th style='border:1px solid gray;'>Tipo</th>";
			// echo "<th style='border:1px solid gray;'>Clase</th>";	
			// echo "<th style='border:1px solid gray;'>Naturaleza</th>";	
			// echo "<th style='border:1px solid gray;'>Mayor</th>";	
			// echo "<th style='border:1px solid gray;'>Codigo Sat</th>";	
			// echo "</tr>";

			
			$main_account_id = $response["data"]["id"];
			$account_ids[$main_account_name] = $main_account_id;

			echo "Cuenta Raiz Creada ID " . $response["data"]["id"];

			for ($i = 0; $i < count($registros); $i++) {		        

				$name = $registros[$i]["name"];
				$parent = $registros[$i]["parent"];
				$tipo_cuenta = $registros[$i]["type"];
				$clase_cuenta = $registros[$i]["class"];
				$mayor = $registros[$i]["mayor"];

				if (isset($account_ids[$parent]))
					$parent_id = $account_ids[$parent];
				else
					$parent_id = $main_account_id;

				$tipo_cuenta_id = 0;
				$tipo_cuenta_name = "";

				if ($mayor == "1")
				{
					$tipo_cuenta_name = "view";
					switch ($clase_cuenta) {
						
						case 'A':
							$tipo_cuenta_id = $tipos["Vista de Activo"];
							break;

						case 'P':
							$tipo_cuenta_id = $tipos["Vista de Pasivo"];
							break;

						case 'I':
							$tipo_cuenta_id = $tipos["Vista de Ingreso"];
							break;

						case 'G':
							$tipo_cuenta_id = $tipos["Vista de Gasto"];
							break;						
						
					}
				}
				else
				{
					switch ($tipo_cuenta) {
						
						case 'caja':
							$tipo_cuenta_id = $tipos["Caja"];
							$tipo_cuenta_name = "liquidity";
							break;

						case 'banco':
							$tipo_cuenta_id = $tipos["Banco"];
							$tipo_cuenta_name = "liquidity";
							break;

						case 'cliente':
							$tipo_cuenta_id = $tipos["Cliente"];
							$tipo_cuenta_name = "receivable";
							break;

						case 'proveedor':
							$tipo_cuenta_id = $tipos["Proveedor"];
							$tipo_cuenta_name = "payable";
							break;

						default:

							$tipo_cuenta_name = "other";
							
							if ($clase_cuenta == "A"){
								$tipo_cuenta_id = $tipos["Activo"];								
							}
							else if ($clase_cuenta == "P"){
								$tipo_cuenta_id = $tipos["Pasivo"];								
							}
							
							else if ($clase_cuenta == "I"){
								$tipo_cuenta_id = $tipos["Ingreso"];								
							}
							
							else{
								$tipo_cuenta_id = $tipos["Gasto"];								
							}								
							
							break;
					}
				}

		        $params = array(
		        	"code" => model($registros[$i]["code"], "string"),
		        	"name" => model($name, "string"),
		        	"type" => model($tipo_cuenta_name, "string"),
		        	"user_type" => model($tipo_cuenta_id, "int"),
		        	"parent_id" => model($parent_id, "int")
		        );		        
		        
		    	$response = $obj->create($uid, $pass, "account.account.template", $params);        		

		    	if ($response["success"])
		    	{		    		
		    		$account_id = $response["data"]["id"];
		    		$account_ids[$name] = $account_id;

		    		if ($registros[$i]["default"] != "")
		    		{		   
		    			$default_type = $registros[$i]["default"];
		    			$defaults[$default_type] = $account_id;
		    		}

		   //  		echo "<tr>";
					// echo "<td style='border:1px solid gray;'>" . $registros[$i]["code"] . "</td>";
					// echo "<td style='border:1px solid gray;'>" . $registros[$i]["name"] . "</td>";			
					// echo "<td style='border:1px solid gray;'>" . $registros[$i]["parent"] . "</td>";
					// echo "<td style='border:1px solid gray;'>" . $registros[$i]["type"] . "</td>";
					// echo "<td style='border:1px solid gray;'>" . $registros[$i]["class"] . "</td>";
					// echo "<td style='border:1px solid gray;'>" . $registros[$i]["nature"] . "</td>";
					// echo "<td style='border:1px solid gray;'>" . $registros[$i]["mayor"] . "</td>";
					// echo "<td style='border:1px solid gray;'>" . $registros[$i]["sat"] . "</td>";
					// echo "</tr>";


		    	}
		    	else
		    	{
		    		echo "Ocurrio un error al cargar las cuentas";
		    		break;
		    	}	    			    	

		    }
		    // echo "</table>";
		    
		    $tax_tpl_code_model = "account.tax.code.template";

		    $tax_tpl_code = array(
				"name" => model($main_account_name, "string"),
				"sign" => model(1.0, "float")
				);			

			$response = $obj->create($uid, $pass, $tax_tpl_code_model, $tax_tpl_code);

			// Se registro correctamente el codigo raiz de los impuestos
			if ($response["success"])
			{
				$tax_tpl_code_id = $response["data"]["id"];

				$chart_tpl_model = "account.chart.template";

				$chart_tpl = array(
					"name" => model($main_account_name, "string"),	
					"account_root_id" => model($main_account_id, "int"),
					"bank_account_view_id" => model($main_account_id, "int"),
					"tax_code_root_id" => model($tax_tpl_code_id, "int"),
					"visible" => model(true, "boolean"),					
				);

				$response = $obj->create($uid, $pass, $chart_tpl_model, $chart_tpl);

				#Se registro correctamente el plan de cuentas
				if ($response["success"])
				{
					$chart_tpl_id = $response["data"]["id"];
					$iva_venta = $defaults["iva_venta"];
					$iva_compra = $defaults["iva_compra"];

					$tax_tpl_model = "account.tax.template";
					$tax_tpl_sale = array(
						"name" => model("IVA DE VENTA 16%", "string"),
						"chart_template_id" => model($chart_tpl_id, "int"),
						"type" => model("percent", "string"),
						"type_tax_use" => model("sale", "string"),
						"applicable_type" => model("true", "string"),
						"amount" => model(16, "int"),
						"sequence" => model(1, "int"),
						"account_collected_id" => model($iva_venta, "int"),
						"account_paid_id" => model($iva_venta, "int"),
					);

					$tax_tpl_purchase = array(
						"name" => model("IVA DE COMPRA 16%", "string"),
						"chart_template_id" => model($chart_tpl_id, "int"),
						"type" => model("percent", "string"),
						"type_tax_use" => model("purchase", "string"),
						"applicable_type" => model("true", "string"),
						"amount" => model(16, "int"),
						"sequence" => model(1, "int"),
						"account_collected_id" => model($iva_compra, "int"),
						"account_paid_id" => model($iva_compra, "int"),
					);

					var_dump("Impuestos");
					
					$response = $obj->create($uid, $pass, $tax_tpl_model, $tax_tpl_sale);
					var_dump($response);
					$response = $obj->create($uid, $pass, $tax_tpl_model, $tax_tpl_purchase);
					var_dump($response); exit();
				}
			}


		}
		else{
			echo "Error al cargar las cuentas";
		}		
	    
	    var_dump($defaults); exit();
	    // var_dump($account_ids); exit();

	}
}
else{
	echo "No se pudieron cargar los datos";	
}
//var_dump($_FILES);
?>