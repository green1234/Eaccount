var accounts, mayores, lines, codesat  = {};
var optionsAcc, lines_rows, estatus_poliza  = "";

get_lines = function(pid, fn)
{
	$.getJSON("server/Polizas.php?action=lines&pid=" + pid, function(res)
	{	
		//console.log(res.data)	
		if (res.success)	
		{
			var head = "<p>Factura de honorarios <b>" + res.data[0].name + "</b> recibida con fecha <b>" + res.data[0].date + "</b><br>";
		    head += "Recibida de <b>" + res.data[0].partner_id[1] + "</b> en <b>" + res.data[0].currency_id[1] + "</b>, por un total de $<b>" + res.data[0].total.toFixed(2) + "</b></p>";
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

	$("td.editable select").on("blur", function()
	{
		$(this).hide().parent("td").find("span").css("visibility", "visible");
		$(this).hide().parents("tr").removeClass("editing_select")
	});
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

get_accounts = function(fn)
{	
	var path = "server/Cuentas.php?action=get";	

	$.getJSON(path, function(res){
		//console.log(res);
		if (res.success)
		{
			accounts  = res.data.subctas;
			mayores = res.data.mayor;
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

get_mayores_options = function()
{
	optionsMayor = ""
	//optionsMayor += "<option value='0' class='new_account'>Agregar Nueva Cuenta</option>";
	$.each(mayores, function(index, value)
	{
		optionsMayor += "<option value='" + value.id + "'>" + value.code + " - "+ value.name + "</option>";
	});	
	//console.log(optionsAcc);
	var mayor = $("#accnew_mayor").html(optionsMayor);

	get_sub_accounts(mayor.val());
}

$(function(){
	
	get_lines(pid, mostrar_lineas);
	get_accounts(get_accounts_options);
	get_sat_codes();

	
	$('#new_account_modal').on('show.bs.modal', function (e) {
  		get_mayores_options();
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