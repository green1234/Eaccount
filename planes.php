<? require_once "server/conf/constantes.conf"; ?>
<? 
  // session_destroy();
  session_start();
  // $session_id = session_id();

  $planes = array();
  $loader = false;
  $susc_id = 0;
  if (isset($_GET["fk"]))
  {
    $key = $_GET["fk"];
    $partner = $_GET["ptr"];    
    $activacion = json_decode(file_get_contents(SERVERNAME . '/Suscripcion.php?action=activacion&fk='.$key), true); 
    #var_dump($activacion);
    $usuario_id = $activacion["data"]["uid"];
    $usuario_pwd = $activacion["data"]["pwd"];
    $usuario_username = $activacion["data"]["username"];
    $usuario_cid = $activacion["data"]["cid"];
    // $usuario_email = $activacion["data"]["email"];  

    $_SESSION["login"] = array(
      "uid" => $usuario_id,
      "username" => $usuario_username,
      // "email" => $usuario_email,
      "pwd" => $usuario_pwd,
      "cid" => $usuario_cid 
    );
    #echo "<pre>";
    #var_dump($_SESSION["login"]);
    #echo "</pre>";
    #exit();
    #var_dump($_SESSION["login"]);
    if ($activacion["success"])
    {
      $susc_id = $activacion["data"]["id"][0]; 
      $variables = 'uid=' . $usuario_id . '&pwd=' . $usuario_pwd;
      $res = json_decode(file_get_contents(SERVERNAME . '/Suscripcion.php?get=planes&'. $variables), true); 
      
      // var_dump("3");
      // var_dump("3");
      
      $planes = array();  
      if ($res["success"])
      {
        // var_dump("4");
        $planes = $res["data"];
        $loader = true;    
      }
    }
  }
  
  if (!$loader)
  {
    // header('Location: ' . APPNAME . '/registro.php');
  }

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <? require 'fijos/head.php'; ?>
    <title>SOBRE SAVVY SYSTEMS</title>
    <link href="css/planes.css" rel="stylesheet">
  </head>
  <body>
    <div class="navbar-wrapper">
      <? require 'fijos/header.php' ?>
      <div class="titulo_pagina">
        <div class="container_titulo_pagina">
          SELECCIONA TU PLAN       
        </div>
      </div>
    </div>

    <div class="container_lines">
      <div class="container">
          <? $i = 1; ?>
          <? foreach ($planes as $index => $plan) { ?>
            <?
              // echo "<pre>";
              // var_dump($plan); #exit();
              // echo "</pre>";
            ?>
            <div class="col-md-4">
              <form id="plan_domicilio" action="compra.php" method="post">
                <input type="hidden" name="key" id="key" value="<? echo $susc_id; ?>" />
                <input type="hidden" name="ptr" id="ptr" value="<? echo $partner; ?>" />
                <input type="hidden" name="plan" id="plan" value="<? echo $plan['id'];?>" />
                <input type="hidden" name="name" id="name" value="<? echo $plan['name'];?>" />
                <input type="hidden" name="resume" id="resume" value="<? echo $plan['resume'];?>" />
                <input type="hidden" name="costo" id="costo" value="<? echo $plan["costo"];?>" />

                <!-- <input type="hidden" name="rfc" id="rfc" value="Aqui va el RFC" />AQUI IMPRIMIMOS EL RFC CON PHP--> 
                <!-- <image onClick="document.getElementById('plan_emprendedor').submit();" id="btnPlanes1" src="img/plane_domicilio.png" style="width: 300px;float:right;cursor:pointer;" /> -->
                <div class="elem_xs_d">
                  <img src="img/plan-0<? echo $i; ?>.png"/>
                  <p><? echo $plan["resume"]; ?></p>
                  <h3>$<? echo $plan["costo"]; ?>.00 / año</h3>
                  <?
                  if ($plan["costo_desc"] != "Pendiente")
                  {?>
                  <h5><? echo $plan["costo_desc"]; ?></h5>
                  <?}?>
                  <span><? echo $plan["description"]; ?></span>
                  <a class="submit" src="#">Comprar Ahora</a>
                </div>
              </form>
            </div>
          <? $i++; ?>
          <? }?>

      </div>
      <p class="message_footer">
        Precios en Pesos (MXN) + IVA
      </p>
    </div>

    <footer>
        <? require 'fijos/footer.php'; ?>
    </footer>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="js/lib/bootstrap.min.js"></script>
    <script src="js/base.js"></script>    
    <script src="js/planes.js"></script>    
  </body>
</html>