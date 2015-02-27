<? 
$cfg = $_SESSION["login"]["config"];
$path = SERVERNAME . "/Catalogo.php?";
//$path = $path . "uid=" . $uid . "&pwd=" . $pwd . "&cid=" . $cid[0];

?>
<div role="tabpanel" class="tab-pane fade in" id="cuentas_contables" style="padding-top: 20px;">
  
  <? if (!$cfg){ ?>

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

  <? } 

  else{
    $path = SERVERNAME . '/Catalogo.php?get=cuentas';
    $path = $path . "&uid=" . $uid . "&pwd=" . $pwd . "&cid=" . $cid[0];
    //var_dump($path);
    $cuentas = json_decode(file_get_contents($path), true);
    //var_dump($cuentas["data"][1]);
    if ($cuentas["success"] && count($cuentas["data"]) > 0)
    {
    ?>
  
      <table class="table">
        <tr>
          <td>Codigo</td>
          <td>Nombre</td>
          <td>Padre</td>
          <td>Naturaleza</td>
          <td>Tipo</td>
          <td>Clase</td>
          <td>SAT</td>
        </tr>

        <? foreach ($cuentas["data"] as $idx => $value) { 

          $parent = $value["parent_id"];
          if (is_array($parent))
          {
            $parent = $parent[1];
          }

          $clase = $value["user_type"];
          if (is_array($clase))
          {
            $clase = $clase[1];
          }

          $code = (is_array($value["codagrup"])) ? $value["codagrup"][1] : $value["codagrup"];

        ?>
          
          <tr>
            <td><?=$value["code"]?></td>
            <td><?=$value["name"]?></td>
            <td><?=$parent?></td>
            <td><?=$value["nature"]?></td>            
            <td><?=$value["type"]?></td>
            <td><?=$clase?></td>            
            <td><?=$code?></td>            
          </tr>

        <?}?>

        
      </table>

  <?
    }


  }?> <!-- ELSE -->
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
            console.log(data)
            alert("Facturas cargadas.");        
            location.reload();
        },
        error: function(data){            
            console.log("data");
        }
    });

  });

  

</script>