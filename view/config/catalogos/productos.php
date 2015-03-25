<div role="tabpanel" class="tab-pane fade in" id="productos" style="padding-top: 20px;">
	<table class="table productos">
    <tr>
    	<th>
        <img src="http://savvysystems.com.mx/img/lapiz.png" whidth="25" height="25">
      </th>
      <th>
        <b>Núm:</b>
      </th>
      <th>
        <b>Nombre:</b>
      </th>
      <th>
        <b>Precio:</b>
      </th>
      
    </tr>    

    <?//TERMINA FOR DE LOS DATOS?>
  </table>
            
</div>
<script>
  
  var productos = {};

  obtener_productos = function()
  {
    $.getJSON("server/Master.php?cat=productos", function(res)
    {
      console.log(res)
      if (res.success)
      {
        productos = res.data;
        mostrar_productos();
      }
    })  
  }

  mostrar_productos = function()
  {
    var tabla1 = tabla2 = "";
    $.each(productos, function(i, prod)
    {
      var tabla = "";
      tabla += "<tr>";
      tabla += "<td><input type='checkbox'></td>";
      tabla += "<td>" + prod.id + "</td>";
      tabla += "<td>" + prod.name + "</td>";
      tabla += "<td>" + prod.tpl.list_price + "</td>";
      tabla += "</tr>";
      console.log(prod.tpl.sale_ok)
      console.log(prod.tpl.purchase_ok)

      if (prod.tpl.sale_ok === true)
        tabla1 += tabla;
      if (prod.tpl.purchase_ok === true)
        tabla2 += tabla;      
    });
    $("table.productos").append(tabla1);
    $("table.insumos").append(tabla2);
  }

  $(function(){
    obtener_productos();
  });
  
</script>