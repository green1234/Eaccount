<?php

require_once "../conf/constantes.conf";
require_once PROYECT_PATH . "/server/Main.php";

$uid = 1;
$pass = "admin";


$obj = new MainObject();

$company = array(
	"name" => model("Mi empresa 13", "string"),
);
$response = $obj->create($uid, $pass, "res.company", $company);

$company_id = $response["data"]["id"];

$config = array(
	"chart_template_id" => model(2, "int"),
	"code_digits" => model(6, "int"),
	"company_id" => model($company_id, "int"),
	"complete_tax_set" => model(true, "boolean"),
	"currency_id" => model(34, "int"),
	"date_start" => model("2014-01-01", "string"),
	"date_stop" => model("2014-12-31", "string"),
	"decimal_precision" => model(2, "int"),
	"period" => model("month", "string"),
	"purchase_tax" => model(10, "int"),
	"purchase_tax_rate" => model(16, "int"),
	"sale_tax" => model(9, "int"),
	"sale_tax_rate" => model(16, "int"),
	);

$response = $obj->create($uid, $pass, "account.config.settings", $config);
$config_id = $response["data"]["id"];
$ids = array(
	model($config_id, "int")
	);

#$msg = $obj->prepare_msg($uid, $pass);
#$msg->addParam(model("account.config.settings", "string"));
#$msg->addParam(model("set_chart_of_accounts", "string")); 
#$msg->addParam(model($ids, "array"));

$model = "account.config.settings";

$method = "set_chart_of_accounts";
$response = $obj->call($uid, $pass, $model, $method, $ids);
var_dump($response);

$method = "set_fiscalyear";
$response = $obj->call($uid, $pass, $model, $method, $ids);
var_dump($response);

$method = "set_default_taxes";
$response = $obj->call($uid, $pass, $model, $method, $ids);

var_dump($response);

$method = "set_default_dp";
$response = $obj->call($uid, $pass, $model, $method, $ids);

var_dump($response); exit();


?>