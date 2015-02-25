<div role="tabpanel" class="tab-pane fade in active" id="clientes" style="padding-top: 20px;">
    		<table class="table">
              <tr>
              	<td>
                  <img src="http://savvysystems.com.mx/img/lapiz.png" whidth="25" height="25">
                </td>
                <td>
                  <b>Núm:</b>
                </td>
                <td>
                  <b>Razón Social del Cliente:</b>
                </td>
                <td>
                  <b>Alias: <img src="http://savvysystems.com.mx/img/interrogacion.png" whidth="15" height="15" class="popover-1" title="Nombre corto para identificarlo rápidamente"></b>
                </td>
                <td>
                  <b>Días de Crédito: <img src="http://savvysystems.com.mx/img/interrogacion.png" whidth="15" height="15" class="popover-1" title="Para visualizar reportes Cuentas por Cobrar"></b>
                </td>
                <td>
                  <b>Cuenta Bancaria: <img src="http://savvysystems.com.mx/img/interrogacion.png" whidth="15" height="15" class="popover-1" title="Cuenta de pago del Cliente"></b>
                </td>
              </tr>
              <?//INICIA FOR DE LOS DATOS?>

              <tr>
              	<td>
                  <input type="radio">
                </td>
                <td>
                  102
                </td>
                <td>
                  Martha Angela Martinez Flores
                </td>
                <td>
                  PMAMF
                </td>
                <td>
                  <select>
                    <option value="0">0</option>
                    <option value="7">7</option>
                    <option value="15">15</option>
                    <option value="30">30</option>
                    <option value="45">45</option>
                    <option value="60">60</option>
                    <option value="90">90</option>
                    <option value="120">120</option>
                    <option value="180">180</option>
                    <option value="Otro">Otro</option>
                  </select>
                </td>
                <td>
                  BMX *5494
                </td>
              </tr>

              <?//TERMINA FOR DE LOS DATOS?>
            </table>
            <div class="col-md-12" style="text-align:right;">
              <a href="#">Agregar otro Cliente manualmente</a>
              <br>
              <a href="#">Importar lista de Clientes (Archivo .csv ó .xls)</a>
			<br>
              <a href="#">Exportar lista de clientes a Excel</a>
            </div>
            <div class="col-md-12" style="text-align:center;">
              <br>
            </div>
            <div class="col-md-12" style="text-align:center;margin-bottom:15px;">
              <button class="btn btn-primary">Guardar Cambios</button>
              <button class="btn btn-primary">Salir sin Cambios</button>
            </div>
    	</div>