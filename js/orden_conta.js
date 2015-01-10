var log = function(msg)
{
    console.log(msg);
}

$(function(){

	var subtotal = costo;
	var iva = subtotal * 0.16;
	var total = subtotal + iva;
	var subtotal_text = "MXN " + subtotal + ".00/año";
	var subtotal_resume = "MXN " + subtotal + ".00";
	var iva_resume = "MXN " + iva + ".00";
	var total_resume = "MXN " + total + ".00";

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
	
	$("select[name=period]").on("change", function(){
		log($(this).val())
		log(costo * $(this).val())
		var subtotal = costo * $(this).val();
		var iva = subtotal * 0.16;
		var total = subtotal + iva;
		var subtotal_text = "MXN " + subtotal + ".00/año";
		var subtotal_resume = "MXN " + subtotal + ".00";
		var iva_resume = "MXN " + iva + ".00";
		var total_resume = "MXN " + total + ".00";

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

	});

	$("a.discount").on("click", function(e){
		e.preventDefault();
	});


});