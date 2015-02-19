<? require_once "server/conf/constantes.conf"; ?>
<? $res = json_decode(file_get_contents(SERVERNAME . '/Configuracion.php'), true); ?>
<? #var_dump($res["data"][0]["empresa"]); exit(); ?>
<? $empresa = $res["data"][0]["empresa"]; ?>

<div role="tabpanel" class="tab-pane fade" id="empresas" style="padding-top: 20px;">
  <div class="col-md-2">
    <b>Nombre de mi Empresa:</b>
  </div>
  <div class="col-md-10">
    Nombre comercial: <b id="idata_empresa_name">LOL<? echo $empresa["name"];?></b> - 
    <a href="#" data-toggle="modal" data-target="#empresaModal">Cambiar</a>
    
    <!-- Modal -->
    <div class="modal fade" id="empresaModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <?
          $path = SERVERNAME . "/Configuracion.php?update=empresa";
          $path = $path . "&uid=" . $uid . "&pwd=" . $pwd;
          ?>
          <form id="EmpresaForm" class="form-modal" action="<? echo $path; ?>">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel">Nombre de mi empresa</h4>
            </div>
            <div class="modal-body">
              <label for="empresa_name">Ingrese un alias o el nombre comercial de su empresa:</label>
              <input type="text" name="empresa_name" placeholder="Nombre Empresa">
              <br><br>              
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
              <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <br>
    <table class="table">
      <tr>
        <td>
          <input type="radio" name="empresa" value="comercial">
        </td>
        <td>
          Utilizar nombre comercial para referirse a esta cuenta.
        </td>
      </tr>
      <tr>
        <td>
          <input type="radio" name="empresa" value="rfc">
        </td>
        <td>
          Utilizar RFC de mi empresa para referirse a esta cuenta.
        </td>
      </tr>
    </table>
  </div>

  <div class="col-md-12">
    <br>
  </div>

  <div class="col-md-2">
    <b>Logotipo:</b>
  </div>
  <div class="col-md-10">
    Puedes personalizar el perfil de tu cuenta con el logotipo de tu empresa. La imagen no debe excederse 500 x 500 pixeles.
    <input type="file">
  </div>

  <div class="col-md-12">
    <br>
  </div>

  <div class="col-md-12">
    <hr>
  </div>

  <div class="col-md-2">
    <b>Datos Fiscales:</b>
    <br>
    <a href="#">Actualizar datos</a>
  </div>
  <div class="col-md-10">
    <table class="table">
      <tr>
        <td style="width: 50%;">
          Razón Social:
        </td>
        <td style="font-weight:bold;text-align:left;width: 50%;">
          <? echo $empresa["gl_razon_social"];?>
        </td>
      </tr>
    </table>
    <table class="table">
      <tr>
        <td style="width: 50%;">
          RFC:
        </td>
        <td style="font-weight:bold;text-align:left;width: 50%;">
          <? echo $empresa["gl_rfc"];?>
        </td>
      </tr>
    </table>
    <table class="table">
      <tr>
        <td style="width: 50%;">
          Régimen Social:
        </td>
        <td style="font-weight:bold;text-align:left;width: 50%;">
          <? echo $empresa["gl_regimen"];?>
        </td>
      </tr>
    </table>
    <table class="table">
      <tr>
        <td style="width: 50%;">
          Actividad Principal / Giro
        </td>
        <td style="font-weight:bold;text-align:left;width: 50%;">
          <? echo $empresa["gl_giro"];?>
        </td>
      </tr>
    </table>
    <table class="table">
      <tr>
        <td style="width: 50%;">
          Domicilio Fiscal:
        </td>
        <td style="font-weight:bold;text-align:left;width: 50%;">
          AQUI VA LA DIRECCION
        </td>
      </tr>
    </table>              
  </div>

  <div class="col-md-12">
    <br>
  </div>

  <div class="col-md-2">
    <b>Representante Legal:</b>
    <br>
    <a href="#">Actualizar datos</a>
  </div>
  <div class="col-md-10">
    <table class="table">
      <tr>
        <td style="width: 50%;">
          Nombre:
        </td>
        <td style="font-weight:bold;text-align:left;width: 50%;">
          <? echo $empresa["gl_rlegal_name"];?>
        </td>
      </tr>
    </table>
    <table class="table">
      <tr>
        <td style="width: 50%;">
          RFC:
        </td>
        <td style="font-weight:bold;text-align:left;width: 50%;">
          <? echo $empresa["gl_rlegal_rfc"];?>
        </td>
      </tr>
    </table>
    <table class="table">
      <tr>
        <td style="width: 50%;">
          CURP:
        </td>
        <td style="font-weight:bold;text-align:left;width: 50%;">
          <? echo $empresa["gl_rlegal_curp"];?>
        </td>
      </tr>
    </table>
  </div>

  <div class="col-md-12">
    <br>
  </div>

  <div class="col-md-2">
    <b>Registros Oficiales:</b>
    <br>
    <a href="#">Actualizar datos</a>
  </div>
  <div class="col-md-10">
    <table class="table">
      <tr>
        <td style="width: 50%;">
          Registro Patronal:
        </td>
        <td style="font-weight:bold;text-align:left;width: 50%;">
          <? echo $empresa["gl_rpatronal"];?>
        </td>
      </tr>
    </table>
    <table class="table">
      <tr>
        <td style="width: 50%;">
          Registro Estatal:
        </td>
        <td style="font-weight:bold;text-align:left;width: 50%;">
          <? echo $empresa["gl_restatal"];?>
        </td>
      </tr>
    </table>
  </div>

  <div class="col-md-12">
    <br>
  </div>

  <div class="col-md-2">
    <b>Datos Adicionales para archivar en mi cuenta:</b>
    <br>
    <a href="#">Actualizar datos</a>
  </div>
  <div class="col-md-10">
    <table class="table">
      <tr>
        <td style="width: 50%;">
          CURP:
        </td>
        <td style="font-weight:bold;text-align:left;width: 50%;">
          <? echo $empresa["gl_curp"];?>
        </td>
      </tr>
    </table>
    <table class="table">
      <tr>
        <td style="width: 50%;">
          IMSS:
        </td>
        <td style="font-weight:bold;text-align:left;width: 50%;">
          <? echo $empresa["gl_imss"];?>
        </td>
      </tr>
    </table>
    <table class="table">
      <tr>
        <td style="width: 50%;">
          Acta Constitutiva:
        </td>
        <td style="font-weight:bold;text-align:left;width: 50%;">
          <a href="#">Descargar Archivo</a>
        </td>
      </tr>
    </table>
  </div>

  <div class="col-md-12">
    <br>
  </div>

  <div class="col-md-2">
    <b>Firma Electrónica:</b>
    <br>
    <a href="#">Actualizar datos</a>
    <br><br>
    <a onClick="muestraporque();" style="cursor:pointer;">
      <i>*¿Por qué proporcionar estos datos?</i>
    </a>
  </div>
  <div class="col-md-10">
    Certificado Digital (*.cer): <input type="file">
    <br>
    Archivo Llave (*.key): <input type="file">
    <br>
    Clave Privada FIEL: <input type="file">
    <br>
    <div id="porque" style="display:none;">
      <b><i>*Por confidencialidad, para asegurar que unicamente tú eres propietario de y tendrás acceso a los CFDI´s en esta cuenta.</i></b>
    </div>
  </div>

  <div class="col-md-12">
    <br>
  </div>

  <div class="col-md-12">
    <hr>
  </div>

  <div class="col-md-2">
    <b>Cuenta de Pago:</b>
    <br>
    <a href="#">Agregar o Editar cuentas</a>
  </div>
  <div class="col-md-10">
    Cuenta de Cheques BANORTE *1230.
  </div>

  <div class="col-md-12">
    <br>
  </div>

  <div class="col-md-12" style="text-align:center;margin-bottom:15px;">
    <button class="btn btn-primary">Guardar Cambios</button>
    <button class="btn btn-primary">Cancelar</button>
  </div>
</div>