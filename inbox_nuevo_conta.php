<!DOCTYPE html>
<html lang="en">
  <head>
    <? require 'fijos/head.php'; ?>
    <link rel="stylesheet" href="css/inbox.css"/>
    
    <link rel="stylesheet" type="text/css" media="screen" href="css/site.css">
    <link rel="stylesheet" type="text/css" media="screen" href="css/bootstrap-datetimepicker.min.css">
    <title>INICIO</title>
    <style type="text/css">
    body {
      font-family: Arial, Helvetica;
    }
    .navbar {
      background: #cc3366;
    }
    .tab_sucursales {
      display: none !important;
    }
    hr{
      border: 1px solid #cc3366;
      width: 100%;
    }
    .panel-default {
      border-color: white;
    }
    .list-group-item {
      border: 0px;
    }
    .header_azul {
      float: right;
      background: url('http://savvysystems.com.mx/img/barra_azul_header.png');
      height: 100px;
      background-size: 100%;
      /* padding-left: 270px; */
      background-repeat: no-repeat;
    }
    .table {
      background: #e6e6e6;
      background-color: #e6e6e6 !important;
      font-family: Arial;
      font-size: 11px;
    }
    .nav-tabs>li.active>a, .nav-tabs>li.active>a:hover, .nav-tabs>li.active>a:focus {
      font-size: 12px;
      font-family: Corbel,century gothic, helvetica;
      background: #e6e6e6;
      font-weight: bold;
    }

    span[id="^_open"] {
      -ms-transform: rotate(90deg); /* IE 9 */
      -webkit-transform: rotate(90deg); /* Chrome, Safari, Opera */
      transform: rotate(90deg);
    }

    span[id="^_closed"] {
      -ms-transform: rotate(0deg); /* IE 9 */
      -webkit-transform: rotate(0deg); /* Chrome, Safari, Opera */
      transform: rotate(0deg);
    }
    .panel-heading {
      border-radius: 10px;
      border: 1px solid #b3b3b3;
      background: #f7f7f7;
      padding: 15px;
    }
    .subLista {
      padding-left: 10px;
    }
    .subLista li {
      list-style-type: circle;
      width: 100%;
      font-size: 12px;
    }
    .subPanel {
      padding: 2px;
      border-radius: 0px;
      border: 0px;
      color: #666666;
    }

    #barra_principal
    {
      overflow: auto;
      padding-left: 2em;
    }

    #yourBtn, #yourBtn2
    {   
      display: block;
      float: left;   
      width:50px;
      height:40px;
      max-width:50px;
      margin-right:10px;
      /*margin-right:10px;      */
      cursor:pointer;
      background: url("img/upload.png");
      background-size: 50px 40px;
      background-repeat: no-repeat;
      /*overflow: auto;*/
    }     
    
    #yourBtn2
    {
      background: url("img/actualizar_naranja.png");
      background-size: 50px 40px;
      background-repeat: no-repeat;
    }

    </style>
  <script>
  
  var msj = "<? echo $_GET["msj"]; ?>";
  if (msj != "")
  {
    alert(msj);
  }
  
  </script>

  </head>
  <body>
    
    <div class="navbar-wrapper">
      <? require 'fijos/header_logged.php' ?>
    </div>

    <div class="container" style="padding:30px 0px;">
      <div class="col-md-2">
        <i><a class="file_upload" href="#"></a></i>
        <div style="text-align:center;margin-bottom:15px;">
          
          <form id="barra_principal" name="myForm" action="server/Upload.php" method="POST" enctype="multipart/form-data">
            <div id="yourBtn"/>&nbsp;</div>
            <div id="yourBtn2"/>&nbsp;</div>
            <div style='height: 0px;width:0px; overflow:hidden;'>
              <input type="file" id="upfile" name="userfile">              
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
                <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                  POLIZAS DIARIO
                </a>
              </h4>
            </div>
            <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
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
                            <a href="#">
                              Ventas (0)
                            </a>
                          </li>
                          <li>
                            <a href="#">
                              Notas de Credito (0)
                            </a>
                          </li>
                          <li>
                            <a href="#">
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
                            <a href="#">
                              Compras (0)
                            </a>
                          </li>
                          <li>
                            <a href="#">
                              Honorarios (0)
                            </a>
                          </li>
                          <li>
                            <a href="#">
                              Notas de Cargo (0)
                            </a>
                          </li>
                          <li>
                            <a href="#">
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
                <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
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
                            <a href="#">
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

      <div class="col-md-10">
        <?
        if (isset($_GET['section'])):

          switch ($_GET['section']) {
            case 'config':
              require 'fijos/config_conta.php';
            break;
            case 'agregar_empresa':
              require 'fijos/agregar_empresa_conta.php';
            break;
            case 'progress':
              require 'fijos/progress_bar.php';
            break;
            case 'alerts':
              require 'fijos/alerts.php';
            break;
            case 'table':
              require 'fijos/tabla_conta.php';
            break;
            case 'poliza':
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
            default:
              echo "Bienvenidos!";
              break;
          }
        endif;
        ?>
      </div>
    </div>

    <footer>
        <? require 'fijos/footer.php'; ?>
    </footer>
     
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/inbox.js"></script>    
  </body>
</html>
