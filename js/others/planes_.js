var showPlanes = false;
var selectedPlan = -1;
var selectedRFC = "";
var username = "";

$(document).ready(function(){
    init();
    registerEvents();
});

function init()
{   
}

function registerEvents()
{
    $("#btnForgotPassword").click(function(){
        $("#divForgotPassword").dialog({
            modal: true,
            width: 480,
            dialogClass: "modalNoBorder"
        });        
    });
    
    $("#dfpBtnSubmit").click(function(){
        var email = $("#dfpTxtEmail").val();
        $.post("php/login.php",
        { 
           request: "rememberPassword",
            "email": email
        })
        .done(function(data) {
            alert("Sigue las instrucciones en tu correo para restablecer tu contraseña.");

        });
        $("#divForgotPassword").dialog("close");
    });
    
    $("#selectYears").change(function(){
        var optYears = $("#selectYears option:selected").val();
        
        $.post("php/planes.php",
        {
            request: "getPlanesDetails",
            "plan": selectedPlan,
            "years": optYears
        })
        .done(function(data) {
            var json = JSON.parse(data);
            var planCFDis = json[0]['max_cfdis'];
            var planCost = json[0]['costo'];
            
            $.post("php/planes.php",
            {
                request: "savePlanesDetails",
                "cfdis":planCFDis,
                "cost":planCost
            })
            .done(function(data) {
                onCalculatePriceTotalAutoDiscount(planCost);
            });
        });
    });
    
    $("#btnIngresar").click(function(){
        showLogin();
    });
    
    $("#txtDataZipCode").focusout(function() {
        var zipCode = $("#txtDataZipCode").val();
        
        if(zipCode.length == 5 && isNumber(zipCode))
        {
            $.post("php/planes.php",
            {
                request: "verifyZipCode",
                "zipCode": zipCode
            })
            .done(function(data) {
                if (data === "-1")
                {
                    alert("El código postal es inválido.");
                }
                else
                {
                    var response = data.split(',');
                    $("#txtDataMunicipio").val(response[0]);
                    $("#txtDataState").val(response[2]);
                    $("#txtDataColonia").val(response[3]);
                    $("#txtDataCountry").val("México");
                }
            })
            .fail(function(data) {
                alert("Ocurrió un error. Vuelve a intentarlo o contacta al administrador para resolver tu problema.");
            });
        }
    });
    
    $("#btnConfirmOrden").click(function()
    {
        $("#ordenConfirmationPanel").dialog("close");
        window.location = "inbox.php";
    });
    
    $("#btnLogin").click(function(){
        onLogin();
    });
    
    $("#btnApplyDiscount").click(function(){
        $.post("php/planes.php",
        {
            request: "getSavedPlanesDetails"
        })
        .done(function(data) {
            var json = JSON.parse(data);
            var planCost = json["costo"];
            var discount = $("#innerCenter").find("#txtDescuento").val();
            if(discount.length > 0)
            {
                $.post("php/planes.php",
                {
                    request: "applyDiscount",
                    "discount": discount
                })
                .done(function(data) {
                    var discount = data;            
                    if(discount.length > 0)
                    {
                        onCalculatePriceTotal(planCost, discount);
                    }
                });
            }
            else
            {
                alert("Escriba su folio.");
            }
       });
    });
    
    $("#btnPlanes1").click(function() {
        selectedPlan = 1;
        
        $.post("php/planes.php",
        {
            request: "getPlanesDetails",
            "plan": selectedPlan,
            "years": 1
        })
        .done(function(data) {
            var json = JSON.parse(data);
            var planCFDis = json[0]['max_cfdis'];
            var planCost = json[0]['costo'];
            
            $.post("php/planes.php",
            {
                request: "savePlanesDetails",
                "cfdis":planCFDis,
                "cost":planCost
            })
            .done(function(data) {
                onRequestOrdenDeCompra();
            });
        });
    });
    //
    $("#btnPlanes2").click(function(){
        selectedPlan = 2;
        
        $.post("php/planes.php",
        {
            request: "getPlanesDetails",
            "plan": selectedPlan,
            "years": 1
        })
        .done(function(data) {
            var json = JSON.parse(data);
            var planCFDis = json[0]['max_cfdis'];
            var planCost = json[0]['costo'];
            
            $.post("php/planes.php",
            {
                request: "savePlanesDetails",
                "cfdis":planCFDis,
                "cost":planCost
            })
            .done(function(data) {
                $("#spanYears").show();
                onRequestOrdenDeCompra();
            });   
        });
    });
    
    $("#btnConfirmOpenAccount").click(function() {
        var rfc = $("#txtDataRFC").val().toUpperCase();
        var rfcConfirm = $("#txtDataRFCConfirm").val().toUpperCase();
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
        
        if(rfc !== rfcConfirm)
        {
            alert("Confirma tu RFC.");
            return;
        }
        if (rfc === null || rfc === "" || rfc === " ")
        {
            alert("RFC no puede estar vacío.");
            return;
        }
        if(rfc.length < 12 || rfc.length > 13)
        {
            alert(rfc + " no tiene 12 o 13 caracteres.");
            return;

        }
        if (razonSocial === null || razonSocial === "" || razonSocial === " ")
        {
            alert("Razon social no puede estar vacía.");
            return;
        }
        if (street === null || street === "" || street === " ")
        {
            alert("Domicilio Fiscal no puede estar vacía.");
            return;
        }
        if (numberOut === null || numberOut === "" || numberOut === " ")
        {
            alert("Número exterior no puede estar vacío.");
            return;
        }
        if (colonia === null || colonia === "" || colonia === " ")
        {
            alert("Colonia no puede estar vacía.");
            return;
        }
        if (municipio === null || municipio === "" || municipio === " ")
        {
            alert("Municipio no puede estar vacío.");
            return;
        }
        if (zipCode === null || zipCode === "" || zipCode === " " || zipCode.length != 5)
        {
            alert("Código Postal no puede estar vacío.");
            return;
        }
        if (state === null || state === "" || state === " ")
        {
            alert("Estado no puede estar vacío.");
            return;
        }
        if (country === null || country === "" || country === " ")
        {
            alert("País no puede estar vacío.");
            return;
        }

        $.post("php/session_manager.php",
        {
            request: "checkUserSession"
        })
        .done(function(data) {
            if(data == 0)
            {
                showLogin();
            }
            else if(data == 1)
            {
                if (username !== null)
                {
                    $.post("php/planes.php",
                    {
                        request: "updateUserDatosFiscales",
                        "username": username,
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
                        if(data == "-1")
                        {
                            alert("Ocurrió un error al intentar guardar sus datos fiscales. Verifique que los datos estén correctos.");
                            window.location = "index.php";
                        }
                        else if(data == "0")
                        {
                           selectedRFC = rfc;                            
                        }
                    });
                }
            }
        });
        $("#taxDataPanel").dialog("close");
    });
    
    $("#btnConfirmBuy").click(function(){
        var plan = $("#ordenDeCompraPlan option:selected").text();
        var rfc = $("#selectEmpresaRFC option:selected").text();
        
        $.post("php/session_manager.php",
        {
            request: "getReciboTotal"
        })
        .done(function(data) {
            var reciboTotal = data;
            var r = confirm("Confirme su compra");
            
            if (r == true)
            {
                $.post("php/planes.php",
                {
                    request: "startSubscriptionProcess",
                    "plan": plan,
                    "reciboTotal": reciboTotal
                })
                .done(function(data) {
                    $("#ordenConfirmationPanelRFC").text(rfc);
                    showOrdenConfirmationPanel();
                });
            }
            else
            {
            }
        });
    });
}

