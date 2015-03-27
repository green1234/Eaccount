<? require_once "server/conf/constantes.conf"; ?>
<? session_start();
if (!isset($_SESSION["login"]))
  header('Location: index.php');

$uid = $_SESSION["login"]["uid"];
$pwd = $_SESSION["login"]["pwd"];
$cid = $_SESSION["login"]["cid"];

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

$var = 'uid=' . $uid . '&pwd=' . $pwd;
$res = json_decode(file_get_contents(SERVERNAME . '/Suscripcion.php?get=descuentos&'.$var), true);
  
$descuentos = array();
if ($res["success"] && count($res["data"]) > 0)
{
  //var_dump($res);
  $descuentos = $res["data"][0];
}


  // var_dump($res); exit();

  // $descuentos = array(
  //   "id" => 1,
  //   "periodo" => "02",
  //   "description" => "Ahorra el 5% al hacer tu compra en el mes de <b>Septiembre</b>",
  //   "porcentaje" => "0.05");

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <? require 'view/head.php'; ?>    
    <title>Orden de Compra</title>
    <link href="css/base.css" rel="stylesheet">
    <link href="css/compra.css" rel="stylesheet">
    <script> 

      var obtener_periodo = function(id)
      {
        var periodos = 
        {
          "01" : "Enero",
          "02" : "Febrero",
          "03" : "Marzo",
          "04" : "Abril",
          "05" : "Mayo",
          "06" : "Junio",
          "07" : "Julio",
          "08" : "Agosto",
          "09" : "Septiembre",
          "10" : "Octubre",
          "11" : "Noviembre",
          "12" : "Diciembre",
        };

        return periodos[id];
      }
      

      var plan_id = <? echo $plan; ?> ;      

      var ptr = "<? echo $partner; ?>" ; 
      var key = "<? echo $key; ?>" ;          
      var name = "<? echo $name; ?>" ;          
      var resume = "<? echo $resume; ?>" ; 
      var costo = <? echo $costo; ?> ;
      
      var desc_id = 0;
      var periodo = "";
      var desc_periodo = "";
      var descuento_rate = 0;
      var desc = "No hay descuentos";
      
      <? if (count($descuentos) > 0){ ?>

      var desc_id = parseInt("<? echo $descuentos['id']; ?>");
      var periodo = "<? echo $descuentos['periodo']; ?>";
      var desc_periodo = obtener_periodo(periodo);
      var descuento_rate = <? echo $descuentos["porcentaje"]; ?>;
      var desc = "Ahorra el <b>" + descuento_rate + "%</b> al hacer tu compra en <b>" + desc_periodo + "</b>.";
      
      <? } ?>     

    </script>
  </head>
  <body>

    <div class="modal fade" id="empresaModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <?
          $path = SERVERNAME . "/Configuracion.php?update=empresa";
          $path = $path . "&uid=" . $uid . "&pwd=" . $pwd . "&cid=" . $cid[0];
          ?>
          <form id="EmpresaForm" class="form-modal" action="<? echo $path; ?>">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel">Configuración de mi Empresa</h4>
            </div>
            <div class="modal-body">
              
              <div class="hid_input fiscales">
                <label for="razon_social">Ingrese su Razon Social: <b style="color:red;">*</b></label>
                <input type="text" name="razon_social" placeholder="Razon Social" required>
                
                <div class="_50">
                    <label for="rfc">RFC: <b style="color:red;">*</b></label>
                    <input type="text" name="rfc" placeholder="RFC" required>                  
                </div>
                <div class="_50">
                  <label for="regimen">Regimen Fiscal:</label>
                  <!-- <input type="text" name="regimen" placeholder="Regimen"> -->
                  <select name="regimen" id="regimen">
                    <option value="1">Sociedad de Nombre Colectivo</option>
                    <option value="2">Sociedad en Comandita Simple</option>
                    <option value="3">Sociedad de Responsabilidad Limitada</option>
                    <option value="4">Sociedad Anonima</option>
                    <option value="5">Sociedad en Comandita por Acciones</option>
                    <option value="6">Sociedad Cooperativa</option>
                    <option value="7">Sociedad Civil</option>
                    <option value="8">Persona Fisica con Actividad Empresarial</option>
                  </select>
                </div>
                <div class="_50">
                  <label for="giro">Actividad Principal o Giro:</label>
                  <input type="text" name="giro" placeholder="Giro">
                </div>
                <div class="_50">
                  <label for="empresa_name">Alias o nombre comercial de empresa:</label>
                  <input type="text" name="empresa_name" placeholder="Nombre Empresa">
                </div>
                <b>DOMICILIO FISCAL</b><br>
                <div class="_50">                  
                  <input type="text" name="calle" placeholder="Calle">                  
                </div>
                <div class="_50">                  
                  <input type="text" name="numero" placeholder="Numero">                  
                </div>
                <div class="_50">                  
                  <input type="text" name="colonia" placeholder="Colonia">                  
                </div>
                <div class="_50">                  
                  <input type="text" name="cp" placeholder="Codigo Postal">                  
                </div>
                <div class="_50">                  
                  <input type="text" name="municipio" placeholder="Municipio">                  
                </div>
                <div class="_50">                  
                  <!-- <input type="text" name="estado" placeholder="Estado">   -->
                  <select name="estado" id="estado" >
                    <option value="1">Monterrey</option>
                    <option value="2">Guerrero</option>
                    <option value="3">Distrito Federal</option>
                    <option value="4">Guadalajara</option>
                    <option value="5">Puebla</option>
                    <option value="6">Queretaro</option>
                    <option value="7">Cancun</option>
                    <option value="8">Sinaloa</option>
                  </select>                
                </div>
                <div style="width:100%;">                  
                  <label for="tipo_registro">
                    <input type="checkbox" id="tipo_registro" style="width:auto;display:inline-block">
                    Utilizar mismos datos fiscales para facurar mi pago
                  </label>
                </div>
                
              </div>
           

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
              <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
          </form>
        </div>
      </div>
    </div>


    <div class="navbar-wrapper">
      <? require 'view/header.php' ?>
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
        <? require 'view/footer.php'; ?>
    </footer>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="js/lib/bootstrap.min.js"></script>
    <script src="js/base.js"></script>
    <script src="js/compra.js"></script>
  </body>
</html>
