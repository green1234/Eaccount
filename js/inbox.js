var regimen = {
    "Sociedad de Nombre Colectivo" : "Sociedad de Nombre Colectivo",
    "Sociedad en Comandita Simple" : "Sociedad en Comandita Simple",
    "Sociedad de Responsabilidad Limitada" : "Sociedad de Responsabilidad Limitada",
    "Sociedad Anonima" : "Sociedad Anonima",
    "Sociedad en Comandita por Acciones" : "Sociedad en Comandita por Acciones",
    "Sociedad Cooperativa" : "Sociedad Cooperativa",
    "Sociedad Civil" : "Sociedad Civil",
    "Persona Fisica con Actividad Empresarial" : "Persona Fisica con Actividad Empresarial",
    "Persona Moral" : "Persona Moral",
    "Regimen General" : "Regimen General",
};
function sub(obj){
    /*var file = obj.value;
    var fileName = file.split("\\");*/

    //console.log($('#upfile')[0].files); return

    if (obj.value == "" || obj.value == null)
    {
        return
    }

    var formData = new FormData($("#barra_principal")[0]);
    //formData.append('userfile', $('#upfile')[0].files);
    
    var path = $("#barra_principal").attr("action")
    console.log("p:" + path)
    console.log(formData)
    //return
    $.ajax({
        url : path,
        message : "",
        data : formData,       
        processData: false,
        contentType: false,
        cache : false,
        method : "POST",
        dataType : "json",
        success: function(data){   
            console.log(data);
            //console.log(data.success);
            $("#upfile").val(null);
            if (data.success)
            {
                alert("Facturas cargadas.");        
                msj = "";
                $.each(data.data, function(i, v)
                {
                    if (v.success == false)
                    {
                        msj += "#" + i + ": " + v.data.description + "\n";
                    }
                });
                if (msj != "")
                {
                    alert("Se detectaron algunos problemas con las facturas siguientes:\n" + msj + "Consulte la seccion de Cfdi's Apocrifos/No Verificados para mas información.");                    
                    window.location = "?section=cfdi&estatus=apoc";                
                }
                else
                    window.location = "?section=cfdi&estatus=vali";                
            }
            else
            {
                console.log(data.data.description);
                alert(data.data.description);
            }
        },
        error: function(data){            
            console.log(data);
        }
    });

    //document.getElementById("yourBtn").innerHTML = fileName[fileName.length-1];
    //document.myForm.submit();
    //event.preventDefault();
  }

obtener_facturas_ini = function()
{    
    var path = "server/Facturas.php";

    $.getJSON(path, function(res){
       
      if (res.success)
      {   
        facturas = res.data; 
        var estatus = {
            "veri" : 0,
            "vali" : 0,
            "apoc" : 0,
            "cont" : 0,
            "erro" : 0,
            "inco" : 0,
        }
        $.each(facturas, function(i, f)
        {
            var st = f.savvy_estatus;
            estatus[st] = estatus[st] + 1;
        });
        //console.log(estatus);
        $.each(estatus, function(i,v)
        {
            var text = $("a.cfdi."+i).text();
            $("a.cfdi."+i).find("span").text("(" + v + ")");
        });
      }
    });
}

$(function(){

    var facturas = {}

    obtener_facturas_ini();

    $(".close").on("click", function(){
        //window.location = "login.php";
    });

    $(".new_account").on("click", function(e){
        e.preventDefault();
        alert("Esta funcion aun esta en desarrollo. Pronto estara disponible.")
    });

    $("#barra_principal").on("submit", function(e){
        e.preventDefault();
        console.log("LOL")
    });

    $(".form-modal").on("submit", function(e){        
        e.preventDefault();
        
        // var data = $(this).serialize();
        var form = $(this);
        var inputs = form.find("input[type=text]:enabled,select");
        
        vals = "";
        var results = [];
        var rvals = [];
        $.each(inputs, function(idx, val){
            
            //console.log(idx)
            var name = $(this).attr("name");
            var val = $(this).val();
            results[idx] = name;
            rvals[idx] = $.trim(val);
            var value = name + "=" + $.trim(val);
            vals = vals + "&" + value; 
            
        });
        var tipo = $('#empresaModal').data("tipo");
        var path = $(this).attr("action");
        path = path + vals + "&tipo=" + tipo;
        console.log(path);
        
        //return
        $.getJSON(path, function(data){
            console.log(data)
            // console.log(results.length)
            // console.log(rvals.length)
            $.each(results, function(i){

                // console.log("#idata_" + results[i])
                // console.log(rvals[i])
                
                $("#idata_" + results[i]).text(rvals[i]);                   
                
                // $('#profileModal').modal("hide");
                form.parents(".modal").modal("hide");
            });
        });
    });

    $("a.openModal").on("click", function(){
        
        if ($(this).hasClass("profile"))
        {
            $('#empresaModal').data("tipo", "profile");        
            var tipo = "profile";
        }
        else if ($(this).hasClass("fiscales"))
        {
            $('#empresaModal').data("tipo", "fiscales");        
            var tipo = "fiscales";
        }        
        else if ($(this).hasClass("representante"))
        {
            $('#empresaModal').data("tipo", "representante");        
            var tipo = "representante";
        }
        else if ($(this).hasClass("registros"))
        {
            $('#empresaModal').data("tipo", "registros");        
            var tipo = "registros";
        }
        else if ($(this).hasClass("adicionales"))
        {
            $('#empresaModal').data("tipo", "adicionales");        
            var tipo = "adicionales";
        }

        $(".hid_input").find("input").attr("disabled", true);
        $(".hid_input").hide();
        $(".hid_input." + tipo).find("input").attr("disabled", false);
        $(".hid_input." + tipo).show();
    });
    
    $('#empresaModal').on('shown.bs.modal', function () {

        var valores = $("#empresas").find("[id^='idata_']");        
        // console.log(valores)
        // var empresa_name = $.trim($("#idata_empresa_name").text());        
        var form = $(this).find("form");

        $.each(valores, function(index, value){
            var valor = $(this);
            var text = $.trim(valor.text());
            if (text == "Pendiente") text = "";
            var id = valor.attr("id");
            id = id.replace("idata_", "");
            console.log(id)
            input_name = form.find("[name=" + id + "]");
            input_name.val(text).data("valor", text);
        });
        
    });

    $('#profileModal').on('shown.bs.modal', function () {
        // $('#myInput').focus()
        // console.log("LOL")

        var login = $.trim($("#idata_login").text());        
        var email = $.trim($("#idata_email").text());
        var phone = $.trim($("#idata_phone").text());
        var mobile = $.trim($("#idata_mobile").text());

        // console.log(login)
        // console.log(email)
        // console.log(phone)
        

        var form = $(this).find("form");

        console.log(form.find("[name=username]"))
        input_login = form.find("[name=username]")
        input_login.val(login).data("valor", login);

        input_email = form.find("[name=email]")
        input_email.val(email).data("valor", email);
        
        input_phone = form.find("[name=phone]");
        input_phone.val(phone).data("valor", phone);
        
        input_mobile = form.find("[name=mobile]");
        input_mobile.val(mobile).data("valor", mobile);
      })

    $("#yourBtn").on("click", function(){        
        $("#upfile").click();
    });

    $("#upfile").on("change", function(){        
        // $(".file_upload").text($(this).val());
        sub(this);
    });

});

// var chkRowChecked = 0;
// var fnTimeout = null;

// //ID de usuarios inicia en 91347
// function muestraporque () {
//   $("#porque").show("slow");
// }

// var openOrClosed = true;

// function rotaflecha(obj) {

//   var id_fleacha = obj.children[0].id;
//   //$("#"+id_fleacha).toggle(openOrClosed);

//   if ( openOrClosed === true ) {
//     console.log("Open");
//     openOrClosed = false;
//   } else if ( openOrClosed === false ) {
//     console.log("Closed");
//     openOrClosed = true;
//   }

// }

// $(document).ready(function(){    
    
//     $('.popover-1').tooltip({
//         trigger: "hover",
//           animation: true,
//           placement: 'bottom'
//       })

//     init();
//     registerEvents();
//     updateInbox();


// });

// function init()
// {
//     // $("#accordion").accordion({heightStyle:"content",collapsible: true});
//     setFirstRootLink();
//     loadAccounts();
//     loadNotificaciones();
//     loadSubscriptionPanel();
//     loadBuyCFDIs();
//     loadCuentasPorCobrar();
//     loadCuentasPorPagar();
//     getRecientes();
//     $("#tblComprobantePDFTest").DataTable({
//                 dom: 'T<"clear">lfrtip',
//                 tableTools: {
//                     "aButtons":[
//                         "print"
//                     ],
//                     "sSwfPath": "js/DataTables-1.10.0/extensions/TableTools/swf/copy_csv_xls_pdf.swf"
//                 },
//                 paging: false,
//                 searching: false,
//                 sort: false,
//                 "language": {
//                     "info": "",
//                     "lengthMenu": "Mostrar _MENU_ filas",
//                     "infoEmpty": "",
//                     "emptyTable": "No hay datos para esta tabla.",
//                     "paginate":{
//                         "next": "Siguiente",
//                         "previous": "Anterior"
//                     }
//                 }
//             });
// }

// function registerEvents()
// {
// //    $("#txtCalendar").datepicker();
// //    
// //    $("#btnCalendar").click(function(){
// //        $("#txtCalendar").datepicker("show");
// //    });
    
//     $("#configurationChangePlan").click(function(){
        
//     });
    
//     $("html").mousemove(function(e){
//         resetSessionTimeout();
//     });
    
//     $("#txtCuentasDatePicker").datepicker({
//         "dateFormat": "yy-mm-dd"
//     });
        
//     $("#btnBuyCFDIsComprar").click(function(){
//         var optCFDIs = $("#selectBuyCFDIsAvailable option:selected").val();
//         var cfdisCost = $("#lblBuyCFDIsTotal").text();
        
//         var r = confirm("Al confirmar la compra para incrementar la capacidad de " + optCFDIs + " CFDIs por " + cfdisCost + " MXN; se enviará un email a tu cuenta con las instrucciones de pago. Gracias por tu preferencia.");        
//         if(r == true)
//         {
//             $.post("php/inbox.php",
//             {
//                 request: "buyCFDIs",
//                 "cfdis": optCFDIs,
//                 "cost": cfdisCost
//             })
//             .done(function(data) {
//             });                                    
//         }
        
//         $("#templateModalBuyCFDIs").dialog("close");
//     });
    
//     $("#selectBuyCFDIsAvailable").change(function(){
//         var optCFDIs = $("#selectBuyCFDIsAvailable option:selected").val();
        
//         $.post("php/inbox.php",
//         {
//             request: "getExtraCFDIsCost",
//             "cfdis": optCFDIs
//         })
//         .done(function(data) {
//             var json = JSON.parse(data);
            
//             if(json.length > 0)
//             {
//                 $("#lblBuyCFDIsTotal").text(json[0]["costo"]);
//             }
//         });
//     });
    
//     $("#btnBuyCFDIs").click(function(){
//         $("#templateModalBuyCFDIs").dialog({
//             modal: true,
//             width: 780,
//             dialogClass: "modalNoBorder"
//         });
//     });
    
//     $("#txtSearchConceptos").change(function(e){
//         var concepto = $("#txtSearchConceptos").val();
//         if(concepto.length >= 4)
//         {
//             $.post("php/inbox.php",
//             {
//                 request: "searchConcepto",
//                 "concepto":concepto
//             })
//             .done(function(data) {
//                 json = JSON.parse(data);
//                 tblData = "<thead><tr><th>FECHA EMISIÓN</th><th>FOLIO</th><th>EMISOR</th><th>RECEPTOR</th><th>CONCEPTO</th><th>CANTIDAD</th><th>UNITARIO</th><th>IMPORTE</th><th>PDF</th><th>XML</th></tr></thead>";
//                 tblData += "<tbody>";
//                 for(var a = 0; a < json.length; ++a)
//                 {
//                    var id = -1;
//                    tblData += "<tr>";
//        //             tblData += "<td>" + (a+1) + "</td>";
//                    for (var row in json[a])
//                    {
//                        if (row == "valido")
//                        {
//                            if (json[a][row] == 1)
//                            {
//                                tblData += "<td><img class='icon' src='img/pagina_inbox/EstatusFactura-OK.png'/></td>";
//                            }
//                            else if (json[a][row] == 0)
//                            {
//                                tblData += "<td><img class='icon' src='img/pagina_inbox/EstatusFactura-pendiente.png'/></td>";
//                            }
//                            else if (json[a][row] == -1)
//                            {
//                                tblData += "<td><img class='icon' src='img/pagina_inbox/EstatusFactura-Error.png'/></td>";
//                            }
//                        }
//                        else if (row == "verificada")
//                        {
//                            if (json[a][row] == 1)
//                            {
//                                tblData += "<td><img class='icon' src='img/pagina_inbox/EstatusFactura-OK.png'/></td>";
//                            }
//                            else if (json[a][row] == 0)
//                            {
//                                tblData += "<td><img class='icon' src='img/pagina_inbox/EstatusFactura-pendiente.png'/></td>";
//                            }
//                            else if (json[a][row] == -1)
//                            {
//                                tblData += "<td><img class='icon' src='img/pagina_inbox/EstatusFactura-Error.png'/></td>";
//                            }

