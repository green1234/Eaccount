var polizas = {};
var html_polizas = "";

asignar_eventos = function()
{
	$(".cfdi_row td").on("dblclick", function(){
      /*alert("LOL")*/
      var id = $(this).parents("tr").find(".id_row").attr("id")
      location.href = "?section=poliza&action=detail&pid=" + id;
      /*console.log(id)*/
     });
}

obtener_polizas = function(fn)
{
	var path = "server/Polizas.php?action=get"; 

	if (type != "")
		path = path + "&type=" + type;

	$.getJSON(path, function(res)
	{
		console.log(res)
		if (res.success)
		{		
			polizas = res.data;
		}	
		else
		{
			polizas = null;
		}	
		fn(asignar_eventos); // Mostrar Polizas
	});
}

mostrar_polizas = function(fn){

	if (polizas != null){

		$.each(polizas, function(index, value){
			html_polizas += "<tr class='cfdi_row'>";
			html_polizas += "<td><input id='" + value.id + "'name='selector' class='id_row' type='radio' style='display:block;width:auto;'></td>";
			html_polizas += "<td>" + value.id + "</td>";
			html_polizas += "<td>" + value.ref + "</td>";
			html_polizas += "<td>" + value.date + "</td>";
			// html_polizas += "<td>" + value.period_id[1] + "</td>";
			// html_polizas += "<td>" + value.journal_id[1] + "</td>";
			html_polizas += "<td>" + value.partner_id[1] + "</td>";
			html_polizas += "<td>$" + value.total.toFixed(2) + "</td>";
			html_polizas += "<td>" + (value.state == "posted" ? "Contabilizado" : "Pendiente") + "</td>";
			html_polizas += "</tr>";		
		});
		
		$("#tabla_polizas").append(html_polizas);
		fn(); //Asignar Eventos
	}
	else
	{
		var row = "<tr><td colspan='7'>No se encontraron datos</td></tr>";
		$("#tabla_polizas").append(row);
	}

}

$(function(){

	obtener_polizas(mostrar_polizas);

	$(".poliza_button").on("click", function()
	{
		var rows = $("[name='selector']:checked");      
      	if (rows.length > 0)
      	{
      		console.log(rows)
        	var move = rows.attr("id");
        	$.getJSON("server/Polizas.php?action=process&pid=" + move, function(res)
			{
				if (res.success)
				{
					alert("Se ha procesado correctamente")
					window.location = "?section=poliza";				
				}
			});
      	}
      	else
      	{
        	alert("Debe seleccionar un registro");
      	}
	});
	
	//$(".cfdi_row td").on("dblclick", function(){
	  /*alert("LOL")*/
	  //var id = $(this).parents("tr").find(".id_row").attr("id")
	  //location.href = "?section=poliza_detail&cfdi=" + id;
	  /*console.log(id)*/
	 //});

	/*$(".new_poliza").on("click", function(e)
	{
		e.preventDefault();
	});*/
});