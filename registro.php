<? require_once "server/conf/constantes.conf"; ?>
<? session_start(); ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <style type="text/css">
      .box_form{
        box-shadow: 0px 4px 40px black;
        max-width: 400px;
        max-height: 600px;
        padding: 30px 50px 30px 30px;
        margin-left: 30px;
      }
    </style>
    <? require 'fijos/head.php'; ?>
    <title>INICIO</title>
  </head>
  <body>
    <div style="height:25px;background:#2C6494;">
    </div>

    <!--div class="container" style="text-align:center;"-->
    <div style="text-align:center;background:white;min-height: 450px;padding-top:50px;">
      <div class="container">
        <div class="col-md-6">
            <img src="img/logo_home.png" style="height:100%;width:100%;max-width: 300px;">
        </div>
        <div class="col-md-6">
          <div class="box_form">
            
            <form id="form_registro" action="<? echo SERVERNAME.'/Suscripcion.php?action='; ?>"
              method="POST">

              <input type="hidden" id="action" name="action" value="registro"/>
              
             <!--  <input type="text" id="nombre" name="nombre" placeholder="Nombre" />
              <br><br>
              <input type="text" id="apellido" name="apellido" placeholder="Apellido" />
              <br><br> -->
              <input type="text" id="username" name="username" pattern="^[a-zA-Z0-9_-]{6,15}$" required="true" title="min. 6 Caracteres a-z, A-Z, 0-9, _ -" placeholder="Username" />
              <br><br>
              <input required="true" type="email" id="email" name="email" placeholder="Email" />
              <br><br>
              <input required="true" type="password" id="password" name="password" placeholder="Contraseña" />
              <br><br>
              <input required="true" type="password" id="password2" name="password2" placeholder="Confirmar Contraseña" />
              <br><br>
              <table class="table tyc">
                <tr>
                  <td>
                    <input type="checkbox" style="display:block; width:auto;" name="tyc" id="tyc"/>
                  </td>
                  <td style="text-align: left;">
                    Acepto los <a href="http://docs.google.com/viewer?url=www.savvysystems.com.mx%2Fdocs%2FSAVVY%2520-%2520Terminos%2520y%2520Condiciones.odt" class="blue">Términos de Privacidad</a>
                  </td>
                </tr>
              </table>
              <input type="submit" class="btn btn-primary" id="submit" value="Registrate">
              <div id="loader" style="display:none;">
                <img src="img/ajax_loader_registrar.gif">
              </div>
              <br><br>
              <span><a class="signin" href="login.php" class="blue">o ingresa a tu cuenta</a></span>
              <!-- </form> -->
          </div>
        </div>
      </div>
    </div>
    <div style="min-height:150px;margin-top: 20px;">
      <div class="container" style="padding: 10px;">
        <div class="col-md-2">
          &nbsp;
        </div>
        <div class="col-md-2">
          <div class="card-container">
            <div class="card">
              <div class="side">
                <img src="http://savvysystems.com.mx/img/pagina_inicio/INFO%201.png">
              </div>
              <div class="side back">
                <img src="http://savvysystems.com.mx/img/pagina_inicio/DEMO%20Y%20VIDEOS%202.png">
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-2">
          <div class="card-container">
            <div class="card">
              <div class="side">
                <img src="http://savvysystems.com.mx/img/pagina_inicio/PLANES%20PRECIOS%201.png">
              </div>
              <div class="side back">
                <img src="http://savvysystems.com.mx/img/pagina_inicio/DEMO%20Y%20VIDEOS%202.png">
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-2">
          <div class="card-container">
            <div class="card">
              <div class="side">
                <img src="http://savvysystems.com.mx/img/pagina_inicio/DEMO%20Y%20VIDEOS%201.png">
              </div>
              <div class="side back">
                <img src="http://savvysystems.com.mx/img/pagina_inicio/DEMO%20Y%20VIDEOS%202.png">
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-2">
          <div class="card-container">
            <div class="card">
              <div class="side">
                <img src="http://savvysystems.com.mx/img/pagina_inicio/NOSOTROS%201.png">
              </div>
              <div class="side back">
                <img src="http://savvysystems.com.mx/img/pagina_inicio/DEMO%20Y%20VIDEOS%202.png">
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-2">
          &nbsp;
        </div>
      </div>
    </div>

    <footer>
        <? require 'fijos/footer.php'; ?>
    </footer>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="js/lib/bootstrap.min.js"></script>
    <script src="js/registro.js"></script>

  </body>
</html>
