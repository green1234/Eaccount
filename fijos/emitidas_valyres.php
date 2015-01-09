<head>
<script type="text/javascript" src="js/jquery-2.1.1.min.js"></script>
</head>
<style type="text/css">
	td {
		text-align: center;
	}
</style>
<table class="table table-striped">
	<thead>
		<tr>
			<td colspan="10" style="background: gray; color: white;">DATOS DEL COMPROBANTE FISCAL</td>
			<td colspan="6" style="background: gray; color: white;">INFORMACION DEL PAGO</td>
		</tr>
		<tr>
			<td></td>
			<td>VER</td>
			<td>VAL</td>
			<td>EMISION</td>
			<td>FOLIO</td>
			<td>CLIENTE</td>
			<td>SUBTOTAL</td>
			<td>DESCUENTO</td>
			<td>IMPUESTOS</td>
			<td>TOTAL</td>
			<td>FECHA</td>
			<td>CUENTA</td>
			<td>METODO</td>
			<td><img src="./img/lapiz_azul.png" style="max-width: 20px;cursor:pointer;" data-toggle="modal" data-target="#myModal"></td>
			<td><img src="./img/pdf_azul.png" style="max-width: 20px;"></td>
			<td><img src="./img/xml_azul.png" style="max-width: 20px;"></td>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>
				<input type="radio">
			</td>
			<td>
				<img src="./img/check_azul.png" style="max-width: 20px;">
			</td>
			<td>
				<img src="./img/cruz_naranja.png" style="max-width: 20px;">
			</td>
			<td>
				01-01-14
			</td>
			<td>
				###
			</td>
			<td>
				ALIAS CLIENTE
			</td>
			<td>
				$0.00
			</td>
			<td>
				$0.00
			</td>
			<td>
				$0.00
			</td>
			<td>
				$0.00
			</td>
			<td>
				01-01-14
			</td>
			<td>
				4687 BBVA
			</td>
			<td>
				Cheque
			</td>
			<td>
				<input type="radio">
			</td>
			<td>
				<input type="checkbox" selected>
			</td>
			<td>
				<input type="checkbox" selected>
			</td>
		</tr>
		<tr>
			<td>
				<input type="radio">
			</td>
			<td>
				<img src="./img/check_azul.png" style="max-width: 20px;">
			</td>
			<td>
				<img src="./img/cruz_naranja.png" style="max-width: 20px;">
			</td>
			<td>
				01-01-14
			</td>
			<td>
				###
			</td>
			<td>
				ALIAS CLIENTE
			</td>
			<td>
				$0.00
			</td>
			<td>
				$0.00
			</td>
			<td>
				$0.00
			</td>
			<td>
				$0.00
			</td>
			<td>
				01-01-14
			</td>
			<td>
				4687 BBVA
			</td>
			<td>
				Cheque
			</td>
			<td>
				<input type="radio">
			</td>
			<td>
				<input type="checkbox" selected>
			</td>
			<td>
				<input type="checkbox" selected>
			</td>
		</tr>
		<tr>
			<td>
				<input type="radio">
			</td>
			<td>
				<img src="./img/check_azul.png" style="max-width: 20px;">
			</td>
			<td>
				<img src="./img/cruz_naranja.png" style="max-width: 20px;">
			</td>
			<td>
				01-01-14
			</td>
			<td>
				###
			</td>
			<td>
				ALIAS CLIENTE
			</td>
			<td>
				$0.00
			</td>
			<td>
				$0.00
			</td>
			<td>
				$0.00
			</td>
			<td>
				$0.00
			</td>
			<td>
				01-01-14
			</td>
			<td>
				4687 BBVA
			</td>
			<td>
				Cheque
			</td>
			<td>
				<input type="radio">
			</td>
			<td>
				<input type="checkbox" selected>
			</td>
			<td>
				<input type="checkbox" selected>
			</td>
		</tr>
	</tbody>
</table>



