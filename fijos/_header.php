<div class="navbar" role="navigation">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse" style="background:gray;">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="http://savvysystems.com.mx/">
        <img src="http://savvysystems.com.mx/img/header_externo/HEADER%20EXTERNO.%20LOGO%20FACTURAS.png" style="max-width: 120px;">
      </a>
    </div>
    <div class="navbar-collapse collapse" style="float:right">
      <ul class="nav navbar-nav">
        <li onClick="window.open('http://savvysystems.com.mx/info.php','_self');" class="link_header" style="padding-top: 19px !important;">
          <div class="card-container">
            <div class="card">
              <div class="side">
                <img src="http://savvysystems.com.mx/img/pagina_inicio/INFO%201.png" class="img_header">
              </div>
              <div class="side back">
                <img src="http://savvysystems.com.mx/img/pagina_inicio/INFO%202.png" class="img_header">
              </div>
            </div>
          </div>
        </li>
        <li onClick="window.open('http://savvysystems.com.mx/planes.php','_self');" class="link_header" style="padding-top: 19px !important;">
          <div class="card-container">
            <div class="card">
              <div class="side">
                <img src="http://savvysystems.com.mx/img/pagina_inicio/PLANES%20PRECIOS%201.png" class="img_header">
              </div>
              <div class="side back">
                <img src="http://savvysystems.com.mx/img/pagina_inicio/PLANES Y PRECIOS 2.png" class="img_header">
              </div>
            </div>
          </div>
        </li>
        <li class="link_header" style="padding-top: 19px !important;">
          <div class="card-container">
            <div class="card">
              <div class="side">
                <img src="http://savvysystems.com.mx/img/pagina_inicio/DEMO%20Y%20VIDEOS%201.png" class="img_header">
              </div>
              <div class="side back">
                <img src="http://savvysystems.com.mx/img/pagina_inicio/DEMO%20Y%20VIDEOS%202.png" class="img_header">
              </div>
            </div>
          </div>
        </li>
        <li onClick="window.open('http://savvysystems.com.mx/acercadesavvy.php','_self');" class="active link_header" style="padding-top: 19px !important;">
          <div class="card-container">
            <div class="card">
              <div class="side">
                <img src="http://savvysystems.com.mx/img/pagina_inicio/NOSOTROS%201.png" class="img_header">
              </div>
              <div class="side back">
                <img src="http://savvysystems.com.mx/img/pagina_inicio/NOSOTROS%202.png" class="img_header">
              </div>
            </div>
          </div>
        </li>
        <li class="link_header">
          <button class="btn btn-primary" data-toggle="modal" data-target="#ingresar" style="margin-top: 8px;">Ingresar</button>         
        </li>
      </ul>
    </div>
  </div>
</div>

<!-- Modal de INGRESAR -->
<div class="modal fade" id="ingresar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
        <h4 class="modal-title" id="myModalLabel">INGRESA CON TU CUENTA</h4>
      </div>
      <div class="modal-body">
        <form>
          <input type="email" placeholder="Email" style="width:49%;" required/>
          <input type="password" placeholder="Contraseña" style="width:49%;" required/>
          <br>
          <div class="col-md-12" style="padding:0px;">
            <div class="col-md-9" style="padding:0px;">
              <input type="checkbox" value="true"> Recordar mi cuenta
              <br>
              <a href="#">Olvide mi contraseña</a>
            </div>
            <div class="col-md-3">
              <button type="submit" class="btn btn-primary" style="margin-top:5px;">Ingresar</button>
            </div>
          </div>
          <br>
          ¿No tienes cuenta? <a href="http://savvysystems.com.mx/">Regístrate aquí</a>
        </form>        
      </div>
    </div>
  </div>
</div>