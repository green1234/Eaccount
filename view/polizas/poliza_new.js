$(function(){

	var accounts = {}
	var optionsAcc = "";

	get_accounts = function(fn)
	{
		$.getJSON("server/Cuentas.php?action=get", function(res){
			//console.log(res);
			if (res.success)
			{
				accounts  = res.data.subctas;
				get_accounts_options();	
			}	
		});
	}

	get_accounts_options = function()
	{		
		$.each(accounts, function(index, value)
		{
			optionsAcc += "<option value='" + value.id + "'>" + value.code + " - "+ value.name + "</option>";
		});		
	}

	obtener_filas = function(selector)
	{
		var filas = selector.find("tbody > tr");
		filas.each(function(i, fila)
		{
			console.log(i)
			console.log(fila)

			var data = $(fila).find("input, select").serialize();
			console.log(data)


		});
	}

	guardar_filas = function()
	{
		$("tr.new").each(function(i, fila){
			var form = $(fila).parents("form");			
			form_id = form.attr("new");
			var path = form.attr("action") + "line";
			var data = $(fila).find("input, select").serialize();
			data = data + "&poliza=" + form_id;

			$.getJSON(path, data, function(res)
			{
				console.log(res)
				$(fila).removeClass("new");
			});			
		});

		procesar_poliza(form_id);

		/*var form = $(obj).parents("form");
		var form_id = form.attr("new");
		var data = $(obj).find("input, select").serialize();
		data = data + "&poliza=" + form_id;
		
		$(obj).removeClass("new");
		$.getJSON(form.attr("action") + "line&" + data, function(res)
		{
			console.log(res)
		});*/
	}

	procesar_poliza = function(pid)
	{
		$.getJSON("server/Polizas.php?action=process&pid=" + pid, function(res)
		{
			if (res.success)
			{
				alert("Se ha procesado correctamente")
				window.location = "?section=poliza";				
			}
		});
	}

	asignar_evento = function(obj)
	{
		$(obj).find(".switch").on("click", function()
		{
			if ($(this).is(":checked"))
			{
				//alert("lol")
				obj.find("input,select").each(function(i,v){
					console.log($(v).prop("tagName"))					

					if ($(v).prop("tagName") == "INPUT")
					{
						if ($(v).prop("type"))
						{
							var valor = $(v).val();
							$(v).hide().parent("td").find("span").text(valor);		
							console.log(valor);
						}
					}
					else
					{
						var valor = $(v).find("option:selected").text();
						$(v).hide().parent("td").find("span").text(valor);
					}
					console.log(valor)
										

				});
			}
		});

		$(obj).find(".p_dc").find("[type='checkbox']").on("click", function()
		{
			
			if($(this).prop("checked"))
			{
				$(this).addClass("new").parent("td").find("input").not(".new").prop("checked", "");				
				//$(this).next().removeAttr("checked");	
			}
			else
			{				
				$(this).addClass("new").parent("td").find("input").not(".new").prop("checked", true);
				//$(this).next().attr("checked", true);		
			}

			$(this).removeClass("new");
		});

		/*if ($(obj).parents("form").attr("new") != "")
		{
			guardar_filas();
		}*/
	}
	
	get_accounts();

	$("#new_poliza_form").on("submit", function(e){
		e.preventDefault();
		var path = $(this).attr("action");
		var data = $(this).serialize();
		//obtener_filas($("#poliza_new"));

		if ($("tr.new").length == 0)
		{
			alert("No puede procesar una poliza sin asientos.");
			return false;
		}

		$.getJSON(path, data, function(res)
		{
			console.log(res)
			if (res.success)
			{
				$("#new_poliza_form").attr("new", res.data[0]);
				guardar_filas();
				//alert("Se registro correctamente");
				//window.location = "?section=poliza";
			}
			else
			{
				//alert(res.data.description)
			}	
		});

		console.log(data);
	});

	$(".new_asiento").on("click", function(e)
	{
		e.preventDefault();
		/*if($("#new_poliza_form").attr("new") == "")		
			$("#new_poliza_form").find(":submit").click();*/

		console.log($('tr.new').length)

		var fila = "<tr class='new'>";
		fila += "<td>-</td>";
		fila += "<td><input type='text' name='concepto' value='-'><span></span></td>";
		fila += "<td class='abs'><select name='cuenta' id='p_cuenta'/><span></span></td>";
		fila += "<td>-</td>";
		fila += "<td><input name='monto' type='text' value=0><span></span></td>";
		fila += "<td class='w_100 p_dc'><input name='debit' type='checkbox' checked='checked'><input name='credit' type='checkbox'></td>";
		fila += "<td>-</td>";
		fila += "<td><input name='uuid' type='text'><span></span></td>";
		fila += "<td><input name='notas' type='text'><span></span></td>";		
		fila += "<td><input class='switch' type='checkbox'></td>";
		fila += "</tr>";
		$("#poliza_new").append(fila).find("tr.new").find("select").html(optionsAcc);
		asignar_evento($('tr.new').last());
			
		
	});
});