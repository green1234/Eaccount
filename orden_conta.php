<?
$plan = ""; #$_POST['plan'];
$rfc = ""; #$_POST['rfc'];
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <? require 'fijos/head.php'; ?>
    <style type="text/css">

      @font-face {
        font-family: "Corbel-bold";
        src: url(fonts/Corbel-Bold.ttf) format("truetype");
      }
      @font-face {
        font-family: "Corbel-italic";
        src: url(fonts/Corbel-Italic.ttf) format("opentype");
      }
      @font-face{
        font-family: "Corbel";
        src: url(fonts/Corbel.ttf); /* .eot - Internet Explorer */
      }

      body
      {
        font-family: "Corbel"
      }

      hr {
        border-top: 1px solid #cc3366;
      }
  
      ul 
      {
        overflow: auto;
        list-style-type: none;
      }
      
      .col-md-12 form div.first
      {
        border: 1px solid gray;
        width: 100%;
        overflow: auto;
      }

      .table_compra_1
      {
        color: white;
        width: 100%;
        background-color: #17354f;
        padding-bottom: 0.5em;
        padding-top: 0.5em;
      }

      .table_compra_1 li
      {
        display: inline-block;
        margin-right: 5em;      
      }   

      .table_compra_1 li.first
      {
        width: 250px;     
      }

      .table_compra_2
      {
        padding: 0;        
      }

      .table_compra_2 li
      {
        width: 20%;
        text-align: center;
        display: block;
        float: left;
        margin-right: 1em;
      }

      .table_compra_2 li.first
      {
        width: 32%;
        padding: 0 0.5em;
        font-size: 0.9em;
      }

      .table_compra_2 li h3
      {        
        font-weight: bold;
        /*font-size: 0.9em;*/
      }

      .table_compra_2 li select
      {        
        padding: 0.2em;
        border-radius: 5px;
        margin-top: 0.5em;
      }
      .table_compra_3
      {
        background-color: #cc3366;
        color: white;
        padding: 0.5em 0;
      }

      .table_compra_3 li
      {
        display: inline-block;
        width: 33%;
        text-align: center;

      }
      
      .table_compra_3 li.first
      {
        text-align: left;
        padding-left: 1em;
      }

      .table_compra_3 li.last
      {
        text-align: right;
        padding-right: 1em;
      }
      
      .table_compra_4 li
      {
        display: inline-block;
        width: 40%;
        text-align: left;
      }

      .table_compra_4 li.first
      {
        /*vertical-align: center;*/
        text-align: left;
        width: 33%;
      }

      .table_compra_4 li.first input
      {
        width: 40%;        
      }

      .table_compra_4 li.first a
      {
        background-color: #2c6494;
        padding: 0.2em 0.5em;
        border-radius: 5px;
        color: white;
      }

      .table_compra_4 li.last
      {
        text-align: right;
        padding-right: 1.5em;
        font-weight: bold;
        width: 26%
      }

      .table_compra_4 li h3
      {        
        font-weight: bold;
      }

      .table_compra_4 li p
      {        
        padding-left: 2em;
      }
      
      .table_compra_5
      {
        padding: 0;
      }

      .table_compra_5 li
      {        
        display: inline-block;
        width: 28%;
        padding-top: 0.5em;
      }

      .table_compra_5 li.first
      {        
        width: 70%;
        padding: 1em 7em 0 2em;
      }

      .table_compra_5 li.last
      {        
        /*text-align: right;*/
        background-color: #e6e6e6;
        border-left: 1px solid gray;
        border-right: 1px solid gray;
        border-bottom: 1px solid gray;
        padding: 1em 1em 1em 0;
        float: right;
      }

      .table_compra_5 li.last div
      {
        display: block;
        width: 100%;
        /*padding: 2em 1em;*/
      }
    
      .table_compra_5 li.last div span
      {
        width: 100px;
        display: inline-block;
        text-align: right;
        margin-right: 2em;
        /*margin-left: 1em;*/
      }

      .confirm_compra
      {
        background-color: #2c6494;
        padding: 0.3em 0.5em;
        float: right;
        color: white;
        border-radius: 5px;
        width: 28%;
        text-align: center;
        margin-top: 0.8em;
        margin-bottom: 5em;
      }


    </style>
    <title>Orden de Compra</title>
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
  </body>
</html>