//                        }
//                        else if (row == "id")
//                        {
//                            id = json[a][row];
//                        }
//                        else if(row == "nombre_xml")
//                        {
//                            if (id != -1)
//                            {
//                                tblData += "<td><button onclick='onViewPDF(" + id + ")'>PDF</button></td>";
//                            }
//                            tblData += "<td><a href='php/request_xml.php?x=" + json[a][row] + "'><img src='img/pagina_inbox/EstatusFactura-Download.png'/></td>";
//                        }
//                        else
//                        {
//                            tblData += "<td>" + json[a][row] + "</td>";
//                        }
//                    }
//                    tblData += "</tr>";
//                 }
//                 tblData += "</tbody>";
//                 loadComprobantesTableWithMenu(tblData,[[1,"desc"]],true,false,false,false);
//             });
//         }
//     });
    
//     $("#btnEmailAdmin").click(function(){
//         alert("Envianos un correo a administracion@savvysystems.com.mx");        
//     });
    
//     $("img[id='btnClose']").click(function(){
//         $(this).parent().toggle();
//     });
    
//     $("#btnDeleteRow").click(function(){
//         var chkRowID = "";
//         $(".chkRow:checked").each(function(){
//             chkRowID += ($(this).attr("id")).replace("chkRow","") + ",";
//         });
//         chkRowID = chkRowID.substr(0,chkRowID.length - 1);
//         $.post("php/inbox.php",
//         {
//             request: "deleteRows",
//             "chkRowID": chkRowID
//         })
//         .done(function(data) {
//             updateInbox();
//             getRecientes();
//         });
//     });
    
//     $("#btnMoveToCancelado").click(function(){
//         var chkRowID = "";
//         $(".chkRow:checked").each(function(){
//             chkRowID += ($(this).attr("id")).replace("chkRow","") + ",";
//         });
//         chkRowID = chkRowID.substr(0,chkRowID.length - 1);
//         $.post("php/inbox.php",
//         {
//             request: "moveToCancelados",
//             "chkRowID": chkRowID
//         })
//         .done(function(data) {
//             updateInbox();
//             getRecientes();
//         });        
//     });
    
//     $("#btnMoveToEmitidas").click(function(){
//         var chkRowID = "";
//         $(".chkRow:checked").each(function(){
//             chkRowID += ($(this).attr("id")).replace("chkRow","") + ",";
//         });
//         chkRowID = chkRowID.substr(0,chkRowID.length - 1);
//         $.post("php/inbox.php",
//         {
//             request: "moveToEmitidas",
//             "chkRowID": chkRowID
//         })
//         .done(function(data) {
//             updateInbox();
//             getRecientes();
//         });        
//     });
    
//     $("#btnLoadComprasReportesConfigurables").click(function(){
//         getComprasFacturadasConfigurable();
//     });
    
//     $("#btnLoadReportesConfigurables").click(function(){
//         getVentasFacturadasConfigurable();
//     });
    
//     $("#btnLogout").click(function(){
//         logout();        
//     });
    
//     $("#btnAccounts").click(function(){
//         $("#boxAccounts").toggle();
//     });
    
//     $("#btnNotificaciones").click(function(){
//         $("#boxNotificaciones").toggle();
//     });
    
//     $("#btnFileUpload").click(function(){
//         $("#inputFileUpload").trigger("click");
//     });
    
//     $("#inputFileUpload").html5_upload({
//         url: "php/upload_file.php",
//         fieldName:"files[]",
//         sendBoundary: window.FormData || $.browser.mozilla,
//         onStart: function(event, total) {
//             stopSessionTimeout();
//             return true;
//         },
//         onStartOne: function(event, name, number, total){
//             name = name.toLowerCase();
//             if(name.indexOf(".xml") == -1)
//             {
//                 return alert(name + " no es un archivo XML.");
//             }
//             else
//             {
//                 return true;
//             }
//         },
//         onProgress: function(event, progress, name, number, total) {
//             //console.log(progress, number);
//         },
//         setName: function(text) {
//             $("#progress_report_name").text(text);
//         },
//         setStatus: function(text) {
//             $("#progress_report_status").text(text);
//         },
//         setProgress: function(val) {
//             $("#progress_report_bar").css('width', Math.ceil(val*100)+"%");
//         },
//         onFinishOne: function(event, response, name, number, total) {
//             console.log(response);
//             if(response != 0)
//             {
//                 alert("Error al procesar " + name);
//             }
//             else
//             {
//                 updateInbox();
//                 if(number == (total - 1))
//                 {
//                    resetSessionTimeout();
//                    getRecientes();
//                 }
//             }
//         },
//         onError: function(event, name, error) {
//             alert('Error al intentar subir el archivo ' + name);
//         }
//     });
    
//     $("#btnConfiguration").click(function(){
//         $("#mainView").empty();
//         var templateConfiguration = $("#templateConfiguration").clone(true);

//         $(templateConfiguration).find("#tabs").tabs({active:0});
        
//         $.post("php/inbox.php",
//         {
//             request: "getMyAccountConfigurationData"
//         })
//         .done(function(data) {
//             var json = JSON.parse(data);
//             var address = json[0].calle + " " + json[0].numero_exterior + " " + json[0].numero_interior + " " + json[0].colonia + " " + json[0].codigo_postal;
//             $(templateConfiguration).find('#configurationEmail').html(json[0].email);
// //            $(templateConfiguration).find('#configurationCommercialName').html(json[0].razon_social);
//             $(templateConfiguration).find('#configurationRazonSocial').html(json[0].razon_social);
//             $(templateConfiguration).find('#configurationRFC').html(json[0].rfc);
//             $(templateConfiguration).find('#configurationSociety').html("");
//             $(templateConfiguration).find('#configurationAddress').html(address);
//             $(templateConfiguration).find('#configurationPlanName').html(json[0].nombre_plan);
//             $(templateConfiguration).find("#configurationPlanRenew").html(json[0].fecha_termino);
//             $(templateConfiguration).find("#configurationPlanCost").html(json[0].costo_plan);
//             $(templateConfiguration).find("#configurationPlanCFDIs").html(json[0].plan_max_cfdis);
//         });
//         $("#mainView").append(templateConfiguration);
//     });
    
//     $("#btnChangePassword").click(function(){
//         var txtOldPassword = $("#txtOldPassword").val();
//         var txtNewPassword = $("#txtNewPassword").val();
//         var txtNewPasswordConfirm = $("#txtNewPasswordConfirm").val();
        
//         if(txtOldPassword === null || txtOldPassword === "" || txtOldPassword === " " || txtNewPassword === null || txtNewPassword === "" || txtNewPassword === " " || txtNewPasswordConfirm === null || txtNewPasswordConfirm === "" || txtNewPasswordConfirm === " ")
//         {
//             alert("Faltaron campos de llenar.");
//             return;
//         }
//         if(txtNewPassword != txtNewPasswordConfirm)
//         {
//             alert("Confirme la contraseña.");
//             return
//         }
                
//         $.post("php/inbox.php",
//         {
//             request: "changePassword",
//             "oldPassword": txtOldPassword,
//             "password": txtNewPassword
//         })
//         .done(function(data) {
//             $(txtOldPassword).val("");
//             $(txtNewPassword).val("");
//             $(txtNewPasswordConfirm).val("");
//         });        
        
//         $("#templateModalChangePassword").dialog("close");
//     });
    
//     $("#btnChangeEmail").click(function(){
//         var txtOldEmail = $("#txtOldEmail").val();
//         var txtNewEmail = $("#txtNewEmail").val();
//         var txtNewEmailConfirm = $("#txtNewEmailConfirm").val();
        
//         if(txtOldEmail === null || txtOldEmail === "" || txtOldEmail === " " || txtNewEmail === null || txtNewEmail === "" || txtNewEmail === " " || txtNewEmailConfirm === null || txtNewEmailConfirm === "" || txtNewEmailConfirm === " ")
//         {
//             alert("Faltaron campos de llenar.");
//             return;
//         }
//         if(txtNewEmail != txtNewEmailConfirm)
//         {
//             alert("Confirme el correo.");
//             return
//         }
                
//         $.post("php/inbox.php",
//         {
//             request: "changeEmail",
//             "oldEmail": txtOldEmail,
//             "email": txtNewEmail
//         })
//         .done(function(data) {
//             $(txtOldEmail).val("");
//             $(txtNewEmail).val("");
//             $(txtNewEmailConfirm).val("");
//         });        
        
//         $("#templateModalChangeEmail").dialog("close");
//     });
    
//     $("#configurationChangePassword").click(function(){
//         $("#templateModalChangePassword").dialog({
//             modal: true,
//             width: 780,
//             dialogClass: "modalNoBorder"
//         });
//     });
    
//     $("#configurationChangeEmail").click(function(){
//         $("#templateModalChangeEmail").dialog({
//             modal: true,
//             width: 780,
//             dialogClass: "modalNoBorder"
//         });
//     });
    
//     $("#txtDataZipCode").focusout(function() {
//         var zipCode = $("#txtDataZipCode").val();
        
//         if(zipCode.length == 5 && isNumber(zipCode))
//         {
//             $.post("php/planes.php",
//             {
//                 request: "verifyZipCode",
//                 "zipCode": zipCode
//             })
//             .done(function(data) {
//                 if (data === "-1")
//                 {
//                     alert("El código postal es inválido.");
//                 }
//                 else
//                 {
//                     var response = data.split(',');
//                     $("#txtDataMunicipio").val(response[0]);
//                     $("#txtDataState").val(response[2]);
//                     $("#txtDataColonia").val(response[3]);
//                     $("#txtDataCountry").val("México");
//                 }
//             })
//             .fail(function(data) {
//                 alert("Ocurrió un error. Vuelve a intentarlo o contacta al administrador para resolver tu problema.");
//             });
//         }
//     });
    
//     $("#configurationChangeDatosFiscales").click(function(){
//         $.post("php/inbox.php",
//         {
//             request: "getDatosFiscales"
//         })
//         .done(function(data) {
//             if(data == "-1")
//             {
//                 alert("Ocurrió un error al intentar guardar sus datos.");
//             }
//             else
//             {
//                 var json = JSON.parse(data);
//                 $("#txtDataRFC").val(json[0].rfc);
//                 $("#txtDataRFCConfirm").val(json[0].rfc);
//                 $("#txtDataSocial").val(json[0].razon_social);
//                 $("#txtDataFiscal").val(json[0].calle);
//                 $("#txtDataExterior").val(json[0].numero_interior);
//                 $("#txtDataInterior").val(json[0].numero_exterior);
//                 $("#txtDataColonia").val(json[0].colonia);
//                 $("#txtDataMunicipio").val(json[0].municipio);
//                 $("#txtDataZipCode").val(json[0].codigo_postal);
//                 $("#txtDataState").val(json[0].estado);
//                 $("#txtDataCountry").val(json[0].colonia);
//                 $("#txtDataLocalidad").val(json[0].localidad);
//                 $("#txtDataReferencia").val(json[0].referencia);

//                 $("#taxDataPanel").dialog({
//                     modal: true,
//                     width: 780,
//                     dialogClass: "taxDataPanel"
//                 });
//             }
            
//         });
//     });
    
//     $("#btnConfirmUpdateAccount").click(function() {
//         var rfc = $("#txtDataRFC").val();
//         var rfcConfirm = $("#txtDataRFCConfirm").val();
//         var razonSocial = $("#txtDataSocial").val();
//         var street = $("#txtDataFiscal").val();
//         var numberOut = $("#txtDataExterior").val();
//         var numberIn = $("#txtDataInterior").val();
//         var colonia = $("#txtDataColonia").val();
//         var municipio = $("#txtDataMunicipio").val();
//         var zipCode = $("#txtDataZipCode").val();
//         var state = $("#txtDataState").val();
//         var country = $("#txtDataCountry").val();
//         var localidad = $("#txtDataLocalidad").val();
//         var referencia = $("#txtDataReferencia").val();

//         if(rfc != rfcConfirm)
//         {
//             alert("Confirma tu RFC.");
//             return;
//         }
//         if (rfc === null || rfc === "" || rfc === " ")
//         {
//             alert("RFC no puede estar vacío.");
//             return;
//         }
//         if(rfc.length < 12 || rfc.length > 13)
//         {
//             alert(rfc + " no tiene 12 o 13 caracteres.");
//             return;

//         }
//         if (razonSocial === null || razonSocial === "" || razonSocial === " ")
//         {
//             alert("Razon social no puede estar vacía.");
//             return;
//         }
//         if (street === null || street === "" || street === " ")
//         {
//             alert("Domicilio Fiscal no puede estar vacía.");
//             return;
//         }
//         if (numberOut === null || numberOut === "" || numberOut === " ")
//         {
//             alert("Número exterior no puede estar vacío.");
//             return;
//         }
//         if (colonia === null || colonia === "" || colonia === " ")
//         {
//             alert("Colonia no puede estar vacía.");
//             return;
//         }
//         if (municipio === null || municipio === "" || municipio === " ")
//         {
//             alert("Municipio no puede estar vacío.");
//             return;
//         }
//         if (zipCode === null || zipCode === "" || zipCode === " " || zipCode.length != 5)
//         {
//             alert("Código Postal no puede estar vacío.");
//             return;
//         }
//         if (state === null || state === "" || state === " ")
//         {
//             alert("Estado no puede estar vacío.");
//             return;
//         }
//         if (country === null || country === "" || country === " ")
//         {
//             alert("País no puede estar vacío.");
//             return;
//         }

