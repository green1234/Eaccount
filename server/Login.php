<?php

require_once "conf/constantes.conf";
require_once PROYECT_PATH . "/service/LoginService.php";

$admin_user = "admin";
$admin_pw = "admin";

$loginService = new LoginService();
$res = $loginService->acceder($admin_user, $admin_pw);
// logg($res,1);
echo json_encode($res);

?>