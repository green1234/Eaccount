<style>
	a
	{
		text-decoration: none;
		color: #2c6494;
	}
	body
	{
		font-family: "arial";
		margin: 0;
		text-align: center;	
	}

	h1
	{
		background-color: #2c6494;
		color: white;
		font-size: 1.4em;
		margin: 0;
		padding: 0.5em 0;
		text-align: center;

	}
	h1 a 
	{
		position: absolute;
		left:2em;
		top: 0.4em;
		/*text-align: left;*/
		color: white;
		/*padding-left: 2em;*/
	}
	h2
	{
		font-size: 1.3em;
		text-align: center;
	}
	div
	{
		/*margin-left: 2em;*/
		text-align: left;
	}
</style>
<div class="table-responsive" id="listado_cfdi">
<h1>INSTRUCCIONES PARA EL LLENADO DEL CATALOGO DE CUENTAS</h1>
<h2><p>
	<br>
	El archivo a importar debe contener SOLAMENTE un (1) catalogo de cuentas. El formato de tu archivo debe ser (*.csv). 
	Debe tener 10 campos (columnas) con el siguiente orden:
	En el renglon 1: El nombre de las columnas, indicado en negritas: 	
	<a href="view/config/catalogos/cat1.csv">Descargar Ejemplo</a>
</p></h2>
<h2 style="text-align:left;">Descripcion de Columnas:</h2>
<div class="columna">
<h4>A1:  Codigo_SAT</h4>
<p>
	Es el código agrupador definido por el SAT en el Anexo 24.
</p>
</div>
<div class="columna">
<h4>B1:  Nivel_de_cuenta.</h4>
<p>
	Es el nivel de la cuenta, Número entero iniciando en 1 (mas alto).
</p>
</div>
<div class="columna">
<h4>C1:  Numero_de_cuenta.</h4>
<p>
	Es la clave de la cuenta. Asignado por el contador. Puede tener cualquier estructura (3-4-4; 4-4, otra).
</p>
</div>
<div class="columna">
<h4>D1:  Nombre_cuenta.</h4>
<p>
	Nombre de la cuenta contable. 
</p>
</div>
<div class="columna">
<h4>E1: Genero</h4>
<p>
	Es el género de la cuenta. Solo debe tener un (1) caracter: los valores válidos son:  
	<br>
	<ul>
		<li><b>A : </b><i>Cuentas de Activos</i></li>
		<li><b>P : </b><i>Cuentas de Pasivos</i></li>
		<li><b>K : </b><i>Cuentas de Capital</i></li>
		<li><b>I : </b><i>Cuentas de Ingresos</i></li>
		<li><b>C : </b><i>Cuentas de Costos</i></li>
		<li><b>G : </b><i>Cuentas de Gastos</i></li>
		<li><b>F : </b><i>Cuentas de Financieros</i></li>
		<li><b>O : </b><i>Cuentas de Orden</i></li>
	</ul>

</p>
</div>
<div class="columna">
<h4>F1:  Naturaleza.</h4>
<p>
	Naturaleza de la cuenta. Solo debe tener un (1) caracter: los valores válidos son:
	<br>
	<ul>
		<li><b>A</b>: Acreedora</li>
		<li><b>D</b>: Deudora</li>
	</ul>
</p>
</div>
<div class="columna">
<h4>G1:  SubCuentaDe.</h4>
<p>
	Es la clave de la cuenta. Asignado por el contador. Puede tener cualquier estructura (3-4-4; 4-4, otra). 
</p>
</div>
<div class="columna">
<h4>H1:  Cuenta_mayor.</h4>
<p>
	Identifica si la cuenta es de Mayor o no. los valores válidos son:
	<br>
	<ul>
		<li><b>SI</b></li>
		<li><b>NO</b></li>
	</ul>	
</p>
</div>
<div class="columna">
<h4>I1:  Afectable.</h4>
<p>
	Identifica si la cuenta es afectable o no. los valores válidos son:
	<br>
	<ul>
		<li><b>SI</b></li>
		<li><b>NO</b></li>
	</ul>	
</p>
</div>

<div class="columna">
<h4>J1:  Moneda.</h4>
<p>
	Identifica los si datos a registrar en la cuenta son en pesos (valor por defecto) o en otra moneda, debe tener las 3 letras aceptadas 
	en el catálogo de moneda publicado por el SAT. Los valores válidos son:
	<ul>
		<li><b>MXP</b>: Para el caso de pesos mexicanos.</li>
		<li><b>USD</b>: Para el caso de dolares de EUA.</li>
	</ul>
	<br>
	<a href="view/config/catalogos/Cat_Monedas.xlsx">Consulte el catalogo de monedas para los demás casos. </a>
</p>
</div>
<p>
	A partir del renglón 2 los datos correspondientes a las cuentas. 
	<br><br>
	<b>Nota: </b>NO debe contener espacios vacios (celdas vacias) ya que si las contiene, 
	NO se importará el catalogo.
</p>
</div>