//         $.post("php/session_manager.php",
//         {
//             request: "checkUserSession"
//         })
//         .done(function(data) {
//             if(data == 0)
//             {
//                 alert("Sesión invalida. Vuelva a iniciar sesión.");
//                 //showLogin();
//             }
//             else if(data == 1)
//             {
//                 $.post("php/inbox.php",
//                 {
//                     request: "updateUserDatosFiscales",
//                     "rfc": rfc,
//                     "razonSocial": razonSocial,
//                     "street": street,
//                     "numberOut": numberOut,
//                     "numberIn": numberIn,
//                     "colonia": colonia,
//                     "municipio": municipio,
//                     "zipCode": zipCode,
//                     "state": state,
//                     "country": country,
//                     "localidad": localidad,
//                     "referencia": referencia
//                 })
//                 .done(function(data) {
//                     $("#taxDataPanel").dialog("close");
//                     if(data == "-1")
//                     {
//                         alert("Ocurrió un error al intentar guardar sus datos fiscales. Verifique que los datos estén correctos.");
//                     }
//                     else if(data == "0")
//                     {
//                         alert("Datos actualizados de manera exitosa.");
//                        //selectedRFC = rfc;                            
//                     }
//                 });                
//             }
//         });
//         $("#taxDataPanel").dialog("close");
//     });
// }

// function registerChkRowEvents(enableBtnBorrar, enableBtnCancelar, enableBtnMoveToEmitidas, enableBtnCalendar)
// {
//     $(".chkRow").change(function() {
//         var checked = $(this).is(":checked");
//         if(checked === true)
//         {
//             chkRowChecked++;
//         }
//         else
//         {
//             chkRowChecked--;
//         }
        
//         if(chkRowChecked > 0)
//         {
//             if(!$("#mainView>#rowEditMenu").length) //Does the element exist under main view?
//             {
//                 loadRowEditMenu(enableBtnBorrar, enableBtnCancelar, enableBtnMoveToEmitidas, enableBtnCalendar);
//             }
//         }
//         else
//         {
//             removeRowEditMenu();
//         }
//     }); 
// }
// function loadRowEditMenu(enableBtnBorrar, enableBtnCancelar, enableBtnMoveToEmitidas, enableBtnCalendar)
// {
//     var templateRowEditMenu = $("#rowEditMenu").clone(true);
//     if(enableBtnBorrar === true)
//     {
//         templateRowEditMenu.children("#btnDeleteRow").show();
//     }
//     else
//     {
//         templateRowEditMenu.children("#btnDeleteRow").hide();     
//     }
    
//     if(enableBtnCancelar === true)
//     {
//         $(templateRowEditMenu).children("#btnMoveToCancelado").show();
//     }
//     else
//     {
//         $(templateRowEditMenu).children("#btnMoveToCancelado").hide();        
//     }
    
//     if(enableBtnMoveToEmitidas === true)
//     {
//         $(templateRowEditMenu).children("#btnMoveToEmitidas").show();
//     }
//     else
//     {
//         $(templateRowEditMenu).children("#btnMoveToEmitidas").hide();
//     }
    
//     if(enableBtnCalendar === true)
//     {
//         $(templateRowEditMenu).children("#divCalendar").show();
//         $(templateRowEditMenu).children("#divCalendar").children("#btnCalendar").click(function(){
//             $(this).parent().children("#txtCalendar").datepicker("show");
//         });
//         $(templateRowEditMenu).children("#divCalendar").children("#txtCalendar").datepicker({
//             "dateFormat": "yy-mm-dd"
//         });
//         $(templateRowEditMenu).children("#divCalendar").children("#txtCalendar").change(function(){
//             var date = $(this).val();
//             var chkRowID = "";
            
//             $(".chkRow:checked").each(function(){
//                 chkRowID += ($(this).attr("id")).replace("chkRow","") + ",";
//             });
//             chkRowID = chkRowID.substr(0,chkRowID.length - 1);
            
//             $.post("php/inbox.php",
//             {
//                 request: "updateFechaEfectivaDePago",
//                 "date": date,
//                 "chkRowID": chkRowID
//             })
//             .done(function(data) {
//                 updateInbox();
//             }); 
            
//         });

//     }
//     else
//     {
//         $(templateRowEditMenu).children("#divCalendar").hide();
//     }
//     $("#mainView").prepend(templateRowEditMenu);
// }

// function removeRowEditMenu()
// {
//     $("#mainView>#rowEditMenu").remove();
// }

// function updateInbox()
// {
//     $.post("php/inbox.php",
//     {
//         request: "getCFDIsUsed"
//     })
//     .done(function(data) {
//         var json = JSON.parse(data);
//         $("#spanCFDIsUsed").text(json[0].usados + "/" + json[0].max_cfdis);
// //        console.log(json);
//     });
//     //
//     $.post("php/inbox.php",
//     {
//         request: "countComprobantesRecientes"
//     })
//     .done(function(data) {
//         $("#estRecientes").text(data);
//     });
//     //
//     $.post("php/inbox.php",
//     {
//         request: "countComprobantesValidados"
//     })
//     .done(function(data) {
//         $("#estValidados").text(data);
//     });
//     //
//     $.post("php/inbox.php",
//     {
//         request: "countComprobantesInvalidados"
//     })
//     .done(function(data) {
//         $("#estInvalidos").text(data);
//     });
//     //
//     $.post("php/inbox.php",
//     {
//         request: "countComprobantesCancelados"
//     })
//     .done(function(data) {
//         $("#estCancelados").text(data);
//     });
//     //
//     $.post("php/inbox.php",
//     {
//         request: "countComprobantesIncorrectos"
//     })
//     .done(function(data) {
//         $("#estDatosIncorrectos").text(data);
//     });
//     $.post("php/inbox.php",
//     {
//         request: "getEmitidas"
//     })
//     .done(function(data) {
//         json = JSON.parse(data);
//         var emisorData = "";
//         var emisorName = "";
//         for(var a = 0; a < json.length; ++a)
//         {
//             emisorName = json[a]["razon_social"];
//             emisorData += "<li><a onclick='getReceptorData(\"" + emisorName + "\");'>" + emisorName + "</a></li><li>&nbsp</li>";          
//         }
//         $("#listEmitidas").html(emisorData);
//         //console.log(json);
//     });
//     //
//     $.post("php/inbox.php",
//     {
//         request: "getRecibidas"
//     })
//     .done(function(data) {
//         json = JSON.parse(data);
//         var receptorData = "";
//         var receptorName = "";
//         for(var a = 0; a < json.length; ++a)
//         {
//             receptorName = json[a]["razon_social"];
//             receptorData += "<li><a onclick='getEmisorData(\"" + receptorName + "\");'>" + receptorName + "</a></li><li>&nbsp</li>";         
//         }
//         $("#listRecibidas").html(receptorData);
//         //console.log(json);
//     });
    
// }

// function buildTableData(columnsInArray, dataInJSON)
// {
//     var tblData = "<thead><tr>";
    
//     for(var a = 0; a < columnsInArray; ++a)
//     {
//         tblData += "<th>" + columnsInArray[a] + "</th>";                
//     }
//     tblData += "</tr></thead>";
//     tblData += "<tbody>";
    
//     for (var a = 0; a < dataInJSON.length; ++a)
//     {
//         var id = -1;
//         tblData += "<tr>";
// //             tblData += "<td>" + (a+1) + "</td>";
//         for (var row in dataInJSON[a])
//         {
//             if (row == "valido")
//             {
//                 if (dataInJSON[a][row] == 1)
//                 {
//                     tblData += "<td><img class='icon' src='img/pagina_inbox/EstatusFactura-OK.png'/></td>";
//                 }
//                 else if (dataInJSON[a][row] == 0)
//                 {
//                     tblData += "<td><img class='icon' src='img/pagina_inbox/EstatusFactura-pendiente.png'/></td>";
//                 }
//                 else if (dataInJSON[a][row] == -1)
//                 {
//                     tblData += "<td><img class='icon' src='img/pagina_inbox/EstatusFactura-Error.png'/></td>";
//                 }
//             }
//             else if (row == "verificada")
//             {
//                 if (dataInJSON[a][row] == 1)
//                 {
//                     tblData += "<td><img class='icon' src='img/pagina_inbox/EstatusFactura-OK.png'/></td>";
//                 }
//                 else if (dataInJSON[a][row] == 0)
//                 {
//                     tblData += "<td><img class='icon' src='img/pagina_inbox/EstatusFactura-pendiente.png'/></td>";
//                 }
//                 else if (dataInJSON[a][row] == -1)
//                 {
//                     tblData += "<td><img class='icon' src='img/pagina_inbox/EstatusFactura-Error.png'/></td>";
//                 }

//             }
//             else if (row == "id")
//             {
//                 id = dataInJSON[a][row];
//                 tblData += "<td><input id='chkRow" + dataInJSON[a][row] + "' class='chkRow' type='checkbox'/></td>";
//             }
//             else if (row == "nombre_xml")
//             {
//                 if (id != -1)
//                 {
//                     tblData += "<td><button onclick='onViewPDF(" + id + ")'>PDF</button></td>";
//                 }
//                 tblData += "<td><a href='php/request_xml.php?x=" + dataInJSON[a][row] + "'><img src='img/pagina_inbox/EstatusFactura-Download.png'/></td>";
//             }
//             else
//             {
//                 tblData += "<td>" + dataInJSON[a][row] + "</td>";
//             }
//         }
//         tblData += "</tr>"
//     }
//     tblData += "</tbody>";
    
//     return tblData;
// }

// /*
//  * 
//  * @param {type} tblData
//  * @param {[[column number,asc/desc]]} order  
//  * @param {type} enableBtnBorrar
//  * @param {type} enableBtnCancelar
//  * @param {type} enableBtnMoveToEmitidas
//  * @returns {nothing}
//  */
// function loadComprobantesTableWithMenu(tblData, order, enableBtnBorrar, enableBtnCancelar, enableBtnMoveToEmitidas, enableBtnCalendar)
// {
//     var templateComprobantes = $("#comprobantes").clone(true);
//     $(templateComprobantes).html(tblData);
//     $(templateComprobantes).attr("id","mainViewTableComprobantes");
//     $("#mainView").empty();
//     $("#mainView").append(templateComprobantes);
//     registerChkRowEvents(enableBtnBorrar, enableBtnCancelar, enableBtnMoveToEmitidas, enableBtnCalendar);
//     $("#mainViewTableComprobantes").DataTable({
//         paging: true,
//         searching: false,
//         "order": order,
//         "language": {
//             "info": "",
//             "lengthMenu": "Mostrar _MENU_ filas",
//             "infoEmpty": "",
//             "emptyTable": "No hay datos para esta tabla.",
//             "paginate":{
//                 "next": "Siguiente",
//                 "previous": "Anterior"
//             }
//         }
//     });
// }

// function loadComprobantesTable(tblData, order)
// {
//     var templateComprobantes = $("#comprobantes").clone(true);
//     $(templateComprobantes).html(tblData);
//     $(templateComprobantes).attr("id","mainViewTableComprobantes");
//     $("#mainView").empty();
//     $("#mainView").append(templateComprobantes);
//     registerChkRowEvents(false,false,false,false);
//     $("#mainViewTableComprobantes").DataTable({
//         paging: true,
//         searching: false,
//         "order": order,
//         "language": {
//             "info": "",
//             "lengthMenu": "Mostrar _MENU_ filas",
//             "infoEmpty": "",
//             "emptyTable": "No hay datos para esta tabla.",
//             "paginate":{
//                 "next": "Siguiente",
//                 "previous": "Anterior"
//             }
//         }
//     });
// }

// function loadReportesTable(tblData)
// {
//     var templateComprobantes = $("#comprobantes").clone(true);
//     $(templateComprobantes).html(tblData);
//     $(templateComprobantes).attr("id","mainViewTableComprobantes");
//     $("#mainView").empty();
//     $("#mainView").append(templateComprobantes);
//     $("#mainViewTableComprobantes").DataTable({
//         dom: 'T<"clear">lfrtip',
//         tableTools: {
//             "sSwfPath": "js/DataTables-1.10.0/extensions/TableTools/swf/copy_csv_xls_pdf.swf"
//         },
//         paging: false,
//         searching: false,
//         sort: false,
//         "language": {
//             "info": "",
//             "lengthMenu": "Mostrar _MENU_ filas",
//             "infoEmpty": "",
//             "emptyTable": "No hay datos para esta tabla.",
//             "paginate":{
//                 "next": "Siguiente",
//                 "previous": "Anterior"
//             }
//         }
//     });
// }

// function loadVentasConfigurablesMenu()
// {
//     var reportesVentasConfigurablesConfiguration = $("#reportesVentasConfigurablesConfiguration").clone(true);
//     $("#mainView").empty();
//     $("#mainView").append(reportesVentasConfigurablesConfiguration);  
// }

// function loadComprasConfigurablesMenu()
// {
//     var reportesComprasConfigurablesConfiguration = $("#reportesComprasConfigurablesConfiguration").clone(true);
//     $("#mainView").empty();
//     $("#mainView").append(reportesComprasConfigurablesConfiguration);     
// }

