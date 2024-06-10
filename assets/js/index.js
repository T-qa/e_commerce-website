$(document).ready(() => {
    $(window).scroll(() => {
      $(this).scrollTop() > 200
        ? $(".navbar").addClass("sticky")
        : $(".navbar").removeClass("sticky");
    });
  
    $(".categori-button-active").on("click", function() {
      $(".categori-dropdown-active-large").toggleClass("open");
    })
  
    $(function () {
      $(".custom-dropdown").on("show.bs.dropdown", function () {
        var that = $(this);
        setTimeout(function () {
          that.find(".dropdown-menu").addClass("active");
        }, 100);
      });
      $(".custom-dropdown").on("hide.bs.dropdown", function () {
        $(this).find(".dropdown-menu").removeClass("active");
      });
    });
  
    //wishlist
    $(".wishlist").each((index, obj) => {
      $(obj).click(function () {
        $(this).children(".heart").toggleClass("fa-heart fa-heart-o");
      })
    })
  });
  