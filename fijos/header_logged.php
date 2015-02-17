<? $a = session_id(); if (empty($a)) session_start(); ?>
<div class="navbar" role="navigation" style="z-index: 3;">
  <div class="container" style="z-index: -2;">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse" style="background:gray;">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" onclick="getRecientes();">
        <img width="130px" height="80px" src="img/logo_header_blanco.png" class="saavyLogo" style="max-width:85%">
      </a>
    </div>
    <div class="navbar-collapse collapse">
      <div class="header_azul">
        <div style="float:left;margin-right: 85px;">
          <div style="color:white;padding: 23px 0px 0px 20px;font-size: 20px;">
            BIENVENIDO
          </div>
          <pre style="display:none;">
            <?
            print_r($_SESSION);
            ?>
          </pre>
        </div>
        
      <ul class="nav navbar-nav">
        <li class="link_header" style="margin-top: 15px;padding: 10px 10px !important;">
          Buscar por concepto:
          <input id="txtSearchConceptos" type="search" style="color:black"/>
        </li>

        <li class="link_header" style="margin-top: 15px;padding: 10px 10px !important;">
          <span class="subMenu1">
            <a href="?section=config">
              <img style="cursor: pointer;" id="btnConfiguration" src="img/pagina_inbox/InboxHeader_Config.png"/>
            </a>
          </span>
        </li>

        <li class="link_header" style="margin-top: 15px;padding: 10px 10px !important;">
          <span class="subMenu2">
            <img style="cursor: pointer;" id="btnNotificaciones" src="img/pagina_inbox/InboxHeader_Notifications.png"/>
              <div id="boxNotificaciones" class="boxNotificaciones">
                  <img id="btnClose" style="cursor: pointer;" src="img/pagina_inbox/EstatusFactura-Error.png"/>
                  <table id="displayNotificaciones" style="width: 100%; border-collapse: collapse;">
                      <tr style="display:block; border-bottom: 1px solid red; padding: 5px">
                          <td>
                              <label style="font-family:BRITANIC; padding: 20px; color: gray;">
                                  NOTIFICACIONES
                              </label>
                          </td>
                      </tr>
                  </table>
              </div>
          </span>
        </li>

        <li class="link_header" style="margin-top: 15px;padding: 10px 10px !important;">
          <span class="subMenu3">
              <a href="contactaadministrador.php">
                  <img src="img/pagina_inbox/InboxHeader_Historial.png"/>
              </a>
          </span>
        </li>

        <li class="link_header" style="margin-top: 15px;padding: 10px 10px !important;">
          <span class="subMenu3">
            <img style="cursor: pointer;" id="btnConfiguration" src="img/pagina_inbox/InboxHeader_distribuidor.png"/>
          </span>
        </li>

        <li class="link_header" style="margin-top: 15px;padding: 10px 10px !important;">
          <span class="subMenu4">
            <img id="btnAccounts" src="img/pagina_inbox/InboxHeader_User Pic.png" style="width: 55%;margin-top: -12px;cursor:pointer;"/>
          </span>
          <div id="boxAccounts" class="boxAccounts">
              <img id="btnClose" style="position: absolute; right: 0px; top: 5px; cursor: pointer; width: 10px; height: 10px;" src="img/pagina_inbox/EstatusFactura-Error.png"/>
              <table id="displayAccounts" style="width: 100%; border-collapse: collapse;">
                  <tr style="display:block; border-bottom: 1px solid red; padding: 5px">
                      <td>
                          <label style="font-family:BRITANIC; padding: 20px; color: gray; font-size: 14px;">
                              MIS CUENTAS
                          </label>
                      </td>
                  </tr>
                  <tr>
                      <td id="accountsArea">
                      </td>
                  </tr>
                  <tr style="display:block; border-top: 1px solid gray; padding: 5px">
                      <td>
                          <label style="font-family:BRITANIC; padding: 20px; color: gray;">
                              <a href="#" onclick="agregarNuevaCuenta();">Agregar una Cuenta</a>
                          </label>
                      </td>
                      <td>
                      </td>
                      <td>
                          <label style="font-family:CORBEL;">
                              <a id="btnLogout" href="#">Salir</a>
                          </label>
                      </td>
                      </td>
                  </tr>
              </table>
          </div>
        </li>
      </ul>
      </div>
    </div>
  </div>
  <div style="margin-top: -20px;margin-left: 400px;color: white;position: absolute;font-size: 11px;">
    <? if (isset($_SESSION["login"])) echo $_SESSION["login"]["username"]; else echo "SAVVY"; ?> <span class="glyphicon glyphicon-play" id="icon_estatus_open"></span>
  </div>
  <div id="bg_azul" style="background: #12334F;height: 73px;top: 0px;width: 500px;float: right;position: absolute;right: -1px;z-index: -1;"></div>
</div>