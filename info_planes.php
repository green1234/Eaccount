<? require_once "server/conf/constantes.conf"; ?>
<? require_once "server/conf/eaccount.conf"; ?>
<? 
  // session_destroy();
  session_start();
  // $session_id = session_id();

  $planes = array();
  $variables = 'uid=1&pwd=' . md5(PASS);
  $res = json_decode(file_get_contents(SERVERNAME . '/Suscripcion.php?get=planes&'. $variables), true); 
  
  if ($res["success"])
  {    
    $planes = $res["data"];       
  } 

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <? require 'fijos/head.php'; ?>
    <title>SOBRE SAVVY SYSTEMS</title>
    <link href="css/base.css" rel="stylesheet">
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
            
            <div class="col-md-4">
              <form id="plan_domicilio" action="compra.php" method="post">
                
                <input type="hidden" name="plan" id="plan" value="<? echo $plan['id'];?>" />
                <input type="hidden" name="name" id="name" value="<? echo $plan['name'];?>" />
                <input type="hidden" name="resume" id="resume" value="<? echo $plan['resume'];?>" />
                <input type="hidden" name="costo" id="costo" value="<? echo $plan["costo"];?>" />

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