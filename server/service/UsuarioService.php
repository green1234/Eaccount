<?php

require_once PROYECT_PATH . "/server/Main.php";
require_once PROYECT_PATH . "/service/PartnerService.php";
require_once PROYECT_PATH . "/service/EmpresaService.php";
require_once PROYECT_PATH . "/service/SuscriptionService.php";

class UsuarioService
{
	var $uid;
	var $pwd;
	var $model = "res.users";
	var $obj;

	function __construct($uid, $pwd)
	{
		$this->uid = $uid;
		$this->pwd = $pwd;
		$this->obj = new MainObject();
	}

	function obtener_datos($usuario_id)
	{
		$model = $this->model;
		$ids = array($usuario_id);
		
		$partner_service = new PartnerService($this->uid, $this->pwd);
		$empresa_service = new EmpresaService($this->uid, $this->pwd);
		$suscription_service = new SuscriptionService($this->uid, $this->pwd);

		// $res = $suscription_service->obtener_planes();
		// logg($res,1);

		$params = array(
				#model("name", "string"),
				#model("email", "string"),
				model("login", "string"),
				model("partner_id", "string"),
				model("company_id", "string"),
		);

		$res = $this->obj->read($this->uid, $this->pwd, $model, $ids, $params);

		if ($res["success"])
		{
			foreach ($res["data"] as $index => $value) {
				$partner_id = $res["data"][$index]["partner_id"][0];
				$company_id = $res["data"][$index]["company_id"][0];
				$empresa = $empresa_service->obtener_datos_empresa($company_id);
				$partner = $partner_service->obtener_datos_partner($partner_id);
				$usuarios = $empresa_service->obtener_usuarios($company_id);
				$planes = $suscription_service->obtener_planes_usuario($this->uid);
				$res["data"][$index]["partner_id"] = $partner["data"][0];
				$res["data"][$index]["usuarios"] = $usuarios["data"];
				$res["data"][$index]["planes"] = $planes["data"];
				$res["data"][$index]["empresa"] = $empresa["data"];
				foreach ($usuarios["data"] as $idx => $usuario) {
					$planes_usuario = $suscription_service->obtener_planes_usuario($usuario["id"]);
					if ($planes_usuario["success"])
					{
						$res["data"][$index]["usuarios"][$idx]["planes"] = $planes_usuario["data"];
					}

				}

				#logg($planes["data"],1);
				// $permisos = array();
				#logg($planes["data"]["perm_ids"],1);
				// foreach ($planes["data"] as $idx => $plan) {					

				// 	$plan_id = $plan["plan_id"][0];
				// 	$datos_permisos = $suscription_service->obtener_datos_permisos($plan["perm_ids"]);

				// 	if ($datos_permisos["success"])
				// 		$res["data"][$index]["planes"][$idx]["perm_ids"] = $datos_permisos["data"];
					// logg($datos_permisos,1);

					// foreach ($plan["perm_ids"] as $i => $perm_id) {
					// 	$permisos[$plan_id][] = $suscription_service->obtener_permisos_plan($perm_id);						
					// }

					// $res["data"][$index]["planes"][$idx]["plan_id"][] = $permisos[$plan_id];
					// unset($res["data"][$index]["planes"][$idx]["id"]);
					// unset($res["data"][$index]["planes"][$idx]["perm_ids"]);
				// }

				#$res["data"][$index]["planes"]["permisos"] = $permisos;

				#logg($permisos,1);

				unset($res["data"][$index]["groups_id"]);
				unset($res["data"][$index]["alias_id"]);		
			}

			// $partner_id = $res["data"][0]["partner_id"][0];			
			// $partner = $partner_service->obtener_datos_partner($partner_id);
			// $planes = $this->obtener_planes($this->uid);
			// // logg($planes,1);
			// $res["data"][0]["partner_id"] = $partner["data"][0];
			// $res["data"][0]["planes"] = $planes["data"];			
			// unset($res["data"][0]["groups_id"]);		


			return $res;
		}		

		return array("success" => false);
	}

	// function obtener_planes($usuario_id)
	// {			
	// 	$model = "gl.planes.usuarios";
	// 	$domain = array(
	// 				array(
	// 					model("user_id", "string"),
	// 					model("=", "string"),
	// 					model($usuario_id, "int"),
	// 					));

	// 	$res = $this->obj->search($this->uid, $this->pwd, $model, $domain);		
		
	// 	if ($res["success"])
	// 	{
	// 		$params = array(
	// 			model("id", "string"),
	// 			model("plan_id", "string"),
	// 			model("name", "string"),
	// 			model("capacity", "string"),
	// 			model("date", "string"),
	// 			model("perm_ids", "string")
	// 		);
			
	// 		$ids = $res["data"]["id"];
	// 		$res = $this->obj->read($this->uid, $this->pwd, $model, $ids, $params);
			
	// 		$result = array();

	// 		foreach ($res["data"] as $index => $value) {			
	// 			$result[$index]["id"] = $value["id"];
	// 			$result[$index]["plan_id"] = $value["plan_id"];
	// 			$result[$index]["name"] = $value["name"];
	// 			$result[$index]["capacity"] = $value["capacity"];
	// 			$result[$index]["date"] = $value["date"];
	// 			$result[$index]["perm_ids"] = $value["perm_ids"]; 
	// 		}		
			
