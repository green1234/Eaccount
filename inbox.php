<? 
require_once "server/conf/constantes.conf"; 
session_start(); 

if (!isset($_SESSION["login"]))
{
  header('Location: login.php');
}
else
{
  //var_dump($_SESSION["login"]["cid"]);
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <? require 'view/head.php'; ?>
    <link rel="stylesheet" href="css/inbox.css"/>    
    <link rel="stylesheet" type="text/css" media="screen" href="css/bootstrap-datetimepicker.min.css">
    <link rel="stylesheet" type="text/css" media="screen" href="css/site.css">
    <link rel="stylesheet" href="css/inbox_custom.css"/> 
    <title>INICIO</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>    
    <script>
    <? if (isset($_GET["msj"])){?>

    var msj = "<? echo $_GET['msj']; ?>";
    if (msj != "")
    {
      alert(msj);
    }
    <?}?>
  
    </script>

  </head>
  <body>
    
    <div class="navbar-wrapper">
      <? require 'view/header_logged.php' ?>
    </div>

    <div class="container" style="padding:30px 0px;">
      <div class="col-md-2 sidebar">
        <i><a class="file_upload" href="#"></a></i>
        <div style="text-align:center;margin-bottom:15px;">
          
          <?
          if (isset($_SESSION["login"]))
          {
            $uid = $_SESSION["login"]["uid"];
            $pwd = $_SESSION["login"]["pwd"];
            $cid = $_SESSION["login"]["cid"];
            $path = "server/Upload.php?";
            $path = $path . "uid=" . $uid . "&pwd=" . $pwd . "&cid=" . $cid[0];
            //var_dump($_SESSION["login"]);
          }
          ?>

          <form id="barra_principal" name="myForm" action="<? echo $path; ?>" method="POST" enctype="multipart/form-data">
            <div id="yourBtn"/>&nbsp;</div>
            <div id="yourBtn2"/>&nbsp;</div>
            <div style='height: 0px;width:0px; overflow:hidden;'>
              <input type="file" id="upfile" name="userfile[]" accept="*.xml" multiple>              
            </div>
            <!-- <button type="submit">Enviar</button>          -->

            <!-- <img src="img/upload.png" style="max-width:50px;margin-right:10px;"> -->
            <!-- <img src="img/actualizar_naranja.png" style="max-width:50px;"> -->
          </form>
        </div>
        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
          <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingOne">
              <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#collapseZero" aria-expanded="true" aria-controls="collapseZero">
                  ESTATUS CFDI
                </a>
              </h4>
            </div>
            <div id="collapseZero" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
              <div class="panel-body">
                <ul class="subLista">
                  <li>
                    <a class="cfdi vali" href="?section=cfdi&estatus=vali">
                      Por contabilizar <span>(0)</span>
                    </a>
                  </li>
                  <li>
                    <a class="cfdi apoc" href="?section=cfdi&estatus=apoc">
                      Apocrifos <span>(0)</span>
                    </a>
                  </li>
                  <li>
                    <a class="cfdi inco" href="?section=cfdi&estatus=inco">
                      Datos Incorrectos <span>(0)</span>
                    </a>
                  </li>
                  <li>
                    <a class="cfdi erro" href="?section=cfdi&estatus=erro">
                      Error al procesar <span>(0)</span>
                    </a>
                  </li>
                  <li>
                    <a class="cfdi cont" href="?section=cfdi&estatus=cont">
                      Contabilizados <span>(0)</span>
                    </a>
                  </li>
              </div>
            </div>           
                
            <div class="panel-heading" role="tab" id="headingOne">
              <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                  POLIZAS DIARIO
                </a>
              </h4>
            </div>
            <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
              <div class="panel-body">
                <div class="panel-group" id="subAccordion" role="tablist" aria-multiselectable="true">
                  <div class="panel panel-default">
                    <div class="panel-heading subPanel" role="tab" id="headingOne">
                      <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#subAccordion" href="#subCollapseOne" aria-expanded="true" aria-controls="subCollapseOne">
                          CFDI Emitidos
                        </a>
                      </h4>
                    </div>
                    <div id="subCollapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                      <div class="panel-body">
                        <ul class="subLista">
                          <li>
                            <a href="?section=poliza&type=sale">
                              Ventas (0)
                            </a>
                          </li>
                          <li>
                            <a href="?section=poliza&type=nc">
                              Notas de Credito (0)
                            </a>
                          </li>
                          <li>
                            <a href="?section=poliza&type=nomina">
                              Nomina (0)
                            </a>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div>
                  <div class="panel panel-default">
                    <div class="panel-heading subPanel" role="tab" id="headingOne">
                      <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#subAccordion" href="#subCollapseTwo" aria-expanded="true" aria-controls="subCollapseTwo">
                          CFDI Recibidos
                        </a>
                      </h4>
                    </div>
                    <div id="subCollapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                      <div class="panel-body">
                        <ul class="subLista">
                          <li>
                            <a href="?section=poliza&type=purchase">
                              Compras (0)
                            </a>
                          </li>
                          <li>
                            <a href="?section=poliza&type=honorarios">
                              Honorarios (0)
                            </a>
                          </li>
                          <li>
                            <a href="?section=poliza&type=nd">
                              Notas de Cargo (0)
                            </a>
                          </li>
                          <li>
                            <a href="?section=poliza&type=imps">
                              Impuestos Locales (0)
                            </a>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div>
                  <div class="panel panel-default">
                    <div class="panel-heading subPanel" role="tab" id="headingOne">
                      <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#subAccordion" href="#subCollapseThree" aria-expanded="true" aria-controls="subCollapseThree">
                          Captura Manual
                        </a>
                      </h4>
                    </div>
                    <div id="subCollapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                      <div class="panel-body">
                        <ul class="subLista">
                          <li>
                            <a href="?section=poliza&action=new">
                              Capturar Nuevo
                            </a>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingTwo">
              <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                  POLIZAS INGRESOS
                </a>
              </h4>
            </div>
            <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
              <div class="panel-body">
                

                <div class="panel-group" id="subAccordionPoliza" role="tablist" aria-multiselectable="true">
                  <div class="panel panel-default">
                    <div class="panel-heading subPanel" role="tab" id="headingOne">
                      <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#subAccordionPoliza" href="#subCollapseOnePoliza" aria-expanded="true" aria-controls="subCollapseOnePoliza">
                          Ventas
                        </a>
                      </h4>
                    </div>
                    <div id="subCollapseOnePoliza" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                      <div class="panel-body">
                        <ul class="subLista">
                          <li>
                            <a href="?section=fin&tipo=ingreso">
                              Cliente 1
                            </a>
                          </li>
                          <li>
                            <a href="#">
                              Cliente 2
                            </a>
                          </li>
                          <li>
                            <a href="#">
                              Cliente 3
                            </a>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div>
                  <div class="panel panel-default">
                    <div class="panel-heading subPanel" role="tab" id="headingOne">
                      <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#subAccordionPoliza" href="#subCollapseTwoPoliza" aria-expanded="true" aria-controls="subCollapseTwoPoliza">
                          Notas de Credito
                        </a>
                      </h4>
                    </div>
                    <div id="subCollapseTwoPoliza" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                      <div class="panel-body">
                        <ul class="subLista">
                          <li>
                            <a href="#">
                              Proveedor 1
                            </a>
                          </li>
                          <li>
                            <a href="#">
                              Proveedor 2
                            </a>
                          </li>
                          <li>
                            <a href="#">
                              Proveedor 3
                            </a>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingThree">
              <h4 class="panel-title">
                <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                  POLIZAS EGRESOS
                </a>
              </h4>
            </div>
            <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
              <div class="panel-body">
                <div class="panel-group" id="subAccordionPolEgre" role="tablist" aria-multiselectable="true">
                  <div class="panel panel-default">
                    <div class="panel-heading subPanel" role="tab" id="headingOne">
                      <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#subAccordionPolEgre" href="#subCollapseOnePolEgre" aria-expanded="true" aria-controls="subCollapseOnePolEgre">
                          Compras y Gastos
                        </a>
                      </h4>
                    </div>
                    <div id="subCollapseOnePolEgre" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                      <div class="panel-body">
                        <ul class="subLista">
                          <li>
                            <a href="?section=fin&tipo=ingreso">
                              Proveedor 1
                            </a>
                          </li>
                          <li>
                            <a href="#">
                              Proveedor 2
                            </a>
                          </li>
                          <li>
                            <a href="#">
                              Proveedor 3
                            </a>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div> 
              </div>
            </div>
          </div>
          <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingFour">
              <h4 class="panel-title">
                <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                  ESTADOS DE CUENTA BANCARIOS
                </a>
              </h4>
            </div>
            <div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
              <div class="panel-body">
                <button class="btn btn-primary" style="margin-bottom:10px;">
                  IMPORTAR .XLS
                </button>
                <div class="panel-group" id="subAccordionBanco" role="tablist" aria-multiselectable="true">
                  <div class="panel panel-default">
                    <div class="panel-heading subPanel" role="tab" id="headingOne">
                      <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#subAccordionBanco" href="#subCollapseOneBanco" aria-expanded="true" aria-controls="subCollapseOneBanco">
                          Banco A
                        </a>
                      </h4>
                    </div>
                    <div id="subCollapseOneBanco" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                      <div class="panel-body">
                        <ul class="subLista">
                          <li>
                            <a href="#">
                              Cuenta *145
                            </a>
                          </li>
                          <li>
                            <a href="#">
                              Cuenta *245
                            </a>
                          </li>
                          <li>
                            <a href="#">
                              Cuenta *345
                            </a>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingFive">
              <h4 class="panel-title">
                <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                  REPORTES
                </a>
              </h4>
            </div>
            <div id="collapseFive" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
              <div class="panel-body">
                
              </div>
            </div>
          </div>
        </div>
        <button class="submit_main btn btn-primary">
          GUARDAR Y SALIR
        </button>
      </div>
      <div class="col-md-10 contenido" >       
        <?
        if (isset($_GET['section'])):

          switch ($_GET['section']) {
            case 'config':
              require 'view/config/index.php';
              break;
            case 'instrucciones':
              require 'view/config/catalogos/instrucciones.php';
              break;
            case 'fin':
              require 'view/finance/index.php';
              break;
            /*
            case 'agregar_empresa':
              require 'fijos/agregar_empresa_conta.php';
              break;case 'progress':
              require 'fijos/progress_bar.php';
              break;
            case 'alerts':
              require 'fijos/alerts.php';
              break;*/
            /*case 'table':              
              require 'fijos/tabla_cfdi.php';
              break;
            case 'detail':              
              require 'fijos/cfdi_detail.php';                            
              break;*/
            case 'cfdi':              
              require 'view/cfdi/index.php';
              break;
            case 'cfdi_detail':              
              require 'view/cfdi/cfdi_detail.php';                            
              break;
            case 'poliza':              
              require 'view/polizas/index.php';
              break;
            /*case 'poliza_detail':              
              require 'view/polizas/poliza_detail.php';                            
              break;*/
            /*case 'poliza':
              require 'fijos/poliza.php';
              break;
            case 'clientes':
              require 'fijos/clientes_conta.php';
              break;
            case 'proveedores':
              require 'fijos/proveedor_conta.php';
              break;
            case 'cuentas':
              require 'fijos/cuenta_conta.php';
              break;
            case 'instrucciones':
              require 'fijos/catalogos/instrucciones.php';
              break;*/
            case 'close':
              session_destroy();
              echo '<script>parent.window.location.reload(true);</script>';                 
              break;
            default:
              break;
          }
        endif;
        ?>
      </div>
    </div>
    <footer>
        <? require 'view/footer.php'; ?>
    </footer>
     
    
    <script src="js/lib/bootstrap.min.js"></script>
    <script src="js/inbox.js"></script>    
  </body>
</html>