function onRequestOrdenDeCompra()
{
    $.post("php/session_manager.php",
    {
        request: "checkUserSession"
    })
    .done(function(data) {
        if(data == 0)
        {
            showLogin();
        }
        else if(data == 1)
        {
           showOrdenDeCompra();
        }
    });
}

function onDatosFiscales()
{
    if (showPlanes)
    {
        $("#taxDataPanel").dialog({
            modal: true,
            width: 780,
            dialogClass: "taxDataPanel"
        });
    }    
}

function showOrdenConfirmationPanel()
{
    $("#ordenConfirmationPanel").dialog({
        modal: true,
        width: 330,
        dialogClass: "loginPanel"
    });
}

function showOrdenDeCompra()
{
    $.post("php/planes.php",
    {
        request: "getSavedPlanesDetails"
    })
    .done(function(data) {
        var json = JSON.parse(data);
        var planCFDis = json["max_cfdis"];
        var planCost = json["costo"];
        
        $('#innerCenter').slideDown('slow', function() {
            $("#innerCenter").empty();
            $("#planCFDIs").text(planCFDis);

            $.post("php/planes.php",
            {
                request: "getUserRFC"
            })
            .done(function(data) {
                var json = JSON.parse(data);
                var options = "";

                if (data != -1)
                {
                    for(a = 0; a < json.length; ++a)
                    {
                        if(json[a].rfc == selectedRFC)
                        {
                            options += "<option selected value='" + a + "'>" + json[a].rfc + "</option>";
                        }
                        else
                        {
                            options += "<option value='" + a + "'>" + json[a].rfc + "</option>";                        
                        }
                    }
                    $("#selectEmpresaRFC").html(options + "");

                    $.post("php/planes.php",
                    {
                        request: "getPlanesDescripcion"
                    })
                    .done(function(data) {
                        var json = JSON.parse(data);
                        var options = "";
                        
                        for(var a = 0; a < json.length; ++a)
                        {
                            if(json[a]["id"] == selectedPlan)
                            {
                                options += "<option selected value='" + json[a]["id"] + "'>";                                
                            }
                            else
                            {
                                options += "<option value='" + json[a]["id"] + "'>";
                            }
                            options += json[a]["nombre"] + "</option>";
                        }
                        $("#ordenDeCompraPlan").append(options + "");
                        //
                        if(selectedPlan == 1)
                        {
                            $("#imgOrdenDeCompra").attr("src","img/pagina_planes/COMPRA-emprendedor.png");
                        }
                        else
                        {
                            $("#imgOrdenDeCompra").attr("src","img/pagina_planes/COMPRA-basico.png");                            
                        }
                        var c = $('#ordenDeCompraTemplate').clone(true);
                        $("#divTitulo").html("ORDEN DE COMPRA");
                        $('#innerCenter').append(c);
                        onCalculatePriceTotal(planCost, 0);
                        c.show();
                        $('#innerCenter').slideDown('slow');

                    });
                }
            });
        });
    });

}

