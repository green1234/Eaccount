$(function(){

	$("#form_registro").on("submit", function(e){
		
		e.preventDefault();	
		$("#loader").show();
	    $("#submit").hide();

		var path = $(this).attr("action")
		
		var username = $("#username").val();
		var apellido = $("#apellido").val();
		var email = $("#email").val();
    	var password = $("#password").val();
    	var password2 = $("#password2").val();
		var dataString = 'username='+ username + '&email='+ email + '&password='+ password + '&password2='+ password2;
				
		if(username==''||email==''||password==''||password2=='')
		{
			alert("Por favor llena todos los campos");
			$("#loader").hide();
			$("#submit").show();
		}
		else
		{
			if (!$('#tyc').is(":checked")) {
	          alert("Debes aceptar los terminos y condiciones.");
	          $("#loader").hide();
	          $("#submit").show();
	          return false;
	        };

	        if (password != password2) {
	          alert("Las contraseñas no coinciden.");
	          $("#loader").hide();
	          $("#submit").show();
	        }
	        else
	        {
	        	$.ajax({type: "POST", url: path, 
	        		data: dataString+'&tyc=1', cache: false,
					success: function(result) {						
						// console.log(result)
						result = JSON.parse(result);

						if (!result.success == true)						
						  alert(result.data.description);						
						
						else
						  alert("Se te ha enviado un correo de confirmacion. Sigue la liga para continuar con el proceso de registro de tu nueva cuenta");
						
						$("#loader").hide();
						$("#submit").show();
					}
				});
	        }
		}
		
		// console.log(path)
		// console.log(dataString)
	});
});