// function loadReportesConfigurablesTable(tblData)
// {
//     var templateComprobantes = $("#comprobantes").clone(true);
//     $(templateComprobantes).html(tblData);
//     $(templateComprobantes).attr("id","mainViewTableComprobantes");
//     $("#mainView").empty();
//     $("#mainView").append(templateComprobantes);
//     $("#mainViewTableComprobantes").DataTable({
//         dom: 'T<"clear">lfrtip',
//         tableTools: {
//             "sSwfPath": "js/DataTables-1.10.0/extensions/TableTools/swf/copy_csv_xls_pdf.swf"
//         },
//         paging: false,
//         searching: false,
//         sort: false,
//         "language": {
//             "info": "",
//             "lengthMenu": "Mostrar _MENU_ filas",
//             "infoEmpty": "",
//             "emptyTable": "No hay datos para esta tabla.",
//             "paginate":{
//                 "next": "Siguiente",
//                 "previous": "Anterior"
//             }
//         }
//     });
    
// }

// function onViewPDF(id)
// {
//     var emisorJSON;
//     var receptorJSON;
    
//     $.post("php/inbox.php",
//     {
//         request: "getFacturaEmisorAndReceptor",
//         "comprobanteID": id
//     })
//     .done(function(data) {
//         var json = JSON.parse(data);
//         emisorJSON = json[0];
//         receptorJSON = json[1];
        
    
//         $.post("php/inbox.php",
//         {
//             request: "getFactura",
//             "pdfID": id
//         })
//         .done(function(data) {
//             var json = JSON.parse(data);
//             var table = $("#templates>#tblComprobantePDF").clone(true);
//             var lblEmisorRazonSocial = table.find("#lblEmisorRazonSocial").text(json[0].emisor_datos_fiscales_razon_social);
//             var lblEmisorRFC = table.find("#lblEmisorRFC").text(emisorJSON.rfc);
//             var lblEmisorDireccion = table.find("#lblEmisorDireccion").text(emisorJSON.calle + " " + emisorJSON.numero_exterior + " " + emisorJSON.colonia);
//             var lblIDFactura = table.find("#lblIDFactura").text(json[0].folio);
//             var lblEmisorMunEstCP = table.find("#lblEmisorMunEstCP").text(emisorJSON.municipio + ", " + emisorJSON.estado + ", " + emisorJSON.codigo_postal);
//             var lblLugarExpedicion = table.find("#lblLugarExpedicion").text(json[0].lugar_expedicion);
//             var lblReceptorRazonSocial = table.find("#lblReceptorRazonSocial").text(json[0].receptor_datos_fiscales_razon_social);
//             var lblReceptorRFC = table.find("#lblReceptorRFC").text(receptorJSON.rfc);
//             var lblReceptorDireccion = table.find("#lblReceptorDireccion").text(receptorJSON.calle + " " + receptorJSON.numero_exterior + " " + receptorJSON.colonia);
//             var lblReceptorMunEstPais = table.find("#lblReceptorMunEstPais").text(receptorJSON.municipio + ", " + receptorJSON.estado + ", " + receptorJSON.codigo_postal);
//             var lblFolioSAT = table.find("#lblFolioSAT").text(json[0].uuid);
//             var lblFechaEmision = table.find("#lblFechaEmision").text(json[0].fecha_hora);
//             var lblCertificadoSAT = table.find("#lblCertificadoSAT").text(json[0].no_cert_sat);
//             var lblFechaCertificacion = table.find("#lblFechaCertificacion").text(json[0].fecha_timbrado);
//             var lblCertificadoEmisor = table.find("#lblCertificadoEmisor").text("");
//             var lblMetodoPago = table.find("#lblMetodoPago").text(json[0].metodo_pago);
//             var lblMoneda = table.find("#lblMoneda").text(json[0].moneda);
//             var lblTipoCambio = table.find("#lblTipoCambio").text(json[0].tipo_cambio);
//             var lblFormaPago = table.find("#lblFormaPago").text(json[0].forma_pago);
//             var lblCondicionesPago = table.find("#lblCondicionesPago").text(json[0].cond_pago);
//             var lblNoCuenta = table.find("#lblNoCuenta").text(json[0].num_cta_pago);
//             var lblSubtotal = table.find("#lblSubtotal").text(json[0].sub_total_original);
//             var lblDescuento = table.find("#lblDescuento").text(json[0].descuento);
//             var lblIVA = table.find("#lblIVA").text(json[0].total_imp_trasladado);
//             var lblTotal = table.find("#lblTotal").text(json[0].total_original);
//             var lblTimbreOriginal = table.find("#lblTimbreOriginal").text("");
//             var lblSelloEmisor = table.find("#lblSelloEmisor").text(json[0].sello_cfd);
//             var lblSelloSAT = table.find("#lblSelloSAT").text(json[0].sello_sat);
//             var trConceptos = table.find("#trConceptos");

//             $.post("php/inbox.php",
//             {
//                 request: "getConceptos",
//                 "comprobanteID": id
//             })
//             .done(function(data) {
//                 var json = JSON.parse(data);
//                 for(var a = 0; a < json.length; ++a)
//                 {
//                     var row = "<tr style='font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;overflow:hidden;word-break:normal'><td>" + json[a]['cantidad'] + "</td><td>" + json[a]['unidad'] + "</td><td>" + json[a]['no_identificacion'] + "</td><td>" + json[a]["descripcion"] + "</td><td>" + json[a]['valor_unitario'] + "</td><td>" + json[a]['importe'] + "</td></tr>";
//                     trConceptos.after(row);
//                 }
//                 $("#templateModalViewPDF").html(table)
//                 $("#templateModalViewPDF").dialog({
//                     modal: true,
//                     width: 1024,
//                     position: { my: "left center", at: "left center"},
//                     dialogClass: "modalPDF"
//                 });
//                 table.DataTable({
//                     dom: 'T<"clear">lfrtip',
//                     tableTools: {
//                         "aButtons":[
//                             "print"
//                         ],
//                         "sSwfPath": "js/DataTables-1.10.0/extensions/TableTools/swf/copy_csv_xls_pdf.swf"
//                     },
//                     paging: false,
//                     searching: false,
//                     sort: false,
//                     "language": {
//                         "info": "",
//                         "lengthMenu": "Mostrar _MENU_ filas",
//                         "infoEmpty": "",
//                         "emptyTable": "No hay datos para esta tabla.",
//                         "paginate":{
//                             "next": "Siguiente",
//                             "previous": "Anterior"
//                         }
//                     }
//                 });
//             });
//         });
//     });
    
// }

// function getRecientes()
// {
//     setThirdRootLink("Recientes");
//     $.post("php/inbox.php",
//     {
//         request: "getRecientes"
//     })
//     .done(function(data) {
//          json = JSON.parse(data);
//          tblData = "<thead><tr><th></th><th>FECHA EMISIÓN</th><th>EMISOR</th><th>FOLIO</th><th>MONTO SUBTOTAL</th><th>DESCUENTO</th><th>TOTAL IMPUESTOS TRASLADADOS</th><th>MONTO TOTAL</th><th>NO. CUENTA</th><th>VER</th><th>VAL</th><th>PDF</th><th>XML</th></tr></thead>";
//          tblData += "<tbody>";
//         for(var a = 0; a < json.length; ++a)
//          {
//             var id = -1;
//             tblData += "<tr>";
// //             tblData += "<td>" + (a+1) + "</td>";
//             for (var row in json[a])
//             {
//                 if (row == "valido")
//                 {
//                     if (json[a][row] == 1)
//                     {
//                         tblData += "<td><img class='icon' src='img/pagina_inbox/EstatusFactura-OK.png'/></td>";
//                     }
//                     else if (json[a][row] == 0)
//                     {
//                         tblData += "<td><img class='icon' src='img/pagina_inbox/EstatusFactura-pendiente.png'/></td>";
//                     }
//                     else if (json[a][row] == -1)
//                     {
//                         tblData += "<td><img class='icon' src='img/pagina_inbox/EstatusFactura-Error.png'/></td>";
//                     }
//                 }
//                 else if (row == "verificada")
//                 {
//                     if (json[a][row] == 1)
//                     {
//                         tblData += "<td><img class='icon' src='img/pagina_inbox/EstatusFactura-OK.png'/></td>";
//                     }
//                     else if (json[a][row] == 0)
//                     {
//                         tblData += "<td><img class='icon' src='img/pagina_inbox/EstatusFactura-pendiente.png'/></td>";
//                     }
//                     else if (json[a][row] == -1)
//                     {
//                         tblData += "<td><img class='icon' src='img/pagina_inbox/EstatusFactura-Error.png'/></td>";
//                     }

//                 }
//                 else if (row == "id")
//                 {
//                     id = json[a][row];
//                     tblData += "<td><input id='chkRow" + json[a][row] + "' class='chkRow' type='checkbox'/></td>";
//                 }
//                 else if(row == "nombre_xml")
//                 {
//                     if (id != -1)
//                     {
//                         tblData += "<td><button onclick='onViewPDF(" + id + ")'>PDF</button></td>";
//                     }
//                     tblData += "<td><a href='php/request_xml.php?x=" + json[a][row] + "'><img src='img/pagina_inbox/EstatusFactura-Download.png'/></td>";
//                 }
//                 else
//                 {
//                     tblData += "<td>" + json[a][row] + "</td>";
//                 }
//             }
//             tblData += "</tr>"
//          }
//          tblData += "</tbody>";
//          loadComprobantesTableWithMenu(tblData,[[1,"desc"]],true,false,false,false);
//     });
//     updateInbox();
// }

// function getValidados()
// {
//     setThirdRootLink("Validados");
//     $.post("php/inbox.php",
//     {
//         request: "getValidados"
//     })
//     .done(function(data) {
//          json = JSON.parse(data);
//          tblData = "<thead><tr><th>FECHA EMISIÓN</th><th>EMISOR</th><th>FOLIO</th><th>MONTO SUBTOTAL</th><th>DESCUENTO</th><th>TOTAL IMPUESTOS TRASLADADOS</th><th>MONTO TOTAL</th><th>NO. CUENTA</th><th>VER</th><th>VAL</th><th>PDF</th><th>XML</th></tr></thead>";
//          tblData += "<tbody>";
//          for(var a = 0; a < json.length; ++a)
//          {
//             var id = -1;
//             tblData += "<tr>";
// //             tblData += "<td>" + (a+1) + "</td>";
//             for (var row in json[a])
//             {
//                 if (row == "valido")
//                 {
//                     if (json[a][row] == 1)
//                     {
//                         tblData += "<td><img class='icon' src='img/pagina_inbox/EstatusFactura-OK.png'/></td>";
//                     }
//                     else if (json[a][row] == 0)
//                     {
//                         tblData += "<td><img src='img/pagina_inbox/EstatusFactura-pendiente.png'/></td>";
//                     }
//                     else if (json[a][row] == -1)
//                     {
//                         tblData += "<td><img src='img/pagina_inbox/EstatusFactura-Error.png'/></td>";
//                     }
//                 }
//                 else if (row == "verificada")
//                 {
//                     if (json[a][row] == 1)
//                     {
//                         tblData += "<td><img class='icon' src='img/pagina_inbox/EstatusFactura-OK.png'/></td>";
//                     }
//                     else if (json[a][row] == 0)
//                     {
//                         tblData += "<td><img src='img/pagina_inbox/EstatusFactura-pendiente.png'/></td>";
//                     }
//                     else if (json[a][row] == -1)
//                     {
//                         tblData += "<td><img src='img/pagina_inbox/EstatusFactura-Error.png'/></td>";
//                     }
//                 }
//                 else if (row == "id")
//                 {
//                     id = json[a][row];                
//                 }
//                 else if(row == "nombre_xml")
//                 {
//                     if (id != -1)
//                     {
//                         tblData += "<td><button onclick='onViewPDF(" + id + ")'>PDF</button></td>";
//                     }
//                     tblData += "<td><a href='php/request_xml.php?x=" + json[a][row] + "'><img src='img/pagina_inbox/EstatusFactura-Download.png'/></td>";
//                 }
//                 else
//                 {
//                     tblData += "<td>" + json[a][row] + "</td>";
//                 }
//             }
//             tblData += "</tr>"
//          }
//          tblData += "</tbody>";
//          loadComprobantesTable(tblData);
//     });    
// }

