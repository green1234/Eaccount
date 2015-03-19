<div role="tabpanel" class="tab-pane fade in active" id="clientes" style="padding-top: 20px;">
	<table class="table partners">
    <tr>
    	<th>
        <img src="http://savvysystems.com.mx/img/lapiz.png" whidth="25" height="25">
      </th>
      <th>
        <b>Núm:</b>
      </th>
      <th>
        <b>Razón Social del Cliente:</b>
      </th>
      <th>
        <b>Alias: <img src="img/interrogacion.png" whidth="15" height="15" class="popover-1" title="Nombre corto para identificarlo rápidamente"></b>
      </th>
      <th>
        <b>Días de Crédito: <img src="img/interrogacion.png" whidth="15" height="15" class="popover-1" title="Para visualizar reportes Cuentas por Cobrar"></b>
      </th>
      <th>
        <b>Cuenta Bancaria: <img src="img/interrogacion.png" whidth="15" height="15" class="popover-1" title="Cuenta de pago del Cliente"></b>
      </th>
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
<script> 

  var credit = '<select>';
      credit += '<option value="0">0</option>';
      credit += '<option value="7">7</option>';
      credit += '<option value="15">15</option>';
      credit += '<option value="30">30</option>';
      credit += '<option value="45">45</option>';
      credit += '<option value="60">60</option>';
      credit += '<option value="90">90</option>';
      credit += '<option value="120">120</option>';
      credit += '<option value="180">180</option>';
      credit += '<option value="Otro">Otro</option>';
      credit += '</select>';

  obtener_clientes = function()
  {
    $.getJSON("server/Master.php?cat=partners", function(res)
    {
      if (res.success)
      {
        var filas = "";
        $.each(res.data, function(idx, partner)
        {
          filas += "<tr>";
          filas += "<td><input type='checkbox'></td>";
          filas += "<td>" + partner.id + "</td>";
          filas += "<td>" + partner.name + "</td>";
          filas += "<td>" + partner.ref + "</td>";
          filas += "<td>" + credit + "</td>";
          filas += "<td>";
          if (partner.bank_ids.length > 0)
          {
            $.each(partner.bank_ids, function(i, v){
              var cta =  partner.bank_ids[i].acc_number

              if (cta.length > 4)
                cta = cta.substr(cta.length - 4)

              var banco_id = partner.bank_ids[i].bank[0];
              var banco = partner.bank_ids[i].bank[1].split("-")[1] + " *" + cta;

              filas += "<b>" + banco + "</b><br>";
            });
          }          
          filas += "<a partner='" + partner.id + "' href='#' data-toggle='modal' data-target='#CtaBanModal' class='openModal ctaban'>Agregar Nueva</a><br>";
          filas += "</td>"
          filas += "</tr>";
        });
        $(".partners").append(filas);
      } 
    });
  }

  $(function()
  {
    obtener_clientes();
  })
</script>