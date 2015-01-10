<? require_once "server/conf/constantes.conf"; ?>
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
            <img src="http://savvysystems.com.mx/img/logo_conta_home.png" style="height:100%;width:100%;max-width: 300px;">
        </div>
        <div class="col-md-6">
          <div class="box_form">
            <!--form action="http://104.236.124.45/eaccount/server/Registro.php" method="GET"-->
              <input type="text" id="nombre" name="nombre" placeholder="Nombre" />
              <br><br>
              <input type="text" id="apellido" name="apellido" placeholder="Apellido" />
              <br><br>
              <input type="text" id="email" name="email" placeholder="Email" />
              <br><br>
              <input type="password" id="password" name="password" placeholder="Contraseña" />
              <br><br>
              <input type="password" id="password2" name="password2" placeholder="Confirmar Contraseña" />
              <br><br>
              <table class="table">
                <tr>
                  <td>
                    <input type="checkbox" name="tyc" id="tyc"/>
                  </td>
                  <td style="text-align: left;">
                    Acepto los <a href="http://docs.google.com/viewer?url=www.savvysystems.com.mx%2Fdocs%2FSAVVY%2520-%2520Terminos%2520y%2520Condiciones.odt" class="blue">Términos de Privacidad</a>
                  </td>
                </tr>
              </table>
              <input type="submit" class="btn btn-primary" id="submit"></input>
              <div id="loader" style="display:none;">
                <img src="img/ajax_loader_registrar.gif">
              </div>
              <span><a href="login.php" class="blue">o ingresa a tu cuenta</a></span>
              <!--/form-->
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
    <script src="js/bootstrap.min.js"></script>

    <script type="text/javascript">
    $("#submit").click(function(){
      $("#submit").hide();
      $("#loader").show();
      var nombre = $("#nombre").val();
      var apellido = $("#apellido").val();
      var email = $("#email").val();
      var password = $("#password").val();
      var password2 = $("#password2").val();
      // Returns successful data submission message when the entered information is stored in database.
      var dataString = 'nombre='+ nombre + '&apellido='+ apellido  + '&email='+ email + '&password='+ password + '&password2='+ password2;
      if(nombre==''||apellido==''||email==''||password==''||password2=='')
      {
        alert("Por favor llena todos los campos");
        $("#loader").hide();
        $("#submit").show();
      }
      else
      {
        if (!$('#tyc').is(":checked")) {
          alert("Debes aceptar los terminos y condiciones.");
          $("#loader").hide();
          $("#submit").show();
          return false;
        };
        if (password != password2) {
          alert("Las contraseñas no coinciden.");
          $("#loader").hide();
          $("#submit").show();
        }else{
          $.ajax({
              type: "POST",
              url: "<? echo SERVERNAME; ?>" + "/Registro.php",
              data: dataString+'&tyc=1',
              cache: false,
              success: function(result) {
                result = JSON.parse(result);
                if (!result.success == true) {
                  alert(result.data.description);
                }else{
                  window.location.href = "<?echo APPNAME; ?>" + "/inbox_nuevo_conta.php?section=";
                }
                $("#loader").hide();
                $("#submit").show();
              }
          });
        }
      }
    });
    </script>
  </body>
</html>
