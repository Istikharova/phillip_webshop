$(function () {
    //navigation farbe ändern beim srollen
    $(function () {
        $(window).scroll(function () {
            $("nav").toggleClass('scrolled',$(this).scrollTop()>400);
        });
      });
    //cklick für navigion responsive
      $(".nav-item").click(function(){
        $("#navbarResponsive").collapse('hide');
    
    });



});
