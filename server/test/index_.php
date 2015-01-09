<?php
	
	require_once "service/ObjectService.php";
	require_once "service/CommonService.php";

	$uid = 1;
	$user = "admin";
	$pass = "admin";
	$toarray = true;
	$empresa = "Mi empresa nueva 7";
	$usuario_nombre = "Demo7";
	$usuario_username = "demo7";
	$login = false;

	#Primero nos logueamos al sistema
	echo "Se esta logueando con usuario " . $user . " password " . $pass . "<br>";

	$CommonService = new CommonService();
	$response = $CommonService->login($user, $pass);
	$response = json_decode($response, $toarray);

	if (isset($response["success"]))
	{
		echo "Inicio Sesion correctamente <br>";
		$uid = $response["data"]["value"];
		$login = true;
	}
	else
	{
		echo $response["description"] . "<br>";
	}

	if ($login)
	{

		echo "Asociando empresa";
		$ObjectService = new ObjectService($uid, "admin");
		$response = $ObjectService->asociar_empresa(13, true);
		$response = json_decode($response, $toarray);
		prep($response);
		exit();

		// echo "Obteniendo empresas asociadas";
		// $ObjectService = new ObjectService($uid, "admin");
		// $response = $ObjectService->obtener_empresas(13);
		// $response = json_decode($response, $toarray);
		// prep($response);
		// exit();

		echo "Creando empresa " . $empresa . "<br>";

		$ObjectService = new ObjectService($uid, $pass);
		$response = $ObjectService->registra_empresa($empresa);
		$response = json_decode($response, $toarray);

		$empresa_id = 0;		

		if($response["success"])
		{
			$empresa_id = $response["data"]["id"];	
			echo $response["data"]["description"] . " ID " . $empresa_id . "<br>";
		}
		else
		{
			$empresa_id = $response["data"]["id"];
			echo "Error " . $response["data"]["error"] . " : " . $response["data"]["description"] . "<br>";			
		}
		
		//echo "Registrando Usuario " . $usuario_nombre . " EMPRESA : " . $empresa_id . "<br>"; 

		//$ObjectService = new ObjectService($uid, $pass);
		$response = $ObjectService->registra_usuario($usuario_nombre, $usuario_username, $empresa_id);
		$response = json_decode($response, $toarray);		

		//prep($response);

		if($response["success"])
		{			
			$user_id = $response["data"]["id"];	
			echo $response["data"]["description"] . " ID " . $user_id . "<br>";
		}
		else
		{
			prep($response);
			$user_id = $response["data"]["id"];
			echo "Error " . $response["data"]["error"] . " : " . $response["data"]["description"] . "<br>";
		}

		echo "Obteniendo empresas asociadas";
		$res = $ObjectService->obtener_empresas($user_id);


	}
	else
	{
		echo "Debe iniciar sesion para registrar una empresa <br>";
	}

	
?>