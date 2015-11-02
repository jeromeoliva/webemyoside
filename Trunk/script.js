//Effect des lien à ancre nommé
$(document) .ready(function(){
	$('a[href^=#]') .click(function(){
		cible=$(this) .attr('href');
		if ($(cible) .length>=1){
			hauteur=$(cible) .offset() .top;
		}
		else
			hauteur=$("a[name="+cible.substr(1,cible.length-1)+"]") .offset() .top;
			cible.substr(1,cible.length-1)
		}
	$('html,body') .animate({scrollTop:hauteur},1000);

	});
});

// Ajoute & supprime class au scroll
$(window).scroll(function() {    
  var scroll = $(window).scrollTop();

  if (scroll >= 100) {
      $(".slogan").addClass("mini-logo");
  } else {
      $(".slogan").removeClass("mini-logo");

  }
});
 