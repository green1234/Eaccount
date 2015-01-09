<!DOCTYPE html>
<html lang="en">
  <head>
    <? require 'fijos/head.php'; ?>
    <title>SOBRE SAVVY SYSTEMS</title>

    <style>
      
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

      .elem_xs_d
      {
        font-family: "Corbel";
        border:1px solid gray;
        position: relative;
        width: 300px;
        height: 354px;        
        background: white;
        border-radius: 15px 15px; 
        margin-left: 2em;
        margin-top: 95px;
        text-align: center;   
        
      }     

      .elem_xs_d a
      {
        position: absolute;
        background-color: #275989;
        color: white;
        padding: 0.3em 0.5em;
        font-size: 1.5em;        
        border-radius: 10px;
        box-shadow: none;
        text-decoration: none;
        bottom: -1em;
        left: 3.8em;
        cursor: pointer;
      }

      .elem_xs_d img
      {
        position: absolute;
        left: 1em;
        top: -70px;        
      }

      .elem_xs_d p
      {
        position: relative;
        margin-top: 140px;
        padding-left: 1em;
        padding-right: 1em;
      }

      .elem_xs_d span
      {        
        display: block;
        position: relative;
        margin-top: 1em;
        margin-bottom: 3em;
        padding: 0 3.5em;        
      }

      .elem_xs_d h3
      {
        margin: 0;
        padding: 0;        
        font-weight: bold;
        color: #cc3366;
      }

      .elem_xs_d h5
      {
        margin: 0;
        padding: 0;        
        font-weight: bold;
        color: #cc3366;
      }

      .container_lines
      {
        padding-bottom: 3em;
        background: #e9e9e9;
      }

      p.message_footer
      {        
        text-align: center;
        width: 100%;
        margin:4em 0 1em 0;
        
      }

    </style>

  </head>
  <body>
    <div class="navbar-wrapper">
      <? require 'fijos/header_conta.php' ?>
      <div class="titulo_pagina">
        <div class="container_titulo_pagina">
          SELECCIONA TU PLAN       
        </div>
      </div>
    </div>

    <div class="container_lines">
      <div class="container" style="background:#e9e9e9">
        <div class="col-md-4">
          <form id="plan_domicilio" action="orden_conta.php" method="post">
            <input type="hidden" name="plan" id="plan" value="2" />
            <input type="hidden" name="rfc" id="rfc" value="Aqui va el RFC" /><!--AQUI IMPRIMIMOS EL RFC CON PHP-->
            <!-- <image onClick="document.getElementById('plan_emprendedor').submit();" id="btnPlanes1" src="img/plane_domicilio.png" style="width: 300px;float:right;cursor:pointer;" /> -->
            <div class="elem_xs_d">
              <img src="img/plan-01.png"/>
              <p>Para los grandes empresarios que inician con su negocio.</p>
              <h3>$550.00 / año</h3>
              <span>Si estas iniciando un negocio o tu empresa procesa hasta 750 CFDI por año, utiliza este plan.</span>
              <a src="#">Comprar Ahora</a>
            </div>
          </form>
        </div>
        <div class="col-md-4" style="text-align:center;">
          <form id="form_plan_sucursales" action="orden_conta.php" method="post">
            <input type="hidden" name="plan" id="plan_basico" value="1" />
            <input type="hidden" name="rfc" id="rfc_basico" value="Aqui va el RFC" /><!--AQUI IMPRIMIMOS EL RFC CON PHP-->
            <!-- <image onClick="document.getElementById('form_plan_basico').submit();" id="btnPlanes2" src="img/plan_sucursales.png" style="width: 300px;cursor:pointer;" /> -->
            
            <div class="elem_xs_d">
              <img src="img/plan-02.png"/>
              <p>Para las empresas en crecimiento. Manejo ilimitado de CFDI</p>
              <h3>$3,250.00 / año</h3>
              <span>Para cumplir con las dispocisiones del SAT de forma segura y sencilla. Ahorra tiempo de tu personal.</span>
              <a src="#">Comprar Ahora</a>
            </div>
            
        </form>
        </div>
        <div class="col-md-4">
          <form id="form_plan_despacho" action="orden_conta.php" method="post">
            <input type="hidden" name="plan" id="plan_basico" value="1" />
            <input type="hidden" name="rfc" id="rfc_basico" value="Aqui va el RFC" /><!--AQUI IMPRIMIMOS EL RFC CON PHP-->
            <!-- <image onClick="document.getElementById('form_plan_basico').submit();" id="btnPlanes3" src="img/plan_despacho.png" style="width: 300px;cursor:pointer;" /> -->
            <div class="elem_xs_d">
              <img src="img/plan-03.png"/>
              <p>Permite trabajar con multiples Razones Sociales</p>
              <h3>$5,250.00 / año</h3>
              <h5>Con capacidad para 6 RFC</h5>
              <span>Puedes agregar contadores en cualquier momento. Por cada 10 RFC adicionales, $3250 / año.</span>
              <a src="#">Comprar Ahora</a>
            </div>
        </form>
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
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
