<? require_once "server/conf/constantes.conf"; ?>
<?
  $plan = $name = $resume = $costo = $key = $partner = "";  
  if (isset($_POST["plan"]))
    $plan = $_POST['plan'];
  if (isset($_POST["name"]))
    $name = $_POST['name'];
  if (isset($_POST["resume"]))
    $resume = $_POST['resume'];
  if (isset($_POST["costo"]))
    $costo = $_POST['costo'];
  if (isset($_POST["key"]))
    $key = $_POST['key'];
  if (isset($_POST["ptr"]))
    $partner = $_POST['ptr'];

  // $res = json_decode(file_get_contents(SERVERNAME . '/Suscripcion.php?get=descuentos'), true);
  // $descuentos = array();
  // if ($res["success"])
  // {
  //   $descuentos = $res["data"];
  // }

  $descuentos = array(
    "id" => 1,
    "name" => "Ahorra el 5% al hacer tu compra en el mes de <b>Septiembre</b>",
    "porcentaje" => "0.05");

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <? require 'fijos/head.php'; ?>    
    <title>Orden de Compra</title>
    <link href="css/orden_conta.css" rel="stylesheet">
    <script>
      var plan_id = <? echo $plan; ?> ;
      var desc_id = "<? echo $descuentos['id']; ?>";
      var ptr = "<? echo $partner; ?>" ; 
      var key = "<? echo $key; ?>" ;          
      var name = "<? echo $name; ?>" ;          
      var resume = "<? echo $resume; ?>" ; 
      var costo = <? echo $costo; ?> ;
      var desc = "<? echo $descuentos['name']; ?>";
      var descuento_rate = <? echo $descuentos["porcentaje"]; ?>;

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
                  <p><b><? echo $name; ?></b> <? echo $resume; ?></p>
                </li>  
                <li>
                  <h3>MXN <? echo $costo; ?>.00/año</h3>
                </li>
                <li>  
                  <select name="period">
                    <option value="1">1 año</option>
                    <option value="2">2 años</option>
                    <option value="3">3 años</option>
                    <option value="4">4 años</option>
                    <option value="5">5 años</option>
                  </select>
                </li>
                <li class="subtotal">                  
                  <h3>MXN <? echo $costo; ?>.00/año</h3>
                </li>
              </ul>
              <ul class="table_compra_3">
                <li class="first">FOLIO DE DESCUENTO</li>
                <li>PROMOCIONES VIGENTES</li>
                <li class="last">DESCUENTOS</li>
              </ul>
              <ul class="table_compra_4 descuentos">
                <li class="first">
                  <input type="text"/>
                  <a class="discount" href="#">Aplicar</a>
                </li>
                <li class="description">
                  <p>Sin descuento</p>                  
                </li>
                <li class="last amount">
                  <h3>MXN 0.00</h3>
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
                  <li class="last resume">
                    <div class="subtotal"><span>Subtotal: </span><b>MXN 5,850.00</b></div>
                    <div class="iva"><span>IVA 16%:  </span><b>MXN 936.00</b></div>
                    <div class="total"><span>Total:    </span><b>MXN 6,786.00</b></div>
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
