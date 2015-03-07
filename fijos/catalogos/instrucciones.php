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
		/*font-size: 1em;*/
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
		font-size: 1.5em;
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
	Descargue el Catalogo de Ejemplo de la siguiente liga.
	<br>
	<a href="fijos/catalogos/cat1.csv">Descargar</a>
</p></h2>
<h2 style="text-align:left;">Descripcion de Columnas:</h2>
<div class="columna">
<h3>Code</h3>
<p>
	Aqui colocaremos el codigo que vamos a utilizar en nuestra cuenta contable.
</p>
</div>
<div class="columna">
<h3>Name</h3>
<p>
	Aqui colocaremos el nombre que vamos a utilizar en nuestra cuenta contable.
</p>
</div>
<div class="columna">
<h3>Type</h3>
<p>
	Aqui colocaremos el codigo que corresponda a la cuenta:
	<br>
	<b>caja</b> : Para las cuentas de mayor y subcuentas que sean de caja.
	<br>
	<b>banco</b> : Para las cuentas de mayor y subcuentas que sean de banco.
	<br>
	<b>cliente</b> : Para las cuentas de mayor y subcuentas que sean de cliente.
	<br>
	<b>proveedor</b> : Para las cuentas de mayor y subcuentas que sean de proveedor.
	<br>
	<b>otro</b> : Para las cuentas de mayor y subcuentas que sean de otro.
</p>
</div>
<div class="columna">
<h3>Parent</h3>
<p>
	Aqui colocaremos el nombre de la cuenta de mayor inmediata superior de nuestra cuenta, si no tuviera padre, la dejan vacia.
</p>
</div>
<div class="columna">
<h3>Class</h3>
<p>
	Aqui colocaremos la letra que corresponda a la clase de la cuenta.
	<br>
	<b>A</b>: Activos
	<br>
	<b>P</b>: Pasivos / Capital
	<br>
	<b>I</b>: Ingresos
	<br>
	<b>G</b>: Gastos
</p>
</div>
<div class="columna">
<h3>Mayor</h3>
<p>
	Aqui colocaremos el numero que corresponda a la cuenta.
	<br>
	<b>0</b>: Subcuentas
	<br>
	<b>1</b>: Cuentas de Mayor	
</p>
</div>
<div class="columna">
<h3>Nature</h3>
<p>
	Aqui colocaremos la naturaleza de la cuenta
	<br>
	<b>A</b>: Acreedora
	<br>
	<b>D</b>: Deudora
</p>
</div>
<div class="columna">
<h3>SAT</h3>
<p>
	Aqui colocaremos el codigo agrupador proporcionado por el SAT para este tipo de cuenta.
	<a href="fijos/catalogos/cat2.xlsx">Ver aqui</a>
</p>
</div>
<div class="columna">
<h3>Default</h3>
<p>
	Aqui debemos indicar las cuentas que seran por default. Es decir debemos de asignar los siguientes valores a 1 sola cuenta en cada caso.
	<br>
	<b>caja</b>: Para la cuenta de caja por default
	<br>
	<b>banco</b>: Para la cuenta de banco por default
	<br>
	<b>bancos</b>: Para la cuenta de mayor de los bancos
	<br>
	<b>cliente</b>: Para la cuenta de cliente por default
	<br>
	<b>proveedor</b>: Para la cuenta de cliente por default
	<br>
	<b>iva_venta</b>: Para la cuenta de IVA de Venta por default
	<br>
	<b>iva_compra</b>: Para la cuenta de IVA de Compra por default
	<br>
	<b>iva_ret</b>: Para la cuenta de IVA Retenido por default
	<br>
	<b>isr_ret</b>: Para la cuenta de ISR de Retenido por default
	<br>
	<b>apertura</b>: Para la cuenta de Apertura de Capital por default
	<br>
	<b>ingreso</b>: Para la cuenta de Ingreso por default
	<br>
	<b>gasto</b>: Para la cuenta de Gasto por default
</p>
</div>
</div>