// function getInvalidos()
// {
//     setThirdRootLink("Invalidados");
//     $.post("php/inbox.php",
//     {
//         request: "getInvalidos"
//     })
//     .done(function(data) {
//          json = JSON.parse(data);
//          tblData = "<thead><tr><th>FECHA EMISIÓN</th><th>EMISOR</th><th>FOLIO</th><th>MONTO SUBTOTAL</th><th>DESCUENTO</th><th>TOTAL IMPUESTOS TRASLADADOS</th><th>MONTO TOTAL</th><th>NO. CUENTA</th><th>VER</th><th>VAL</th><th>PDF</th><th>XML</th></tr></thead>";
//          tblData += "<tbody>";
//          for(var a = 0; a < json.length; ++a)
//          {
//              var id = -1;
//             tblData += "<tr>";
// //             tblData += "<td>" + (a+1) + "</td>";
//             for (var row in json[a])
//             {
//                 if (row == "valido")
//                 {
//                     if (json[a][row] == 1)
//                     {
//                         tblData += "<td><img class='icon' src='img/pagina_inbox/EstatusFactura-OK.png'/></td>";
//                     }
//                     else if (json[a][row] == 0)
//                     {
//                         tblData += "<td><img src='img/pagina_inbox/EstatusFactura-pendiente.png'/></td>";
//                     }
//                     else if (json[a][row] == -1)
//                     {
//                         tblData += "<td><img src='img/pagina_inbox/EstatusFactura-Error.png'/></td>";
//                     }
//                 }
//                 else if (row == "verificada")
//                 {
//                     if (json[a][row] == 1)
//                     {
//                         tblData += "<td><img class='icon' src='img/pagina_inbox/EstatusFactura-OK.png'/></td>";
//                     }
//                     else if (json[a][row] == 0)
//                     {
//                         tblData += "<td><img src='img/pagina_inbox/EstatusFactura-pendiente.png'/></td>";
//                     }
//                     else if (json[a][row] == -1)
//                     {
//                         tblData += "<td><img src='img/pagina_inbox/EstatusFactura-Error.png'/></td>";
//                     }

//                 }
//                 else if (row == "id")
//                 {
//                     id = json[a][row];                
//                 }
//                 else if(row == "nombre_xml")
//                 {
//                     if (id != -1)
//                     {
//                         tblData += "<td><button onclick='onViewPDF(" + id + ")'>PDF</button></td>";
//                     }
//                     tblData += "<td><a href='php/request_xml.php?x=" + json[a][row] + "'><img src='img/pagina_inbox/EstatusFactura-Download.png'/></td>";
//                 }
//                 else
//                 {
//                     tblData += "<td>" + json[a][row] + "</td>";
//                 }
//             }
//             tblData += "</tr>"
//          }
//          tblData += "</tbody>";
//          loadComprobantesTable(tblData);
//     });    
// }

// function getDatosIncorrectos()
// {
//     setThirdRootLink("Datos Incorrectos");
//     $.post("php/inbox.php",
//     {
//         request: "getDatosIncorrectos"
//     })
//     .done(function(data) {
//          json = JSON.parse(data);
//          tblData = "<thead><tr><th>FECHA EMISIÓN</th><th>EMISOR</th><th>FOLIO</th><th>MONTO SUBTOTAL</th><th>DESCUENTO</th><th>TOTAL IMPUESTOS TRASLADADOS</th><th>MONTO TOTAL</th><th>NO. CUENTA</th><th>VER</th><th>VAL</th><th>PDF</th><th>XML</th></tr></thead>";
//          tblData += "<tbody>"; 
//          for(var a = 0; a < json.length; ++a)
//          {
//             var id = -1;
//             tblData += "<tr>";
// //             tblData += "<td>" + (a+1) + "</td>";
//             for (var row in json[a])
//             {
//                 if (row == "valido")
//                 {
//                     if (json[a][row] == 1)
//                     {
//                         tblData += "<td><img class='icon' src='img/pagina_inbox/EstatusFactura-OK.png'/></td>";
//                     }
//                     else if (json[a][row] == 0)
//                     {
//                         tblData += "<td><img src='img/pagina_inbox/EstatusFactura-pendiente.png'/></td>";
//                     }
//                     else if (json[a][row] == -1)
//                     {
//                         tblData += "<td><img src='img/pagina_inbox/EstatusFactura-Error.png'/></td>";
//                     }
//                 }
//                 else if (row == "verificada")
//                 {
//                     if (json[a][row] == 1)
//                     {
//                         tblData += "<td><img class='icon' src='img/pagina_inbox/EstatusFactura-OK.png'/></td>";
//                     }
//                     else if (json[a][row] == 0)
//                     {
//                         tblData += "<td><img src='img/pagina_inbox/EstatusFactura-pendiente.png'/></td>";
//                     }
//                     else if (json[a][row] == -1)
//                     {
//                         tblData += "<td><img src='img/pagina_inbox/EstatusFactura-Error.png'/></td>";
//                     }
//                 }
//                 else if (row == "id")
//                 {
//                     id = json[a][row];                
//                 }
//                 else if(row == "nombre_xml")
//                 {
//                     if (id != -1)
//                     {
//                         tblData += "<td><button onclick='onViewPDF(" + id + ")'>PDF</button></td>";
//                     }
//                     tblData += "<td><a href='php/request_xml.php?x=" + json[a][row] + "'><img src='img/pagina_inbox/EstatusFactura-Download.png'/></td>";
//                 }
//                 else
//                 {
//                     tblData += "<td>" + json[a][row] + "</td>";
//                 }
//             }
//             tblData += "</tr>"
//          }
//          tblData += "</tbody>";
//          loadComprobantesTable(tblData);
//     });    
// }

// function getCancelados()
// {
//     setThirdRootLink("Cancelados");
//     $.post("php/inbox.php",
//     {
//         request: "getCancelados"
//     })
//     .done(function(data) {
//          json = JSON.parse(data);
//          tblData = "<thead><tr><th></th><th>FECHA EMISIÓN</th><th>CLIENTE</th><th>FOLIO</th><th>MONTO SUBTOTAL</th><th>DESCUENTO</th><th>TOTAL IMPUESTOS TRASLADADOS</th><th>MONTO TOTAL</th><th>NO. CUENTA</th><th>VER</th><th>VAL</th><th>XML</th></tr></thead>";
//          tblData += "<tbody>"; 
//          for(var a = 0; a < json.length; ++a)
//          {
//             tblData += "<tr>";
// //             tblData += "<td>" + (a+1) + "</td>";
//             for (var row in json[a])
//             {
//                 if (row == "valido")
//                 {
//                     if (json[a][row] == 1)
//                     {
//                         tblData += "<td><img class='icon' src='img/pagina_inbox/EstatusFactura-OK.png'/></td>";
//                     }
//                     else if (json[a][row] == 0)
//                     {
//                         tblData += "<td><img src='img/pagina_inbox/EstatusFactura-pendiente.png'/></td>";
//                     }
//                     else if (json[a][row] == -1)
//                     {
//                         tblData += "<td><img src='img/pagina_inbox/EstatusFactura-Error.png'/></td>";
//                     }
//                 }
//                 else if (row == "verificada")
//                 {
//                     if (json[a][row] == 1)
//                     {
//                         tblData += "<td><img class='icon' src='img/pagina_inbox/EstatusFactura-OK.png'/></td>";
//                     }
//                     else if (json[a][row] == 0)
//                     {
//                         tblData += "<td><img src='img/pagina_inbox/EstatusFactura-pendiente.png'/></td>";
//                     }
//                     else if (json[a][row] == -1)
//                     {
//                         tblData += "<td><img src='img/pagina_inbox/EstatusFactura-Error.png'/></td>";
//                     }
//                 }
//                 else if (row == "id")
//                 {
//                     tblData += "<td><input id='chkRow" + json[a][row] + "' class='chkRow' type='checkbox'/></td>";
//                 }
//                 else if(row == "nombre_xml")
//                 {
//                     tblData += "<td><a href='php/request_xml.php?x=" + json[a][row] + "'><img src='img/pagina_inbox/EstatusFactura-Download.png'/></td>";
//                 }
//                 else
//                 {
//                     tblData += "<td>" + json[a][row] + "</td>";
//                 }
//             }
//             tblData += "</tr>"
//          }
//          tblData += "</tbody>";
//          loadComprobantesTableWithMenu(tblData,[],false,false,true,false);
//     });    
// }

// function getEmisorData(emisorName)
// {
//     setThirdRootLink(emisorName);
//     $.post("php/inbox.php",
//     {
//         request: "getComprobanteBasedOnEmisor",
//         causanteName: emisorName
//     })
//     .done(function(data) {
//          json = JSON.parse(data);
//          tblData = "<thead><tr><th></th><th>FECHA EMISIÓN</th><th>PROVEEDOR</th><th>FOLIO</th><th>MONTO SUBTOTAL</th><th>DESCUENTO</th><th>TOTAL IMPUESTOS TRASLADADOS</th><th>MONTO TOTAL</th><th>NO. CUENTA</th><th>FECHA PAGADA</th><th>VER</th><th>VAL</th><th>PDF</th><th>XML</th></tr></thead>";
//         tblData += "<tbody>"; 
//         for(var a = 0; a < json.length; ++a)
//          {
//             var id = -1;
//             tblData += "<tr>";
//             for (var row in json[a])
//             {
//                 if (row == "valido")
//                 {
//                     if (json[a][row] == 1)
//                     {
//                         tblData += "<td><img class='icon' src='img/pagina_inbox/EstatusFactura-OK.png'/></td>";
//                     }
//                     else if (json[a][row] == 0)
//                     {
//                         tblData += "<td><img src='img/pagina_inbox/EstatusFactura-pendiente.png'/></td>";
//                     }
//                     else if (json[a][row] == -1)
//                     {
//                         tblData += "<td><img src='img/pagina_inbox/EstatusFactura-Error.png'/></td>";
//                     }
//                 }
//                 else if (row == "verificada")
//                 {
//                     if (json[a][row] == 1)
//                     {
//                         tblData += "<td><img class='icon' src='img/pagina_inbox/EstatusFactura-OK.png'/></td>";
//                     }
//                     else if (json[a][row] == 0)
//                     {
//                         tblData += "<td><img src='img/pagina_inbox/EstatusFactura-pendiente.png'/></td>";
//                     }
//                     else if (json[a][row] == -1)
//                     {
//                         tblData += "<td><img src='img/pagina_inbox/EstatusFactura-Error.png'/></td>";
//                     }
//                 }
//                 else if (row == "id")
//                 {
//                     id = json[a][row];
//                     tblData += "<td><input id='chkRow" + json[a][row] + "' class='chkRow' type='checkbox'/></td>";
//                 }
//                 else if(row == "nombre_xml")
//                 {
//                     if (id != -1)
//                     {
//                         tblData += "<td><button onclick='onViewPDF(" + id + ")'>PDF</button></td>";
//                     }
//                     tblData += "<td><a href='php/request_xml.php?x=" + json[a][row] + "'><img src='img/pagina_inbox/EstatusFactura-Download.png'/></td>";
//                 }
//                 else
//                 {
//                     tblData += "<td>" + json[a][row] + "</td>";
//                 }
//             }
//             tblData += "</tr>"
//          }
//          tblData += "</tbody>";
//          loadComprobantesTableWithMenu(tblData,[[1,"desc"]],true,false,false,true);
//     });  
// }

// function getReceptorData(receptorName)
// {
//     setThirdRootLink(receptorName);
//     $.post("php/inbox.php",
//     {
//         request: "getComprobanteBasedOnReceptor",
//         causanteName: receptorName
//     })
//             .done(function(data) {
//                 json = JSON.parse(data);
//                 tblData = "<thead><<tr><th></th><th>FECHA EMISIÓN</th><th>CLIENTE</th><th>FOLIO</th><th>MONTO SUBTOTAL</th><th>DESCUENTO</th><th>TOTAL IMPUESTOS TRASLADADOS</th><th>MONTO TOTAL</th><th>NO. CUENTA</th><th>FECHA PAGADA</th><th>VER</th><th>VAL</th><th>PDF</th><th>XML</th></tr></thead>";
//                 tblData += "<tbody>";
//                 for (var a = 0; a < json.length; ++a)
//                 {
//                     var id = -1;
//                     tblData += "<tr>";
//                     for (var row in json[a])
//                     {
//                         if (row == "valido")
//                         {
//                             if (json[a][row] == 1)
//                             {
//                                 tblData += "<td><img class='icon' src='img/pagina_inbox/EstatusFactura-OK.png'/></td>";
//                             }
//                             else if (json[a][row] == 0)
//                             {
//                                 tblData += "<td><img src='img/pagina_inbox/EstatusFactura-pendiente.png'/></td>";
//                             }
//                             else if (json[a][row] == -1)
//                             {
//                                 tblData += "<td><img src='img/pagina_inbox/EstatusFactura-Error.png'/></td>";
//                             }
//                         }
//                         else if (row == "verificada")
//                         {
//                             if (json[a][row] == 1)
//                             {
//                                 tblData += "<td><img class='icon' src='img/pagina_inbox/EstatusFactura-OK.png'/></td>";
//                             }
//                             else if (json[a][row] == 0)
//                             {
//                                 tblData += "<td><img src='img/pagina_inbox/EstatusFactura-pendiente.png'/></td>";
//                             }
//                             else if (json[a][row] == -1)
//                             {
//                                 tblData += "<td><img src='img/pagina_inbox/EstatusFactura-Error.png'/></td>";
//                             }
//                         }
//                         else if (row == "id")
//                         {
//                             id = json[a][row];
//                             tblData += "<td><input id='chkRow" + json[a][row] + "' class='chkRow' type='checkbox'/></td>";
//                         }
//                         else if (row == "nombre_xml")
//                         {
//                             if (id != -1)
//                             {
//                                 tblData += "<td><button onclick='onViewPDF(" + id + ")'>PDF</button></td>";
//                             }
//                             tblData += "<td><a href='php/request_xml.php?x=" + json[a][row] + "'><img src='img/pagina_inbox/EstatusFactura-Download.png'/></td>";
//                         }
//                         else
//                         {
//                             tblData += "<td>" + json[a][row] + "</td>";
//                         }
//                     }
//                     tblData += "</tr>"
//                 }
//                 tblData += "</tbody>";
//                 loadComprobantesTableWithMenu(tblData, [[1, "desc"]], false, true, false, true);
//             });
// }

