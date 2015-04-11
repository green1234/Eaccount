var accounts, mayores, lines, codesat, levels  = {};
var optionsAcc, lines_rows, estatus_poliza  = "";

get_lines = function(pid, fn)
{
	$.getJSON("server/Polizas.php?action=lines&pid=" + pid, function(res)
	{	

		if (res.data[0].invoice_id)
		{
			if (res.data[0].invoice_id.type == "out_invoice" && res.data[0].invoice_id.tipo_comprobante == "ingreso")
		    {
		      var tipo = "La factura";
		      var accion = "emitida";
		      var causa = "a";

		      if (res.data[0].invoice_id.retenciones === true)
		      {
		        var tipo = "El recibo de honorarios";
		        var accion = "emitido";
		        var causa = "a";
		      }
		    }
		    else if (res.data[0].invoice_id.type == "in_invoice" && res.data[0].invoice_id.tipo_comprobante == "ingreso")
		    {
		      var tipo = "La Factura";
		      var accion = "recibida";
		      var causa = "de";

		      if (res.data[0].invoice_id.retenciones === true)
		      {
		        var tipo = "El recibo de honorarios";
		        var accion = "recibido";
		        var causa = "de";
		      }
		    }
		    else if (res.data[0].invoice_id.type == "out_invoice" && res.data[0].invoice_id.tipo_comprobante == "egreso")
		    {
		      var tipo = "La nota de credito";
		      var accion = "emitida";
		      var causa = "a";
		    }
		    else if (res.data[0].invoice_id.type == "in_invoice" && res.data[0].invoice_id.tipo_comprobante == "egreso")
		    {
		      var tipo = "La nota de debito";
		      var accion = "recibida";
		      var causa = "de";

		      if (res.data[0].invoice_id.complemento_nomina_id != "")
		      {
		        var tipo = "El recibo de nómina";
		        var accion = "emitida";
		        var causa = "a";
		      }
		    }

		    var head = "<p>" + tipo +" <b>" + res.data[0].invoice_id.folio + "</b> " + accion + " con fecha <b>" + res.data[0].invoice_id.date_invoice + "</b><br>";
      		head += causa + " <b>" + res.data[0].invoice_id.partner_id[1] + "</b> en <b>" + res.data[0].invoice_id.currency_id[1] + "</b>, por un total de $<b>" + res.data[0].invoice_id.amount_total.toFixed(2) + "</b></p>";
		}
		else
		{
			var head = "<p>Factura de honorarios <b>" + res.data[0].name + "</b> recibida con fecha <b>" + res.data[0].date + "</b><br>";
		    head += "Recibida de <b>" + res.data[0].partner_id[1] + "</b> en <b>" + res.data[0].currency_id[1] + "</b>, por un total de $<b>" + res.data[0].total.toFixed(2) + "</b></p>";
		}

		//console.log(res.data)	
		if (res.success)	
		{		    
		    $("#header_poliza_detail").html(head);
			estatus_poliza = res.data[0].state
			lines = res.data[0].lines;				
		}	
		fn(asignar_eventos, pid);
	});
}

update_line = function(line_id, values)
{
	$.getJSON("server/Polizas.php?action=update&id="+line_id, values, function(res)
	{
		console.log("Update")		
		console.log(res)
	})
}

mostrar_lineas = function(fn, pid)
{
	var rows = ""
	var editable = ""

	if (estatus_poliza=="draft")
		editable = "editable";

	$.each(lines, function(index, line)
	{
		rows += "<tr>";
		rows += "<td><input class='line_id' type='checkbox' id='" + line.id + "'/></td>";
		rows += "<td>" + pid + "</td>";
		rows += "<td>" + line.name + "</td>";
		rows += "<td width='200px' class='" + editable + " account' id='" + line.account_id[0] + "'><select style='display:none'></select><span>" + line.account_id[1] + "</span></td>";
		/*rows += "<td>" + line.id + "</td>";*/
		rows += "<td>-</td>";
		rows += "<td>" + line.debit.toFixed(2) + "</td>";
		rows += "<td>" + line.credit.toFixed(2) + "</td>";
		rows += "<td>-</td>";
		rows += "<td>-</td>";
		rows += "</tr>";
	});
	$("#poliza_detalle").append(rows);
	fn();
}

