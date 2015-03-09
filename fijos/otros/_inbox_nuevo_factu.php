<!DOCTYPE html>
<html lang="en">
  <head>
    <? require 'fijos/head.php'; ?>
    <link rel="stylesheet" href="css/inbox.css"/>
    <script src="js/inbox.js"></script>
    <title>INICIO</title>
    <style type="text/css">
    .navbar {
      background: #7eb066;
    }
    .tab_cuentas_contables, .tab_otros_causantes, .tab_sucursales {
      display: none !important;
    }
    hr{
      border: 1px solid #7eb066;
      width: 100%;
    }
    .panel-default>.panel-heading {
      background-color: white;
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
    /*
    .glyphicon-play {
      -ms-transform: rotate(90deg);
      -webkit-transform: rotate(90deg);
      transform: rotate(90deg);
    }
    */

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
    </style>
  </head>
  <body>
    
    <div class="navbar-wrapper">
      <? require 'fijos/header_logged.php' ?>
    </div>

    <div class="container" style="padding:30px 0px;">
      <div class="col-md-2">

        <div style="text-align:center;">
          <button class="btn btn-primary">
            Subir&nbsp;<span class="glyphicon glyphicon-upload"></span>
          </button>
        </div>

        <div class="panel-group" role="tablist" style="margin-top: 20px;">
          <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="collapseListGroupHeading1">
                <a class="" data-toggle="collapse" href="#collapseListGroup1" aria-expanded="true" aria-controls="collapseListGroup1" onClick="rotaflecha(this)">
                  <span class="glyphicon glyphicon-play" id="icon_estatus_open"></span>
                  Estatus
                </a>
            </div>
            <div id="collapseListGroup1" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="collapseListGroupHeading1" aria-expanded="true">
              <ul class="list-group">
                <li class="list-group-item">Recientes (20)</li>
                <li class="list-group-item">Validas (250)</li>
                <li class="list-group-item">Apócrifas (3)</li>
                <li class="list-group-item">Datos incorrectos (5)</li>
              </ul>
            </div>

            <div class="panel-heading" role="tab" id="collapseListGroupHeading3">
                <a class="" data-toggle="collapse" href="#collapseListGroup3" aria-expanded="false" aria-controls="collapseListGroup3" onClick="rotaflecha(this)">
                  <span class="glyphicon glyphicon-play" id="icon_reportes_open"></span>
                  Reportes
                </a>
            </div>
            <div id="collapseListGroup3" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="collapseListGroupHeading3" aria-expanded="false">
              <ul class="list-group">
                <li class="list-group-item">Cuentas por Cobrar</li>
                <li class="list-group-item">Cuentas por Pagar</li>
                <li class="list-group-item">Pólizas</li>
                <li class="list-group-item">Egresos Mensuales</li>
                <li class="list-group-item">Ingresos Mensuales</li>
              </ul>
            </div>

            <div class="panel-heading" role="tab" id="collapseListGroupHeading4">
                <a class="" data-toggle="collapse" href="#collapseListGroup4" aria-expanded="false" aria-controls="collapseListGroup4" onClick="rotaflecha(this)">
                  <span class="glyphicon glyphicon-play" id="icon_emitidas_open"></span>
                  Emitidas
                </a>
            </div>
            <div id="collapseListGroup4" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="collapseListGroupHeading4" aria-expanded="false">
              <ul class="list-group">
                <li class="list-group-item">Cliente 1</li>
                <li class="list-group-item">Cliente 2</li>
                <li class="list-group-item">Cliente 3</li>
                <li class="list-group-item">Cliente 4</li>
                <li class="list-group-item">Cliente ...</li>
              </ul>
            </div>

            <div class="panel-heading" role="tab" id="collapseListGroupHeading5">
                <a class="" data-toggle="collapse" href="#collapseListGroup5" aria-expanded="false" aria-controls="collapseListGroup5" onClick="rotaflecha(this)">
                  <span class="glyphicon glyphicon-play" id="icon_recibidas_open"></span>
                  Recibidas
                </a>
            </div>
            <div id="collapseListGroup5" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="collapseListGroupHeading5" aria-expanded="false">
              <ul class="list-group">
                <li class="list-group-item">Proveedor 1</li>
                <li class="list-group-item">Proveedor 2</li>
                <li class="list-group-item">Proveedor 3</li>
                <li class="list-group-item">Proveedor 4</li>
                <li class="list-group-item">Proveedor ...</li>
              </ul>
            </div>

          </div>
        </div>


        <button class="btn btn-warning">
          Invita a un Amigo
          <br>
          y amplia tu subscripción
        </button>


      </div>

      <div class="col-md-10">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist" style="margin-bottom: -2px;">
          <li role="presentation" class="active"><a href="#cuentas" role="tab" data-toggle="tab">MIS CUENTAS</a></li>
          <li role="presentation"><a href="#empresas" role="tab" data-toggle="tab">MI EMPRESA</a></li>
          <li role="presentation"><a href="#catalogos" role="tab" data-toggle="tab">CATÁLOGOS</a></li>
          <!--li role="presentation"><a href="#clientes" role="tab" data-toggle="tab">CLIENTES</a></li>
          <li role="presentation"><a href="#proveedores" role="tab" data-toggle="tab">PROVEEDORES</a></li-->
        </ul>

        <!-- Tab panes -->
        <div class="tab-content container" style="width: auto;background: #e6e6e6;font-family: Arial;font-size: 11px;">

          <!--INICIA TAB "MIS CUENTAS"-->
          <? require 'mis_cuentas.php' ?>
          <!--FIN TAB "MIS CUENTAS"-->

          <!--INICIA TAB "MI EMPRESA"-->
          <? require 'mi_empresa.php' ?>
          <!--FIN TAB "MI EMPRESA"-->

          <!--INICIA TAB "CATALOGOS"-->
          <? require 'catalogos.php' ?>
          <!--FIN TAB "CATALOGOS"-->
        </div>
      </div>
    </div>

      <footer>
          <? require 'fijos/footer.php'; ?>
      </footer>

      <script type="text/javascript">
        function muestraporque () {
          $("#porque").show("slow");
        }

        var openOrClosed = true;

        function rotaflecha(obj) {
          var id_fleacha = obj.children[0].id;
          

          //$("#"+id_fleacha).toggle(openOrClosed);


          if ( openOrClosed === true ) {
            console.log("Open");
            openOrClosed = false;
          } else if ( openOrClosed === false ) {
            console.log("Closed");
            openOrClosed = true;
          }

        }
      </script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script type="text/javascript">
      jQuery(document).ready(function() {
        jQuery('.popover-1').tooltip({
          trigger: "hover",
            animation: true,
            placement: 'bottom'
        })
      });
    </script>
  </body>
</html>
