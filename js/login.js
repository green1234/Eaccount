$(function(){    
    
    // for (var i = 1; i <= 10; i++) {
        
    //     if(i < 5)
    //     {
    //         console.log("hola" + i);    
    //     }
    //     if(i >= 5)
    //     {
    //      console.log("adios" + i);       
    //     }
    // };

    $("#form_login").on("submit", function(e){
        e.preventDefault();
        
        var path = $(this).attr("action");
        var username = $("#username").val();
        var password = $("#password").val();

        var data = "username=" + username + "&password=" + password
        path = path + data;

        $.getJSON(path, function(res){
            // console.log(res)

            if (res.success)
            {
                console.log(res.data)

                window.location = "/eaccount/inbox.php"
            }
            else
            {
                alert(res.data.description);
            }
        });      
    });

});

// var tmpEmail = "";
// var tmpPassword = "";

// $(document).ready(function(){
//     init();
//     registerEvents();
// });

// function init()
// {    
// }

// function registerEvents()
// {
//     $("#btnForgotPassword").click(function(){
//         $("#divForgotPassword").dialog({
//             modal: true,
//             width: 480,
//             dialogClass: "modalNoBorder"
//         });
//     });
    
//     $("#dfpBtnSubmit").click(function(){
//         var email = $("#dfpTxtEmail").val();
//         $.post("php/login.php",
//         { 
//            request: "rememberPassword",
//             "email": email
//         })
//         .done(function(data) {
//             alert("Sigue las instrucciones en tu correo para restablecer tu contraseña.");

//         });
//         $("#divForgotPassword").dialog("close");
//     });
    
//     $("#btnLogin").click(function(){
//         login();
//     });
    
//     $("#txtPassword").keypress(function(e){
//         if(e.which == 13)
//         {
//             login();
//         }
//     });
    
//     $("#txtEmail").keypress(function(e){
//         if(e.which == 13)
//         {
//             login();
//         }
//     });
// }

// function login()
// {
//     var email = $("#txtEmail").val();
//     var password = $("#txtPassword").val();
//     var remember = $("#chkRememberMe").is(':checked');
    
//     if(email == "" || email == " ")
//     {
//         alert("Email no puede estar vacío");
//         return;
//     }
//     if(password == "" || password == " ")
//     {
//         alert("Contraseña no puede estar vacía");
//         return;
//     }
    
//     $.post("php/login.php",
//     { 
//        request: "loginUser",
//         "email": email,
//         "password": password,
//         "remember": remember
//     })
//     .done(function(data) {
//         var json = JSON.parse(data);
//         var isLogged = json.logged;
//         var validado = json.validado;
//         var redir = json.redir;
        
//         if(typeof(redir) != 'undefined')
//         {
//             if(redir == "planes.php")
//             {
//                 alert("Usted necesita registrar sus datos fiscales y una suscripción para poder utilizar el sistema. Será redirigido a la página para poder hacer esto.");
//             }
//             window.location = redir;
//             return;
//         }
        
//         if (isLogged)
//         {
//             alert("¡Bienvenido!");
//             window.location = 'inbox.php';
//            // showDialog("Respuesta", "Bienvenido " + email);
//         }
//         else
//         {
//             if(validado === false)
//             {
//                 alert("Para tener acceso al sistema, usted tiene que verificar su cuenta mediante el correo que se le hizo llegar.");
//             }
//             else
//             {
//                 alert("Usuario o contraseña incorrectos. Verifique que estén escritos correctamente.");
//                 //showDialog("Error", "Usuario o contraseña incorrectos");
//             }
//         }
//     });
// }