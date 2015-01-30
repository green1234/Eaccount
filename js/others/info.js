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
    
    $("#btnIngresar").click(function(){
        $("#loginForm").toggle();
    });
    
    $("#btnLogin").click(function(){
        onLogin();
    });
}

function onLogin()
{
    var username = $("#txtLoginUsuario").val();
    var password = $("#txtLoginPassword").val();

    if(username.length > 0 && password.length > 0)
    {
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

            if (isLogged)
            {
                $("#loginForm").toggle();
                window.location = "inbox.php";
            }
            else
            {
                alert("Usuario o contraseña incorrectos. Verifique que estén escritos correctamente.");
            }
        });
    }
    else
    {
        alert("Su usuario o contraseña no pueden estar vacíos.")
    }
}