// function setFirstRootLink()
// {    
//     $.post("php/session_manager.php",
//     {
//         request: "getSessionUsername"
//     })
//     .done(function(data) {
//         $("#firstRootLink").html(data);
//         setSecondRootLink("");
//         setThirdRootLink("");
//     });
    
// }

// function setSecondRootLink(linkName)
// {
// //    $("#secondRootLink").html(linkName);
// //    setThirdRootLink("");
// }

// function setThirdRootLink(linkName)
// {
// //    $("#thirdRootLink").html(linkName);
// }

// function loadAccounts()
// {
//     $.post("php/inbox.php",
//     {
//         request: "getAllAccounts"
//     })
//     .done(function(data) {
//         var json = JSON.parse(data);
//         var razonSocial = "";
//         var rfc = "";
//         var newHTML = "";
        
//         for(var a = 0; a < json.length; ++a)
//         {
//             razonSocial = json[a]["razon_social"];
//             rfc = json[a]["rfc"];
//             newHTML += "<tr class='trAccountData' onclick=\"switchTo(\'" + rfc + "\')\">";
//                 newHTML += "<td>";
//                     newHTML += "<div>"
//                         newHTML += "<table>";
//                             newHTML += "<tr>";
//                                 newHTML += "<td>";
//                                 newHTML += razonSocial;
//                                 newHTML += "</td>";
//                             newHTML += "</tr>";
//                                 newHTML += "<tr>";
//                                 newHTML += "<td>";
//                                 newHTML += rfc;
//                                 newHTML += "</td>";
//                             newHTML += "</tr>";
//                         newHTML += "</table>";
//                     newHTML += "</div>";
//                 newHTML += "</td>";
//             newHTML += "</tr>";
//         }
//         $("#accountsArea").html(newHTML);
//     });
    
// }

// function switchTo(rfc)
// {
//     $.post("php/inbox.php",
//     {
//         request: "switchToAccount",
//         "rfc": rfc
//     })
//     .done(function(data) {
//         if(data == 0)
//         {
//             window.location = 'inbox.php';
//         }
//     });    
// }

// function loadNotificaciones()
// {
//     $.post("php/inbox.php",
//     {
//         request: "getAllNotifications"
//     })
//     .done(function(data) {
//         if(data.length > 0)
//         {
//             var json = JSON.parse(data);
//             var date = 0;
//             var icon = 0;
//             var paragraph = "";
            
//             for(var a = 0; a < json.length; ++a)
//             {
//                 paragraph = json[a]["mensaje"];
//                 date = json[a]["fecha"];
//                 icon = json[a]["importancia"];
//                 var template = $("#templates>#templateNotificacion").clone(true).show();
//                 //$(template).find("#notificacionIcon");
//                 $(template).find("#notificacionDate").text(date);
//                 $(template).find("#message").text(paragraph);
//                 $("#displayNotificaciones").append("<tr><td>" + $(template).html() + "</td></tr>");
//             }
//         }
//         else
//         {
            
//         }
//     });
// }

// function loadSubscriptionPanel()
// {
//     $.post("php/inbox.php",
//     {
//         request: "getPlanesDescripcion"
//     })
//     .done(function(data) {
//         var json = JSON.parse(data);
//         var id = "";
//         var nombre = "";
//         var maxCFDIs = "";
//         var costo = "";
//         var opt = "";
//         //$("#selectPlanes").empty();
        
//         for(var a = 0; a < json.length; ++a)
//         {
//             id = json[a]['id'];
//             nombre = json[a]['nombre'];
//             opt = "<option value='plan" + id + "'>" + nombre + "</option>";
//             $("#selectPlanes").append(opt);
//         }
//     });
    
//     $("#selectPlanes").change(function(){
//         var optPlan = $("#selectPlanes option:selected").val().replace("plan","");
        
//         $.post("php/inbox.php",
//         {
//             request: "getPlanesDetails",
//             "plan":optPlan
//         })
//         .done(function(data) {
//             var json = JSON.parse(data);
//             var maxCFDIs = json[0]['max_cfdis'];
//             var costo = json[0]['costo'];
//             $("#lblMaxCFDIs").html(maxCFDIs);
//             $("#lblCosto").html(costo);
    
//         });
//     });
// }

// function loadBuyCFDIs()
// {
//     $.post("php/inbox.php",
//     {
//         request: "getAvailableExtraCFDIs",
//     })
//     .done(function(data) {
//         var json = JSON.parse(data);

//         for(var a = 0; a < json.length; ++a)
//         {
//             $("#selectBuyCFDIsAvailable").append("<option>" + json[a]["cfdis"] + "</option>");
//         }
//         $("#lblBuyCFDIsTotal").text(json[0]["costo"]);
//     });
// }

// function loadCuentasPorCobrar()
// {
//     $.post("php/inbox.php",
//     {
//         request: "getCuentasPorCobrar"
//     })
//     .done(function(data) {
//         json = JSON.parse(data);
//         var emisorData = "";
//         var emisorName = "";
//         var diaDelMes = "";
//         var id = -1;
        
//         for(var a = 0; a < json.length; ++a)
//         {
//             var selectCuentasPorCobrar = $("#templateSelectCuentasPorCobrar").clone(true);
//             emisorName = json[a]["razon_social"];
//             diaDelMes = json[a]["dia_del_mes"];
//             id = json[a]["id"];
//             emisorData += "<tr>";
//             emisorData += "<td>" + emisorName + "</td>";
//             //Select the correct option in the select box.
//             $(selectCuentasPorCobrar).children().filter(function(){
//                 return $(this).text() == diaDelMes;
//             }).attr("selected","selected");
//             emisorData += "<td><select id='selectCuentasPorCobrar" + id + "'>" + $(selectCuentasPorCobrar).html() + "</select>";
//             emisorData += "</td>";
//             emisorData += "</tr>";
//             emisorData += "<tr><td></td><td></td></tr>";
//             emisorData += "<tr><td></td><td></td></tr>";                          
//         }
                
//         $("#tabCuentasPorCobrar>tbody").html(emisorData);
//         //Register the change event for the select boxes.
//         $("select[id*='selectCuentasPorCobrar']").change(function(){
//             var id = $(this).attr("id").toString().replace("selectCuentasPorCobrar","");
//             $("#templateModalDatePicker").dialog({
//                 modal: true,
//                 width: 400,
//                 buttons:{
//                     "Aceptar": function(){
//                         var date = $("#txtCuentasDatePicker").val();
//                         var selectID = id;
//                         var selectedOption = $("option:selected","#selectCuentasPorCobrar" + id).val();
                        
//                         $.post("php/inbox.php",
//                         {
//                             request: "updateCuentasPorCobrar",
//                             "selectID": selectID,
//                             "value": selectedOption,
//                             "date": date
//                         })
//                         .done(function(data) {
//                             loadCuentasPorCobrar();
//                         });
//                         $("#txtCuentasDatePicker").val("");
//                         $(this).dialog("close");
//                     }
//                 }
//             });
//         });
//     });        
// }

// function loadCuentasPorPagar()
// {
//     $.post("php/inbox.php",
//     {
//         request: "getCuentasPorPagar"
//     })
//     .done(function(data) {
//         json = JSON.parse(data);
//         var receptorData = "";
//         var receptorName = "";
//         var diaDelMes = "";
//         var id = -1;
        
//         for(var a = 0; a < json.length; ++a)
//         {
//             var selectCuentasPorPagar = $("#templateSelectCuentasPorCobrar").clone(true);
//             receptorName = json[a]["razon_social"];
//             diaDelMes = json[a]["dia_del_mes"];
//             id = json[a]["id"];
//             receptorData += "<tr>";
//             receptorData += "<td>" + receptorName + "</td>";
//             //Select the correct option in the select box.
//             $(selectCuentasPorPagar).children().filter(function(){
//                 return $(this).text() == diaDelMes;
//             }).attr("selected","selected");
//             receptorData += "<td><select id='selectCuentasPorPagar" + id + "'>" + $(selectCuentasPorPagar).html() + "</select>";
//             receptorData += "</td>";
//             receptorData += "</tr>";
//             receptorData += "<tr><td></td><td></td></tr>";
//             receptorData += "<tr><td></td><td></td></tr>";                          
//         }
//         $("#tabCuentasPorPagar>tbody").html(receptorData);
//         //Register the change event for the select boxes.
//         $("select[id*='selectCuentasPorPagar']").change(function(){
//             var id = $(this).attr("id").toString().replace("selectCuentasPorPagar","");
//             $("#templateModalDatePicker").dialog({
//                 modal: true,
//                 width: 400,
//                 buttons:{
//                     "Aceptar": function(){
//                         var date = $("#txtCuentasDatePicker").val();
//                         var selectID = id;
//                         var selectedOption = $("option:selected","#selectCuentasPorPagar" + id).val();
                        
//                         $.post("php/inbox.php",
//                         {
//                             request: "updateCuentasPorPagar",
//                             "selectID": selectID,
//                             "value": selectedOption,
//                             "date": date
//                         })
//                         .done(function(data) {
//                             loadCuentasPorPagar();
//                         });
//                         $("#txtCuentasDatePicker").val("");
//                         $(this).dialog("close");
//                     }
//                 }
//             });
//         });
//     });        
// }

// /*
 
//             emisorData += "<input style='display:none;' id='txtCuentasPorCobrarCalendar" + id + "' placeholder='AA-MM-DD' type='text'/>";
//             emisorData += "</td>";
//             emisorData += "</tr>";
//             emisorData += "<tr><td></td><td></td></tr>";
//             emisorData += "<tr><td></td><td></td></tr>";                          
//         }
                
//         $("#tabCuentasPorCobrar>tbody").html(emisorData);
//         //Register the change event for the select boxes.
//         $("select[id*='selectCuentasPorCobrar']").change(function(){
//             var id = $(this).attr("id").toString().replace("selectCuentasPorPagar","");
//             $("#templateModalDatePicker").dialog({
//                 modal: true,
//                 width: 400,
//                 buttons:{
//                     "Aceptar": function(){
//                         var date = $("#txtCuentasDatePicker").val();
//                         $("#txtCuentasPorPagarCalendar" + id).val(date);
//                         $("#txtCuentasPorPagarCalendar" + id).show();
//                         var selectID = ($(this).attr("id")).replace("selectCuentasPorPagar","");
//                         var selectedOption = $("option:selected","#selectCuentasPorPagar" + id).val();
                        
//                         $.post("php/inbox.php",
//                         {
//                             request: "updateCuentasPorPagar",
//                             "selectID": selectID,
//                             "value": selectedOption,
//                             "date": date
//                         })
//                         .done(function(data) {
//                             loadCuentasPorCobrar();
//                         });
//                         $(this).dialog("close");
//                     }
//                 }
//             });
//         });
//  */
// function getComprasFacturadasConfigurable()
// { 
//     var sMes = $("#selectReportesComprasMes option:selected").val();
//     var week = $("#selectReportesComprasSemana option:selected").val();
//     var title = "";
//     var iMes = getMonthFromSpanishToNumber(sMes);
    
//     if(week.length == 0 || week == " ")
//     {
//         week = 0;
//     }
    
//     title = "COMPRAS DEL MES DE " + sMes.toUpperCase();
//     if(week > 0)
//     {
//         title += " SEMANA " + week;        
//     }
    
//     $.post("php/inbox.php",
//     {
//         request: "getComprasFacturadasConfigurable",
//         "mes": iMes,
//         "week": week
//     })
//     .done(function(data) {
//         var json = JSON.parse(data);
//         var tblData = "<thead><tr><th>" + title + "</th><th>PROVEEDOR</th><th>FACTURA</th><th>MONTO SUBTOTAL</th><th>TOTAL IMPUESTOS TRASLADADOS</th><th>MONTO TOTAL</th></tr></thead>";
//         tblData += "<tbody>";
//         for(var a = 0; a < json.length; ++a)
//          {
//             if(json[a]['Total'] == "Total")
//             {
//                 tblData += "<tr style='color:red; border-bottom: 1px solid black;'>";
//             }
//             else if(json[a]['Total'] == "Subtotal")
//             {
//                 tblData += "<tr style='color:blue; border-bottom: 1px solid black;'>";
//             }
//             else
//             {
//                 tblData += "<tr>";
//             }
// //             tblData += "<td>" + (a+1) + "</td>";
//             for (var row in json[a])
//             {
//                 if(json[a][row] == "C")
//                 {
//                     json[a][row] = "";
//                 }
//                 else if(json[a][row] == "F")
//                 {
//                     json[a][row] = "";
//                 }
//                 else if(json[a][row] == null)
//                 {
//                     json[a][row] = "0";
//                 }
//                 tblData += "<td style='color:inherit; border-bottom: 1px solid black;'>" + json[a][row] + "</td>";
//             }
//             tblData += "</tr>";
//          }
//          tblData += "</tbody>";
//          loadComprasConfigurablesMenu();
//          loadReportesConfigurablesTable(tblData);        
//     });
// }

