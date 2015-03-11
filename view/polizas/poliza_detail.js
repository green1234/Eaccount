var accounts, lines  = {};
var optionsAcc, lines_rows;

get_lines = function(pid, fn)
{
	$.getJSON("server/Polizas.php?action=lines&pid=" + pid, function(res)
	{		
		if (res.success)		
			lines = res.data;				
		fn(asignar_eventos);
	});
}

mostrar_lineas = function(fn)
{
	var rows = ""
	$.each(lines, function(index, line)
	{
		rows += "<tr>";
		rows += "<td><input type='checkbox' id='" + line.id + "'/></td>";
		rows += "<td>" + line.ref + "</td>";
		rows += "<td>" + line.name + "</td>";
		rows += "<td width='200px' class='editable'><select style='display:none'></select><span>" + line.account_id[1] + "</span></td>";
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
		
		var select = $(this).find("select");
		var text = $(this).find("span");
		
		$(this).data("html", select);
		$(this).data("text", text);
		console.log(accounts)
		select.html(optionsAcc).show();
		text.css("visibility", "hidden");
	});

	$("td.editable select").on("change", function()
	{
		var cuenta = $(this).find("option:selected").text();
		$(this).hide().parent("td").find("span").text(cuenta).css("visibility", "visible");		
	});
}

get_accounts = function(fn)
{
	$.getJSON("server/Cuentas.php?action=get", function(res){
		//console.log(res);
		if (res.success)
		{
			accounts  = res.data;
			fn();	
		}	
	});
}

get_accounts_options = function()
{
	optionsAcc = ""
	$.each(accounts, function(index, value)
	{
		optionsAcc += "<option value='" + value.id + "'>" + value.code + " - "+ value.name + "</option>";
	});
	//console.log(optionsAcc);
}

$(function(){
	
	get_lines(pid, mostrar_lineas);
	get_accounts(get_accounts_options);

	
	

});