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
		font-size: 1.2em;
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
		/*margin-bottom: 1.5em;		*/
	}	
	div.description > p.submit
	{
		text-align: center;
		position: relative;
	}

	div.description > p.submit > a.button
	{
		border: 1px solid #224d71;
		background-color: #2c6494;
		border-radius: 0.3em;
		bottom: -1.2em;
		color: white;
		left: 25%;
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
	div.redirect > p
	{
		color: #17344e;
		padding: 0 5em 0 5em;
	}
	
	div.redirect > a
	{
		color: #2c6494;
		display: block;
		margin-top: 0.5em;
		/*text-decoration: none;*/
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
		<h1>ORDEN DE COMPRA</h1>
	</div>
	<div class="section">
		<div class="article description">
			<p>
				<b>&lt;nombre de usuario&gt;</b>,
			</p>
			<p>
				Has adquirido el <b>PLAN &lt;NOMBRE PLAN&gt;</b> de la aplicación <b>&lt;APLICACION&gt;</b> por un periodo &lt;PERIODO&gt;.
			</p>
			<p class="datos">
				<b>Subtotal: $ &lt; &gt;</b>
				<br>
				<b>Descuentos: -$ &lt; &gt;</b>
				<br>
				<b>IVA: $ &lt; &gt;</b>
				<br>
				<b>Total a Pagar: $ &lt; &gt;</b>				
			</p>
			<p>
				Tienes un plazo máximo de de 5 días naturales para realizar tu 
				<br>
				pago de <b>$ &lt; Total &gt;</b> mediante transferencia bancaria o depósito a 
				<br>
				la cuenta:
				<br> 
				<b>&lt; Cuenta Bancaria Servicios Corp &gt;</b>
			</p>
			<p>
				Indica como referencia tu Número de Cliente: <b>&lt; NumCliente &gt;</b>
			</p>
			<p class="submit">
				<a class="button" target="_blank" href="http://savvysystems.com.mx">
					<span>IR A MI CUENTA AHORA</span></a>							
			</p>
		</div>
		<div class="article redirect">
			<p>
				<img width="50px" height="55px" src="http://104.236.124.45/eaccount/img/g3.png">
				<br>
				<i><b>Puedes uttilizar el servicio desde este momento, inicia configurando los datos de tu cuenta y empresa en la sección de configuraciones.</b></i>
			</p>
			
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