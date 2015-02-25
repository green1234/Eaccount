<? 
// var_dump($cid);
$path = SERVERNAME . "/Catalogo.php?";
$path = $path . "uid=" . $uid . "&pwd=" . $pwd . "&cid=" . $cid[0];

?>
<div role="tabpanel" class="tab-pane fade in" id="cuentas_contables" style="padding-top: 20px;">
  <form id="chart_form" action="<?=$path?>" enctype="multipart/form-data"  method="POST">
      <!-- MAX_FILE_SIZE debe preceder el campo de entrada de archivo -->
      <input type="hidden" name="MAX_FILE_SIZE" value="30000" />
      <!-- El nombre del elemento de entrada determina el nombre en el array $_FILES -->
      Enviar este archivo: <input name="userfile" type="file" />
      <!-- <input type="submit" value="Send File" /> -->

      <div class="col-md-12" style="text-align:center;margin-bottom:15px;">
        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        <button class="btn btn-primary">Salir sin Cambios</button>
      </div>
  </form>

</div>

<script>
  
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
        success: function(data){            
            //alert("Facturas cargadas.");        
            //location.reload();
            console.log(data)
        },
        error: function(data){            
            console.log("data");
        }
    });

  });

  

</script>