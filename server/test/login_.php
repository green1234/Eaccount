<?php

	require_once "service/CommonService.php";
	require_once "service/ObjectService.php";

	$CommonService = new CommonService();	

	$uid = 0;
	$toarray = true;
	
	$response = json_decode($CommonService->login(), $toarray);		

	if(isset($response["success"]))
	{
		$uid = $response["data"]["value"];	
		echo "<h1>Se ha logueado correctamente</h1>";
	}
	else
	{
		echo "<h1>Error " . $response["error"] . " : " . $response["description"] . "</h1>";	
	}

	
?>