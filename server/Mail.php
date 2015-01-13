// <?php
require_once "conf/constantes.conf";
require_once PROYECT_PATH . "/service/MailService.php";

$admin_id = 1;
$admin_pw = "admin";

$mailService = new MailService($admin_id, $admin_pw);

// $_POST["partner_id"] = 26;
	

// $params = array(
// 	"partner_id" => model($_POST["partner_id"], "int"));

// $params = array(
// 	"partner_id" => $_POST["partner_id"]);
// logg($params,1);
$res = $mailService->enviar_mail($_POST["partner_id"]);
// logg($res,1);
echo json_encode($res);

?>