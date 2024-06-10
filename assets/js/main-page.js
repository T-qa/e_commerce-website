$(document).ready(() => { 
  // banner
  $(".banner").owlCarousel({
    loop: false,
    margin: 10,
    nav: true,
    rewind: true,
    autoplay: true,
    autoplayHoverPause: true,
    animateOut: "fadeOut",
    navText: [
      "<div class='nav-btn prev-slide'></div>",
      "<div class='nav-btn next-slide'></div>",
    ],

    responsive: {
      0: {
        items: 1,
      },
    },
  });

  $(".banner").on("changed.owl.carousel", (event) => {
    var item = event.item.index;
    $(".hero-title").removeClass("animate__backInRight");
    $(".hero-subtitle").removeClass("animate__backInRight");
    $(".hero-button").removeClass("animate__backInRight");
    $(".owl-item")
      .eq(item)
      .find(".hero-title")
      .addClass("animate__backInRight");
    $(".owl-item")
      .eq(item)
      .find(".hero-subtitle")
      .addClass("animate__backInRight");
    $(".owl-item")
      .eq(item)
      .find(".hero-button")
      .addClass("animate__backInRight");
  });

  //featured laptop carousel
  $(".featured-laptop").owlCarousel({
    loop: false,
    margin: 10,
    nav: false,
    autoplay: true,
    rewind: true,
    responsive: {
      0: {
        items: 1,
      },
      600: {
        items: 3,
      },
      1000: {
        items: 5,
      },
    },
  });
})