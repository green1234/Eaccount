<?php

require_once "server/Object.php";

class ObjectService
{
	var $conn;
	var $uid;
	var $pass;
	var $ws;

	function __construct($uid, $pass){

		$this->conn = new Object();		
		$this->uid  = $uid;
		$this->pass = $pass;		
	}	

	function verificar_campo($value, $field, $model)
	{			
		echo "Verificando si existe " . $field . "=" . $value . " en el modelo " . $model . "<br>";

		$conn = $this->conn;
		$domain = array(
			array(
				array("value" => $field, 	"type"  => "string"), 
				array("value" => "=", 		"type"  => "string"), 
				array("value" => $value, 	"type" 	=> "string"), 				
				));		

		$msg = $conn->get_object_message(

			array(				
				"user_id"  => array("value" => $this->uid, 		"type" => "int"), 
				"password" => array("value" => $this->pass, 	"type" => "string"), 
				"modelo"   => array("value" => $model, 			"type" => "string"), 
				"accion"   => array("value" => "search", 		"type" => "string"), 
				"values"   => array("value" => $domain, 		"type" => "array"), 
			));	
		
		$response = $conn->ejecutar($msg);
		//$response = $conn->verificar($response);		

		return $response;
	}

	function obtener_empresas($user_id)
	{

		$conn = $this->conn;
		$database = $conn->database;

		$id_list = array(						
			array("value" => $user_id, "type"  => "int"),			
		);

		$key = array(				
			//array("value" => "company_id", "type"  => "string", "id" => true),
			array("value" => "company_ids", "type"  => "string", "id" => true),
			//array("value" => "name", "type"  => "string"),			
		);		

		//prep($id_list);

		$msg = $conn->get_object_message(

			array(								
				"user_id"  => array("value" => $this->uid, 		"type" => "int"), 
				"password" => array("value" => $this->pass, 	"type" => "string"), 
				"modelo"   => array("value" => "res.users", 	"type" => "string"), 
				"accion"   => array("value" => "read", 			"type" => "string"), 
				"values"   => array("value" => $id_list, 		"type" => "list"), 
				"fields"   => array("value" => $key, 			"type" => "list"), 
			));		

		$response = $conn->ejecutar($msg);

		//prep($response["data"][0]->me["struct"], true);

		if($response["success"])
		{
			$response["data"] = obtener_estructura($response["data"], $key);
			//prep($res);
		}	

		//prep($response["data"][0]->me["struct"]["company_id"]->me["array"][0]->me["int"]);
		//prep($response["data"][0]->me["struct"]["company_id"]->me["array"][1]->me["string"]);
		return json_encode($response);
	}

	function asociar_empresa($user_id, $empresas)
	{
		$conn = $this->conn;
		$empresas = array(
			array("value" => 1, 	"type"  => "int"), 
			// array("value" => 25, 	"type"  => "int"), 
			);

		$tupla = array(			
			array("value" => 6, "type"  => "int"), 
			array("value" => 0, "type"  => "int"), 
			array("value" => $empresas, "type" 	=> "list"), 				
			);

		$attributes = array(
			"company_ids" => array("value" => $tupla, "type" => "list")
			);

		//prep($attributes, true);
		// $tupla = array(
		// 	"name" => array("value" => "LALO", "type" => "string")
		// 	);

		$user_ids = array(
			array("value" => 13, 	"type"  => "int"), 

			);

		$msg = $conn->get_object_message(

				array(		
					"user_id"  => array("value" => $this->uid, 		"type" => "int"), 
					"password" => array("value" => $this->pass, 	"type" => "string"), 
					"modelo"   => array("value" => "res.users",	 	"type" => "string"), 
					"accion"   => array("value" => "write", 		"type" => "string"),
					"id_list"  => array("value" => $user_ids, 		"type" => "list"), 
					"values"   => array("value" => $attributes,		"type" => "struct2"), 
				));
		//prep($msg, true);	

		$res = $conn->ejecutar($msg);

		prep($res, true);
	}

	function registra_usuario($nombre, $usuario, $empresa){

		$model = "res.users";
		$res = $this->verificar_campo($nombre, "name", $model);			

		if($res["success"]){		

			$res["success"] = false;
			$res["data"] = array(
				'id' => obtener_id($res, true),
				'error' => "UU",
				'description' => "El usuario ya existe, el nombre del usuario debe ser unico");
		}

		else
		{
			echo "El usuario " . $nombre . " no existe, inicio de registro <br>";

			$conn = $this->conn;

			$values = array(
				"name" => array("value" => $nombre, "type" => "string"),
				"login" => array("value" => $usuario, "type" => "string"),
				//"company_id" => array("value" => $empresa, "type" => "int"),
			);			

			$msg = $conn->get_object_message(

				array(		
					"user_id"  => array("value" => $this->uid, 		"type" => "int"), 
					"password" => array("value" => $this->pass, 	"type" => "string"), 
					"modelo"   => array("value" => $model,		 	"type" => "string"), 
					"accion"   => array("value" => "create", 		"type" => "string"), 
					"values"   => array("value" => $values, 		"type" => "struct"), 
				));
			

			$res = $conn->ejecutar($msg);
			//$res = $conn->verificar($res);

			//prep($res, true);

			if($res["success"]){				

				$res["data"] = array(
					'id' => obtener_id($res),
					'description' => "El usuario ha sido registrado");
			}

			//prep($response);	
		}

		return json_encode($res);
	}

	function registra_empresa($nombre)
	{
		$res = $this->verificar_campo($nombre, "name", "res.company");						

		if($res["success"]){			
			
			$value = $res["data"][0] -> me["int"];

			$res["success"] = false;
			$res["data"] = array(
				'id' => obtener_id($res, true),
				'error' => "UE",
				'description' => "La empresa ya existe, el nombre de la empresa debe ser unico");
		}
		else
		{
			echo "La empresa " . $nombre . " no existe, inicio de registro <br>";

			$conn = $this->conn;	
			$values = array(
				"name" => array(
					"value" => $nombre, 
					"type" => "string")
			);

			$msg = $conn->get_object_message(

				array(		
					"user_id"  => array("value" => $this->uid, 		"type" => "int"), 
					"password" => array("value" => $this->pass, 	"type" => "string"), 
					"modelo"   => array("value" => "res.company", 	"type" => "string"), 
					"accion"   => array("value" => "create", 		"type" => "string"), 
					"values"   => array("value" => $values, 		"type" => "struct"), 
					));

			$res = $conn->ejecutar($msg);
			//$res = $conn->verificar($res);

			if($res["success"]){

				$value = $res["data"][0];

				$res["data"] = array(
					'id' => obtener_id($res), 
					'description' => "La empresa ha sido registrada");
			}					
		}
		return json_encode($res);
	}
}

?>