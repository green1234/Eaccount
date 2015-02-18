<? 
require_once "server/conf/constantes.conf";

if (isset($_SESSION["login"]))
{
  $uid = $_SESSION["login"]["uid"];
  $pwd = $_SESSION["login"]["pwd"];
  
  // var_dump($uid);
  // var_dump($pwd);

  $path = SERVERNAME . "/Configuracion.php?uid=" . $uid . "&pwd=" . $pwd;
  $res = json_decode(file_get_contents($path), true);
  $usuario = $res["data"][0];
  // echo "<pre>";
  // var_dump($res["data"][0]["planes"]);
  // echo "</pre>";
  // exit();
   
  $planes = $usuario["planes"];
}
?>
<div role="tabpanel" class="tab-pane fade in active" id="cuentas" style="padding-top: 20px;">
    <div class="col-md-2">
      <b>Cuenta Principal:</b>
      <br>
      <!-- Button trigger modal -->
      <a href="#" data-toggle="modal" data-target="#profileModal">Editar perfil</a>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="profileModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <?
          $path = SERVERNAME . "/Configuracion.php?update=perfil";
          $path = $path . "&uid=" . $uid . "&pwd=" . $pwd;
          ?>
          <form id="ProfileForm" action="<? echo $path; ?>">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel">Editar Perfil</h4>
            </div>
            <div class="modal-body">
              <label for="username">Usuario:</label>
              <input type="text" name="username" placeholder="username">
              <br><br>
              <label for="email">Email:</label>
              <input type="text" name="email" placeholder="email">
              <br><br>
              <label for="phone">Teléfono:</label>
              <input type="text" name="phone" placeholder="phone">
              <br><br>
              <label for="mobile">Teléfono Móvil:</label>
              <input type="text" name="mobile" placeholder="mobile">
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
              <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <div class="col-md-10">
      <table class="table">
        <tr>
          <td>
            Usuario:
          </td>
          <td style="font-weight:bold;" id="idata_login">
            <? echo $usuario["login"]; ?>
          </td>
        </tr>

        <tr>
          <td>
            Correo Electrónico:
          </td>
          <td style="font-weight:bold;" id="idata_email">
            <? echo $usuario["partner_id"]["email"]; ?>
          </td>
        </tr>

        <tr>
          <td>
            Teléfono fijo:
          </td>
          <td style="font-weight:bold;" id="idata_phone">
            <? echo $usuario["partner_id"]["phone"]; ?>
          </td>
        </tr>

        <tr>
          <td>
            Teléfono móvil:
          </td>
          <td style="font-weight:bold;" id="idata_mobile">
            <? echo $usuario["partner_id"]["mobile"]; ?>
          </td>
        </tr>

      </table>
    </div>

    <div class="col-md-2">
      <b>Configuración de planes de tus aplicaciones de Savvy Systems:</b>
      <br>
      <a href="#">Editar Planes contratados</a>
    </div>
    <div class="col-md-10">
      <table class="table">

        <? if (count($planes) > 0){

          $tipo_planes = array(
            "micro" => "Micro Empresa",
            "empresa" => "Empresarial",
            "despacho" => "Despacho Contable",
            );

          foreach ($planes as $idx => $plan) { ?>
            
            <tr>
              <td>
                <b><? echo $plan["app_id"][1]; ?></b> 
                <? if ($plan["contratado"] === "Pendiente") { 

                ?>
                  - Por el momento no cuentas con este servicio, 
                  <a href="<? echo $plan['app_path']; ?>/info_planes.php">contrátalo aquí</a>.
                <? } ?>
              </td>
            </tr>
            <? if ($plan["contratado"] === true) { ?>
            <tr>
              <td>
                <table class="table">
                  <tr>
                    <td>
                      Plan contratado:
                    </td>
                    <td style="font-weight:bold;">
                      <?  
                        
                        // $plan_idx = $plan["tipo_plan"]; 
                        // echo $tipo_planes[$plan_idx];
                        echo $plan["plan_id"][1]; 
                      ?>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      Capacidad:
                    </td>
                    <td style="font-weight:bold;">
                      <?  echo $plan["capacity"]; ?>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      Vigente hasta:
                    </td>
                    <td style="font-weight:bold;">
                      <?  echo $plan["date"]; ?>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
            <? } ?>
        <? } 
        } ?>

      </table>
    </div>

    <div class="col-md-2">
      <b>Método de Pago:</b>
    </div>
    <div class="col-md-10">
      Cuenta de Cheques BANORTE con terminacion *1230. - <a href="#">Cambie método de pago</a> - <a href="#">Bloquear uso de cuenta bancaria</a>.
    </div>

    <div class="col-md-12">
      <hr>
    </div>

    <div class="col-md-2">
      <b>Cuentas Adicionales:</b>
    </div>
    <div class="col-md-10">
      Puedes crear cuentas adicionales para darle acceso a otras personas de tu empresa a una o varias aplicaciones, con las restricciones y accesos que tú configures para cada quien. 
      <a href="#">Crear nueva cuenta Adicional</a>.
    </div>

    <div class="col-md-12">
      <br>
    </div>

    <?//AQUI EMPIEZA EL FOR PARA MOSTRAR A LOS USUARIOS ?>

    <? foreach ($usuario["usuarios"] as $index => $value) { ?>
    <? //var_dump($value); exit(); ?>
    <div class="col-md-2">
      <b>Perfil y accesos de cuenta adicional 1:</b>
      <a href="#">Editar perfil y permisos</a>
      <a href="#">Eliminar esta cuenta</a>
    </div>

    <div class="col-md-10">
      <table class="table">
        <tr>
          <td>
            Usuario:
          </td>
          <td style="font-weight:bold;">
            <? echo $value["login"]; ?>
          </td>
        </tr>

        <tr>
          <td>
            Nombre de la persona a cargo:
          </td>
          <td style="font-weight:bold;">
            <? echo $value["partner_id"]["name"]; ?>
          </td>
        </tr>

        <tr>
          <td>
            Correo Electrónico:
          </td>
          <td style="font-weight:bold;">
            <? echo $value["partner_id"]["email"]; ?>
          </td>
        </tr>

        <tr>
          <td>
            Teléfono fijo:
          </td>
          <td style="font-weight:bold;">
            <? echo $value["partner_id"]["phone"]; ?>
          </td>
        </tr>

        <tr>
          <td>
            Teléfono móvil:
          </td>
          <td style="font-weight:bold;">
            <? echo $value["partner_id"]["mobile"]; ?>
          </td>
        </tr>

      </table>

      <table class="table">
    
      <?foreach ($value["planes"] as $idx => $val) { ?>        
        <tr>
          <td>
            <b><? echo $val["plan_id"][1]; ?></b> - Usuario tiene acceso a la Aplicación.
          </td>
        </tr>
        <tr>
          <td>
            <table class="table">
            <? #var_dump($val["perm_ids"]); exit();?>
            <? foreach ($val["perm_ids"] as $i => $v) {?>
                  <tr>
                    <td>
                      <input type="checkbox">
                    </td>
                    <td>
                      <? echo $v["name"]; ?>
                    </td>
                  </tr>
                   
            <? } ?>
            </table>
          </td>
        </tr>
    
      <? } ?>
      </table>
    </div>
    <?} ?>

      <!-- <div class="col-md-12" style="text-align:center;margin-bottom:15px;">
        <button class="btn btn-primary">Guardar Cambios</button>
        <button class="btn btn-primary">Salir sin Cambios</button>
      </div>   -->    
    <!-- </div> -->
    <div class="col-md-2">
      <b>Perfil y accesos de cuenta adicional 1:</b>
      <a href="#">Editar perfil y permisos</a>
      <a href="#">Eliminar esta cuenta</a>
    </div>
    <div class="col-md-10">
      <table class="table">
        <tr>
          <td>
            Usuario:
          </td>
          <td style="font-weight:bold;">
            NOMBREUSUARIO
          </td>
        </tr>

        <tr>
          <td>
            Nombre de la persona a cargo:
          </td>
          <td style="font-weight:bold;">
            Nombre ApellidoP ApellidoM
          </td>
        </tr>

        <tr>
          <td>
            Correo Electrónico:
          </td>
          <td style="font-weight:bold;">
            correo@electronico.com
          </td>
        </tr>

        <tr>
          <td>
            Teléfono fijo:
          </td>
          <td style="font-weight:bold;">
            1234567890
          </td>
        </tr>

        <tr>
          <td>
            Teléfono móvil:
          </td>
          <td style="font-weight:bold;">
            0987654321
          </td>
        </tr>

      </table>

      <table class="table">
        <tr>
          <td>
            <b>FACTURACIÓN</b> - Usuario tiene acceso a la Aplicación.
          </td>
        </tr>
        <tr>
          <td>
            <table class="table">
              <tr>
                <td>
                  <input type="checkbox">
                </td>
                <td>
                  Generar Factura
                </td>
              </tr>
              <tr>
                <td>
                  <input type="checkbox">
                </td>
                <td>
                  Timbrar Factura
                </td>
              </tr>
              <tr>
                <td>
                  <input type="checkbox">
                </td>
                <td>
                  Cambiar precios de productos
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>


      <table class="table">
        <tr>
          <td>
            <b>VALIDACIÓN Y RESGUARDO</b> - Usuario tiene acceso a la Aplicación.
          </td>
        </tr>
        <tr>
          <td>
            <table class="table">
              <tr>
                <td>
                  <input type="checkbox">
                </td>
                <td>
                  Subir Facturas
                </td>
              </tr>
              <tr>
                <td>
                  <input type="checkbox">
                </td>
                <td>
                  Capturar Pagos
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>

      <table class="table">
        <tr>
          <td>
            <b>CONTABILIDAD ELECTRÓNICA</b> - Usuario tiene acceso a la Aplicación.
          </td>
        </tr>
        <tr>
          <td>
            <table class="table">
              <tr>
                <td>
                  <input type="checkbox">
                </td>
                <td>
                  Crear empresas
                </td>
              </tr>
              <tr>
                <td>
                  <input type="checkbox">
                </td>
                <td>
                  Importar XML
                </td>
              </tr>
              <tr>
                <td>
                  <input type="checkbox">
                </td>
                <td>
                  Crear cuentas contables
                </td>
              </tr>
              <tr>
                <td>
                  <input type="checkbox">
                </td>
                <td>
                  Generar pólizas
                </td>
              </tr>
              <tr>
                <td>
                  <input type="checkbox">
                </td>
                <td>
                  Conciliar cuentas bancarias
                </td>
              </tr>
              <tr>
                <td>
                  <input type="checkbox">
                </td>
                <td>
                  Cerrar mes contable
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>

    </div> 

    <?//AQUI TERMINA EL FOR PARA MOSTRAR A LOS USUARIOS ?>

    <div class="col-md-12" style="text-align:center;margin-bottom:15px;">
      <button class="btn btn-primary">Guardar Cambios</button>
      <button class="btn btn-primary">Salir sin Cambios</button>
    </div>
</div>