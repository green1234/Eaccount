var planes = {};

var log = function(msg)
{
    console.log(msg);
}

var obtener_datos_planes = function(){

	$.getJSON("server/Suscripcion.php?get=planes", function(res)
	{
		console.log(res.data)
		if(res.success)
		{
			planes = res.data;
			mostrar_planes();
		}
	});
}

var mostrar_planes = function()
{
	var elems = "";
	$.each(planes, function(i, plan){
        
        var idx = i + 1;

		elems += '<div class="col-md-4">';
		elems += '<form id="plan_domicilio" action="compra.php" method="post">';
		elems += '<input type="hidden" name="key" id="key" value="' + susc_id +'" />';
		elems += '<input type="hidden" name="ptr" id="ptr" value="' + partner + '" />';
        elems += '<input type="hidden" name="plan" id="plan" value="' + plan.id + '" />';
        elems += '<input type="hidden" name="name" id="name" value="' + plan.name + '" />';
        elems += '<input type="hidden" name="resume" id="resume" value="' + plan.resume + '" />';
        elems += '<input type="hidden" name="costo" id="costo" value="' + plan.costo + '" />';
        
        elems += '<div class="elem_xs_d">';
        elems += '<img src="img/plan-0' + idx + '.png"/>';
        elems += '<p>' + plan.resume + '</p>';
        elems += '<h3>$' + plan.costo + ' / año</h3>';
                  
        if (plan.costo_desc != "Pendiente")        
	        elems += '<h5>' + plan.costo_desc + '</h5>'
    	   
        elems += '<span>' + plan.description + '</span>'
        elems += '<a class="submit" src="#">Comprar Ahora</a>'
	    elems += '</div></form></div>';
	});
	$("#planes_container").html(elems);

	$("a.submit").on("click", function(e){
        e.preventDefault();
        $(this).parents("form").submit();        
    });
}

$(function(){
    obtener_datos_planes();  
});