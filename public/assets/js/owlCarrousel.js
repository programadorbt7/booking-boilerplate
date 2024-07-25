$(function ($) {

    // SLIDER BANNER HOME
    $('.main-slider-one__carousel').owlCarousel({
        items: 1,
        margin: 0,
        loop: true,
        smartSpeed: 700,
        animateOut: 'fadeOut',
        autoplayTimeout: 5000,
        nav: true,
        navText: [
            "<span class=\"icon-left-arrow\"></span>",
            "<span class=\"icon-right-arrow\"></span>"
        ],
        dots: false,
        autoplay: true
    });
    // MAS EXP & EXP SIMILARES
    $('.tour-listing-one__carousel').owlCarousel({
        items: 2,
        margin: 30,
        smartSpeed: 700,
        loop: true,
        autoplay: 6000,
        nav: false,
        dots: true,
        navText: ["<span class=\"fa fa-angle-left\"></span>", "<span class=\"fa fa-angle-right\"></span>"],
        responsive: {
            0: {
                items: 1
            },
            768: {
                items: 2
            },
            1200: {
                items: 2
            }
        }
    });

    // HOME CIVI, HOTEL, MEGATRAVEL
    var windowWidth = $(window).width();
    var owl = $('.destination-two__carousel');
    owl.owlCarousel({
        items: 3,
        margin: 30,
        smartSpeed: 700,
        loop: true,
        // autoplay: 6000,
        nav: false,
        dots: true,
        navText: ["<span class=\"fa fa-angle-left\"></span>", "<span class=\"fa fa-angle-right\"></span>"],
        responsive: {
            0: {
                items: 1
            },
            500: {
                items: 1
            },
            768: {
                items: 1
            },
            840: {
                items: 3
            },
            1400: {
                items: 3
            }
        }
    });

    if(windowWidth < 768){
        owl.trigger('play.owl.autoplay', [6000]);  
    }
    $('.destination-two').mouseenter(function() {
        owl.trigger('play.owl.autoplay', [6000]);   
    });
    $('.destination-two bg-megat').mouseenter(function() {
        owl.trigger('play.owl.autoplay', [6000]);   
    });

    // BLOG
    $('.blog-two__carousel').owlCarousel({
        items: 2,
        margin: 30,
        smartSpeed: 700,
        loop: true,
        autoplay: 6000,
        nav: false,
        dots: true,
        navText: ["<span class=\"fa fa-angle-left\"></span>", "<span class=\"fa fa-angle-right\"></span>"],
        responsive: {
            0: {
                items: 1
            },
            992: {
                items: 2
            }
        }
    });
    // PROMOCIONES
    $('.pricing-page__carousel').owlCarousel({
        items: 3,
        margin: 30,
        smartSpeed: 700,
        loop: true,
        // autoplay: 6000,
        nav: false,
        dots: true,
        navText: ["<span class=\"fa fa-angle-left\"></span>", "<span class=\"fa fa-angle-right\"></span>"],
        responsive: {
            0: {
                items: 1
            },
            768: {
                items: 2
            },
            992: {
                items: 3
            }
        }
    });
    // DISTINTIVOS
    $('.client-carousel__one').owlCarousel({
        items: 4,
        margin: 65,
        smartSpeed: 700,
        loop: true,
        autoplay: 6000,
        nav: false,
        dots: false,
        navText: ["<span class=\"fa fa-angle-left\"></span>", "<span class=\"fa fa-angle-right\"></span>"],
        responsive: {
            0: {
                items: 1
            },
            768: {
                items: 1
            },
            992: {
                items: 1
            },
            1200: {
                items: 1
            }
        }
    });
    // GALERIA-DETAILS EXP/CIVI/HOTEL
    $('.tour-listing-details__top-carousel-wrapper').owlCarousel({
        items: 4,
        margin: 20,
        smartSpeed: 700,
        loop: false,
        autoplay: 6000,
        nav: false,
        dots: false,
        navText: ["<span class=\"fa fa-angle-left\"></span>", "<span class=\"fa fa-angle-right\"></span>"],
        responsive: {
            0: {
                items: 1
            },
            768: {
                items: 2
            },
            992: {
                items: 3
            },
            1300: {
                items: 3,
                dots: false
            }
        }
    });
    // GALERIA BLOG
    $('.tour-listing-details__carousel').owlCarousel({
        items: 1,
        margin: 30,
        smartSpeed: 700,
        loop: true,
        autoplay: 6000,
        nav: false,
        dots: true,
        navText: ["<span class=\"fa fa-angle-left\"></span>", "<span class=\"fa fa-angle-right\"></span>"],
        responsive: {
            0: {
                items: 1
            },
            768: {
                items: 1
            }
        }
    });
});