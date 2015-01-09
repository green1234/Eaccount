<?php

require_once PROYECT_PATH . "/server/Main.php";
require_once PROYECT_PATH . "/service/UsuarioService.php";
require_once PROYECT_PATH . "/service/EmpresaService.php";

class LoginService
{
	var $uid;
	var $pwd;	
	var $obj;

	function __construct()
	{		
		$this->obj = new MainObject("common");
	}

	function acceder($usuario, $password)
	{
		$res = $this->obj->login($usuario, $password);

		if ($res["success"])
		{
			$this->uid = $res["data"]["id"];
			$this->pwd = $password;

			$usuario_service = new UsuarioService($this->uid, $password);
			$res = $usuario_service->obtener_datos($this->uid);

			if ($res["success"])
				return $res;
			// logg($res, 1);
			// $res = $usuario_service->obtener_planes($this->uid);
			
		}

		return array("success"=>false);
	}

}

?>