<?php

require_once PROYECT_PATH . "/server/Main.php";

class MailService
{
	var $uid;
	var $pwd;
	var $model = "my.task.mail";
	var $obj;	

	function __construct($uid, $pwd)
	{
		$this->uid = $uid;
		$this->pwd = $pwd;
		$this->obj = new MainObject();		
	}

	function enviar_mail($params)
	{
		$method = "action_send";
		$partner_id = $params["partner_ids"][0];
		$message = $params["message"];
		$title = $params["title"];

		$params = array(
			"partner_id" => model($partner_id, "int"),
			"message" => model($message, "string"),
			"title" => model($title, "string")
		);

		$response = $this->obj->call(
			$this->uid, $this->pwd, 
			$this->model, $method, 
			null, $params);
	}


}

