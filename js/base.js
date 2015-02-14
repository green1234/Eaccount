$(function(){
   
    // $(".back").hide();

    // $(".card-container").not(".inheader").on("mouseenter", function(){
    //   $(this).find(".back").show();
    //   console.log("in")
    //   // $(this).find(".side").not(".back").hide();
    // });

    // $(".card-container").not(".inheader").on("mouseleave", function(){
    //   $(this).find(".back").hide();
    //   console.log("out")
    //   // $(this).find(".side").not(".back").show();
    // });
    
    $("#form_login").on("submit", function(e){
        e.preventDefault();
        console.log("XD");
        var path = $(this).attr("action");
        var username = $("#username").val();
        var password = $("#password").val();

        var data = "username=" + username + "&password=" + password
        path = path + data;

        $.getJSON(path, function(res){            

            if (res.success)
            {
                console.log(res.data)

                window.location = "/eaccount/inbox.php"
            }
            else
            {
                alert(res.data.description);
            }
        });      
    });
  });