function onCalculatePriceTotal(planCost, descuento)
{
    descuento = Number(descuento);
    planCost = Number(planCost);
    
    $.post("php/planes.php",
    {
        request: "getDescuentosInstitucionales"
    })
    .done(function(data) {
        var json = JSON.parse(data);
        var descripcionDescuentoInstitucional = "";
        if(typeof(descuento) == 'undefined')
        {
            descuento = 0;
        }
        
        for(var a  = 0; a < json.length; ++a)
        {
            descuento += Number(json[a]["descuento"]);
            descripcionDescuentoInstitucional += json[a]["descripcion"] + ": %" + json[a]["descuento"] + "<br>";
        }
        var cost = Number(planCost);
        var reciboDiscount = (cost * descuento) / 100;
        var reciboSubTotal = cost - reciboDiscount;
        var mexicoIVA = 0.16;
        var reciboIVA = mexicoIVA * reciboSubTotal;
        var reciboTotal = reciboSubTotal + (reciboSubTotal * mexicoIVA);
        $("#innerCenter").find("#reciboPrice").text("$" + cost.toFixed(2));
        $("#innerCenter").find("#reciboDiscount").text("%" + descuento);
        $("#innerCenter").find("#reciboDiscountInstitucional").html (descripcionDescuentoInstitucional);
        $("#innerCenter").find("#reciboSubTotal").text("$" + reciboSubTotal.toFixed(2));
        $("#innerCenter").find("#reciboIVA").text("$" + reciboIVA.toFixed(2));
        $("#innerCenter").find("#reciboTotal").text("$" + reciboTotal.toFixed(2));
        
        $.post("php/session_manager.php",
        {
            request: "saveReciboTotal",
            "reciboTotal":reciboTotal
        });
    });                       
}