	// 		$res["data"] = $result;
	// 	}
	// 	// logg($res, 1);
	// 	return $res;
	// }

	function obtener_empresa($usuario_id)
	{
		$usuario_id = $this->uid;
		$ids = array($usuario_id);

		$params = array(
			model("company_id", "string")
		);

		$res = $this->obj->read($this->uid, $this->pwd, $this->model, $ids, $params);		
		#logg($res["data"],1);
		if ($res["success"])
		{
			$res["data"] = array("company_id" => $res["data"][0]["company_id"][0]);			
		}
		
		return $res;
	}

	function obtener_empresas($usuario_id)
	{
		$ids = array($usuario_id);

		$params = array(
			model("company_ids", "string")
		);

		$res = $this->obj->read($this->uid, $this->pwd, $this->model, $ids, $params);

		if ($res["success"])
		{
			$res["data"] = array("company_ids" => $res["data"][0]["company_ids"]);			
		}
		
		return $res;
	}

	function asignar_empresa($user_id, $empresa_id)
	{
		$ids = array($user_id);
		$attrs = array("company_id" => $empresa_id);
		$attrs = prepare_params($attrs);
		#logg($ids,1);
		$res = $this->obj->write($this->uid, $this->pwd, $this->model, $ids, $attrs);

		if ($res["success"])
		{	
			return true;
		}

		return false;
	}

	function desasociar_empresas($user_id, $empresa_id = 0)
	{
		$company_ids = array();	 			
		$company_id_exist = false;
		
		//Si es 0 se va a quitar la empresa que tiene asignada el usuario logueado.
		if ($empresa_id == 0)
		{
			$res = $this->obtener_empresa($this->uid);
			#logg($res,1);
			if ($res["success"])
				$empresa_id = $res["data"]["company_id"];
			else{
				logg("Ocurrio un error al desasociar la empresa");
				return false;
			}
		}

 		$res = $this->obtener_empresas($user_id);

 		if ($res["success"])
 		{		 	
	 		$company_ids = $res["data"]["company_ids"];
	 		$ids_new = array();
	 		foreach ($company_ids as $idx => $company_id) 
	 		{
	 			if ($company_id != $empresa_id)
	 			{		 			
	 				$ids_new[] = $company_id;	 				
	 			}
	 			else
	 			{
	 				$company_id_exist = true;
	 			}
	 		}
	 	}

	 	if ($company_id_exist && count($ids_new) > 0)
	 	{ 		
 			$ids = array($user_id);
 			$company_ids = $ids_new;

			$attrs = array("company_ids" => prepare_tupla($company_ids));
			$res = $this->obj->write($this->uid, $this->pwd, $this->model, $ids, $attrs);

			if ($res["success"])			
				return true;		
			
			return false;
 		}

 		return false;
	}

	//Sirve para permitir al usuario que tenga acceso a la empresa recien creada
	function asociar_empresas($user_id, $empresa_id, $nueva_lista=false)
	{		
		$company_ids = array();	 			
		$company_id_exist = false;

		if (!$nueva_lista){	 		
	 		$res = $this->obtener_empresas($user_id);
	 		if ($res["success"])
	 		{		 	
		 		$company_ids = $res["data"]["company_ids"];
		 		foreach ($company_ids as $idx => $company_id) 
		 		{
		 			if ($company_id == $empresa_id)
		 			{		 			
		 				$company_id_exist = true;
		 				break;
		 			}
		 		}
		 	}
		}	

 		if (!$company_id_exist)
 		{
 			$ids = array($user_id);
 			$company_ids[] = $empresa_id;

			$attrs = array("company_ids" => prepare_tupla($company_ids));
			$res = $this->obj->write($this->uid, $this->pwd, $this->model, $ids, $attrs);

			if (!$res["success"])
			{
				return false;
			}
			return true;
 		}
 		else
 		{
 			return true;
 		}	 	
	}

	function obtener_usuario_id($usuario_name)
	{		
		//logg($empresa_name);
		$domain = array(
					array(
						model("login", "string"),
						model("=", "string"),
						model($usuario_name, "string"),
						));

		$res = $this->obj->search($this->uid, $this->pwd, $this->model, $domain);
		return $res;		
	}

	function crear_usuario($params, $empresa_id)
	{
		$keys = prepare_params($params);
		$res = $this->obtener_usuario_id($params["name"]);
		// logg("Crear Usuario");
		// logg($res);
		if ($res["success"] && count($res["data"]["id"])>0){
			$res["success"] = false;			
			$res["data"]["description"] = "El usuario que quiere registrar ya existe";
			return $res;
		}			

		$res = $this->obj->create($this->uid, $this->pwd, $this->model, $keys);

		if (!$res["success"]){						
			$res["data"]["description"] = "Ocurrio un error al registrar el usuario";
			return $res;
		}
		else
		{
			$usuario_id = $res["data"]["id"];
			$this->asociar_empresas($usuario_id, $empresa_id);
			$this->asignar_empresa($usuario_id, $empresa_id);
			$this->desasociar_empresas($usuario_id);
		}

		return $res;
	}

	

}

?>