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

	// function enviar_mail($params)
	// {
	// 	$method = "action_send";
	// 	$partner_id = $params["partner_ids"][0];
	// 	$message = $params["message"];
	// 	$title = $params["title"];

	// 	$params = array(
	// 		"partner_id" => model($partner_id, "int"),
	// 		"message" => model($message, "string"),
	// 		"title" => model($title, "string")
	// 	);

	// 	$response = $this->obj->call(
	// 		$this->uid, $this->pwd, 
	// 		$this->model, $method, 
	// 		null, $params);

	// }

	function send_mail($params)
	{

		// $id_partner = $partner_id['partner_id'];
		// $path = APPNAME . "/planes.php?fk=$folio&ptr=$id_partner";
		// $params = array(
		// 	"partner_ids" => array($id_partner),
		// 	"email" => $partner_id["email"],
		// 	"message" => "Da click en la siguente liga para confirmar tu suscripcion
		// 					<a href='$path'>Confirmar</a>
		// 					",
		// 	"title" => "Suscripcion"			
		// );

		$tipo_mail = $params["tipo_mail"];

		switch ($tipo_mail) 
		{
			case 'confirmacion':
				$method = "mail_confirmacion";
				$partner_id = $params["partner_id"];
				$nombre = $params["nombre"];
				$email = $params["email"];
				$folio = $params["folio"];
				$path = $params["path"];

				$params = array(
					"partner_id" => model($partner_id, "int"),
					"email" => model($email, "string"),
					"nombre" => model($nombre, "string"),
					"folio" => model($folio, "string"),
					"path" => model($path, "string"),				
				);			
				
				break;

			case "compra":
				$method = "mail_compra";
				$partner_id = $params["partner_id"];
				$usuario = $params["value"]["usuario"];
				$plan = $params["value"]["plan"];				
				$app = $params["value"]["app"];
				$period = $params["value"]["period"];
				$subtotal = $params["value"]["subtotal"];
				$descuento = $params["value"]["descuento"];
				$iva = $params["value"]["iva"];
				$total = $params["value"]["total"];
				$cuenta = $params["value"]["cuenta"];
				$cliente = $params["value"]["cliente"];

				$params = array(
					"partner_id" => model($partner_id, "int"),
					"usuario" => model($usuario, "string"),
					"plan" => model($plan, "string"),
					"app" => model($app, "string"),
					"period" => model($period, "string"),
					"cuenta" => model($cuenta, "string"),
					"subtotal" => model($subtotal, "string"),
					"descuento" => model($descuento, "string"),
					"iva" => model($iva, "string"),
					"total" => model($total, "string"),
					"cliente" => model($cliente, "int"),
				);
				
				break;										
		}

		$response = $this->obj->call($this->uid, $this->pwd, 
					$this->model, $method, null, $params);

		return array("success"=>true);

		// $method = "mail_confirmacion";
		// $partner_id = $params["partner_id"];
		// $email = $params["email"];
		// $message = ""; #$params["message"];
		// $title = ""; #$params["title"];

		// $params = array(
		// 	"partner_id" => model($partner_id, "int"),
		// 	"email" => model($email, "string"),
		// 	"message" => model($message, "string"),
		// 	"title" => model($title, "string")
		// );

		// $response = $this->obj->call(
		// 	$this->uid, $this->pwd, 
		// 	$this->model, $method, 
		// 	null, $params);
	}


}