function onCalculatePriceTotalAutoDiscount(planCost)
{
    var descuento = 0;
    
    $.post("php/planes.php",
    {
        request: "getSavedDiscounts"
    })
    .done(function(data) {
        var json = JSON.parse(data);
        descuento = Number(json.descuento);
    });
    
    descuento = Number(descuento);
    planCost = Number(planCost);
    
    $.post("php/planes.php",
    {
        request: "getDescuentosInstitucionales"
    })
    .done(function(data) {
        var json = JSON.parse(data);
        var descripcionDescuentoInstitucional = "";
        if(typeof(descuento) == 'undefined')
        {
            descuento = 0;
        }
        
        for(var a  = 0; a < json.length; ++a)
        {
            descuento += Number(json[a]["descuento"]);
            descripcionDescuentoInstitucional += json[a]["descripcion"] + ": %" + json[a]["descuento"] + "<br>";
        }
        var cost = Number(planCost);
        var reciboDiscount = (cost * descuento) / 100;
        var reciboSubTotal = cost - reciboDiscount;
        var mexicoIVA = 0.16;
        var reciboIVA = mexicoIVA * reciboSubTotal;
        var reciboTotal = reciboSubTotal + (reciboSubTotal * mexicoIVA);
        $("#innerCenter").find("#reciboPrice").text("$" + cost.toFixed(2));
        $("#innerCenter").find("#reciboDiscount").text("%" + descuento);
        $("#innerCenter").find("#reciboDiscountInstitucional").html (descripcionDescuentoInstitucional);
        $("#innerCenter").find("#reciboSubTotal").text("$" + reciboSubTotal.toFixed(2));
        $("#innerCenter").find("#reciboIVA").text("$" + reciboIVA.toFixed(2));
        $("#innerCenter").find("#reciboTotal").text("$" + reciboTotal.toFixed(2));
        
        $.post("php/session_manager.php",
        {
            request: "saveReciboTotal",
            "reciboTotal":reciboTotal
        });
    }); 
    
}

function showLogin()
{
    $("#loginPanel").dialog({
        modal: true,
        width: 390,
        dialogClass: "loginPanel"
    });
}

function onLogin()
{
    var username = $("#txtLoginUsuario").val();
    var password = $("#txtLoginPassword").val();

    if(username.length > 0 && password.length > 0)
    {
        $("#loginPanel").dialog("close");
        $.post("php/login.php",
        {
            request: "loginUser",
            "email": username,
            "password": password,
            "remember": true
        })
        .done(function(data) {
            var json = JSON.parse(data);
            var isLogged = json.logged;
            var validado = json.validado;
            var redir = json.redir;
        
            if (isLogged)
            {
                alert("¡Bienvenido!");
                window.location = 'inbox.php';
               // showDialog("Respuesta", "Bienvenido " + email);
            }
            else
            {
                if(validado === false)
                {
                    alert("Para tener acceso al sistema, usted tiene que verificar su cuenta mediante el correo que se le hizo llegar.");
                }
                else
                {
                    alert("Usuario o contraseña incorrectos. Verifique que estén escritos correctamente.");
                    //showDialog("Error", "Usuario o contraseña incorrectos");
                }
            }
        });
    }
    else
    {
        alert("Su usuario o contraseña no pueden estar vacíos.")
    }
}

function isNumber(n) {
  return !isNaN(parseFloat(n)) && isFinite(n);
}