<style type="text/css">
  td, th{
    text-align: center;
  }
  ul {
    list-style: none;
  }
  .li_activa {
    background: gray;
    color: white;
  }
  #sub_tabla,#sub_tabla2,#sub_tabla3,#sub_tabla4 {
    display: none;
  }
  #sub_tabla li {
    overflow: hidden;
    max-height: 15px;
    cursor: pointer;
  }
  #sub_tabla li:hover {
    background: #cc3366;
    color: white;
  }
  .grad1 {
    padding: 15px;
    color: white;
    border-radius: 12px;
    font-size: 15px;
    margin-bottom: 20px;
  }
  #sub_tabla1,#sub_tabla2,#sub_tabla3,#sub_tabla4 {
    margin: 0 auto;
    border: 1px solid #ddd;
    background: #F7F7F7;
    margin-left: -1px;
    height: 100px;
    overflow: scroll;
  }
</style>

<? 
require_once "server/conf/constantes.conf"; 

$band = false;
if (isset($_SESSION["login"]))
{

  $uid = $_SESSION["login"]["uid"];
  $pwd = $_SESSION["login"]["pwd"];
  $cid = $_SESSION["login"]["cid"];

  if (isset($_SESSION["cfdi"]) && isset($_GET["cfdi"]))
  {
    $cfdi = $_SESSION["cfdi"][$_GET["cfdi"]];  
    $band = true;
  }
  //var_dump($cfdi);
}
if ($band){
?>

<div class="grad1">
  <p>
    Factura de honorarios <b><?=$cfdi["folio"]?></b> recibida con fecha <b><?=$cfdi["date_invoice"]?></b>
    <br>
    Recibida de <b><?=$cfdi["partner_id"][1]?></b> en <b><?=$cfdi["currency_id"][1]?></b>, por un total de $<b><?=$cfdi["amount_total"]?></b> 
    <br>
    Concepto: <b>Concepto_poliza<b>
  </p>
</div>
<div class="table-responsive">
  <table class="table table-bordered table-striped" id="tabla_conta" style="border: 0px;border-radius:10px;">
    <thead>
      <tr>
        <th style="border: 0px;">&nbsp;</th>
        <th>PÓLIZA</th>
        <th>CONCEPTO</th>
        <th>CUENTA</th>
        <th>NOMBRE</th>
        <th>SALDO ANT.</th>
        <th>DEBE</th>
        <th>HABER</th>
        <th>SALDO NUEVO</th>
        <th>UUID</th>
        <th style="border: 0px;">&nbsp;</th>
      </tr>
    </thead>
    <tbody>
      
      <?
      var_dump($cfdi['lines']);
      foreach ($cfdi['lines'] as $factura){
        $id = $factura['id'];
        $cuenta = split(" ", $cfdi['account_expense_income'][1]);
      ?>
        <tr>
          <td><input id="<?=$id?>" type="checkbox"></td>
          <td><?=$cfdi['id']?></td>
          <td><?=$factura['name']?></td>          
          <td><?=[0]?></td>
          <td><?=split(" ", $cfdi['account_expense_income'][1])[1]?></td>
          <td><?=$factura['amount_total']?></td>
          <td><?=$factura['lines']['name']?></td>
          <td><?=$factura['lines']['quantity']?></td>
          <td><?=$factura['amount_total']?></td>
          <td><?=$factura['currency_id']['1']?></td>
          <td><input id="<?=$id?>" type="checkbox"></td>
        </tr>
      <? }?>
      
    </tbody>
  </table>
</div>

<div class="col-md-1">
  <img src="../img/menu_rosa.png" style="max-width: 25px;float:left;cursor:pointer;" onClick="showHideSubTabla()">
</div>
<div class="col-md-8" id="sub_tabla" style="font-size: 10px;">
  <div class="col-md-3" id="sub_tabla1" class="sub_tablas">
    <ul class="list-group" id="lista_sub_tabla1">
      <li>001 Activos <span class="glyphicon glyphicon-play" id="icon_estatus_open" style="float:right;"></span></li>
      <li>002 Pasivos <span class="glyphicon glyphicon-play" id="icon_estatus_open" style="float:right;"></span></li>
      <li>003 ... <span class="glyphicon glyphicon-play" id="icon_estatus_open" style="float:right;"></span></li>
    </ul>
  </div>
  <div class="col-md-3" id="sub_tabla2" class="sub_tablas">
    <ul class="list-group" id="lista_sub_tabla2">
      <li>011 Circulantes <span class="glyphicon glyphicon-play" id="icon_estatus_open" style="float:right;"></span></li>
      <li>... <span class="glyphicon glyphicon-play" id="icon_estatus_open" style="float:right;"></span></li>
      <li>... <span class="glyphicon glyphicon-play" id="icon_estatus_open" style="float:right;"></span></li>
    </ul>
  </div>
  <div class="col-md-3" id="sub_tabla3" class="sub_tablas">
    <ul class="list-group" id="lista_sub_tabla3">
      <li>111 Cajas <span class="glyphicon glyphicon-play" id="icon_estatus_open" style="float:right;"></span></li>
      <li>112 Bancos <span class="glyphicon glyphicon-play" id="icon_estatus_open" style="float:right;"></span></li>
      <li>113 Clientes Nacionales <span class="glyphicon glyphicon-play" id="icon_estatus_open" style="float:right;"></span></li>
      <li>... <span class="glyphicon glyphicon-play" id="icon_estatus_open" style="float:right;"></span></li>
    </ul>
  </div>
  <div class="col-md-3" id="sub_tabla4" class="sub_tablas">
    <ul class="list-group" id="lista_sub_tabla4">
      <li>0054 Cliente 1</li>
      <li>0084 Cliente 2</li>
      <li>0167 Cliente 3</li>
      <li>...</li>
    </ul>
  </div>
</div>

<div class="col-md-1"></div>

<div class="col-md-2" style="float:right;">
  <button class="btn btn-primary">CONTABILIZAR</button>
</div>


<script type="text/javascript">
$('#tabla_conta td').click(function () {
  var valor_input = this.innerHTML;
  if (valor_input.indexOf("<input") > -1) {
  }else{
    var input = $('<input type="text" value="'+valor_input+'" id="input_tabla" onBlur="guarda(this)" />');
    $(this).html(input);
    $("#input_tabla").focus();
  }
});

$("#lista_sub_tabla1 li").click(function () {
  $(this).addClass("li_activa");
  console.log(this);
  $("#sub_tabla2").show(800);
  //LO SIGUIENTE SE PUEDE ACTIVAR EN CASO DE QUE SE ACTUALIZE ESTA COLUMNA
  //$("#sub_tabla3").hide(300);
  //$("#sub_tabla4").hide(300);
});

$("#lista_sub_tabla2 li").click(function () {
  $("#sub_tabla3").show(800);
  //LO SIGUIENTE SE PUEDE ACTIVAR EN CASO DE QUE SE ACTUALIZE ESTA COLUMNA
  //$("#sub_tabla4").hide(300);
});

$("#lista_sub_tabla3 li").click(function () {
  $("#sub_tabla4").show(800);
});

  function guarda(objInput){
    //AQUI ES DONDE HACE EL GUARDAR LA INFORMACION QUE EDITE SE PUEDE HACER CON AJAX
    objInput.parentNode.innerHTML = objInput.value;
  }

  function showHideSubTabla () {
    $("#sub_tabla").toggle(800);
  }

</script>

<? } 
else{ ?>
  NO SE RECIBIERON DATOS
<?}?>
