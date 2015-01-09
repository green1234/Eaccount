<?php
	
	require_once "../conf/constantes.conf";
	require_once PROYECT_PATH . "/server/Main.php";

	$usuario = $password = "admin";	

	$obj = new MainObject("common");
	$response = $obj->login($usuario, $password);

	echo "Login con Usuario admin Password admin <br>";


	if($response["success"])
	{
		echo "El usuario se logueo correctamente ID ID " . $response["data"]["id"] .  "<br>";
	}
	else
	{
		echo $response["data"]["description"] .  "<br>";	
	}

	echo "Listado de Catalogos de Cuentas SAT<br>";

	$field = "name";
	$value = "Administrator";
	$model = "res.users";	

	$domain = array(
		array(
			model("tipo", "string"),
			model("=", "string"),
			model("account", "string")
			)
		);


	$mo = new MainObject("object");
	$response = $mo->search(1, "admin", "gl.cat.sat", $domain);

	if ($response["success"])
	{
		$params = array(			
					model("name", "string"),
					model("description", "string"),					
				);
		$ids = $response["data"]["id"]; 			
		$response = $mo->read(1, "admin", "gl.cat.sat", $ids, $params);
		//var_dump($response["data"]); exit();
		echo "<table style='border:1px solid gray;'>";
		echo "<tr>";
		echo "<th style='border:1px solid gray;'>Codigo</th>";
		echo "<th style='border:1px solid gray;'>Descripcion</th>";	
		echo "</tr>";
		foreach ($response["data"] as $index => $value) {
			echo "<tr>";
			echo "<td style='border:1px solid gray;'>" . $value["name"] . "</td>";
			echo "<td style='border:1px solid gray;'>" . $value["description"] . "</td>";			
			echo "</tr>";
		}
		echo "</table>";

		
	}
?>