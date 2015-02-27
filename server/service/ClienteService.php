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

	function registrar_cliente($usuario, $empresa){
		
		$res = $this->empresaService->crear_empresa($empresa);		
		$registrado = false;
		
		if ($res["success"])
		{	
		 	$empresa_id = $res["data"]["id"];	
		 	unset($usuario["password"]);	 	
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
			return array("success" => true, 
				"data" => array(
					"usuario_id" => $usuario_data, 
					"empresa_id" => $empresa_id));
		}
		
		return $res;
	}

	function registrar_suscripcion($usuario, $empresa)
	{
		date_default_timezone_set("America/Mexico_City");
		$model = "gl.suscripcion";
		$folio = md5($usuario["email"] . $usuario["name"]);
		$data = array(
			"name" => $folio,
			"nombre" => $usuario["name"],
			"email" => $usuario["email"],
			"password" => $usuario["password"],
			"date" => date("Y-m-d"),
			"status" => "draft");
		
		$data = prepare_params($data);
		$registro = $this->obj->create($this->uid, $this->pwd, $model, $data);

		if ($registro["success"])
		{
			$registro_id = $registro["data"]["id"];
			$res = $this->registrar_cliente($usuario, $empresa);
			if ($res["success"])
			{
				$usuario_data = $res["data"]["usuario_id"];
				$user_id = $usuario_data["id"];
				$company_id = $res["data"]["empresa_id"];

				// $attrs = array(
				// 	"user_id" => $user_id, 
				// 	"company_id" => $company_id);
				$attrs = prepare_params(array(
										"user_id" => $user_id, 
										"company_id" => $company_id));

				$this->obj->write($this->uid, $this->pwd, 
					$model, array($registro_id), $attrs);

				$this->enviar_confirmacion($usuario_data["partner_id"][0], $folio);
			}

			return $res;
		}

		return array(
			"success"=>false, 
			"data"=>array(
				"description" => "Occurrio un error al realizar el registro de suscripcion"
			));

		// logg($registro,1);

		// $data["nombre"] = $usuario["name"];
		// $data["email"] = $usuario["email"];
		// $data["password"] = $usuario["password"];

	}

	function enviar_confirmacion($partner_id, $folio)
	{
		$ids = array($partner_id);
		$mail = new MailService($this->uid, $this->pwd);
		$path = APPNAME . "/planes.php?fk=$folio";
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