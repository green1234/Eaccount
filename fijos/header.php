<? require_once "server/conf/constantes.conf"; ?>
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
        <img src="img/logo_header.png" style="max-width: 120px;">
      </a>
    </div>
    <div class="navbar-collapse collapse" style="float:right">
      <ul class="nav navbar-nav">
        <li class="link_header" style="padding-top: 19px !important;">
          <div class="card-container">
            <div class="card">
              <div class="side">
                <a href="info.php">
                  <img src="img/home_info_desc.png" class="img_header">
                </a>
              </div>
              <div class="side back">
                <img src="img/home_info.png" class="img_header">
                <!-- <img src="http://savvysystems.com.mx/img/pagina_inicio/INFO%202.png" class="img_header"> -->
              </div>
            </div>
          </div>
        </li>
        <li class="link_header" style="padding-top: 19px !important;">
          <div class="card-container">
            <div class="card">
              <div class="side">
                <!-- <img src="http://savvysystems.com.mx/img/pagina_inicio/PLANES%20PRECIOS%201.png" class="img_header"> -->
                <a href="info_planes.php">
                  <img src="img/home_planes_desc.png" class="img_header">
                </a>
              </div>
              <div class="side back">
                <img src="img/home_planes.png" class="img_header">                
                <!-- <img src="http://savvysystems.com.mx/img/pagina_inicio/PLANES Y PRECIOS 2.png" class="img_header"> -->
              </div>
            </div>
          </div>
        </li>
        <li class="link_header" style="padding-top: 19px !important;">
          <div class="card-container">
            <div class="card">
              <div class="side">
                <img src="img/home_videos_desc.png" class="img_header">
                <!-- <img src="http://savvysystems.com.mx/img/pagina_inicio/DEMO%20Y%20VIDEOS%201.png" class="img_header"> -->
              </div>
              <div class="side back">
                <img src="img/home_videos.png" class="img_header">
                <!-- <img src="http://savvysystems.com.mx/img/pagina_inicio/DEMO%20Y%20VIDEOS%202.png" class="img_header"> -->
              </div>
            </div>
          </div>
        </li>
        <li class="active link_header" style="padding-top: 19px !important;">
          <div class="card-container">
            <div class="card">
              <div class="side">
                <a href="info_nosotros">
                  <img src="img/home_nosotros_desc.png" class="img_header">
                </a>
                <!-- <img src="http://savvysystems.com.mx/img/pagina_inicio/NOSOTROS%201.png" class="img_header"> -->
              </div>
              <div class="side back">
                <img src="img/home_nosotros.png" class="img_header">
                <!-- <img src="http://savvysystems.com.mx/img/pagina_inicio/NOSOTROS%202.png" class="img_header"> -->
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
        <form id="form_login" action="<? echo SERVERNAME.'/Login.php?'; ?>">
          <input id="username" name="username" type="text" placeholder="Username" style="width:49%;" required/>
          <input id="password" name="password" type="password" placeholder="Contraseña" style="width:49%;" required/>
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
          ¿No tienes cuenta? <a href="registro.php">Regístrate aquí</a>
        </form>        
      </div>
    </div>
  </div>
</div>