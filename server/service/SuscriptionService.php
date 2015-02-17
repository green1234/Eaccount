<?php

require_once PROYECT_PATH . "/server/Main.php";
require_once PROYECT_PATH . "/service/ClienteService.php";

class SuscriptionService
{
	var $uid;
	var $pwd;
	var $model = "gl.planes.permisos";
	var $obj;

	function __construct($uid, $pwd)
	{
		$this->uid = $uid;
		$this->pwd = $pwd;
		$this->obj = new MainObject();
		$this->clienteService = new ClienteService($uid, $pwd);
		$this->usuarioService = new UsuarioService($uid, $pwd);
		$this->empresaService = new EmpresaService($uid, $pwd);
	}

	function obtener_descuentos()
	{
		$model = "gl.descuentos.sucripcion";
		$periodo = obtener_periodo();
		$domain = array(
					array(
							model("periodo", "string"),
							model("=", "string"),
							model($periodo, "string")
						));	

		$res = $this->obj->search($this->uid, $this->pwd, $model, $domain);
		
		if ($res["success"])
		{
			$ids = $res["data"]["id"];
			$params = array(
				model("name","string"), 
				model("description","string"),
				model("periodo","string"),
				model("porcentaje","string"));
			$res = $this->obj->read($this->uid, $this->pwd, $model, $ids, $params);

			return $res;
		}
		
		return array("success" => false, 
			"data" => array(
				"description" => "No se encontraron descuentos disponibles."));
	}

	function comprar_plan($params)
	{		
		$model = "gl.compras.sucripcion";
		// $params["partner_id"] = $partner_id;
		$data = prepare_params($params);
		$data["discounts"] = prepare_tupla($params["discount_id"]);
		$compra = $this->obj->create($this->uid, $this->pwd, $model, $data);
		// logg($compra);
		if ($compra["success"])
		{
			// $compra["data"]["partner_id"] = $partner_id;
			// $this->confirmar_compra($compra["data"]);
			// $this->enviar_datos_compra($partner_id);		
			return $compra;
		}

		return array(
			"success"=>false, 
			"data"=>array(
				"description" => "Occurrio un error al realizar el registro de la compra"
			));

	}

	function verificar_existe($usuario, $empresa)
	{
		// $res = $this->empresaService->obtener_empresa_id($empresa);
		
		// if ($res["success"] && count($res["data"]["id"]) > 0){
		// 	return array("description" => "Ya existe un registro con ese nombre.");
		// }	

		$res = $this->usuarioService->obtener_usuario_id($usuario);

		if ($res["success"] && count($res["data"]["id"]) > 0){
			return array("description" => "Ya existe un usuario con ese nombre.");
		}

		$res = $this->usuarioService->obtener_usuario_id_email($usuario);

		if ($res["success"] && count($res["data"]["id"]) > 0){
			return array("description" => "El email registrado ya existe para otro usuario.");
		}

		return false;
	}

	function registrar_suscripcion($data/*$usuario, $empresa*/)
	{
		$username = $data["username"];
		$empresa_nombre = $username;
		$empresa_rfc = "XAXX010101000";
		$usuario_email = $data["email"];
		$usuario_password = $data["password"];	

		$empresa = array(
			"name" => $empresa_nombre, 
			"gl_rfc" => $empresa_rfc, 
			"currency_id" => 34, #MXN
		);

		$usuario = array(
			"name" => $username, 
			"login" => $username,
			"email" => $usuario_email,	
			"password" => md5($usuario_password),		
		);

		$res = $this->verificar_existe($usuario, $empresa);
		
		if (!$res)
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
				"application" => "EACCOUNT",
				"status" => "draft");
			
			$_data = prepare_params($data);
			$registro = $this->obj->create($this->uid, $this->pwd, $model, $_data);

