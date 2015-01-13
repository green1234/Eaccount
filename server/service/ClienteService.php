<?php

require_once PROYECT_PATH . "/server/Main.php";
require_once PROYECT_PATH . "/service/UsuarioService.php";
require_once PROYECT_PATH . "/service/EmpresaService.php";
require_once PROYECT_PATH . "/service/MailService.php";

class ClienteService
{
	var $uid;
	var $pwd;
	var $model_user = "res.users";
	var $model_company = "res.company";
	var $obj;
	var $usuarioService;
	var $empresaService;

	// El usuario que se encargara de los registros se llamara
	// Landing_user
	function __construct($uid, $pwd)
	{
		$this->uid = $uid;
		$this->pwd = $pwd;
		$this->obj = new MainObject();
		$this->usuarioService = new UsuarioService($uid, $pwd);
		$this->empresaService = new EmpresaService($uid, $pwd);
	}
	// El proceso de suscripcion y registro de un cliente nuevo
	// implica realizar los registros en los distintos modelos
	// Usuario "res.users",
	// Empresa "res.company"
	function registrarCliente($usuario, $empresa){

		$res = $this->empresaService->crear_empresa($empresa);		
		$registrado = false;
		
		if ($res["success"])
		{	
		 	$empresa_id = $res["data"]["id"];		 	
		 	$res = $this->usuarioService->crear_usuario($usuario, $empresa_id);
			
		 	if ($res["success"])
		 	{
		 		$usuario_data = $res["data"];
		 		$usuario_id = $usuario_data["id"]; 		 		
		 		$registrado = true;			
		 	}		 	
		}		

		if($registrado)
		{			
			$this->enviar_confirmacion($usuario_data["partner_id"][0]);
			
			return array("success" => true, 
				"data" => array(
					"usuario_id" => $usuario_data, 
					"empresa_id" => $empresa_id));
		}
		
		return $res;
	}

	function enviar_confirmacion($partner_id)
	{
		$ids = array($partner_id);
		$mail = new MailService($this->uid, $this->pwd);
		$path = APPNAME . "/planes.php";
		$params = array(
			"partner_ids" => $ids,
			"message" => "Da click en la siguente liga para confirmar tu suscripcion
							<a href='$path'>Confirmar</a>
							",
			"title" => "Suscripción"
		);

		$mail->enviar_mail($params);

		return array("success"=>true);
	}
}

?>