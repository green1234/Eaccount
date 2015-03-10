$(function(){

	var accounts  = {};
	alert("LOL")
	$.getJSON("server/Cuentas.php?action=get", function(res){
		console.log(res);
	});

});