<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Informacion del Pago - Factura Emitida</h4>
      </div>
      <div class="modal-body container">
        <div class="col-md-3">
			<div class="campos_metodos cheque trans tc efectivo">
    			<b>Fecha en que se efectuo el pago:</b>
    			<br>
    			<div class="input-group date input_fecha">
	                <input type="text" class="form-control" data-date-format="YYYY/MM/DD">
	                <span class="input-group-addon">
	                    <span class="glyphicon-calendar glyphicon"></span>
	                </span>
              	</div>
            </div>
          	
          	<div class="campos_metodos cheque">
	          	<br>
	          	<b>Fecha del cheque:</b>
				<br>
				<div class="input-group date input_fecha">
	                <input type="text" class="form-control" data-date-format="YYYY/MM/DD">
	                <span class="input-group-addon">
	                    <span class="glyphicon-calendar glyphicon"></span>
	                </span>
	          	</div>
	        </div>

	        <div class="campos_metodos cheque trans tc">
	          	<br>
	          	<b>Cuenta bancaria de retiro:</b><br>
				<div class="btn-group"> <a class="btn btn-default dropdown-toggle btn-select" data-toggle="dropdown" href="#">SELECCIONA CUENTA<span class="caret"></span></a>
		            <ul class="dropdown-menu">
		                <li><a href="#">Cta 1</a></li>
		                <li><a href="#">Cta 2</a></li>
		                <li><a href="#">Cta 3</a></li>
		                <li><a href="#">Cta 4</a></li>
		            </ul>
		        </div>
		    </div>

		    <div class="campos_metodos trans tc">
		        <br>
		        <b>Numero de transaccion</b>
		        <br>
		        <input type="text">
		    </div>
          	
		</div>
        <div class="col-md-3">
			<b>Metodo de pago:</b><br>
			<div class="btn-group"> <a class="btn btn-default dropdown-toggle btn-select" data-toggle="dropdown" href="#">SELECCIONA METODO DE PAGO<span class="caret"></span></a>
	            <ul class="dropdown-menu">
	                <li><a href="#" onClick="showHideCampos('cheque');">Cheque</a></li>
	                <li><a href="#" onClick="showHideCampos('trans');">Transferencia Electronica</a></li>
	                <li><a href="#" onClick="showHideCampos('tc');">Tarjeta de Credito</a></li>
	                <li><a href="#" onClick="showHideCampos('efectivo');">Efectivo</a></li>
	            </ul>
	        </div>

	        <div class="campos_metodos trans tc">
	          	<br>
	          	<b>Cuenta beneficiario:</b><br>
				<div class="btn-group"> <a class="btn btn-default dropdown-toggle btn-select" data-toggle="dropdown" href="#">SELECCIONA CUENTA<span class="caret"></span></a>
		            <ul class="dropdown-menu">
		                <li><a href="#">Cta 1</a></li>
		                <li><a href="#">Cta 2</a></li>
		                <li><a href="#">Cta 3</a></li>
		                <li><a href="#">Cta 4</a></li>
		            </ul>
		        </div>
		    </div>

	        <div class="campos_metodos cheque">
		        <br>
		        <b>Numero de cheque</b>
		        <br>
		        <input type="text">
		    </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Regresar</button>
        <button type="button" class="btn btn-primary">Guardar Cambios</button>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript" src="js/moment.js"></script>
<script type="text/javascript" src="js/bootstrap-datetimepicker.js"></script>
<script type="text/javascript">
$(function () {
  $('.input_fecha').datetimepicker({
      pickTime: false
  });
});

function showHideCampos(metodo) {
	$('.campos_metodos').hide();
	switch(metodo) {
	    case 'cheque':
	        $('.cheque').show();
	        break;
	    case 'trans':
	        $('.trans').show();
	        break;
	    case 'tc':
	        $('.tc').show();
	        break;
	    case 'efectivo':
	        $('.efectivo').show();
	        break;
	    default:
	        break;
	}
}

$(document).ready(function () {
	$('.campos_metodos').hide();
});
</script>