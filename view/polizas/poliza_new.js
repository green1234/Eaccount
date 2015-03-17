$(function(){

	var accounts = {}
	var optionsAcc = "";

	get_accounts = function(fn)
	{
		$.getJSON("server/Cuentas.php?action=get", function(res){
			//console.log(res);
			if (res.success)
			{
				accounts  = res.data;
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

	asignar_evento = function(obj)
	{
		console.log($(obj))
		$(obj).find(".switch").on("click", function()
		{
			if ($(this).is(":checked"))
			{
				//alert("lol")
				obj.find("input,select").each(function(i,v){
					console.log($(v).prop("tagName"))					

					if ($(v).prop("tagName") == "INPUT")
					{
						if ($(v).prop("type") == "text")
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

		$(obj).removeClass("new");
	}
	
	get_accounts();

	$("#new_poliza_form").on("submit", function(e){
		e.preventDefault();
		var path = $(this).attr("action");
		var data = $(this).serialize();

		$.getJSON(path, data, function(res)
		{
			console.log(res)
			if (res.success)
			{
				alert("Se registro correctamente");
				window.location = "?section=poliza";
			}
			else
			{
				alert(res.data.description)
			}	
		});

		console.log(data);
	});

	$(".new_asiento").on("click", function(e)
	{
		e.preventDefault();
		var fila = "<tr class='new'>";		
		fila += "<td>-</td>";
		fila += "<td><input type='text'><span></span></td>";
		fila += "<td class='abs'><select id='p_cuenta'/><span></span></td>";
		fila += "<td>-</td>";
		fila += "<td><input type='text' min='0'><span></span></td>";
		fila += "<td class='w_100 p_dc'><input type='checkbox'><input type='checkbox'></td>";
		fila += "<td>-</td>";
		fila += "<td><input type='text'><span></span></td>";
		fila += "<td><input type='text'><span></span></td>";		
		fila += "<td><input class='switch' type='checkbox'></td>";
		fila += "</tr>";
		$("#poliza_new").append(fila).find("tr.new").find("select").html(optionsAcc);
		asignar_evento($('tr.new'));
	});
});