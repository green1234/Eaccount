<!-- Nav tabs -->
<ul class="nav nav-tabs" role="tablist" style="margin-bottom: -2px;">
  <li role="presentation" class="active">
    <a href="#cuentas" aria-controls="cuentas" role="tab" data-toggle="tab">MIS CUENTAS</a></li>
  <li role="presentation">
    <a href="#empresas" aria-controls="empresas"role="tab" data-toggle="tab">MI EMPRESA</a></li>
  <!-- <li role="presentation">
    <a href="#catalogos" aria-controls="catalogos" role="tab" data-toggle="tab">CATÁLOGOS</a></li> -->
</ul>

<!-- Tab panes -->
<div class="tab-content container" style="width: auto;background: #e6e6e6;font-family: Arial;font-size: 11px;">

  <!--INICIA TAB "MIS CUENTAS"-->
  <? require 'mis_cuentas.php'; ?>
  <!--FIN TAB "MIS CUENTAS"-->

  <!--INICIA TAB "MI EMPRESA"-->
  <? require 'mi_empresa.php'; ?>
  <!--FIN TAB "MI EMPRESA"-->

  <!--INICIA TAB "CATALOGOS"-->
  <? #require 'catalogos.php' ?>
  <!--FIN TAB "CATALOGOS"-->
</div>