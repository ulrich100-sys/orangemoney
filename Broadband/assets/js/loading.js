window.addEventListener("load", function(){
  var load_screen = document.getElementById("load-screen");
  document.body.removeChild(load_screen);
});

$(document).ready(function() {
  var counter = 0;
  var c = 0;
  var i = setInterval(function(){
      $(".loading-page .counter span.num").html(c + "%");
      $(".loading-page .counter .animation").css("width", c + "%");
      //$(".loading-page .counter").css("background", "linear-gradient(to right, #f60d54 "+ c + "%,#0d0d0d "+ c + "%)");

    /*
    $(".loading-page .counter h1.color").css("width", c + "%");
    */
    counter++;
    c++;

    if(counter == 100) {
        clearInterval(i);
    }
  }, 50);
});
