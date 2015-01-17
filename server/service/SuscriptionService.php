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
	}

	function registrar_suscripcion($usuario, $empresa)
	{
		date_default_timezone_set("America/Mexico_City");
		$clienteService = new ClienteService($this->uid, $this->pwd);

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
			$res = $clienteService->registrar_cliente($usuario, $empresa);
			if ($res["success"])
			{
				$usuario_data = $res["data"]["usuario_id"];
				$user_id = $usuario_data["id"];
				$company_id = $res["data"]["empresa_id"];

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

	}

	function enviar_confirmacion($partner_id, $folio)
	{
		// $ids = array($partner_id);		
		$path = APPNAME . "/planes.php?fk=$folio";
		$params = array(
			"partner_ids" => array($partner_id),
			"message" => "Da click en la siguente liga para confirmar tu suscripcion
							<a href='$path'>Confirmar</a>
							",
			"title" => "Suscripcion"			
		);

		$mail = new MailService($this->uid, $this->pwd);
		$mail->enviar_mail($params);
		// $mail->enviar_mail($params);

		return array("success"=>true);
	}

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
			$ids = $suscripcion["data"]["id"];
			$attrs = prepare_params(array("status" => "confirm"));
			$activacion = $this->obj->write($this->uid, $this->pwd, $model, $ids, $attrs);

			return $activacion;						
		}

		return array(
			"success"=>false, 
			"data" => array(
				"description" => "El registro buscado no existe"));
	}

	function obtener_planes_suscription()
	{
		$model = "gl.planes.suscription";
		$domain = array();
		$res = $this->obj->search($this->uid, $this->pwd, $model, $domain);
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