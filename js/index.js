var tmpName = "";
var tmpLastName1 = "";
var tmpLastName2 = "";
var tmpEmail = "";
var tmpConfirmEmail = "";
var tmpPassword = "";
var tmpConfirmPassword = "";

$(document).ready(function(){
    init();
    registerEvents();
});

function init()
{
//    $("#btnRegister").button();    
}

function registerEvents()
{    
    $("#btnChangePassword").click(function(){
        var newPasswordConfirm = $("#txtNewPasswordConfirm").val();
        var newPassword = $("#txtNewPassword").val();

        if (newPassword.length == 0)
        {
            alert("Contraseña no puede estar vacía.");
            return;
        }
        if (newPasswordConfirm.length == 0)
        {
            alert("Confirme su contraseña.");
            return;
        }
        if (newPasswordConfirm != newPassword)
        {
            alert("Su contraseña y confirmación de contraseña tienen que ser iguales.");
            return;
        }

        $('#templateModalChangePassword').dialog("close");

        $.post("php/index.php",
        {
            request: "changePassword",
            "newPassword": newPassword
        })
        .done(function(data) {
            alert("Ingresa al sistema con tu nueva contraseña.");
        });
    });
    
    $("#btnRegister").click(function() {
        tmpName = $("#txtName").val();
        tmpLastName1 = $("#txtLastname").val();
        tmpEmail = $("#txtEmail").val();
        tmpPassword = $("#txtPassword").val();
        tmpConfirmPassword = $("#txtPasswordConfirm").val();
        tmpTermsConditions = $("#chkTermsConditions").is(":checked");
        
        if(tmpName.length == 0)
        {
            alert("Nombre no puede estar vacío.");
            return;
        }
        if(tmpLastName1.length == 0)
        {
            alert("Apellido no puede estar vacío.");
            return;
        }
        if(tmpEmail.length == 0 || tmpEmail.indexOf("@") == -1)
        {
            alert("Email está incorrecto.");
            return;
        }
        if(tmpPassword.length == 0)
        {
            alert("Contraseña no puede estar vacía.");
            return;
        }
        if(tmpConfirmPassword.length == 0)
        {
            alert("Se necesita confirmar la contraseña.");
            return;
        }
        if(tmpPassword != tmpConfirmPassword)
        {
            alert("Confirme su contraseña correctamente.");
            return;
        }
        if(tmpTermsConditions === false)
        {
            alert("Tiene que aceptar los términos y condiciones.");
            return;
        }
        
        $.post("php/index.php",
            {
                request: "startUserRegistrationProcess",
                "userName": tmpName,
                "lastName1": tmpLastName1,
                "lastName2": tmpLastName1,
                "email": tmpEmail,
                "password": tmpPassword,
//                "rfc": rfc,
//                "razonSocial": razonSocial,
//                "street": street,
//                "numberOut": numberOut,
//                "numberIn": numberIn,
//                "colonia": colonia,
//                "municipio": municipio,
//                "zipCode": zipCode,
//                "state": state,
//                "country": country,
//                "localidad": localidad,
//                "referencia": referencia
            })
            .done(function(data) {
                data = JSON.parse(data);
                if(data.result === "-1")
                {
                    alert("Ese correo ya existe, favor de elegir otro.");
                }
                else if(data.result === "-2")
                {
                    alert("Ocurrió un error. Vuelva a intentarlo más tarde.");
                }
                else
                {
                    alert("Siga las instrucciones en el correo de confirmación que se le envió al correo especificado.");
                }                
                window.location = "index.php";
            });            
    });
}

function createAccount()
{
    var errors = 0;
    var name = tmpName;
    var lastName1 = tmpLastName1;
    var lastName2 = tmpLastName2;
    var email = tmpEmail;
    var confirmEmail = tmpConfirmEmail;
    var password = tmpPassword;
    var confirmPassword = tmpConfirmPassword;
    var rfc = $("#txtDataRFC").val();
    var razonSocial = $("#txtDataSocial").val();
    var street = $("#txtDataFiscal").val();
    var numberOut = $("#txtDataExterior").val();
    var numberIn = $("#txtDataInterior").val();
    var colonia = $("#txtDataColonia").val();
    var municipio = $("#txtDataMunicipio").val();
    var zipCode = $("#txtDataZipCode").val();
    var state = $("#txtDataState").val();
    var country = $("#txtDataCountry").val();
    var localidad = $("#txtDataLocalidad").val();
    var referencia = $("#txtDataReferencia").val();
    
    
//    if(name.length == 0)
//    {
//        showDialog("¡Falta información!", "El nombre no puede estar vacío");
//        errors++;
//        return errors;
//    }
//    if(lastName1.length == 0)
//    {
//        showDialog("¡Falta información!", "El apellido paterno no puede estar vacío.");
//        errors++;
//        return errors;
//    }
//    if(lastName2.length == 0)
//    {
//        showDialog("¡Falta información!", "El apellido materno no puede estar vacío.");
//        errors++;
//        return errors;
//    }
//    if(email.length == 0 || email.indexOf("@") == -1)
//    {
//        showDialog("¡Falta información!", "El correo electrónico no puede estar vacío.");
//        errors++;
//        return errors;
//    }
//    if(email != confirmEmail)
//    {
//        showDialog("¡Falta información!", "Los correos electrónicos son diferentes.");
//        errors++;
//        return errors;
//    }
//    if(password.length == 0)
//    {
//        showDialog("¡Falta información!", "La contraseña no puede estar vacía.");
//        errors++;
//        return errors;
//    }
//    if(confirmPassword.length == 0)
//    {
//        showDialog("¡Falta información!", "Por favor confirma la contraseña.");
//        errors++;
//        return errors;
//    }
//    if(password != confirmPassword)
//    {
//        showDialog("¡Falta información!", "Las contraseñas no pueden ser diferentes.");
//        errors++;
//        return errors;
//    }
    $.post("php/index.php",
            {
                request: "registerUser",
                "userName": name,
                "lastName1": lastName1,
                "lastName2": lastName2,
                "email": email,
                "password": password,
                "rfc": rfc,
                "razonSocial": razonSocial,
                "street": street,
                "numberOut": numberOut,
                "numberIn": numberIn,
                "colonia": colonia,
                "municipio": municipio,
                "zipCode": zipCode,
                "state": state,
                "country": country,
                "localidad": localidad,
                "referencia": referencia
            })
            .done(function(data) {
                showDialog("Response", data);
            });
}

function showDialog(title, message)
{       
    $("#dialogGeneralMessageText").text(message);
    $("#dialogGeneralMessage").dialog({
        title: title,
        dialogClass: "no-close",
        buttons:[
            {
                text: "OK",
                click: function(){
                    $(this).dialog("close");
                }
            }
        ]
    });
}