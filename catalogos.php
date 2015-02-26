<?
require_once "server/conf/constantes.conf";
if (isset($_SESSION["login"]))
{
  $uid = $_SESSION["login"]["uid"];
  $pwd = $_SESSION["login"]["pwd"];
  $cid = $_SESSION["login"]["cid"];
  $cfg = $_SESSION["login"]["config"];
}
?>
<div role="tabpanel" class="tab-pane fade" id="catalogos" style="padding-top: 20px;">

	<ul class="nav nav-tabs" role="tablist" style="margin-bottom: -2px;">
      <li role="presentation" class="tab_clientes subTab"><a href="#clientes" role="tab" data-toggle="tab">CLIENTES</a></li>
      <li role="presentation" class="tab_proveedores subTab"><a href="#proveedores" role="tab" data-toggle="tab">PROVEEDORES</a></li>
      <li role="presentation" class="tab_productos subTab"><a href="#productos" role="tab" data-toggle="tab">PRODUCTOS</a></li>
      <li role="presentation" class="tab_cuentas_contables subTab"><a href="#cuentas_contables" role="tab" data-toggle="tab">CUENTAS CONTABLES</a></li>
      <li role="presentation" class="tab_otros_causantes subTab"><a href="#otros_causantes" role="tab" data-toggle="tab">OTROS CAUSANTES</a></li>
      <li role="presentation" class="tab_sucursales subTab"><a href="#sucursales" role="tab" data-toggle="tab">SUCURSALES</a></li>
    </ul>

    <div class="tab-content container" style="width: auto;background: #e6e6e6;font-family: Arial;font-size: 11px;">
    	<? require 'fijos/catalogos/clientes.php' ?>
    	<? #require 'proveedores.php' ?>
    	<? #require 'productos.php' ?>
    	<? require 'fijos/catalogos/cuentas_contables.php' ?>
    	<? #require 'otros_causantes.php' ?>
    	<? #require 'sucursales.php' ?>
    </div>
</div>