// function getVentasFacturadasConfigurable()
// {
//     var sMes = $("#selectReportesMes option:selected").val();
//     var week = $("#selectReportesSemana option:selected").val();
//     var iMes = getMonthFromSpanishToNumber(sMes);
//     var title = "";
    
//     if(week.length == 0 || week == " ")
//     {
//         week = 0;
//     }
    
//     title = "VENTAS DEL MES DE " + sMes.toUpperCase();
//     if(week > 0)
//     {
//         title += " SEMANA " + week;        
//     }
    
//     $.post("php/inbox.php",
//     {
//         request: "getVentasFacturadasConfigurable",
//         "mes": iMes,
//         "week": week
//     })
//     .done(function(data) {
//         var json = JSON.parse(data);
//         var tblData = "<thead><tr><th>" + title + "</th><th>CLIENTE</th><th>FACTURA</th><th>MONTO SUBTOTAL</th><th>TOTAL IMPUESTOS TRASLADADOS</th><th>MONTO TOTAL</th></tr></thead>";
//         tblData += "<tbody>"; 
//         for(var a = 0; a < json.length; ++a)
//          {
//             if(json[a]['Total'] == "Total")
//             {
//                 tblData += "<tr style='color:red; border-bottom: 1px solid black;'>";
//             }
//             else if(json[a]['Total'] == "Subtotal")
//             {
//                 tblData += "<tr style='color:blue; border-bottom: 1px solid black;'>";
//             }
//             else
//             {
//                 tblData += "<tr>";
//             }
// //             tblData += "<td>" + (a+1) + "</td>";
//             for (var row in json[a])
//             {
//                 if(json[a][row] == "C")
//                 {
//                     json[a][row] = "";
//                 }
//                 else if(json[a][row] == "F")
//                 {
//                     json[a][row] = "";
//                 }
//                 else if(json[a][row] == null)
//                 {
//                     json[a][row] = "0";
//                 }
//                 tblData += "<td style='color:inherit; border-bottom: 1px solid black;'>" + json[a][row] + "</td>";
//             }
//             tblData += "</tr>";
//          }
//          tblData += "</tbody>";
//          loadVentasConfigurablesMenu();
//          loadReportesConfigurablesTable(tblData);        
//     });    
// }

// function getVentasFacturadasMes()
// {        
//     $.post("php/inbox.php",
//     {
//         request: "getVentasMesFacturadas"
//     })
//     .done(function(data) {
//         if(data.indexOf("{") != -1)
//         {
//             var json = JSON.parse(data);
//             var tblData = "<thead><tr><th>VENTAS DEL MES DE " + getMonthInSpanish().toUpperCase() + " " + (new Date()).getFullYear() + "</th><th>CLIENTE</th><th>MONTO SUBTOTAL</th><th>TOTAL IMPUESTOS TRASLADADOS</th><th>MONTO TOTAL</th></tr></thead>";
//             tblData += "<tbody>"; 
//             for(var a = 0; a < json.length; ++a)
//              {
//                 if(json[a]['Total'] == "Total")
//                 {
//                     tblData += "<tr style='color:red; border-bottom: 1px solid black;'>";
//                 }
//                 else if(json[a]['Total'] == "Subtotal")
//                 {
//                     tblData += "<tr style='color:blue; border-bottom: 1px solid black;'>";
//                 }
//                 else
//                 {
//                     tblData += "<tr>";
//                 }
//     //             tblData += "<td>" + (a+1) + "</td>";
//                 for (var row in json[a])
//                 {
//                     if(json[a][row] == null)
//                     {
//                         json[a][row] = "0";
//                     }
//                     tblData += "<td style='color:inherit; border-bottom: 1px solid black;'>" + json[a][row] + "</td>";
//                 }
//                 tblData += "</tr>"
//              }
//              tblData += "</tbody>";
//              loadReportesTable(tblData);        
//         }
//         else
//         {
//             var tblData = "<thead><tr><th></th></tr></thead><tbody></tbody>";
//              loadReportesTable(tblData);
//         }
//     });
    
// }

// function getVentasFacturadasAcumuladas()
// {        
//     $.post("php/inbox.php",
//     {
//         request: "getVentasAcumuladasFacturadas"
//     })
//     .done(function(data) {
//         var json = JSON.parse(data);
//         var tblData = "<thead><tr><th>VENTAS ACUMULADAS " + (new Date()).getFullYear() + " </th><th>Periodo</th><th>MONTO SUBTOTAL</th><th>TOTAL IMPUESTOS TRASLADADOS</th><th>MONTO TOTAL</th></tr></thead>";
//         tblData += "<tbody>"; 
//         for(var a = 0; a < json.length; ++a)
//          {
//             if(json[a]['Total'] == "Total")
//             {
//                 tblData += "<tr style='color:red; border-bottom: 1px solid black;'>";
//             }
//             else if(json[a]['Total'] == "Subtotal")
//             {
//                 tblData += "<tr style='color:blue; border-bottom: 1px solid black;'>";
//             }
//             else
//             {
//                 tblData += "<tr>";
//             }
// //             tblData += "<td>" + (a+1) + "</td>";
//             for (var row in json[a])
//             {
//                 if(json[a][row] == "1")
//                 {
//                     json[a][row] = "Enero";
//                 }
//                 else if(json[a][row] == "2")
//                 {
//                     json[a][row] = "Febrero";
//                 }
//                 else if(json[a][row] == "3")
//                 {
//                     json[a][row] = "Marzo";
//                 }
//                 else if(json[a][row] == "4")
//                 {
//                     json[a][row] = "Abril";
//                 }
//                 else if(json[a][row] == "5")
//                 {
//                     json[a][row] = "Mayo";
//                 }
//                 else if(json[a][row] == "6")
//                 {
//                     json[a][row] = "Junio";
//                 }
//                 else if(json[a][row] == "7")
//                 {
//                     json[a][row] = "Julio";
//                 }
//                 else if(json[a][row] == "8")
//                 {
//                     json[a][row] = "Agosto";
//                 }
//                 else if(json[a][row] == "9")
//                 {
//                     json[a][row] = "Septiembre";
//                 }
//                 else if(json[a][row] == "10")
//                 {
//                     json[a][row] = "Octubre";
//                 }
//                 else if(json[a][row] == "11")
//                 {
//                     json[a][row] = "Noviembre";
//                 }
//                 else if(json[a][row] == "12")
//                 {
//                     json[a][row] = "Diciembre";
//                 }
//                 else if(json[a][row] == null)
//                 {
//                     json[a][row] = "0";
//                 }
//                 tblData += "<td style='color:inherit; border-bottom: 1px solid black;'>" + json[a][row] + "</td>";
//             }
//             tblData += "</tr>"
//          }
//          tblData += "</tbody>";
//          loadReportesTable(tblData);
        
//     });   
// }

// function getComprasFacturadasMes()
// {
//     $.post("php/inbox.php",
//     {
//         request: "getComprasMesFacturadas"
//     })
//     .done(function(data) {
//         if(data.indexOf("{") == -1)
//         {
//             var tblData = "<thead><tr><th></th></tr></thead><tbody></tbody>";
//             loadReportesTable(tblData);
//         }
//         else
//         {
//             var json = JSON.parse(data);
//             var tblData = "<thead><tr><th>COMPRAS DEL MES DE " + getMonthInSpanish().toUpperCase() + " " + (new Date()).getFullYear() + "</th><th>PROVEEDOR</th><th>MONTO SUBTOTAL</th><th>TOTAL IMPUESTOS TRASLADADOS</th><th>MONTO TOTAL</th></tr></thead>";
//             tblData += "<tbody>"; 
//             for(var a = 0; a < json.length; ++a)
//              {
//                 if(json[a]['Total'] == "Total")
//                 {
//                     tblData += "<tr style='color:red; border-bottom: 1px solid black;'>";
//                 }
//                 else if(json[a]['Total'] == "Subtotal")
//                 {
//                     tblData += "<tr style='color:blue; border-bottom: 1px solid black;'>";
//                 }
//                 else
//                 {
//                     tblData += "<tr>";
//                 }
//     //             tblData += "<td>" + (a+1) + "</td>";
//                 for (var row in json[a])
//                 {
//                     if(json[a][row] == null)
//                     {
//                         json[a][row] = "0";
//                     }
//                     tblData += "<td style='color:inherit; border-bottom: 1px solid black;'>" + json[a][row] + "</td>";
//                 }
//                 tblData += "</tr>"
//              }
//              tblData += "</tbody>";
//              loadReportesTable(tblData);
//          }
//     });
// }

// function getComprasFacturadasAcumuladas()
// {        
//     $.post("php/inbox.php",
//     {
//         request: "getComprasAcumuladasFacturadas"
//     })
//     .done(function(data) {
//         var json = JSON.parse(data);
//         var tblData = "<thead><tr><th>COMPRAS ACUMULADAS " + (new Date()).getFullYear() + " </th><th>Periodo</th><th>MONTO SUBTOTAL</th><th>TOTAL IMPUESTOS TRASLADADOS</th><th>MONTO TOTAL</th></tr></thead>";
//         tblData += "<tbody>"; 
//         for(var a = 0; a < json.length; ++a)
//          {
//             if(json[a]['Total'] == "Total")
//             {
//                 tblData += "<tr style='color:red; border-bottom: 1px solid black;'>";
//             }
//             else if(json[a]['Total'] == "Subtotal")
//             {
//                 tblData += "<tr style='color:blue; border-bottom: 1px solid black;'>";
//             }
//             else
//             {
//                 tblData += "<tr>";
//             }
// //             tblData += "<td>" + (a+1) + "</td>";
//             for (var row in json[a])
//             {
//                 if(json[a][row] == "1")
//                 {
//                     json[a][row] = "Enero";
//                 }
//                 else if(json[a][row] == "2")
//                 {
//                     json[a][row] = "Febrero";
//                 }
//                 else if(json[a][row] == "3")
//                 {
//                     json[a][row] = "Marzo";
//                 }
//                 else if(json[a][row] == "4")
//                 {
//                     json[a][row] = "Abril";
//                 }
//                 else if(json[a][row] == "5")
//                 {
//                     json[a][row] = "Mayo";
//                 }
//                 else if(json[a][row] == "6")
//                 {
//                     json[a][row] = "Junio";
//                 }
//                 else if(json[a][row] == "7")
//                 {
//                     json[a][row] = "Julio";
//                 }
//                 else if(json[a][row] == "8")
//                 {
//                     json[a][row] = "Agosto";
//                 }
//                 else if(json[a][row] == "9")
//                 {
//                     json[a][row] = "Septiembre";
//                 }
//                 else if(json[a][row] == "10")
//                 {
//                     json[a][row] = "Octubre";
//                 }
//                 else if(json[a][row] == "11")
//                 {
//                     json[a][row] = "Noviembre";
//                 }
//                 else if(json[a][row] == "12")
//                 {
//                     json[a][row] = "Diciembre";
//                 }
//                 else if(json[a][row] == null)
//                 {
//                     json[a][row] = "0";
//                 }
//                 tblData += "<td style='color:inherit; border-bottom: 1px solid black;'>" + json[a][row] + "</td>";
//             }
//             tblData += "</tr>"
//          }
//          tblData += "</tbody>";
//          loadReportesTable(tblData);
        
//     });   
    
// }

// function logout(){
//     $.post("php/session_manager.php",
//     {
//         request: "logout"
//     })
//     .done(function(data) {
//         window.location = "index.php";
//     });
// }

// function getAllEmitidas()
// {
//     $.post("php/inbox.php",
//     {
//         request: "getAllEmitidas"
//     })
//     .done(function(data) {
//                 json = JSON.parse(data);
//                 tblData = "<thead><tr><th></th><th>FECHA EMISIÓN</th><th>CLIENTE</th><th>FOLIO</th><th>MONTO SUBTOTAL</th><th>DESCUENTO</th><th>TOTAL IMPUESTOS TRASLADADOS</th><th>MONTO TOTAL</th><th>NO. CUENTA</th><th>FECHA PAGADA</th><th>VER</th><th>VAL</th><th>PDF</th><th>XML</th></tr></thead>";
//                 tblData += "<tbody>";
//                 for (var a = 0; a < json.length; ++a)
//                 {
//                     var id = -1;
//                     tblData += "<tr>";
// //             tblData += "<td>" + (a+1) + "</td>";
//                     for (var row in json[a])
//                     {
//                         if (row == "valido")
//                         {
//                             if (json[a][row] == 1)
//                             {
//                                 tblData += "<td><img class='icon' src='img/pagina_inbox/EstatusFactura-OK.png'/></td>";
//                             }
//                             else if (json[a][row] == 0)
//                             {
//                                 tblData += "<td><img src='img/pagina_inbox/EstatusFactura-pendiente.png'/></td>";
//                             }
//                             else if (json[a][row] == -1)
//                             {
//                                 tblData += "<td><img src='img/pagina_inbox/EstatusFactura-Error.png'/></td>";
//                             }
//                         }
//                         else if (row == "verificada")
//                         {
//                             if (json[a][row] == 1)
//                             {
//                                 tblData += "<td><img class='icon' src='img/pagina_inbox/EstatusFactura-OK.png'/></td>";
//                             }
//                             else if (json[a][row] == 0)
//                             {
//                                 tblData += "<td><img src='img/pagina_inbox/EstatusFactura-pendiente.png'/></td>";
//                             }
//                             else if (json[a][row] == -1)
//                             {
//                                 tblData += "<td><img src='img/pagina_inbox/EstatusFactura-Error.png'/></td>";
//                             }
//                         }
//                         else if (row == "id")
//                         {
//                             id = json[a][row];
//                             tblData += "<td><input id='chkRow" + json[a][row] + "' class='chkRow' type='checkbox'/></td>";
//                         }
//                         else if (row == "nombre_xml")
//                         {
//                             if (id != -1)
//                             {
//                                 tblData += "<td><button onclick='onViewPDF(" + id + ")'>PDF</button></td>";
//                             }
//                             tblData += "<td><a href='php/request_xml.php?x=" + json[a][row] + "'><img src='img/pagina_inbox/EstatusFactura-Download.png'/></td>";
//                         }
//                         else
//                         {
//                             tblData += "<td>" + json[a][row] + "</td>";
//                         }
//                     }
//                     tblData += "</tr>"
//                 }
//                 tblData += "</tbody>";
//                 loadComprobantesTableWithMenu(tblData, [[0,"desc"]], false, true, false, true);
//     });
// }

