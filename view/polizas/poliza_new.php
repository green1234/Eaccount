<style type="text/css">
  td, th{
    text-align: center;
  }
  ul {
    list-style: none;
  }
  
 input[type=checkbox]
  {
    display: block;
    width: auto;
  }
  .editable
  {
    position: relative;
  }
  .editable select
  {
    position: absolute;
    width: 180px;
    left: 0.5em;
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
<link rel="stylesheet" href="view/polizas/new.css">
<? 
require_once "server/conf/constantes.conf";
require_once "server/lib/common.php"; 
?>
<form action="server/Polizas.php?action=new" id="new_poliza_form" new="">
  <div id="header_poliza_detail" class="grad1">
    <h1>GENERAR POLIZA DE DIARIO EN CAPTURA MANUAL</h1>  
    <div class="p_data">
      <div>
        <div>Concepto de Póliza</div>
        <input type="text" name="p_concepto" id="p_concepto" required>
      </div>
      <div>
        <div for="p_fecha">Fecha de Póliza</div>
        <input type="date" name="p_fecha" id="p_fecha" required>
      </div>
    </div>
  </div>
  <div class="table-responsive">
    <table class="table table-bordered table-striped" id="poliza_new" style="border: 0px;border-radius:10px;">
      <thead>
        <tr>
          
          <th>PÓLIZA</th>
          <th>CONCEPTO</th>        
          <th>CUENTA</th>
          <!-- <th>NOMBRE</th> -->
          <th>SALDO ANTERIOR</th>
          <th>MONTO</th>
          <th>DEBE / HABER</th>        
          <th>SALDO NUEVO</th>
          <th>UUID</th>        
          <th>Notas</th>                  
          <th style="border: 0px;">&nbsp;</th>
        </tr>
      </thead>
      <tbody>
        
      </tbody>
    </table>
  </div>
  <div class="col-md-1">    
    <a class="new_asiento" href="#">
      <img src="img/mas_rosa.png" style="max-width: 25px;"></a>  
  </div>

  <div class="col-md-2" style="float:right;">
    <button class="btn btn-primary action_new">CONTABILIZAR</button>
  </div>
</form>

<script type="text/javascript" src="view/polizas/poliza_new.js"></script>