asignar_eventos = function()
{
	$(".line_id").on("click", function(){
		
		var fila = $(this).parents("tr").addClass("editing_select");		
		var celda = fila.find("td.editable.account");

		if ($(this).is(":checked"))
		{
			var id = celda.attr("id");
			var select = celda.find("select");
			var text = celda.find("span");

			select.html(optionsAcc).val(id).show().focus();
			text.css("visibility", "hidden");
		}
		else
		{

			celda.find("select").hide().parent("td").find("span").css("visibility", "visible");
			celda.find("select").hide().parents("tr").removeClass("editing_select")
		}

	});

	$("td.editable").on("dblclick", function(){
		
		$(this).parents("tr").addClass("editing_select");
		var id = $(this).attr("id");
		var select = $(this).find("select");
		var text = $(this).find("span");
		
		$(this).data("html", select);
		$(this).data("text", text);
		//console.log(accounts)
		select.html(optionsAcc).val(id).show().focus();
		text.css("visibility", "hidden");				
	});

	

	$("td.editable select").on("change", function()
	{

		var cuenta_id = $(this).val();
		var line_id = $(this).parents("tr").find(".line_id").attr("id");
		var cuenta = $(this).find("option:selected").text();
		console.log(cuenta_id)
		if (cuenta_id != 0)
		{
			var params = {
				"account_id" : cuenta_id,			
			}

			update_line(line_id, params)
			$(this).hide().parent("td").find("span").text(cuenta).css("visibility", "visible");			
		}
		else
		{
			$("#new_account_modal").modal("toggle");

			/*var options = ""
			//options += "<option value='0' class='new_account'>Agregar Nueva Cuenta</option>";
			$.each(mayores, function(index, value)
			{
				options += "<option value='" + value.id + "'>" + value.code + " - "+ value.name + "</option>";
			});	

			$("#accnew_mayor").html(options);	*/		
		}
		
	});

	// $("td.editable select").on("blur", function()
	// {
	// 	$(this).hide().parent("td").find("span").css("visibility", "visible");
	// 	$(this).hide().parents("tr").removeClass("editing_select")
	// });
}

get_sub_accounts = function(parent_id)
{
	var path = "server/Cuentas.php?action=get&parent_id=" + parent_id;	
	var result =  {};
	$.getJSON(path, function(res){
		//console.log(res);
		if (res.success)
		{
			//result  = res.data;
			get_accounts_options(res.data, $("#accnew_sub"));			
		}	
	});
}

prepare_lista_cuentas = function(id,level)
{
	console.log("====LEVELS====")
	console.log(levels);
	console.log("========")
	var cuentas = levels[level];
	cuentas = cuentas[id];
	var listaCtas = "";
	var i = 0;
	console.log("====ID/LEVEL====")
	console.log(id)
	console.log(level)
	console.log("========")
	// console.log(levels)
	console.log(cuentas)
	$.each(cuentas, function(idx, cta)
	{
		console.log("=>" + cta.id)
		listaCtas += "<li parent='" + id + "' id='"+cta.id+"' class='cta_lista_sub' level='"+cta.level+"'>" + cta.code + " " + cta.name;
		//listaCtas += "<span class='glyphicon glyphicon-play' id='icon_estatus_open' style='float:right;'></span>";
		listaCtas += "</li>";		
	});
	listaCtas += "<li data-toggle='modal' data-target='#new_account_modal' parent='" + id + "' class='new_account cta_lista_sub'>Nueva Cuenta</li>"

	console.log(listaCtas)

	$("#sub_tabla"+level).removeClass("hidden")
		.find("#lista_sub_tabla"+ level).html(listaCtas)
		.find(".cta_lista_sub").off("click").on("click", function()
		{				
			if ($(this).hasClass("new_account")){
				//alert("new")
				//$("#new_account_modal").modal("show");
			}
			// else
			// {
			// 	var id = $(this).attr("id");
			// 	var lvl = $(this).attr("level");
			// 	var nxtLvl = parseInt(lvl) + 1;
			// 	//alert("LOL")
			// 	//prepare_lista_cuentas(id, nxtLvl);
			// }		
		});	
}

get_accounts = function(fn)
{	
	var path = "server/Cuentas.php?action=get";	
	var listaMayores = "";
	$.getJSON(path, function(res){
		//console.log(res);
		if (res.success)
		{
			accounts  = res.data.subctas;
			mayores = res.data.mayor;
			//console.log(mayores)

			$.each(mayores, function(idx, cta)
			{
				var id = cta.id;
				var lv = cta.level;
				var parent = cta.parent_id[0];

				//console.log(lv)
				if (levels[lv] != undefined)
				{
					//console.log(lv)
					if (levels[lv][parent] !== undefined)
						levels[lv][parent][id] = cta;
					else
						levels[lv][parent] = {id : cta}
				}
				else
				{
					//console.log(lv)
					
					levels[lv] = {};
					levels[lv][parent] = {};
					levels[lv][parent][id] = cta;
				}

				if (lv == 1)
				{
					listaMayores = "<li id='"+cta.id+"' class='cta_lista' level='"+cta.level+"' style='position:relative'>";
					listaMayores += "<span>" + cta.code + " " + cta.name + "</span>";					
					listaMayores += "<span class='glyphicon glyphicon-play' id='icon_estatus_open' style='right:0;position:absolute;'></span>";
					listaMayores += "</li>";	
					$("#lista_sub_tabla1").append(listaMayores);				
				}
				
			});
			$("#lista_sub_tabla1")
				.find(".cta_lista")
				.on("click", function()
			{
				var id = $(this).attr("id");
				var lvl = $(this).attr("level");
				var nxtLvl = parseInt(lvl) + 1;
				
				//alert("LOL")

				prepare_lista_cuentas(id, nxtLvl);
					
			});

			fn(accounts);	
		}	
	});
}

