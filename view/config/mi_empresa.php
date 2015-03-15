<? require_once "server/conf/constantes.conf"; 

if (isset($_SESSION["login"]))
{
  $uid = $_SESSION["login"]["uid"];
  $pwd = $_SESSION["login"]["pwd"];
  $cid = $_SESSION["login"]["cid"];
  #var_dump($_SESSION["login"]);
}
$path = SERVERNAME . '/Configuracion.php?';
$path = $path . "uid=" . $uid . "&pwd=" . $pwd . "&cid=" . $cid[0];
$res = json_decode(file_get_contents($path), true);
$empresa = $res["data"];
// var_dump($empresa);
?>
<style>
   .input
  {
    display: inline-block;  
    font-size: 1.2em;  
    margin: 0.6em 1.5em;
    width: 40%;
  }

  .input label
  {
    display: block;
  }

  .input select, .input input
  {
    height: 30px;
    width: 100%;
  }
</style>
<div role="tabpanel" class="tab-pane fade" id="empresas" style="padding-top: 20px;">
  <div class="col-md-2">
    <b>Nombre de mi Empresa:</b>
  </div>
  <div class="col-md-10">
    Nombre comercial: <b id="idata_empresa_name"><? echo $empresa["name"];?></b> - 
    <a href="#" data-toggle="modal" data-target="#empresaModal" class="openModal profile">Cambiar</a>
    
    <!-- Modal -->
    <div class="modal fade" id="empresaModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <?
          $path = SERVERNAME . "/Configuracion.php?update=empresa";
          $path = $path . "&uid=" . $uid . "&pwd=" . $pwd . "&cid=" . $empresa["id"];
          ?>
          <form id="EmpresaForm" class="form-modal" action="<? echo $path; ?>">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel">Configuración de mi Empresa</h4>
            </div>
            <div class="modal-body">
              <div class="hid_input profile">
                <label for="empresa_name">Ingrese un alias o el nombre comercial de su empresa:</label>
                <input type="text" name="empresa_name" placeholder="Nombre Empresa">
                <br><br>
              </div>
              <div class="hid_input fiscales">
                <label for="razon_social">Ingrese su Razon Social:</label>
                <input type="text" name="razon_social" placeholder="Razon Social">
                <br><br>
                <label for="rfc">RFC:</label>
                <input type="text" name="rfc" placeholder="RFC">
                <br><br>
                <label for="regimen">Regimen:</label>
                <input type="text" name="regimen" placeholder="Regimen">
                <br><br>
                <label for="giro">Giro:</label>
                <input type="text" name="giro" placeholder="Giro">
                <br><br>
                <label for="domicilio">Domicilio:</label>
                <input type="text" name="domicilio" placeholder="Domicilio">
                <br><br>
              </div>

              <div class="hid_input representante">
                <label for="rep_nombre">Nombre:</label>
                <input type="text" name="rep_nombre" placeholder="Nombre del Representante">
                <br><br>
                <label for="rep_rfc">RFC:</label>
                <input type="text" name="rep_rfc" placeholder="RFC del representante">
                <br><br>
                <label for="rep_curp">CURP:</label>
                <input type="text" name="rep_curp" placeholder="CURP del Reprersentante">
                <br><br>                
              </div>

              <div class="hid_input registros">
                <label for="patronal">Registro Patronal:</label>
                <input type="text" name="patronal" placeholder="Registro Patronal">
                <br><br>
                <label for="estatal">Registro Estatal:</label>
                <input type="text" name="estatal" placeholder="Registro Estatal">
                <br><br>
              </div>

              <div class="hid_input adicionales">
                <label for="ad_curp">CURP:</label>
                <input type="text" name="ad_curp" placeholder="CURP">
                <br><br>
                <label for="ad_imss">IMSS:</label>
                <input type="text" name="ad_imss" placeholder="IMSS">
                <br><br>
              </div>             

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
    <a href="#" data-toggle="modal" data-target="#empresaModal" class="openModal fiscales">Actualizar datos</a>
  </div>
  <div class="col-md-10">
    <table class="table">
      <tr>
        <td style="width: 50%;">
          Razón Social:
        </td>
        <td style="font-weight:bold;text-align:left;width: 50%;" id="idata_razon_social">
          <? echo $empresa["gl_razon_social"];?>
        </td>
      </tr>
    </table>
    <table class="table">
      <tr>
        <td style="width: 50%;">
          RFC:
        </td>
        <td style="font-weight:bold;text-align:left;width: 50%;" id="idata_rfc">
          <? echo $empresa["gl_rfc"];?>
        </td>
      </tr>
    </table>
    <table class="table">
      <tr>
        <td style="width: 50%;">
          Régimen Social:
        </td>
        <td style="font-weight:bold;text-align:left;width: 50%;" id="idata_regimen">
          <? echo $empresa["gl_regimen"];?>
        </td>
      </tr>
    </table>
    <table class="table">
      <tr>
        <td style="width: 50%;">
          Actividad Principal / Giro
        </td>
        <td style="font-weight:bold;text-align:left;width: 50%;" id="idata_giro">
          <? echo $empresa["gl_giro"];?>
        </td>
      </tr>
    </table>
    <table class="table">
      <tr>
        <td style="width: 50%;">
          Domicilio Fiscal:
        </td>
        <td style="font-weight:bold;text-align:left;width: 50%;" id="idata_domicilio">
          <? echo $empresa["street"];?>
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
    <a href="#" class="openModal representante" data-toggle="modal" data-target="#empresaModal">Actualizar datos</a>
  </div>
  <div class="col-md-10">
    <table class="table">
      <tr>
        <td style="width: 50%;">
          Nombre:
        </td>
        <td style="font-weight:bold;text-align:left;width: 50%;" id="idata_rep_nombre">
          <? echo $empresa["gl_rlegal_name"];?>
        </td>
      </tr>
    </table>
    <table class="table">
      <tr>
        <td style="width: 50%;">
          RFC:
        </td>
        <td style="font-weight:bold;text-align:left;width: 50%;" id="idata_rep_rfc">
          <? echo $empresa["gl_rlegal_rfc"];?>
        </td>
      </tr>
    </table>
    <table class="table">
      <tr>
        <td style="width: 50%;">
          CURP:
        </td>
        <td style="font-weight:bold;text-align:left;width: 50%;" id="idata_rep_curp">
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
    <a href="#" class="openModal registros" data-toggle="modal" data-target="#empresaModal">Actualizar datos</a>
  </div>
  <div class="col-md-10">
    <table class="table">
      <tr>
        <td style="width: 50%;">
          Registro Patronal:
        </td>
        <td style="font-weight:bold;text-align:left;width: 50%;" id="idata_patronal">
          <? echo $empresa["gl_rpatronal"];?>
        </td>
      </tr>
    </table>
    <table class="table">
      <tr>
        <td style="width: 50%;">
          Registro Estatal:
        </td>
        <td style="font-weight:bold;text-align:left;width: 50%;" id="idata_estatal">
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
    <a href="#" class="openModal adicionales" data-toggle="modal" data-target="#empresaModal">Actualizar datos</a>
  </div>
  <div class="col-md-10">
    <table class="table">
      <tr>
        <td style="width: 50%;">
          CURP:
        </td>
        <td style="font-weight:bold;text-align:left;width: 50%;" id="idata_ad_curp">
          <? echo $empresa["gl_curp"];?>
        </td>
      </tr>
    </table>
    <table class="table">
      <tr>
        <td style="width: 50%;">
          IMSS:
        </td>
        <td style="font-weight:bold;text-align:left;width: 50%;" id="idata_ad_imss">
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
    <a href="#" data-toggle="modal" data-target="#CtaBanModal" class="openModal ctaban">Agregar o Editar cuentas</a>
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

