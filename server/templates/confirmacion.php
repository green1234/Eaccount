<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Email Template</title>
	<meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">	
	<style>	

	/*@font-face{
	    font-family: "Corbel";
	    src: url(fonts/Corbel.ttf); 
	}*/

	a
	{
		text-decoration: none;
	}

	body
	{
		/*background-color: #ededed;*/
		font-family: "Arial";
		font-size: 18px;
		margin: 0;
		padding: 0;	
		width: 782px;
		height: 100%;
		min-height: 100%;
	}
	
	div.description
	{
		background-color: white;
		box-shadow: 5px 5px 10px #a1a1a1;
		border: 1px solid #a1a1a1;
		border-radius: 0.5em;		
		font-size: 1.3em;
		margin-left: 2.2em;
		margin-right: 2.2em;
		/*margin-top: 1em;*/
		/*overflow: auto;
		overflow-y: hidden;*/ 
		position: relative;

	}

	div.description > p
	{
		padding: 1em;		
	}

	div.description > p.datos
	{
		padding: 1em;		
		margin-bottom: 1.5em;		
	}	
	div.description > p.submit
	{
		text-align: center;
	}

	div.description > p.submit > a.button
	{
		border: 1px solid #224d71;
		background-color: #2c6494;
		border-radius: 0.3em;
		bottom: -1.2em;
		color: white;
		left: 18%;
		/*right: 18%;*/
		font-size: 1.2em;
		/*margin-left: 343px;*/
		/*margin-right: 0;*/
		/*text-decoration: none;*/
		text-align: center;
		padding: 0.5em 1em 0.5em 1em;
		position: absolute;
	}

	div.footer
	{
		/*position: absolute;*/
		width: 782px;
		bottom: 0;
		margin-top: 5em;
		/*top: 100%;*/
		/*right: 0;*/
	}
	div.footer > ul
	{
		background-color: #2c6494;		
		list-style-type: none;
		margin: 0;
		padding: 0.5em 0 0.5em 0;
		text-align: center;

	}

	div.redirect
	{
		padding: 1em;
		text-align: center;
		font-size: 1em;
		margin-top: 2.5em;
		margin-bottom: 1.5em;
	}
	
	div.redirect > a
	{
		color: #2c6494;
		display: block;
		margin-top: 0.5em;
		/*text-decoration: none;*/
	}
	
	div.aplicaciones
	{
		background-color: white;
		/*position: absolute;*/
		width: 100%;
		padding: 0.5em 0 0.5em 0;
		overflow: auto;
	}

	div.aplicaciones > .picture
	{
		margin-left: 3.5em;
		/*width: 30%;*/
		float: left;
	}

	div.footer > ul > li
	{
		display: inline;
		margin-left: 0.5em;
	}

	div.footer > ul > li > a
	{
		color: white;
	/*	display: block;
		float: left;		*/
	}

	h1, p
	{
		margin: 0;
		padding: 0;
	}
	div.header
	{		
		position: relative;
		background-color: #2c6494;
		color: white;
		height: 150px;
		text-align: center;
	}
	div.header > h1
	{
		font-weight: normal;
		padding: 1.5em 0 0 0;
		/*left: 2.8em;		*/
		/*position: absolute;*/
		/*top: 1.5em;*/
	}
	div.section
	{		
		background-color: #ededed;
		color: #4d4d4d;
		padding-top: 1.2em;
		/*padding-bottom: 12em;*/
		height: auto;
		min-height: 100%;
		/*overflow: auto;*/
		/*position: relative;*/
		/*width: 100%;*/
	}
	
	.logos img
	{
		height: 100px;
		width: 180px;

	}
	</style>
</head>
<body>
	<div class="header">
		<h1>BIENVENIDO A SAVVY SYSTEMS!</h1>
	</div>
	<div class="section">
		<div class="article description">
			<p>
				Gracias por crear una cuenta con nosotros, con ella podrás iniciar sesion en nuestro sistema para utilizar todas las aplicaciones que desarrollamos para facilitarte la administración de tu negocio.
			</p>
			<p>
				Ingresa en el sitio de Savvy Systems cualquiera de los siguientes datos seguido de tu contraseña para iniciar sesión.
			</p>
			<p class="datos">
				Tu correo: <b>&lt;email de usuario&gt;</b>
				<br>
				Tu nombre de usuario: <b>&lt;nombre de usuario&gt;</b>	
			</p>
			<p class="submit">
				<a class="button" target="_blank" href="http://savvysystems.com.mx">
					<span>ACTIVAR MI CUENTA AHORA</span></a>							
			</p>
		</div>
		<div class="article redirect">
			<p>
				Si el botón no abre una nueva ventana, copie y pegue la siguiente liga en su navegador:
			</p>
			<a href="http://savvysystems.com.mx">http://savvysystems.com.mx/ejemplo-de-liga/para-confirmar-cuenta</a>
		</div>
		<div class="article aplicaciones">			
			<div class="picture">
				<a class="logos" target="_blank" href="http://savvysystems.com.mx">
					<img src="http://104.236.124.45/eaccount/img/savvy_logo_1.png" alt=""></a>
			</div>
			<div class="picture">
				<a class="logos" target="_blank" href="http://savvysystems.com.mx">
					<img src="http://104.236.124.45/eaccount/img/savvy_logo_2.png" alt=""></a>
			</div>
			<div class="picture">
				<a class="logos" target="_blank" href="http://savvysystems.com.mx">
					<img src="http://104.236.124.45/eaccount/img/savvy_logo_3.png" alt=""></a>
			</div>
		</div>
		<div class="footer">
			<ul>
				<li ><a href="http://savvysystems.com.mx">Savvy Systems ©</a></li>
				<li ><a href="http://savvysystems.com.mx">Centro de Ayuda</a></li>
				<li ><a href="http://savvysystems.com.mx">Terminos y Privacidad</a></li>
			</ul>
		</div>
	</div>	
</body>
</html>