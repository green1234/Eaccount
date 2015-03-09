<form style="padding: 2% 25%;">
    <div class="well carousel-search hidden-sm" style="text-align: center;border:1px solid black;background-color: #12334F;padding: 70px;border-radius: 10px;">
        <div class="btn-group"> <a class="btn btn-default dropdown-toggle btn-select" data-toggle="dropdown" href="#">ABRIR EMPRESAS DEL CATÁLOGO<span class="caret"></span></a>
            <ul class="dropdown-menu">
                <li><a href="#">Diseño y Arte XA SC</a></li>
                <li><a href="#">Diseño y Arte XA SC</a></li>
                <li><a href="#">Diseño y Arte XA SC</a></li>
                <li><a href="#">Diseño y Arte XA SC</a></li>
                <li><a href="#">Diseño y Arte XA SC</a></li>
                <li><a href="#">Diseño y Arte XA SC</a></li>
            </ul>
        </div>
        <div class="btn-group">
            <button type="button" id="btnSearch" class="btn btn-primary">ABRIR</button>
        </div>
    </div>
</form>

<script type="text/javascript">
$(".dropdown-menu li a").click(function(){
  var selText = $(this).text();
  $(this).parents('.btn-group').find('.dropdown-toggle').html(selText+' <span class="caret"></span>');
});

$("#btnSearch").click(function(){
	alert($('.btn-select').text());
});
</script>