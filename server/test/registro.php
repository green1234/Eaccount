<?php
#Prueba de Registro, Crear usuario (Nombre, Apellido, Email, Password)

require_once "../conf/constantes.conf";
require_once PROYECT_PATH . "/server/Main.php";

$uid = 1;
$pass = "admin";
$nombre = "Gerardo";
$apellidos = "Lopez";
$email = "mcgalv@gmail.com";
$password = "123456";

echo "Se va a registrar el usuario con los siguientes datos: ";
echo "<br>";
echo "Nombre: " . $nombre;
echo "<br>";
echo "Apellido: " . $apellidos;
echo "<br>";
echo "Email: " . $email;
echo "<br>";
echo "Password: " . $password;
echo "<br>";

$params = array(
	"name" => model($nombre . " " . $apellidos, "string"),
	"login" => model($email, "string"),
	);

$domain = array(
	array(
		model("login", "string"),
		model("=", "string"),
		model($email, "string"),
		)
	);

$obj = new MainObject("object");

$response = $obj->search($uid, $pass, "res.users", $domain);

echo "Verificando si el usuario existe por email " . $email . "<br>";

if($response["success"])
{
	echo "El usuario ya existe ID " . $response["data"]["id"][0];
}
else
{
	echo "Se va a proceder al registro";
	echo "<br>";
	$response = $obj->create($uid, $pass, "res.users", $params);

	if($response["success"])
	{
		echo "El usuario se ha registrado ID " . $response["data"]["id"];
		echo "<br>";
	}
}

var_dump($response["data"]); exit();

?>