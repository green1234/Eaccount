<?php
	
	require_once PROYECT_PATH . "/lib/xmlrpc.inc";
	require_once PROYECT_PATH . "/lib/common.php";
	require_once PROYECT_PATH . "/lib/phpmailer/mailer.php";
	require_once PROYECT_PATH . "/conf/eaccount.conf";

	class MainObject
	{
		var $server_url;
		var $database;
		var $ws;	

		function __construct($ws="object")
		{
			$this->server_url = HOST;
			$this->database = DB;
			$this->ws = $ws;
		}

		function ejecutar($msg, $error="")
		{
			$sock = new xmlrpc_client($this->server_url.$this->ws);
			$sock->setSSLVerifyPeer(0);
			$response = $sock->send($msg);

			// logg($response, true);

			$response = $this->verificar($response, $error);
			// logg($response, true);
			return $response;
		}

		function verificar($response, $error)
		{			
			$values = $response->value()->scalarval();
			// logg($values,1);
			if ($response->errno != 0 || $response->faultCode()){        		
				$response = $this->prepare_error(
					$response->faultCode(),
					$response->faultString()
					//"Ocurrio un error al conectarse a la aplicacion"
				);        		
			}
			else if (isset($values["error"]))
			{
				$response = $this->prepare_error(
					"0", 
					$values["description"]->me["string"]					
					//"Ocurrio un error al conectarse a la aplicacion"
				);	
			}
			else {				

				if (is_array($values) && count($values) > 0) {   
					#logg("IF"); 				
					$response = array('success' => true, 'data' => array());					
					foreach ($values as $key => $value) {    					
	    				$response["data"][$key] = $value;
	    			}	    			   
				}
				else if((is_numeric($values) && $values > 0) || is_string($values)) {
					#logg("EIF");
					$response = array('success' => true, 'data' => array($values)); 
				}
				else if ($values) {					
					$response = array('success' => true, 'data' => array()); 	
				}
				else {    						
					if (is_array($values) && count($values) == 0)
						return array('success' => true, 'data' => array()); 						
					$response = $this->prepare_error($values, $error);
				}
			}
			return $response;
		}

		function prepare_error($code, $description){
			
			$error = array(
					"success" => false,
					"data" => array(
						"id" => $code,
						"description" => $description));

			return $error;
		}		

		function prepare_msg($uid, $pwd)
		{			
			$msg = new xmlrpcmsg('execute');
 			$msg->addParam(model($this->database, "string"));
 			$msg->addParam(model($uid, "int"));
 			$msg->addParam(model($pwd, "string")); 	
 			return $msg;		
		}

		function prepare_search_msg($uid, $pwd, $model, $domain)
		{
			$domain = prepare_domain($domain);
			$msg = $this->prepare_msg($uid, $pwd);
			$msg->addParam(model($model, "string"));
 			$msg->addParam(model("search", "string")); 			
 			$msg->addParam(model($domain, "array")); 			
 			return $msg;
		}

		function prepare_read_msg($uid, $pwd, $model, $ids, $params)
		{			
			$ids = prepare_ids($ids);
			$msg = $this->prepare_msg($uid, $pwd);
			$msg->addParam(model($model, "string"));
 			$msg->addParam(model("read", "string")); 
 			$msg->addParam(model($ids, "array")); 			
 			$msg->addParam(model($params, "array")); 		
 			return $msg;
		}

		function prepare_create_msg($uid, $pwd, $model, $params)
		{			
			$msg = $this->prepare_msg($uid, $pwd);
			$msg->addParam(model($model, "string"));
 			$msg->addParam(model("create", "string"));  					
 			$msg->addParam(model($params, "struct")); 
 			//var_dump($msg->params[5]); exit();		
 			return $msg;
		}

		function prepare_write_msg($uid, $pwd, $model, $ids, $attributes)
		{			
			$ids = prepare_ids($ids);
			$msg = $this->prepare_msg($uid, $pwd);
			$msg->addParam(model($model, "string"));
 			$msg->addParam(model("write", "string"));  					
 			$msg->addParam(model($ids, "array")); 
 			$msg->addParam(model($attributes, "struct")); 
 			//var_dump($msg->params[5]); exit();		
 			return $msg;
		}

		function prepare_login_msg($user, $pass)
		{
			$msg = new xmlrpcmsg('login');
 			$msg->addParam(model($this->database, "string"));
 			$msg->addParam(model($user, "string"));
 			$msg->addParam(model($pass, "string")); 	

 			return $msg;		
		}	

		function prepare_method_msg($user, $pass, $model, $method, $ids=null, $params=null)
		{
			#logg($params, 1);
			$msg = $this->prepare_msg($user, $pass);
 			$msg->addParam(model($model, "string"));
 			$msg->addParam(model($method, "string"));  					
 			if ($ids != null)
 				$msg->addParam(model($ids, "array"));
 			else
 			 	$msg->addParam(model(array(), "array"));
 			if ($params != null){
 				$msg->addParam(model($params, "struct")); 	
 			}
 			#logg($msg->params[6], 1);
 			return $msg;		
		}		

		function create($uid, $pass, $model, $params)
		{			
			$msg = $this->prepare_create_msg($uid, $pass, $model, $params);			
			$response = $this->ejecutar($msg);

			if ($response["success"])
			{
				$id = $response["data"][0];
				$response["data"] = array("id" => $id);
			}
			return $response;
		}

		function write($uid, $pass, $model, $ids, $attributes)
		{	
			$msg = $this->prepare_write_msg($uid, $pass, $model, $ids, $attributes);			
			$response = $this->ejecutar($msg);
			#logg($response);
			if ($response["success"])
			{
				#logg($response, 1);				
				$response["data"] = array("id" => $ids[0]);
			}
			return $response;
		}

		function call($uid, $pwd, $model, $method, $ids=null, $params=null)
		{
			#logg($params, 1);
			$msg = $this->prepare_method_msg($uid, $pwd, $model, $method, $ids, $params);	
			
			$response = $this->ejecutar($msg);				

			return $response;		
		}		

		function login($usuario, $password)
		{
			$error = "No se ha podido iniciar sesion en el sistema, verificar usuario y password";
			$msg = $this->prepare_login_msg($usuario, $password);
			$response = $this->ejecutar($msg, $error);
			
			$login = array();
			if($response["success"])
			{
				$id_user = $response["data"][0];				
				$response["data"] = array(
					"id" => $id_user);			
			}			
			return $response;
		}

		function search($uid, $pwd, $model, $domain)
		{			
			$msg = $this->prepare_search_msg($uid, $pwd, $model, $domain);
			$response = $this->ejecutar($msg);	

			if ($response["success"])
			{
				$ids = array();
				foreach ($response["data"] as $index => $value) 
				{					
					$ids[$index] = $value->me["int"];				
				}
				$response["data"] = array("id" => $ids);				
				//var_dump($response); exit();		
			}
			return $response;
		}

		function read($uid, $pwd, $model, $ids, $params)
		{			
			$msg = $this->prepare_read_msg($uid, $pwd, $model, $ids, $params);			
			$response = $this->ejecutar($msg);
			if ($response["success"])
			{	
				$vals = array();
				foreach ($response["data"] as $index => $value) 
				{
					$data = $value->me["struct"];					
					$vals[$index] = prepare_response($data);					
					/*$vals[$index] = codificar_utf8($vals[$index]);*/
				}
				/*$vals = codificar_utf8($vals);*/
				$response["data"] = $vals;

			}
			return $response;			
		}
	}


?>