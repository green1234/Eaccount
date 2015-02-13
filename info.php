<? require_once "server/conf/constantes.conf"; ?>
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
          VENTAJAS DE NUESTRO SISTEMA DE CONTABILIDAD      
        </div>
      </div>
    </div>

    <div class="container_lines">
      <div class="container" >
        <div class="col-md-12" style="text-align:center;">
          <? $i = 1; 
          $planes = array(1,2,3,4,5);

          foreach ($planes as $index => $plan) { 

            if ($i == 4)
            {
              echo "</div><div class='col-md-12' style='text-align:center;'>";
              $i = 1;
            }

            ?>            
            
              <form id="plan_domicilio" action="compra.php" method="post" style="display:inline-block;">               

                <div class="elem_xs_d">
                  <img src="img/plan-01.png"/>
                  <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec commodo vitae sapien sit amet porta. Cras sollicitudin magna a felis sodales, at congue diam tincidunt.  </p>
                  <!-- <h3>$500.00 / año</h3>                   -->
                  <!-- <h5>descripcion adicional</h5>                   -->
                  <!-- <span>Descripcion Larga</span> -->
                  <!-- <a class="submit" src="#">Comprar Ahora</a> -->
                </div>
              </form>
          <? 
          $i++;
          }?>
          </div>          
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
  </body>
</html>