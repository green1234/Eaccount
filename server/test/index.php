<?php
	
	require_once "../conf/constantes.conf";
	require_once PROYECT_PATH . "/server/Main.php";

	$usuario = $password = "admin";	

	$obj = new MainObject("common");
	$response = $obj->login($usuario, $password);

	echo "Login con Usuario admin Password admin <br>";


	if($response["success"])
	{
		echo "El usuario se ha logueado correctamente ID " . $response["data"]["id"] .  "<br>";
	}
	else
	{
		echo "Error " . $response["data"]["id"] . " : " . $response["data"]["description"] .  "<br>";	
	}

	echo "Listado de Usuarios <br>";

	$field = "name";
	$value = "Administrator";
	$model = "res.users";	

	$mo = new MainObject("object");
	$response = $mo->search(1, "admin", $model, array());

	if ($response["success"])
	{
		$params = array(			
					model("name", "string"),
					model("email", "string"),
					model("partner_id", "string"),
					model("company_id", "string"),
					model("company_ids", "string"));
				
		$ids = $response["data"]["id"]; 			
		$response = $mo->read(1, "admin", "res.users", $ids, $params);
		//var_dump($response["data"]); exit();
		echo "<table style='border:1px solid gray;'>";
		echo "<tr>";
		echo "<th style='border:1px solid gray;'>Nombre</th>";
		echo "<th style='border:1px solid gray;'>Email</th>";
		echo "<th style='border:1px solid gray;'>Empresa</th>";
		echo "</tr>";
		foreach ($response["data"] as $index => $value) {
			echo "<tr>";
			echo "<td style='border:1px solid gray;'>" . $value["name"] . "</td>";
			echo "<td style='border:1px solid gray;'>" . $value["email"] . "</td>";
			echo "<td style='border:1px solid gray;'>" . $value["company_id"][1] . "</td>";
			echo "</tr>";
		}
		echo "</table>";

		
	}
?>