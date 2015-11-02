// Ajoute & supprime class au scroll
$(window).scroll(function() {    
  var scroll = $(window).scrollTop();

  if (scroll >= 100) {
      $(".slogan").addClass("mini-logo");
  } else {
      $(".slogan").removeClass("mini-logo");

  }
});
 