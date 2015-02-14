<? require_once "server/conf/constantes.conf"; ?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <? require 'fijos/head.php'; ?>
    <title>SOBRE SAVVY SYSTEMS</title>
    <link href="css/base.css" rel="stylesheet">
    <style type="text/css">
      hr
      {
        border-top: 1px solid gray;
      }

      .box_form{
        box-shadow: 0px 4px 40px black;
        max-width: 400px;
        max-height: 600px;
        padding: 30px 50px 30px 30px;
        margin-left: 30px;
      }

      div.aplicaciones
      {
        background-color: white;
        /*position: absolute;*/
        width: 100%;
        padding: 2em 0 2em 0;
        overflow: auto;
        text-align: center;
        box-shadow: 10px 10px 30px gray;
        margin-bottom: 2em; 
      }

      div.aplicaciones > .picture
      {
        margin-left: 3.5em;
        /*width: 30%;*/
        /*float: left;*/
        display: inline-block;
      }
    </style>
  </head>
  <body>
    <div style="height:25px;background:#2C6494;">
    </div>    

    <div class="container_lines">
      <div style="text-align:center;min-height: 450px;padding-top:50px;">
        <div class="container">
          <div class="col-md-3"></div>
          <div class="col-md-6">
            <img src="img/logo_savvy.png" style="height:100%;width:100%;max-width: 300px;">
          </div>
           
        </div>
      </div>
    
      <div class="article aplicaciones" >      
        <div class="picture">
          <a class="logos" target="_blank" href="/vresguardo/registro.php">
            <img src="img/savvy_logo_1.png" width="70%" alt=""></a>
        </div>
        <div class="picture">
          <a class="logos" target="_blank" href="/eaccount/registro.php">
            <img src="img/savvy_logo_2.png" width="70%" alt=""></a>
        </div>
        <div class="picture">
          <a class="logos" target="_blank" href="/vresguardo/registro.php">
            <img src="img/savvy_logo_3.png" width="70%" alt=""></a>
        </div>
      </div>
    

      <div class="container container_text" >
             
        <div class="col-md-14">
          <h2>SOBRE SAVVY SYSTEMS</h2>
          <p>            
            Somos una empresa dedicada a desarrollar aplicaciones para facilitar 
            la administración de tu negocio y el de miles de empresas con la caracteristica 
            de ser servicios 100% web, esto significa que lo puedes utilizar con cualquier 
            dispositivo que tenga acceso a internet; y también que no requieres comprar 
            el software o sus actualizaciones; siempre está disponible desde cualquier lugar.
          </p>
          <p>
            Al desarrollar nuestros productos consideramos tus necesidades y valoramos 
            tu tiempo, nos enfocamos en que obtengas valor al usar nuestros productos por 
            su eficiencia y eficacia.
          </p>
          <p>
            Nuestro equipo de trabajo está conformado por especialistas en programación, en 
            diseño y administración de procesos de negocio, lo que nos permite ofrecerte 
            productos desarrollados con tecnologías de últíma generación.
          </p>

          <hr>
          
          <h2>FACTURACIÓN ELECTRÓNICA SAVVY</h2>

          <p>            
            La aplicación de Facturación Electrónica SAVVY te facilita la generación de Comprobantes Fiscales Digitales por Internet, CFDI, como son las facturas, notas de crédito y recibos de nómina que utilizas para la operación diaria de tu negocio.
          </p>

          <p>
            Facturación Electrónica SAVVY tiene un diseño amigable, es de navegación intuitiva por lo que no requiere de capacitación o asistencia técnica; se aprende a usar en pocos minutos. No requieres crear catálogos para usarlo.
          </p>

          <p>
            Tus facturas son generadas, envíadas a tus clientes, almacenadas en forma segura y genera reportes.
          </p>
          
          <hr>
          <h2>VALIDACIÓN Y RESGUARDO SAVVY</h2>

          <p>           
            Esta aplicación es tu asistente perfecta para tener control de tus CFDIs, tus cuentas por pagar y por cobrar. Todo sin complicaciones y sin pérdida de tiempo y mínima captura de datos.
          </p>
          <p>
            Te permite cumplir con engorrosas disposiciones fiscales, tales como la de validar los CFDIs que recibes de tus proveedores y la de mantener disponibles para la autoridad fiscal todos los CFDIs que incluyes en tu contabilidad en forma ordenada en tu domicilio fiscal.
          </p>
          <p>
            Facilita el registro de tu proceso de consolidación bancaria. Te ayuda a tener control de tus ventas, compras, cuentas por cobrar y cuentas por pagar.  ¡Todo con la herramienta mas fácil de utilizar del mercado!
          </p>
          
          <hr>
          <h2>CONTABILIDAD ELECTRÓNICA SAVVY</h2>
          <p>
            No permitas que el SAT te "obligue" a contratar más contadores para cumplir con la contabilidad electrónica. Contabilidad Electrónica SAVVY te permite cumplir con las disposiciones del SAT e incrementar la productividad de tu contador al mismo tiempo, porque es un sistema que aprende y tu contador es el supervisor que autoriza las operaciones que realiza la aplicación.
          </p>
          <p>
            Si tienes un despacho contable y tus Clientes utilizan  Validación y Resguardo SAVVY, esta aplicación genera para tí las polizas de diario, de ingreso y de egreso en forma automática incrementando tu capacidad de trabajo y tienes la oportunidad de ofrecerles servicios de mayor valor agregado.
          </p>
        </div>
      </div>      
    </div>
    <footer>
        <? require 'fijos/footer.php'; ?>
    </footer>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="js/lib/bootstrap.min.js"></script>
    <script src="js/base.js"></script>           
  </body>
</html>