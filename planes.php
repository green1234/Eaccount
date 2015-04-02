<? 
require_once "server/conf/constantes.conf";
session_start();

$susc_id = $partner = 0;
if (isset($_GET["fk"]) && isset($_GET["ptr"]))
{
  $key = $_GET["fk"];
  $partner = $_GET["ptr"];    
  
  $activacion = json_decode(file_get_contents(SERVERNAME . '/Suscripcion.php?action=activacion&fk='.$key), true);   
  if ($activacion["success"])
  {
    $usuario_id = $activacion["data"]["uid"];
    $usuario_pwd = $activacion["data"]["pwd"];
    $usuario_username = $activacion["data"]["username"];
    $usuario_cid = $activacion["data"]["cid"];
    $susc_id = $activacion["data"]["id"][0]; 
    
    $_SESSION["login"] = array(
      "uid" => $usuario_id,
      "username" => $usuario_username,    
      "pwd" => $usuario_pwd,
      "cid" => array($usuario_cid, $usuario_username),
      "config" => false
    );
  }
  else
  {
    header("Location : index.php");
    exit();  
  } 
} 
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <? require 'view/head.php'; ?>
    <title>SOBRE SAVVY SYSTEMS</title>
    <link href="css/planes.css" rel="stylesheet">
    <script>
      var susc_id = <?=($susc_id);?>;
      var partner = <?=$partner;?>;
    </script>
  </head>
  <body>
    <div class="navbar-wrapper">
      <? require 'view/header.php'; ?>
      <div class="titulo_pagina">
        <div class="container_titulo_pagina">
          SELECCIONA TU PLAN       
        </div>
      </div>
    </div>

    <div class="container_lines">
      <div id="planes_container" class="container">
         
      </div>
      <p class="message_footer">
        Precios en Pesos (MXN) + IVA
      </p>
    </div>

    <footer>
        <? require 'view/footer.php'; ?>
    </footer>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="js/lib/bootstrap.min.js"></script>
    <script src="js/base.js"></script>    
    <script src="js/planes.js"></script>    
  </body>
</html>
