$(function () {
    //navigation farbe ändern beim srollen
    $(function () {
        $(window).scroll(function () {
            $("nav").toggleClass('scrolled',$(this).scrollTop()>1200);
        });
      });
    //cklick event für Navigation responsive
    $(".nav-item").click(function(){
        $("#navbarResponsive").collapse('hide');

});

});