			if ($registro["success"])
			{
				$data["rid"] = $registro["data"]["id"];
				$data["folio"] = $folio;
				$data["path"] = APPNAME;
				// $rid = $registro["data"]["id"];
				$res = $this->registrar_cliente($usuario, $empresa, $data, $model);

				// $registro_id = $registro["data"]["id"];
				// $res = $this->clienteService->registrar_cliente($usuario, $empresa);
				// if ($res["success"])
				// {
				// 	$company_id = $res["data"]["empresa_id"];
				// 	$usuario_data = $res["data"]["usuario_id"];
				// 	$user_id = $usuario_data["id"];

				// 	$attrs = prepare_params(array(
				// 							"user_id" => $user_id, 
				// 							"company_id" => $company_id));

				// 	$this->obj->write($this->uid, $this->pwd, 
				// 		$model, array($registro_id), $attrs);

				// 	$data["partner_id"] = $usuario_data["partner_id"][0];
				// 	$data["folio"] = $folio;
				// 	$data["path"] = APPNAME;
				// 	$this->confirmar_registro($data);
				// 	// $mail = new MailService($this->uid, $this->pwd);
				// 	// $mail->send_mail($data);

				// 	// $this->enviar_confirmacion($data, $folio);

				// }

				return $res;
			}

		}
		else
		{
			return array("success" => false, 
				"data" => array(
					"description" => $res["description"]));
		}
			
		return array(
			"success"=>false, 
			"data"=>array(
				"description" => "Occurrio un error al realizar el registro de suscripcion"
			));

	}

	#Registro del cliente despues de registrar la suscripcion
	function registrar_cliente($usuario, $empresa, $data, $model)
	{
		$rid = $data["rid"]; #Id del registro.

		$res = $this->clienteService->registrar_cliente($usuario, $empresa);
		
		if ($res["success"])
		{
			$company_id = $res["data"]["empresa_id"];
			$usuario_data = $res["data"]["usuario_id"];
			$user_id = $usuario_data["id"];

			$attrs = prepare_params(array(
									"user_id" => $user_id, 
									"company_id" => $company_id));

			$this->obj->write($this->uid, $this->pwd, 
				$model, array($rid), $attrs);

			$data["partner_id"] = $usuario_data["partner_id"][0];
			// $data["folio"] = $data["folio"];
			// $data["path"] = APPNAME;
			# Enviar mail de confirmacion.
			$this->confirmar_registro($data);
			// $mail = new MailService($this->uid, $this->pwd);
			// $mail->send_mail($data);

			// $this->enviar_confirmacion($data, $folio);
		}

		return $res;
	}

	// Envio de Email de Registro
	function confirmar_registro($data)
	{
		$data["tipo_mail"] = "confirmacion";
		$mail = new MailService($this->uid, $this->pwd);
		$mail->send_mail($data);
	}

	// Envio de Email de Compra /*deprecated*/
	function confirmar_compra($data)
	{
		$data["tipo_mail"] = "compra";
		$mail = new MailService($this->uid, $this->pwd);
		$mail->send_mail($data);	
	}

	// function enviar_confirmacion($partner_id, $folio)
	// {
	// 	// $ids = array($partner_id);
	// 	$id_partner = $partner_id['partner_id'];
	// 	$path = APPNAME . "/planes.php?fk=$folio&ptr=$id_partner";
	// 	$params = array(
	// 		"partner_ids" => array($id_partner),
	// 		"email" => $partner_id["email"],
	// 		"message" => "Da click en la siguente liga para confirmar tu suscripcion
	// 						<a href='$path'>Confirmar</a>
	// 						",
	// 		"title" => "Suscripcion"			
	// 	);

	// 	$mail = new MailService($this->uid, $this->pwd);
	// 	$mail->enviar_mail($params);
	// 	// $mail->enviar_mail($params);

	// 	return array("success"=>true);
	// }

	function enviar_datos_compra($partner_id)
	{		
		$params = array(
			"partner_ids" => array($partner_id),
			"message" => "Aqui van los datos de pago",							
			"title" => "Datos de Pago"			
		);

		$mail = new MailService($this->uid, $this->pwd);
		$mail->enviar_mail($params);	

		return array("success"=>true);
	}

	// Activar Suscripcion
	function confirmar_suscripcion($folio){

		$model = "gl.suscripcion";		
		$domain = array(
					array(
							model("name", "string"),
							model("=", "string"),
							model($folio, "string")
						));

		$suscripcion = $this->obj->search($this->uid, $this->pwd, $model, $domain);
		
		if($suscripcion["success"] && count($suscripcion["data"]["id"]) > 0)
		{
			// return $suscripcion;
			$ids = array($suscripcion["data"]["id"][0]); #Es un array de 1 elemento por lo menos
			$attrs = prepare_params(array("status" => "confirm"));
			$activacion = $this->obj->write($this->uid, $this->pwd, $model, $ids, $attrs);
			// return $activacion;
			if ($activacion["success"])
			{

				$params = array(model("user_id","string"), model("password","string"));
				$query = $this->obj->read($this->uid, $this->pwd, $model, $ids, $params);
				// return $query;
				if ($query["success"])
				{
					$model = "res.users";
					$data = $query["data"][0];
					$ids = array($data["user_id"][0]); #Id del Ususario relacionado
					// 
					$attrs = prepare_params(array("password" => $data["password"]));
					$user_activation = $this->obj->write($this->uid, $this->pwd, $model, $ids, $attrs);
					
					// $usuario = $this->usuarioService->obtener_datos($ids[0]);					
					// $suscripcion["data"]["email"] = $usuario["data"][0]["email"];
					$suscripcion["data"]["uid"] = $data["user_id"][0];
					$suscripcion["data"]["username"] = $data["user_id"][1];
					$suscripcion["data"]["pwd"] = $data["password"];
				}
			}
			// $attrs = prepare_params(array("password" => "confirm"));

			return $suscripcion;						
		}

		return array(
			"success"=>false, 
			"data" => array(
				"description" => "El registro buscado no existe"));
	}

	function obtener_planes_suscription()
	{
		$model = "gl.planes.suscription";
		$domain = array(
			array(
				model("application", "string"),
				model("=", "string"),
				model("EACCOUNT", "string")
		));
		$res = $this->obj->search($this->uid, $this->pwd, $model, $domain);
		// return $res;
		// logg($res,1);
		if ($res["success"])
		{
			$ids = $res["data"]["id"];
			$params = array(
				model("name", "string"),
				model("resume", "string"),
				model("description", "string"),			
				model("costo", "string"),
				model("costo_desc", "string"),
			);
			$res = $this->obj->read($this->uid, $this->pwd, $model, $ids, $params);

			if ($res["success"])
			{
				foreach ($res["data"] as $index => $value) {
					$permisos = $this->obtener_permisos($value["id"]);

					#logg($persmisos["data"],1);

					if ($permisos["success"])
					{
						$res["data"][$index]["permisos"] = $permisos["data"];
					}
				}
				// logg($res,1);
				return $res;
			}

			return array("success" => false);
		}
	}

	/*
	*Recibe el id del plan y devuelve los permisos asociados
	*/
	function obtener_permisos($plan_id)
	{
		$domain = array(
					array(
						model("plan_id", "string"),
						model("=", "string"),
						model($plan_id, "int"),
					));

		$res = $this->obj->search($this->uid, $this->pwd, $this->model, $domain);

		if ($res["success"])
		{
			$params = array(
				model("name", "string"),				
			);	
			$res = $this->obj->read($this->uid, $this->pwd, $this->model, $res["data"]["id"], $params);
			if ($res["success"])
			{			
				return $res;
			}			
		}	

		return array("success" => false);
	}

	/*
	* Obtiene los datos asociados a los permisos, recibe un array de permisos
	*/
	function obtener_datos_permisos($permisos_id)
	{
		$params = array(
				model("name", "string"),				
		);	
		
		$res = $this->obj->read($this->uid, $this->pwd, $this->model, $permisos_id, $params);
		
		if ($res["success"])
		{			
			return $res;
		}
		return array("success" => false);
	}

	// /*
	// * Obtiene el nombre del permiso
	// */
	// function obtener_permisos_plan($perm_id)
	// {
	// 	$model = $this->model;
	// 	$ids = array($perm_id);		
	// 	// logg($ids,1);
	// 	$params = array(
	// 			model("name", "string"),				
	// 	);

	// 	$res = $this->obj->read($this->uid, $this->pwd, $model, $ids, $params);
	// 	#logg($res["data"],1);
	// 	if ($res["success"])
	// 	{			
	// 		return $res["data"][0];
	// 	}		

	// 	return array("success" => false);
	// }

	/*
	* Obtiene los planes asociados a un usuario
	*/
	function obtener_planes_usuario($usuario_id)
	{			
		$model = "gl.planes.usuarios";
		$domain = array(
					array(
						model("user_id", "string"),
						model("=", "string"),
						model($usuario_id, "int"),
						));

		$res = $this->obj->search($this->uid, $this->pwd, $model, $domain);		
		
		if ($res["success"])
		{
			$params = array(
				model("id", "string"),
				model("plan_id", "string"),
				model("name", "string"),
				model("capacity", "string"),
				model("date", "string"),
				model("tipo_plan", "string"),
				model("contratado", "string"),
				model("perm_ids", "string")
			);
			
			$ids = $res["data"]["id"];
			$res = $this->obj->read($this->uid, $this->pwd, $model, $ids, $params);
			
			$result = array();

			foreach ($res["data"] as $index => $value) {			
				$result[$index]["id"] = $value["id"];
				$result[$index]["plan_id"] = $value["plan_id"];
				$result[$index]["name"] = $value["name"];
				$result[$index]["capacity"] = $value["capacity"];
				$result[$index]["date"] = $value["date"];
				$result[$index]["tipo_plan"] = $value["tipo_plan"];
				$result[$index]["contratado"] = $value["contratado"];
				$datos_permisos = $this->obtener_datos_permisos($value["perm_ids"]); 

				if ($datos_permisos["success"])
					$result[$index]["perm_ids"] = $datos_permisos["data"];
			}		
			
			$res["data"] = $result;			
			// logg($res["data"],1);
		}
		
		return $res;
	}
	
}

?>