<!-- Modal -->
<div class="modal fade" id="CtaBanModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Nueva cuenta bancaria</h4>
      </div>
      <form id="CtaBanForm" action="server/">
        <div class="modal-body">          
            <div class="input def">
              <label for="cta_nac">Nacionalidad del banco:</label>              
              <select name="cta_nac" id="cta_nac">
                <option class="default" value="" selected disabled='disabled'>Selecciona una opcion</option>
                <option value="1">Mexicana</option>
                <option value="2">Extranjera</option>
              </select>
              <span style="display:none;">** Requerido **</span>
            </div>
            <div class="input def">
              <label for="cta_pais">País de origen del banco:</label>              
              <select name="cta_pais" id="cta_pais">
                <option class="default" value="" selected>Selecciona una opcion</option>                
              </select>
              <span style="display:none;">** Requerido **</span>
            </div>
            <div class="input def">
              <label for="cta_banco">Nombre del banco:</label>              
              <select name="cta_banco" id="cta_banco">
                <option class="default" value="" selected>Selecciona una opcion</option>                
              </select>
              <span style="display:none;">** Requerido **</span>
            </div>
            <div class="input def">
              <label for="cta_moneda">Moneda:</label>              
              <select name="cta_moneda" id="cta_moneda">
                <option class="default" value="" selected>Selecciona una opcion</option>                
              </select>
              <span style="display:none;">** Requerido **</span>
            </div>
            <div class="input def">
              <label for="cta_tipo">Tipo de Cuenta:</label>              
              <select name="cta_tipo" id="cta_tipo">
                <option class="default" value="" selected disabled>Selecciona una opcion</option>
                <option value="1">Cuenta de Cheques</option>                
                <option value="2">Tarjeta de débito</option>
                <option value="3">Tarjeta de crédito</option>
              </select>
              <span style="display:none;">** Requerido **</span>
            </div>
            <div class="input def">
              <label style="color:purple;">&nbsp;</label>
            </div>
            <div class="input def">
              <label for="cta_numero">Numero de cuenta:</label>              
              <input type="text" name="cta_numero" id="cta_numero" required>   
              <!-- <span style="display:none;">** Requerido **</span>   -->           
            </div>
            <div class="input def">
              <label for="cta_clabe">CLABE:</label>              
              <input type="text" name="cta_clabe" id="cta_clabe" required>   
              <!-- <span style="display:none;">** Requerido **</span>     -->         
            </div>        
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Regresar</button>
          <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        </div>
      </form>
    </div>
  </div>
