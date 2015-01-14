<?php
require_once "conf/constantes.conf";
require_once PROYECT_PATH . "/service/MailService.php";

$admin_id = 1;
$admin_pw = "admin";

$ids = array($_POST["partner_id"]);
$mail = new MailService($admin_id, $admin_pw);
$path = APPNAME . "/planes.php";
$params = array(
	"partner_ids" => $ids,
	"message" => "Da click en la siguente liga para confirmar tu suscripcion
					<a href='$path'>Confirmar</a>
					",
	"title" => "Suscripcion"
);
$res = $mail->enviar_mail($params);
echo json_encode($res);

?>