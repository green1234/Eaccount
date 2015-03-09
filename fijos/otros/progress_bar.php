<?//PARA CAMBIAR EL VALOR A LA BARRA SE LE TIENE QUE CAMBIAR EL "width" CON JQUERY O JAVASCRIPT?>
<div class="progress">
  <div class="progress-bar" id="progress-bar" role="progressbar" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100">
    <!--span class="sr-only">60% Complete</span-->
  </div>
</div>

<script type="text/javascript">
	//$(document).ready(function () {
		var modWidth = "100%";
		//for (var i = 0; i = 100; i++) {
			$("#progress-bar").width(modWidth).delay(20000);
			//modWidth = modWidth + 2;
		//};
	//});
</script>