// function getReporteCuentasPorCobrar()
// {
//     $.post("php/inbox.php",
//     {
//         request: "getReporteCuentasPorCobrar"
//     })
//     .done(function(data) {
//         var json = JSON.parse(data);
//         var tblData = "<thead><tr><th>FECHA DE EMISIÓN</th><th>FOLIO</th><th>CLIENTE</th><th>MONTO TOTAL</th><th>FECHA DE VENCIMIENTO</th></thead>";
//         tblData += "<tbody>";
//         for(var a = 0; a < json.length; ++a)
//          {
//             tblData += "<tr>";
//             for (var row in json[a])
//             {
//                 tblData += "<td style='color:inherit; border-bottom: 1px solid black;'>" + json[a][row] + "</td>";
//             }
//             tblData += "</tr>";
//          }
//          tblData += "</tbody>";
//          loadReportesConfigurablesTable(tblData);
//     });
// }

// function getReporteCuentasPorPagar()
// {
//     $.post("php/inbox.php",
//     {
//         request: "getReporteCuentasPorPagar"
//     })
//     .done(function(data) {
//         var json = JSON.parse(data);
//         var tblData = "<thead><tr><th>FECHA DE EMISIÓN</th><th>FOLIO</th><th>PROVEEDOR</th><th>MONTO TOTAL</th><th>FECHA DE VENCIMIENTO</th></thead>";
//         tblData += "<tbody>";
//         for(var a = 0; a < json.length; ++a)
//          {
//             tblData += "<tr>";
//             for (var row in json[a])
//             {
//                 tblData += "<td style='color:inherit; border-bottom: 1px solid black;'>" + json[a][row] + "</td>";
//             }
//             tblData += "</tr>";
//          }
//          tblData += "</tbody>";
//          loadReportesConfigurablesTable(tblData);        
//     });
// }

// function getAllRecibidas()
// {
//     $.post("php/inbox.php",
//     {
//         request: "getAllRecibidas"
//     })
//     .done(function(data) {
//                 json = JSON.parse(data);
//                 //tblData = buildTableData(['FECHA EMISIÓN','PROVEEDOR','FOLIO','MONTO SUBTOTAL','TOTAL IMPUESTOS TRASLADADOS','MONTO TOTAL','FORMA DE PAGO','NO. CUENTA','VERIFICADA','VALIDADA','XML'], json);
//                 tblData = "<thead><tr><th></th><th>FECHA EMISIÓN</th><th>PROVEEDOR</th><th>FOLIO</th><th>MONTO SUBTOTAL</th><th>DESCUENTO</th><th>TOTAL IMPUESTOS TRASLADADOS</th><th>MONTO TOTAL</th><th>NO. CUENTA</th><th>FECHA PAGADA</th><th>VER</th><th>VAL</th><th>PDF</th><th>XML</th></tr></thead>";
//                 tblData += "<tbody>";
//                 for (var a = 0; a < json.length; ++a)
//                 {
//                     var id = -1;
//                     tblData += "<tr>";
// //             tblData += "<td>" + (a+1) + "</td>";
//                     for (var row in json[a])
//                     {
//                         if (row == "valido")
//                         {
//                             if (json[a][row] == 1)
//                             {
//                                 tblData += "<td><img class='icon' src='img/pagina_inbox/EstatusFactura-OK.png'/></td>";
//                             }
//                             else if (json[a][row] == 0)
//                             {
//                                 tblData += "<td><img src='img/pagina_inbox/EstatusFactura-pendiente.png'/></td>";
//                             }
//                             else if (json[a][row] == -1)
//                             {
//                                 tblData += "<td><img src='img/pagina_inbox/EstatusFactura-Error.png'/></td>";
//                             }
//                         }
//                         else if (row == "verificada")
//                         {
//                             if (json[a][row] == 1)
//                             {
//                                 tblData += "<td><img class='icon' src='img/pagina_inbox/EstatusFactura-OK.png'/></td>";
//                             }
//                             else if (json[a][row] == 0)
//                             {
//                                 tblData += "<td><img src='img/pagina_inbox/EstatusFactura-pendiente.png'/></td>";
//                             }
//                             else if (json[a][row] == -1)
//                             {
//                                 tblData += "<td><img src='img/pagina_inbox/EstatusFactura-Error.png'/></td>";
//                             }
//                         }
//                         else if (row == "id")
//                         {
//                             id = json[a][row];
//                             tblData += "<td><input id='chkRow" + json[a][row] + "' class='chkRow' type='checkbox'/></td>";
//                         }
//                         else if (row == "nombre_xml")
//                         {
//                            if (id != -1)
//                            {
//                                tblData += "<td><button onclick='onViewPDF(" + id + ")'>PDF</button></td>";
//                            }
//                             tblData += "<td><a href='php/request_xml.php?x=" + json[a][row] + "'><img src='img/pagina_inbox/EstatusFactura-Download.png'/></td>";
//                         }
//                         else
//                         {
//                             tblData += "<td>" + json[a][row] + "</td>";
//                         }
//                     }
//                     tblData += "</tr>"
//                 }
//                 tblData += "</tbody>";
//                 loadComprobantesTableWithMenu(tblData,[[1,"desc"]],true,false,false,true);
//     });
// }

// function getAllNominas()
// {
//     $.post("php/inbox.php",
//     {
//         request: "getAllNominas"
//     })
//     .done(function(data) {
//                 json = JSON.parse(data);
//                 //tblData = buildTableData(['FECHA EMISIÓN','PROVEEDOR','FOLIO','MONTO SUBTOTAL','TOTAL IMPUESTOS TRASLADADOS','MONTO TOTAL','FORMA DE PAGO','NO. CUENTA','VERIFICADA','VALIDADA','XML'], json);
//                 tblData = "<thead><tr><th># EMPLEADO</th><th>NOMBRE</th><th>DÍAS PAGADOS</th><th>PERIODO INICIAL</th><th>PERIODO FINAL</th><th>TOTAL DE PERCEPCIONES</th><th>TOTAL DE DEDUCCIONES</th><th>TOTAL</th><th>XML</th></tr></thead>";
//                 tblData += "<tbody>";
//                 for (var a = 0; a < json.length; ++a)
//                 {
//                     var id = -1;
//                     tblData += "<tr>";
// //             tblData += "<td>" + (a+1) + "</td>";
//                     for (var row in json[a])
//                     {
//                         if (row == "valido")
//                         {
//                             if (json[a][row] == 1)
//                             {
//                                 tblData += "<td><img class='icon' src='img/pagina_inbox/EstatusFactura-OK.png'/></td>";
//                             }
//                             else if (json[a][row] == 0)
//                             {
//                                 tblData += "<td><img src='img/pagina_inbox/EstatusFactura-pendiente.png'/></td>";
//                             }
//                             else if (json[a][row] == -1)
//                             {
//                                 tblData += "<td><img src='img/pagina_inbox/EstatusFactura-Error.png'/></td>";
//                             }
//                         }
//                         else if (row == "verificada")
//                         {
//                             if (json[a][row] == 1)
//                             {
//                                 tblData += "<td><img class='icon' src='img/pagina_inbox/EstatusFactura-OK.png'/></td>";
//                             }
//                             else if (json[a][row] == 0)
//                             {
//                                 tblData += "<td><img src='img/pagina_inbox/EstatusFactura-pendiente.png'/></td>";
//                             }
//                             else if (json[a][row] == -1)
//                             {
//                                 tblData += "<td><img src='img/pagina_inbox/EstatusFactura-Error.png'/></td>";
//                             }
//                         }
//                         else if (row == "id")
//                         {
//                             id = json[a][row];
// //                            tblData += "<td><input id='chkRow" + json[a][row] + "' class='chkRow' type='checkbox'/></td>";
//                         }
//                         else if (row == "nombre_xml")
//                         {
//                            if (id != -1)
//                            {
//                                //tblData += "<td><button onclick='onViewPDF(" + id + ")'>PDF</button></td>";
//                            }
//                             tblData += "<td><a href='php/request_xml.php?x=" + json[a][row] + "&y=n'><img src='img/pagina_inbox/EstatusFactura-Download.png'/></td>";
//                         }
//                         else
//                         {
//                             tblData += "<td>" + json[a][row] + "</td>";
//                         }
//                     }
//                     tblData += "</tr>"
//                 }
//                 tblData += "</tbody>";
//                 loadComprobantesTableWithMenu(tblData,[[1,"desc"]],false,false,false,false);
//     });    
// }

// function agregarNuevaCuenta()
// {
//     $.post("php/inbox.php",
//     {
//         request: "agregarNuevaCuenta"
//     })
//     .done(function(data) {
//         window.location = 'planes.php';
//     });
// }

// function startSessionTimeout()
// {
//     //Destruye la sesion despues de 5mins.
//     fnTimeout = setTimeout(function(){
//        logout();        
//     }, 300000);
// }

// function resetSessionTimeout()
// {
//     clearTimeout(fnTimeout);
//     startSessionTimeout();
// }

// function stopSessionTimeout()
// {
//     clearTimeout(fnTimeout);    
// }

// function isNumber(n) {
//   return !isNaN(parseFloat(n)) && isFinite(n);
// }

// function getMonthInSpanish()
// {
//     var month = (new Date()).getMonth() + 1;
    
//     if(month == 1)
//     {
//         month = "Enero";
//     }
//     else if(month == 2)
//     {
//         month = "Febrero";
//     }
//     else if(month == 3)
//     {
//         month = "Marzo";
//     }
//     else if(month == 4)
//     {
//         month = "Abril";
//     }
//     else if(month == 5)
//     {
//         month = "Mayo";
//     }
//     else if(month == 6)
//     {
//         month = "Junio";
//     }
//     else if(month == 7)
//     {
//         month = "Julio";
//     }
//     else if(month == 8)
//     {
//         month = "Agosto";
//     }
//     else if(month == 9)
//     {
//         month = "Septiembre";
//     }
//     else if(month == 10)
//     {
//         month = "Octubre";
//     }
//     else if(month == 11)
//     {
//         month = "Noviembre";
//     }
//     else if(month == 12)
//     {
//         month = "Diciembre";
//     }
//     return month;
// }

// function getMonthFromNumberToSpanish(number)
// {
//     var month = number;
    
//     if(month == 1)
//     {
//         month = "Enero";
//     }
//     else if(month == 2)
//     {
//         month = "Febrero";
//     }
//     else if(month == 3)
//     {
//         month = "Marzo";
//     }
//     else if(month == 4)
//     {
//         month = "Abril";
//     }
//     else if(month == 5)
//     {
//         month = "Mayo";
//     }
//     else if(month == 6)
//     {
//         month = "Junio";
//     }
//     else if(month == 7)
//     {
//         month = "Julio";
//     }
//     else if(month == 8)
//     {
//         month = "Agosto";
//     }
//     else if(month == 9)
//     {
//         month = "Septiembre";
//     }
//     else if(month == 10)
//     {
//         month = "Octubre";
//     }
//     else if(month == 11)
//     {
//         month = "Noviembre";
//     }
//     else if(month == 12)
//     {
//         month = "Diciembre";
//     }
//     return month;
// }

// function getMonthFromSpanishToNumber(mes)
// {
//     var number = -1;
    
//     if(mes == "Enero")
//     {
//         number = 1;
//     }
//     else if(mes == "Febrero")
//     {
//         number = 2;
//     }
//     else if(mes == "Marzo")
//     {
//         number = 3;
//     }
//     else if(mes == "Abril")
//     {
//         number = 4;
//     }
//     else if(mes == "Mayo")
//     {
//         number = 5;
//     }
//     else if(mes == "Junio")
//     {
//         number = 6;
//     }
//     else if(mes == "Julio")
//     {
//         number = 7;
//     }
//     else if(mes == "Agosto")
//     {
//         number = 8;
//     }
//     else if(mes == "Septiembre")
//     {
//         number = 9;
//     }
//     else if(mes == "Octubre")
//     {
//         number = 10;
//     }
//     else if(number == "Noviembre")
//     {
//         number = 11;
//     }
//     else if(mes == "Diciembre")
//     {
//         number = 12;
//     }
    
//     return number;
// }