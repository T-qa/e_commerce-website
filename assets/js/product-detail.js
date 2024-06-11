$(document).ready(() => {
  //change product image
  $(".product-img-item").on("click",(e) => {
    let currentImg = e.target.getAttribute("src");
    $(".product-img > img").attr("src", currentImg);
})
})