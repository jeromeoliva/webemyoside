/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

jQuery(function($) {

	"use strict";

    $('.flex-slide').flexslider({
        smoothHeight: true,
		pauseOnHover: true,
		animation: "slide",
        controlNav: false
    });

    $('.flex-fade').flexslider({
        smoothHeight: true,
		pauseOnHover: true,
		animation: "fade",
        controlNav: false
    });

    $('.post-slider').flexslider({
        smoothHeight: true,
		pauseOnHover: true,
		animation: "fade",
        controlNav: false
    });	


	/*
	Header Fixed
	*/
	$(window).bind('scroll', function () {
		var windowSize = $(window).width();
		if( windowSize > 979 ) {
			if ($(this).scrollTop() > 150) {
				$('#sticky-header').removeClass('hide').animate({top:'0px'}, 300);
				$('.sticky-form').hide();
				$('.sticky-open').removeClass('active');
			} else {
				$('#sticky-header').addClass('hide');
				$('.sticky-form').hide();
				$('.sticky-open').removeClass('active');
			}
		}
		else {
			$('#sticky-header').addClass('hide');
		}
		return false;
	});
	$('.sticky-open').click(function () {
		$('.sticky-form').slideToggle('normal').focus();
		//window.scrollTo(0, 0);
		$(this).toggleClass('active');
	});


    /*
	Menu Nav
	*/
    $('#primary-nav li, #sticky-nav li').has('ul').hover(function () {
        $(this).children('ul').stop(true, true).slideDown(400);
    }, function () {
        $(this).children('ul').slideUp(100);
    });


    /*
	Mobile Menu
	*/
    $('ul#primary-menu').mobileMenu({
        defaultText: 'Navigate to...',
        className: 'responsive-menu',
        subMenuDash: '&nbsp;&nbsp;&nbsp;&nbsp;'
    });


    /*
	Back to Top
	*/
    $(window).bind('scroll', function () {
        if ($(this).scrollTop() > 200) {
            $('.scrollTop').fadeIn();
        } else {
            $('.scrollTop').fadeOut();
        }
    });

    $('.scrollTop').click(function (e) {
        e.stopPropagation();
        $('body,html').animate({
            scrollTop: 0
        }, 800);
        return false;
    });


    /*
	PrettyPhoto
	*/
    $("a[rel^='prettyPhoto']").prettyPhoto({
        show_title: false,
        social_tools: false
    });


    /*
	FitVids
	*/
    $("body").fitVids();


    /*
	Zoom Hover
	*/
    var zoomHover = function () {
        $(".portfolio-list, a.zoom").live({
            mouseover: function () {
                var _img = $(this).find('img'),
                    _overlay = $(this).find('.zoom-overlay'),
                    _hover = $(this).find('.zoom-hover');
                _overlay.animate({
                    'opacity': 1
                }, 0);
                _hover.animate({
                    bottom: '0%'
                }, 0);
            },
            mouseout: function () {
                var _img = $(this).find('img'),
                    _overlay = $(this).find('.zoom-overlay'),
                    _hover = $(this).find('.zoom-hover');
                _overlay.animate({
                    'opacity': 0
                }, 0);
                _hover.animate({
                    bottom: '0%'
                }, 0);
            }
        });
    };
    zoomHover();


    /*
	Portfolio Filter
	*/
    $('#filters li a').click(function () {
        $('#filters li').removeClass('active');
        $(this).parent().addClass('active');
        var selector = $(this).attr('data-filter');
        $container.isotope({
            filter: selector
        });
        return false;
    });


    /*
	Portfolio List
	*/
    var $container = $('#ourHolder');
    // initialize isotope
    $container.isotope({
        animationEngine: 'best-available',
        animationOptions: {
            duration: 300,
            easing: 'easeInOutQuad',
            queue: false
        }
    });

    // Isotope Chrome Fix	
    setTimeout(function () {
        $container.isotope('reLayout');
    }, 1000);


    /*
	Shortcode Tabs
	*/
    $('.st-tabs .tab-content').hide().filter(':first').show();
    $('.st-tabs .tab-title li').filter(':first').addClass('active');
    $('.st-tabs .tab-title a').click(function (e) {
        e.preventDefault();
        $(this).parents('li').addClass('active').siblings('li.active').removeClass('active');
        var tab_id = $(this).parents('li').index();
        $(this).parents('.st-tabs').find('.tab-content').eq(tab_id).show().siblings('.tab-content').hide();
        return false;
    });


    /*
	Shortcode Toggle
	*/
    $('.st-accordion > .accordion-content').hide().filter('.open').show();
    $(".st-accordion > .accordion-title").click(function (e) {
        e.preventDefault();
        var icons = $(this);
        var toggle = $(this).next();
        $(toggle).slideToggle('slow', function () {
            $(icons).toggleClass('active', $(this).is(':visible'));
        });
    });


    /*
	Shortcode Accordion
	*/
    var allPanels = $('.st-accordion li .accordion-content').hide();
    $('.st-accordion li .open').show();
    $('.st-accordion li .accordion-title').click(function (e) {
        e.preventDefault();
        var icons = $(this);
        var accordion = $(this).next();
        if (!icons.hasClass('active')) {
            allPanels.prev().removeClass('active');
            allPanels.slideUp();
            icons.addClass('active');
            accordion.slideDown();
        }
        return false;
    });

});
