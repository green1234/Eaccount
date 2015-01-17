var log = function(msg)
{
    console.log(msg);
}

$(function(){

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


});