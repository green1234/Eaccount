<? require_once "server/conf/constantes.conf"; ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <link rel="stylesheet" href="css/login.css">
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
            <img src="http://savvysystems.com.mx/img/logo_conta_home.png" style="height:100%;width:100%;max-width: 300px;">
        </div>
        <div class="col-md-6">
          <div class="box_form">
            <div class="left">Ingresar con mi cuenta:</div>
            <br><br>
            <form id="form_login" action="<? echo SERVERNAME.'/Login.php?'; ?>">              
              <input type="text" id="username" name="username" pattern="^[a-zA-Z0-9_-]{5,15}$" required="true" title="min. 6 Caracteres a-z, A-Z, 0-9, _ -" placeholder="Username" />
              <br><br>              
              <input required="true" type="password" id="password" name="password" placeholder="Confirmar Contraseña" />
              <br><br>
              <label class="left"><input type="checkbox">&nbsp;&nbsp;Recordar mi cuenta.</label>
              <br><br>
              <input type="submit" class="login_button btn btn-primary" id="submit" value="Ingresar">
              <div id="loader" style="display:none;">
                <img src="img/ajax_loader_registrar.gif">
              </div>
              <br><br>
              <span><a class="signup" href="registro.php" class="blue">Olvide mi contraseña</a></span>
              <br>
              <span><a class="signup" href="registro.php" class="blue">Crear una nueva cuenta</a></span>
            </form>
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
    <script src="js/login.js"></script>

  </body>
</html>
