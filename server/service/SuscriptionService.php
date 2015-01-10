<?php

require_once PROYECT_PATH . "/server/Main.php";

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

	function obtener_planes()
	{
		$model = "gl.planes";
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