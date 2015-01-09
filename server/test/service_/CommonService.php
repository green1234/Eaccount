<?php

require_once "server/Common.php";

class CommonService
{
	var $conn;

	function __construct(){
		$this->conn = new Common();
	}

	function check_login()
	{
		if(isset($_COOKIE["user_id"]) == true)  
		{	    
		    if($_COOKIE["user_id"] > 0) 
		    {	   
		    	$uid = $_COOKIE["user_id"];	    	
		    	return true;
		    }
		}
		
		return false;

	}

	function login($user, $pass)
	{
		//require_once("conf/olink.conf");

		$conn = $this->conn;
		$res = $conn->common_method("login",
			array(
				// "db"   => array("value" => DB, "type" => "string"),
				"user" => array("value" => $user, "type" => "string"), 
				"pass" => array("value" => $pass, "type" => "string"),
				));			
		
		if (isset($res["error"]))
		{
		 	if(isset($error_msg) && $res["description"] == "")
				$res["description"] = "Login o Password incorrecto";
		}

		return json_encode($res);

	}
}

?>