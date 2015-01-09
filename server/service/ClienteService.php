<?php

require_once PROYECT_PATH . "/server/Main.php";
require_once PROYECT_PATH . "/service/UsuarioService.php";
require_once PROYECT_PATH . "/service/EmpresaService.php";

class ClienteService
{
	var $uid;
	var $pwd;
	var $model_user = "res.users";
	var $model_company = "res.company";
	var $obj;
	var $usuarioService;
	var $empresaService;

	function __construct($uid, $pwd)
	{
		$this->uid = $uid;
		$this->pwd = $pwd;
		$this->obj = new MainObject();
		$this->usuarioService = new UsuarioService($uid, $pwd);
		$this->empresaService = new EmpresaService($uid, $pwd);
	}

	function registrarCliente($usuario, $empresa){

		$res = $this->empresaService->crear_empresa($empresa);
		$registrado = false;
		if ($res["success"])
		{	
		 	$empresa_id = $res["data"]["id"];
		 	$res = $this->usuarioService->crear_usuario($usuario, $empresa_id);
			
		 	if ($res["success"])
		 	{
		 		$usuario_id = $res["data"]["id"]; 
		 		$registrado = true;			
		 	}		 	
		}		

		if($registrado)
		{
			return array("success" => true, 
				"data" => array(
					"usuario_id" => $usuario_id, 
					"empresa_id" => $empresa_id));
		}
		
		return $res;
	}

}

?>