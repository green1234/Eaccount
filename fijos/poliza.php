<head>
<script type="text/javascript" src="js/jquery-2.1.1.min.js"></script>
</head>
<style type="text/css">
  td, th{
    text-align: center;
  }
  .grad1 {
    padding: 15px;
    color: white;
    border-radius: 12px;
    font-size: 15px;
    margin-bottom: 20px;
  }
</style>
<div class="grad1">
  <p>
    GENERAR POLIZA DE DIARIO EN CAPTURA MANUAL
  </p>
  <table width="100%">
    <tr>
      <td width="50%">
        <table>
          <tr>
            <td>
              Concepto de Poliza:
            </td>
            <td>
              <input type="text" />
            </td>
          </tr>
        </table>
      </td>
      <td width="50%">
        <table>
          <tr>
            <td>
              Fecha de Poliza:
            </td>
            <td>
              <div class="input-group date" id="datetimepicker5">
                <input type="text" class="form-control" data-date-format="YYYY/MM/DD">
                <span class="input-group-addon">
                    <span class="glyphicon-calendar glyphicon"></span>
                </span>
              </div>

              <script type="text/javascript">
              $(function () {
                  $('#datetimepicker5').datetimepicker({
                      pickTime: false
                  });
              });
              </script>
            </td>
          </tr>
        </table>
        <script type="text/javascript" src="js/moment.js"></script>
        <script type="text/javascript" src="js/bootstrap-datetimepicker.js"></script>
      </td>
    </tr>
  </table>
</div>

<div class="table-responsive">
  <table class="table table-bordered table-striped" id="tabla_conta" style="border: 0px;border-radius:10px;">
    <thead>
      <tr>
        <th style="border: 0px;">PÓLIZA</th>
        <th>CONCEPTO</th>
        <th>CUENTA</th>
        <th>NOMBRE</th>
        <th>SALDO ANT.</th>
        <th>MONTO</th>
        <th>DEBE / HABER</th>
        <th>SALDO NUEVO</th>
        <th>NOTAS</th>
        <th style="border: 0px;"><img src="../img/check_negro.png" style="max-width: 20px;"></th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>Id_poliza</td>
        <td><input type="text"></td>
        <td><input type="text"></td>
        <td><input type="text"></td>
        <td>Cta_SaldoInicial</td>
        <td><input type="text"></td>
        <td>
          <table style="width: 100%;">
            <tr>
              <td style="width:50%">
                <input type="radio" name="debe-haber" value="debe">
              </td>
              <td style="width:50%">
                 <input type="radio" name="debe-haber" value="haber">
              </td>
            </tr>
          </table>
        </td>
        <td>Cta_SaldoFinal</td>
        <td><input type="text"></td>
        <td><input type="checkbox"></td>
      </tr>
      <tr>
        <td>Id_poliza</td>
        <td><input type="text"></td>
        <td><input type="text"></td>
        <td><input type="text"></td>
        <td>Cta_SaldoInicial</td>
        <td><input type="text"></td>
        <td>
          <table style="width: 100%;">
            <tr>
              <td style="width:50%">
                <input type="radio" name="debe-haber" value="debe">
              </td>
              <td style="width:50%">
                 <input type="radio" name="debe-haber" value="haber">
              </td>
            </tr>
          </table>
        </td>
        <td>Cta_SaldoFinal</td>
        <td><input type="text"></td>
        <td><input type="checkbox"></td>
      </tr>
    </tbody>
  </table>
</div>
<div class="col-md-12">
  <img src="../img/mas_rosa.png" style="max-width: 25px;float:left;margin-right: 10px;cursor:pointer;">
  <img src="../img/menu_rosa.png" style="max-width: 25px;float:left;margin-right: 10px;cursor:pointer;">
</div>


