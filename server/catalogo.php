<?php

require_once "conf/constantes.conf";
require_once PROYECT_PATH . "/service/AccountTplService.php";

if(count($_FILES) > 0)
{
	$uid = 1;
	$pass = "admin";
	$empresa_name = "MI EMPRESA";

	$uploaddir = PROYECT_PATH . '/tmp/';
	$uploadfile = $uploaddir . basename($_FILES['userfile']['name']);

	if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {		
		$service = new AccountTplService($uid, $pass);
		$response = $service->crear_catalogo_template($empresa_name, $uploadfile);		
	}	

	var_dump($response);
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

<?php
}
?>