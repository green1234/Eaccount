var log = function(msg)
{
    console.log(msg);
}

var obtener_datos_planes = function(){

}

$(function(){
    
    $("a.submit").on("click", function(e){
        e.preventDefault();
        $(this).parents("form").submit();
        log("XD")
    });

    $("form").on("submit", function(e){
        // e.preventDefault();
        
    });

});