get_sat_codes = function()
{	
	var path = "server/Master.php?cat=codesat";	

	$.getJSON(path, function(res){
		//console.log(res);
		if (res.success)
		{
			codesat  = res.data;
			get_codesat_option(codesat);
		}	
	});
}

get_codesat_option = function(codes)
{
	optionsCode = ""
	$.each(codes, function(index, value)
	{
		optionsCode += "<option value='" + value.id + "'>" + value.code + "</option>";
	});
	$("#accnew_codesat").html(optionsCode);
}

get_accounts_options = function(acs, selector)
{
	//console.log(accounts)	
	if (acs == undefined)
		acs = accounts;

	options = ""
	$.each(acs, function(index, value)
	{
		options += "<option value='" + value.id + "'>" + value.code + " - "+ value.name + "</option>";
		//levels[value.level] = value;

		var id = value.id;
		var lv = value.level;
		var parent = value.parent_id[0];

		console.log(lv)
		if (levels[lv] !== undefined)
		{
			if (levels[lv][parent] !== undefined)
			{
				levels[lv][parent][id] = value;
			}
			else
			{
				levels[lv][parent] = {};
				levels[lv][parent][id] = value

			}			
		}
		else
		{
			//console.log(id)
			
			levels[lv] = {};
			levels[lv][parent] = {};
			levels[lv][parent][id] = value;
		}
	});		

	if(selector != null)
	{		
		selector.html(options);
		var last = selector.find("option").last().text();
		selector.next("div").text(last)
	}
	else
	{
		var first = "<option value='0' class='new_account'>Agregar Nueva Cuenta</option>";
		options = first + options;		
	}

	if (optionsAcc == undefined || optionsAcc == null || optionsAcc == "")
		optionsAcc = options;
}

get_mayores_options = function(parent)
{
	optionsMayor = ""
	var filasMayor = "";
	
	//optionsMayor += "<option value='0' class='new_account'>Agregar Nueva Cuenta</option>";
	$.each(mayores, function(index, value)
	{
		optionsMayor += "<option value='" + value.id + "'>" + value.code + " - "+ value.name + "</option>";
		//levels[value.level] = value;
				
	});	
	//console.log(optionsAcc);
	var mayor = $("#accnew_mayor").html(optionsMayor).val(parent);
	get_sub_accounts(mayor.val());
}

$(function(){
	
	get_lines(pid, mostrar_lineas);
	get_accounts(get_accounts_options);
	get_sat_codes();

	
	$('#new_account_modal').on('show.bs.modal', function (e) {
		console.log(e)
		var button = $(e.relatedTarget);
		var parent = button.attr("parent");
  		get_mayores_options(parent);
  		$("tr.editing_select").addClass("editing_modal");
	});

	$('#new_account_modal').on('hide.bs.modal', function (e) {
  		$("tr.editing").removeClass("editing_modal");
	});

	$("#new_account_form").on("submit", function(e)
	{
		e.preventDefault();

		var data = $(this).serialize();

		$.getJSON("server/Cuentas.php?action=add", data, function(res){
			console.log(res)

			if (res.success)
			{
				var value = res.data
				var accName = value.code + " - "+ value.name;
				var newOpt = "<option value='" + value.id + "'>" + accName + "</option>";
				optionsAcc += newOpt;			
				//var tr = $("tr.editing_modal");
				$("tr.editing_modal").find("td.account").attr("id", value.id)					
					.find("span").text(accName);

				var line_id = $("tr.editing_modal").find(".line_id").attr("id");		
				var params = {
					"account_id" : value.id,			
				}
				update_line(line_id, params)				
			}
			$('#new_account_modal').modal("hide");			

		});
		//console.log(data)
	});

	$("#accnew_mayor").on("change", function()
	{		
		get_sub_accounts($(this).val())
	});

});