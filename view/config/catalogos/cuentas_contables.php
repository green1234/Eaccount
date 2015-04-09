<? 
// session_start();
// require_once "../../../server/conf/constantes.conf";
// require_once "../../../server/lib/common.php";

$cfg = $_SESSION["login"]["config"];

$path = SERVERNAME . "/Catalogo.php?";
//$path = $path . "uid=" . $uid . "&pwd=" . $pwd . "&cid=" . $cid[0];

?>
<style>

.file_input_
{
  padding: 0.5em;
  margin-bottom: 1em;
  width: 100%;
}

.file_input_ p 
{
  display: inline-block;
  vertical-align: top;
  font-size: 1em; 
  padding: 0.5em;
  margin: 0;  
}

.file_input_ p.instructions 
{
  /* display: inline-block;
    vertical-align: top;
    font-size: 1em; 
    padding: 0.5em;
    margin: 0;
     */  
  width: 50%;
  border-bottom: 2px solid gray;
}

.file_input_ > a
{
  width: 18%;
  display: inline-block;
  vertical-align: top;
  background-color: #2c6494;
  border-radius: 5px;
  color: white;
  font-size: 1.4em;
  padding: 10px 0;
  margin-right: 10px;
  text-decoration: none;
  text-align: center;
}

.file_input_ > a:hover
{
  background-color: #3071a9;
}

.custom-file-input 
{
  color: transparent;
  width: 18%;
  height: 42px;
  margin-right: 10px;
  overflow-y: hidden;
  display: inline-block !important;  
}
.custom-file-input::-webkit-file-upload-button {
  visibility: hidden;
}
.custom-file-input::before {
  width: 100%;
  content: 'Cargar Catálogo';
  color: white;
  display: inline-block;
  text-align: center;
  /*background: -webkit-linear-gradient(top, #f9f9f9, #e3e3e3);*/
  background-color: #2c6494;
  /* border: 1px solid #999; */
  border-radius: 5px;
  padding: 10px;
  outline: none;
  white-space: nowrap;
  -webkit-user-select: none;
  cursor: pointer;
  /* text-shadow: 1px 1px #fff; */
  /* font-weight: 700; */
  font-size: 1.4em;
}
.custom-file-input:hover::before {
  background-color: #3071a9;
}
.custom-file-input:active {
  outline: 0;
}
.custom-file-input:active::before {
  /*background: -webkit-linear-gradient(top, #e3e3e3, #f9f9f9);*/
  background-color: #2c6494;
  color: white;
}

.row_view
{
  color: blue;
}

</style>
<div role="tabpanel" class="tab-pane fade in" id="cuentas_contables" style="padding-top: 20px;">
  
  <? /*$cfg = false;*/ if (!$cfg){ ?>

  <form id="chart_form" action="<?=$path?>" enctype="multipart/form-data"  method="POST">
      <!-- MAX_FILE_SIZE debe preceder el campo de entrada de archivo -->
      <input type="hidden" name="MAX_FILE_SIZE" value="300000" />
      <!-- El nombre del elemento de entrada determina el nombre en el array $_FILES -->
      <!-- Enviar este archivo: <input name="userfile" type="file" /> -->
      
      <div class="file_input_">
        <p><b>Cuentas Contables:</b></p>
        <input id="userfile" name="userfile" class="custom-file-input" type="file" />  
        <p class="instructions">        
          <b>Selecciona un archivo para cargar tu Catalogo</b>
          <br>
          <a href="?section=instrucciones">Ver instucciones</a>
          <br>
        </p>
      </div>

      <div class="file_input_">
        <p><b>Saldos de Cuentas:</b></p>
        <a href="#">Mostrar Catalogo</a>
        <p class="instructions">        
          <b>Ya has agregado un Catálogo de Cuentas Contables</b> – <a href="#">Sustituir Catálogo</a>
          <br>          
        </p>
      </div>
      <!-- <input type="submit" value="Send File" /> -->

      <div class="col-md-12" style="text-align:center;margin-bottom:15px;">
        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        <button class="btn btn-primary">Salir sin Cambios</button>
      </div>
  </form>

  <? } 

  else{

    ?>
  
      <table id="cat_cuentas" class="table">
        <tr>
          <!-- <th>ID</th> -->
          <th>Codigo</th>
          <th>Nombre</th>
          <th>Padre</th>
          <th>Naturaleza</th>
          <!-- <th>Tipo</th> -->
          <th>Nevel</th>
          <th>SAT</th>
        </tr>        
      </table>

<?}?> <!-- ELSE -->
</div>

<script>  

  $.getJSON("server/Cuentas.php?action=get&all=1", function(res){

    if(res.success)
    {
      var filas = "";
      $.each(res.data, function(idx, cta){
        if (cta.type == "view")
          filas+= "<tr class='row_view'>";
        else
          filas+= "<tr>";
        // filas+= "<td>" + cta.id + "</td>";
        filas+= "<td>" + cta.code + "</td>";
        filas+= "<td>" + utf8_decode(cta.name) + "</td>";
        filas+= "<td>" + cta.parent_id[1].split(" ", 1)[0] + "</td>";
        filas+= "<td>" + cta.nature + "</td>";
        // filas+= "<td>" + cta.type + "</td>";
        filas+= "<td>" + cta.level+ "</td>";
        filas+= "<td>" + cta.codagrup[1].split(" ", 1)[0] + "</td>";
        filas+= "</tr>";
      });
      $("#cat_cuentas").append(filas);
    }

  });

  $("#userfile").on("change", function(){
    //alert($(this).val())

  });
  
  $("#chart_form").on("submit", function(e){
    e.preventDefault();

    var formData = new FormData($(this)[0]);
    //formData.append('userfile', $('#upfile')[0].files);
    
    var path = $(this).attr("action")
    /*console.log("p:" + path)
    console.log(formData)
    return*/    

    $.ajax({
        url : path,
        message : "",
        data : formData,       
        processData: false,
        contentType: false,
        cache : false,
        method : "POST",
        dataType: 'json',
        success: function(data){            
            //var data = $.parseJSON(data);
            console.log(data)
            console.log(data.success)
            console.log(data.description)
            if(data.success)
              alert("Catalogo Cargado");
            else
            {
              var msj = data.data.description + ", " + data.data.error;
              alert(msj);              
            }

            location.reload();
        },
        error: function(data){            
            console.log("data");
        }
    });

  });

  

</script>