</div>
<script>
  
  var uid = <?=$uid?>;
  var pwd = "<?=$pwd?>";
  var cid = <?=$cid[0]?>;

  var cuentas = {};
  var bancos = {};
  var monedas = {};
  var paises = {};

  var optPaises = "";

  obtener_bancos = function()
  {
    var path = "server/Master.php?cat=bancos";
    
    $.getJSON(path, function(res){

      if (res.success)
      {
        //console.log(res)
        bancos = res.data;
        //return res.data;
      }
    });
  }  

  obtener_cuentas = function()
  {
    var path = "server/Master.php?cat=cuentas";
    
    $.getJSON(path, function(res){
      
      if (res.success)
      {    
        //console.log(res.data);    
        cuentas = res.data;
      }
    });
  }

  obtener_monedas = function()
  {
    var path = "server/Master.php?cat=monedas";
    
    $.getJSON(path, function(res){
      
      if (res.success)
      {    
        //console.log(res.data);    
        monedas = res.data;
      }
    });
  }

  obtener_paises = function()
  {
    var path = "server/Master.php?cat=paises";
    
    $.getJSON(path, function(res){
      
      if (res.success)
      {    
        //console.log(res.data);    
        paises = res.data;
      }
    });
  }

  $(function(){

    obtener_cuentas();
    obtener_bancos();
    obtener_monedas();
    obtener_paises();

    $('#CtaBanModal').on('show.bs.modal', function (e) {
      
      $("option.default").attr("selected", true);
      // $("option.default").removeAttr("disabled");

      var optMonedas = "<option class='default' selected disabled='disabled'>Seleccione una opción</option>";
      $.each(monedas, function(i, v){
        optMonedas += "<option value='" + v.id + "'>" + v.name + " - " + v.description + "</option>" ;
      });
      $("#cta_moneda").html(optMonedas);

      var optBancos = "<option class='default' selected disabled='disabled'>Seleccione una opción</option>";
      $.each(bancos, function(i, v){
        optBancos += "<option value='" + v.id + "'>" + v.name + "</option>" ;
      });
      $("#cta_banco").html(optBancos);

      optPaises = "<option class='default' selected disabled='disabled'>Seleccione una opción</option>";
      $.each(paises, function(i, v){
        optPaises += "<option value='" + v.id + "'>" + v.code + " - " + v.name + "</option>" ;
      });
      $("#cta_pais").html(optPaises);

    });

    $("#cta_nac").on("change", function()
    {      
      var value = $(this).find("option:selected").val();
      console.log(value)
      if (value == 1)
      {
        $("#cta_pais").html("<option selected value='157'>MX - México</option>");
      }
      else
      {
        $("#cta_pais").html(optPaises); 
      }

    });

    // $("#CtaBanForm").find("select").on("change", function()
    // {
    //   $(this).find("option.default").attr("disabled", true);
    // });

    $("#CtaBanForm").on("submit", function(e){
      e.preventDefault();
      
      var selects = $(this).find("select");
      emptySelect = false;
      $.each(selects, function(i,v)
      {
        if($(v).val() == null)
        {
          $(v).css("border", "1px solid red").focus().next("span").show();
          //return false;
          emptySelect = true;
        }
        else
        {
          $(v).css("border", "1px solid").next("span").hide();
          console.log($(v).val());
        }
      });


      if (!emptySelect)
      {
        var data = $(this).serialize();
        console.log(data)
        $.getJSON("server/Configuracion.php?add=ctaban&", data, function(res)
        {
          console.log(res)

          if (res.success)
          {
            alert("La cuenta se registro correctamente");
            
          }
          else
          {
            alert("No se pudo registrar la cuenta");
          }
          $('#CtaBanModal').modal("hide");

        });
      }
      
    });

  });

</script>