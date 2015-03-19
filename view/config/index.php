<!-- Nav tabs -->
<ul class="nav nav-tabs" role="tablist" style="margin-bottom: -2px;">
  <li role="presentation" class="active">
    <a href="#cuentas" aria-controls="cuentas" role="tab" data-toggle="tab">MIS CUENTAS</a></li>
  <li role="presentation">
    <a href="#empresas" aria-controls="empresas"role="tab" data-toggle="tab">MI EMPRESA</a></li>
  <li role="presentation">
    <a href="#catalogos" aria-controls="catalogos" role="tab" data-toggle="tab">CATÁLOGOS</a></li>
</ul>

<!-- Tab panes -->
<div class="tab-content container" style="width: auto;background: #e6e6e6;font-family: Arial;font-size: 11px;">

  <!--INICIA TAB "MIS CUENTAS"-->
  <? require 'mis_cuentas.php'; ?>
  <!--FIN TAB "MIS CUENTAS"-->

  <!--INICIA TAB "MI EMPRESA"-->
  <? require 'mi_empresa.php'; ?>
  <!--FIN TAB "MI EMPRESA"-->

  <!--INICIA TAB "CATALOGOS"-->
  <? require 'mis_catalogos.php'; ?>
  <!--FIN TAB "CATALOGOS"-->
</div>

<script>
  var partners = {};
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

  mostrar_partners = function(tipo)
  {
    $.each(partners, function(idx, partner)
    {
      var filas = "";
      if (partner[tipo]===true)
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
      }
      console.log(".partners."+tipo)
      $(".partners."+tipo).append(filas); 
    });
  }

  obtener_partners = function()
  {
    $.getJSON("server/Master.php?cat=partners", function(res)
    {
      if (res.success)
      {        
        partners = res.data;
        mostrar_partners("customer");
        mostrar_partners("supplier");
      } 
    });
  }
  
  obtener_partners();
  
</script>