<?  
  if (isset($_POST["plan"]))
    $plan = $_POST['plan'];
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <? require 'fijos/head.php'; ?>    
    <title>Orden de Compra</title>
    <link href="css/orden_conta.css" rel="stylesheet">
    <script>
      var plan_id = <? echo $plan; ?> ;      
    </script>
  </head>
  <body>
    <div class="navbar-wrapper">
      <? require 'fijos/header_conta.php' ?>
      <div class="titulo_pagina">
        <div class="container_titulo_pagina">
          ORDEN DE COMPRA
        </div>
      </div>
    </div>

    <div class="container_lines">
      <div class="container container_text" style="font-size: 20px;color:#4D4D4D;">
        
        <div class="col-md-12" style="margin-bottom:20px;">
          <form>
            <div class="first">
              <ul class="table_compra_1">
                <li class="first">PRODUCTO</li>
                <li>PRECIO UNITARIO</li>
                <li>PERIODO</li>
                <li>SUBTOTAL</li>
              </ul>
              <ul class="table_compra_2">
                <li class="first">
                  <p><b>Plan Empresarial</b> de contabilidad electrónica con manejo ilimitado de CFDIs y de usuarios para una sola Razón Social.</p>
                </li>  
                <li>
                  <h3>MXN 3,250.00/año</h3>
                </li>
                <li>  
                  <select>
                    <option>2 años</option>
                  </select>
                </li>
                <li>
                  <h3>MXN 6,500.00/año</h3>
                </li>
              </ul>
              <ul class="table_compra_3">
                <li class="first">FOLIO DE DESCUENTO</li>
                <li>PROMOCIONES VIGENTES</li>
                <li class="last">DESCUENTOS</li>
              </ul>
              <ul class="table_compra_4">
                <li class="first">
                  <input type="text"/>
                  <a href="#">Aplicar</a>
                </li>
                <li>
                  <p>Ahorra el 5% al hacer tu compra en el mes de <b>Septiembre</b></p>
                </li>
                <li class="last">
                  <h3>MXN 650.00</h3>
                </li>
              </ul>
              </div>
              <div class="last">
                <ul class="table_compra_5">
                  <li class="first">
                    <p>
                      <i>Puedes realizar tu pago ya sea con transferencia bancaria, o con un 
                      deposito en cuenta. Al confirmar tu pedido podras configurar los datos
                      de tu empresa y recibiras en tu correo indicaciones de pago.</i>
                    </p>
                  </li>
                  <li class="last">
                    <div><span>Subtotal: </span><b>MXN 5,850.00</b></div>
                    <div><span>IVA 16%:  </span><b>MXN 936.00</b></div>
                    <div><span>Total:    </span><b>MXN 6,786.00</b></div>
                  </li>
                </ul> 
                <a class="confirm_compra" href="#">Confirmar Pedido</a> 
              </div>
          </form>
        </div>
      </div>
    </div>
    <footer>
        <? require 'fijos/footer.php'; ?>
    </footer>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/orden_conta.js"></script>
  </body>
</html>
