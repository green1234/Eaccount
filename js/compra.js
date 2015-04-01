var estados = {};
var colonias = {};
var municipios = {};

var log = function(msg)
{
    console.log();
}

var confirmar_compra = function(values)
{	
	var action = "server/Suscripcion.php?action=compra";
	console.log(values);
	//return;
	$.get(action, values, function(result){

		console.log(result)
		result = JSON.parse(result);
		
		if (result.success)
		{
			alert("Se ha enviado un correo con los datos para el deposito");
			window.location.href = "inbox.php";
		}
		else
		{
			alert(result.data.description);
		}
	});
}

obtener_estados = function()
{
	var path = "server/Master.php?cat=estados";

	$.getJSON(path, function(res){
	  
	  if (res.success)
	  {    
	    //console.log(res.data);    
	    estados = res.data;
	  }
	});
}

function obtener_direccion(cp, fn, params)
  {
    var path = "server/Configuracion.php?get=direccion&cp=" + cp;

    $.getJSON(path, function(res)
    {
      if(res.success)
      {
        direcciones = res.data;        
        fn(params); 
      }       

    });
  }

  function mostrar_direccion()
  {     
    var colOptions = ""; 
    var estado_id = 0;  
    $.each(direcciones, function(i, dir){   
      colonias[i] = dir.name; 
      municipios[i] = dir.municipio;     
      colOptions += "<option val='" + dir.name + "'>" + dir.name +"</option>"

      if (estado_id == 0)      		
      	estado_id = dir.state_id[0];

    });
    $("#colonia").val("").html(colOptions);
    $("#municipio").val(municipios[0]);
    $("#estado").val(estado_id);
  } 

$(function(){

	obtener_estados();

	descuento_rate = descuento_rate / 100;
	var subtotal = costo.toFixed(2);
	var descuento = (subtotal * descuento_rate).toFixed(2);	
	var subtotal_desc = (subtotal - descuento).toFixed(2);
	// log(subtotal)
	var iva = (subtotal_desc * 0.16).toFixed(2);
	// log(iva)
	var total = (parseFloat(subtotal_desc) + parseFloat(iva)).toFixed(2);
	// log(total)

	var subtotal_text = "MXN " + subtotal + ".00/año";
	var subtotal_resume = "MXN " + subtotal_desc;
	var iva_resume = "MXN " + iva;
	var total_resume = "MXN " + total;	
	var descuento_resume = "MXN " + descuento;

	$("li.resume")
			.find("div.subtotal > b")			
			.text(subtotal_resume)
			.end()
			.find("div.iva > b")
			.text(iva_resume)
			.end()
			.find("div.total > b")
			.text(total_resume)
			.end();

	$("ul.descuentos")
			.find("li.description > p")
			.html(desc)
			.end()
			.find("li.amount > h3")
			.text(descuento_resume)
			.end()	
	
	$("select[name=period]").on("change", function(){
		// log($(this).val())
		// log(costo * $(this).val())
		var subtotal = (costo * $(this).val()).toFixed(2);
		var descuento = (subtotal * descuento_rate).toFixed(2);	
		var subtotal_desc = (subtotal - descuento).toFixed(2);
		var iva = (subtotal_desc * 0.16).toFixed(2);
		var total = (parseFloat(subtotal_desc) + parseFloat(iva)).toFixed(2);
		var subtotal_text = "MXN " + subtotal + "/año";
		var subtotal_resume = "MXN " + subtotal_desc;
		var iva_resume = "MXN " + iva;
		var total_resume = "MXN " + total;
		var descuento_resume = "MXN " + descuento;

		$("li.subtotal")
			.find("h3")
			.text(subtotal_text);

		$("li.resume")
			.find("div.subtotal > b")			
			.text(subtotal_resume)
			.end()
			.find("div.iva > b")
			.text(iva_resume)
			.end()
			.find("div.total > b")
			.text(total_resume)
			.end()

		$("ul.descuentos")			
			.find("li.amount > h3")
			.text(descuento_resume)
			.end()	

	});

	$("a.discount").on("click", function(e){
		e.preventDefault();
	});

	$("#EmpresaForm").on("submit", function(e){
		e.preventDefault();

		var data = $(this).serialize();
		var path = "server/Configuracion.php?update=empresa&tipo=fiscales&"+data;

		$.getJSON(path, function(res){
			if (res.success)
			{
				var period_id = $("select[name=period]").val();
				var values = {"key" : key, "ptr" : ptr, "plan" : plan_id, "period" : period_id}				
				if (desc_id != 0)
					values["discount"] = desc_id;
				confirmar_compra(values);
				$("#empresaModal").modal("hide");
			}
			else
			{
				alert(res.data.description)
			}
		});
	});

	$("a.confirm_compra").on("click", function(e)
	{
		e.preventDefault();
		
		var period_id = $("select[name=period]").val();
		var values = 
		{
			"key" : key, 
			"ptr" : ptr, 
			"plan" : plan_id, 
			"period" : period_id				
		}
		
		if (desc_id != 0)
			values["discount"] = desc_id;

		//var values = '&key=' + key + '&ptr=' + ptr + '&plan=' + plan_id + '&period=' + period_id + '&discount=' + desc_id; 
		var action = "server/Suscripcion.php?action=compra";
		$("#empresaModal").modal("show");
		//confirmar_compra(values);
		// $.get(action, values, function(result){

		// 	console.log(result)

		// 	result = JSON.parse(result);
			
		// 	if (result.success)
		// 	{
		// 		alert("Se ha enviado un correo con los datos para el deposito");

		// 		window.location.href = "inbox.php";
		// 	}
		// 	else
		// 	{
		// 		log(result.data);
		// 	}
		// });
	})

	$("#cp").on("keyup", function(){
      //console.log($(this).val().length)
      if($(this).val().length == 5)
      {
        obtener_direccion($(this).val(), mostrar_direccion);
      }
      else
      {
      	$(this).focus();
      }
    });

    $('#empresaModal').on('shown.bs.modal', function () 
    {
      // var edo = $.trim($("#empresas").find("[id='idata_estado']").text())      
      // var cp = $.trim($("#empresas").find("[id='idata_cp']").text())

      // obtener_direccion(cp, mostrar_direccion);

      //$("#colonia").html("<option val='" + col + "'>" + col + "</option>");
      
      var optEstados = "";
      var idx = 0;
      $.each(estados, function(i, v){
        // if (v.name == edo)
        // {
        //   optEstados += "<option selected value='" + v.id + "'>" + v.name + "</option>" ;
        // }
        optEstados += "<option value='" + v.id + "'>" + v.name + "</option>" ;
        //console.log("Index: " + idx)
        //console.log(estados)        
        if (idx == Object.keys(estados).length - 1)
          $("#estado").html(optEstados);

        idx++;
      });

    });

    $("#rfc").on("blur", function()
    {      
      var valor = $(this).val().toUpperCase();
      $(this).val(valor);
    });

});