; (function ($) {
    "use strict";

    $(document).ready(function () {

        /**-----------------------------
         *  Navbar fix
         * ---------------------------*/
        $(document).on('click', '.navbar-area .navbar-nav li.menu-item-has-children>a', function (e) {
            e.preventDefault();
        })
       
        /*-------------------------------------
            menu
        -------------------------------------*/
        $('.navbar-area .menu').on('click', function() {
            $(this).toggleClass('open');
            $('.navbar-area .navbar-collapse').toggleClass('sopen');
        });
    
        // mobile menu
        if ($(window).width() < 992) {
            $(".in-mobile").clone().appendTo(".sidebar-inner");
            $(".in-mobile ul li.menu-item-has-children").append('<i class="fas fa-chevron-right"></i>');
            $('<i class="fas fa-chevron-right"></i>').insertAfter("");

            $(".menu-item-has-children a").on('click', function(e) {
                // e.preventDefault();

                $(this).siblings('.sub-menu').animate({
                    height: "toggle"
                }, 300);
            });
        }

        var menutoggle = $('.menu-toggle');
        var mainmenu = $('.navbar-nav');
        
        menutoggle.on('click', function() {
            if (menutoggle.hasClass('is-active')) {
                mainmenu.removeClass('menu-open');
            } else {
                mainmenu.addClass('menu-open');
            }
        });

        /*--------------------------------------------
            Search Popup
        ---------------------------------------------*/
        var bodyOvrelay =  $('#body-overlay');
        var searchPopup = $('#search-popup');

        $(document).on('click','#body-overlay',function(e){
            e.preventDefault();
        bodyOvrelay.removeClass('active');
            searchPopup.removeClass('active');
        });
        $(document).on('click','.search',function(e){
            e.preventDefault();
            searchPopup.addClass('active');
        bodyOvrelay.addClass('active');
        });


        /*--------------------------------------------------
            select onput
        ---------------------------------------------------*/
        $(document).ready(function() {
            $('select').niceSelect();
        });



        /* -----------------------------------------------------
            Variables
        ----------------------------------------------------- */
        var leftArrow = '<i class="fa fa-arrow-left"></i>';
        var leftAngle = '<i class="fa fa-angle-left"></i>';
        var rightArrow = '<i class="fa fa-arrow-right"></i>';
        var rightAngle = '<i class="fa fa-angle-right"></i>';

        /* -------------------------------------------------
            Magnific JS 
        ------------------------------------------------- */
        $('.video-play-btn').magnificPopup({
          type: 'iframe',
          removalDelay: 260,
          mainClass: 'mfp-zoom-in',
        });
        $.extend(true, $.magnificPopup.defaults, {
          iframe: {
            patterns: {
              youtube: {
                index: 'youtube.com/', 
                id: 'v=', 
                src: 'https://www.youtube.com/embed/Wimkqo8gDZ0' 
              }
            }
          }
        });

        /*---------------------------------------
            Quantity
        ---------------------------------------*/
        function wcqib_refresh_quantity_increments() {
            jQuery("div.quantity:not(.buttons_added), td.quantity:not(.buttons_added)").each(function(a, b) {
                var c = jQuery(b);
                c.addClass("buttons_added"), c.children().first().before('<input type="button" value="-" class="minus" />'), c.children().last().after('<input type="button" value="+" class="plus" />')
            })
        }
        String.prototype.getDecimals || (String.prototype.getDecimals = function() {
            var a = this,
                b = ("" + a).match(/(?:\.(\d+))?(?:[eE]([+-]?\d+))?$/);
            return b ? Math.max(0, (b[1] ? b[1].length : 0) - (b[2] ? +b[2] : 0)) : 0
        }), jQuery(document).ready(function() {
            wcqib_refresh_quantity_increments()
        }), jQuery(document).on("updated_wc_div", function() {
            wcqib_refresh_quantity_increments()
        }), jQuery(document).on("click", ".plus, .minus", function() {
            var a = jQuery(this).closest(".quantity").find(".qty"),
                b = parseFloat(a.val()),
                c = parseFloat(a.attr("max")),
                d = parseFloat(a.attr("min")),
                e = a.attr("step");
            b && "" !== b && "NaN" !== b || (b = 0), "" !== c && "NaN" !== c || (c = ""), "" !== d && "NaN" !== d || (d = 0), "any" !== e && "" !== e && void 0 !== e && "NaN" !== parseFloat(e) || (e = 1), jQuery(this).is(".plus") ? c && b >= c ? a.val(c) : a.val((b + parseFloat(e)).toFixed(e.getDecimals())) : d && b <= d ? a.val(d) : b > 0 && a.val((b - parseFloat(e)).toFixed(e.getDecimals())), a.trigger("change")
        });
        
        /* -------------------------------------------------------------
         fact counter
         ------------------------------------------------------------- */
        $('.counter').counterUp({
            delay: 15,
            time: 2000
        });

        /*------------------------------------------------
            banner-slider
        ------------------------------------------------*/
        $('.banner-slider').owlCarousel({
            loop: true,
            nav: true,
            dots: true,
            smartSpeed:1500,
            items: 1,
            navText: [ leftArrow, rightArrow],
        });

        /*------------------------------------------------
            course-slider
        ------------------------------------------------*/
        $('.course-slider').owlCarousel({
            loop: true,
            margin: 30,
            nav: false,
            dots: true,
            smartSpeed:1500,
            items: 3,
            navText: [ leftArrow, rightArrow],
            responsive: {
                0: {
                    items: 1
                },
                426: {
                    items: 1
                },
                768: {
                    items: 2
                },
                1100: {
                    items: 3
                },
            }
        });

        /*------------------------------------------------
            partner-slider
        ------------------------------------------------*/
        $('.partner-slider').owlCarousel({
            loop: true,
            margin: 70,
            nav: false,
            dots: true,
            smartSpeed:1500,
            items: 5,
            responsive: {
                0: {
                    items: 3
                },
                426: {
                    items: 3
                },
                768: {
                    items: 3
                },
                1100: {
                    items: 5
                },
            }
        });

        /*------------------------------------------------
            testimonial-slider
        ------------------------------------------------*/
        $('.testimonial-slider').owlCarousel({
            loop: true,
            margin: 30,
            nav: false,
            dots: false,
            smartSpeed:1500,
            items: 2,
            responsive: {
                0: {
                    items: 1
                },
                426: {
                    items: 1
                },
                768: {
                    items: 2
                },
                1100: {
                    items: 2
                },
            }
        });

        /*------------------------------------------------
            product-slider-2
        ------------------------------------------------*/
        $('.product-slider-2').owlCarousel({
            loop: true,
            margin: 30,
            nav: true,
            dots: false,
            smartSpeed:1500,
            items: 1,
            navText: [ leftAngle, rightAngle],
            responsive: {
                0: {
                    items: 1
                },
                426: {
                    items: 2
                },
                767: {
                    items: 3
                },
                1100: {
                    items: 5
                },
                1600: {
                    items: 6
                },
            }
        });

        /*------------------------------------------------
            partner-slider
        ------------------------------------------------*/
        $('.partner-slider').owlCarousel({
            loop: true,
            margin: 30,
            nav: true,
            dots: false,
            smartSpeed:1500,
            items: 1,
            navText: [ leftAngle, rightAngle],
            responsive: {
                0: {
                    items: 1
                },
                426: {
                    items: 2
                },
                768: {
                    items: 3
                },
                1100: {
                    items: 5
                },
            }
        });

        /*-------------------------------------------------
            wow js init
        --------------------------------------------------*/
        new WOW().init();

        /*------------------
           back to top
        ------------------*/
        $(document).on('click', '.back-to-top', function () {
            $("html,body").animate({
                scrollTop: 0
            }, 2000);
        });

    });

    $(window).on("scroll", function() {
        /*---------------------------------------
        sticky menu activation && Sticky Icon Bar
        -----------------------------------------*/

        var mainMenuTop = $(".navbar-area");
        if ($(window).scrollTop() >= 1) {
            mainMenuTop.addClass('navbar-area-fixed');
        }
        else {
            mainMenuTop.removeClass('navbar-area-fixed');
        }
        
        var ScrollTop = $('.back-to-top');
        if ($(window).scrollTop() > 1000) {
            ScrollTop.fadeIn(1000);
        } else {
            ScrollTop.fadeOut(1000);
        }
    });


    $(window).on('load', function () {

        /*-----------------
            preloader
        ------------------*/
        var preLoder = $("#preloader");
        preLoder.fadeOut(0);

        /*-----------------
            back to top
        ------------------*/
        var backtoTop = $('.back-to-top')
        backtoTop.fadeOut();

        /*---------------------
            Cancel Preloader
        ----------------------*/
        $(document).on('click', '.cancel-preloader a', function (e) {
            e.preventDefault();
            $("#preloader").fadeOut(2000);
        });

    });

    (function () {
      const second = 1000,
            minute = second * 60,
            hour = minute * 60,
            day = hour * 24;

      let birthday = "Feb 05, 2021 00:00:00",
          countDown = new Date(birthday).getTime(),
          x = setInterval(function() {    

            let now = new Date().getTime(),
                distance = countDown - now;

            document.getElementById("days").innerText = Math.floor(distance / (day)),
              document.getElementById("hours").innerText = Math.floor((distance % (day)) / (hour)),
              document.getElementById("minutes").innerText = Math.floor((distance % (hour)) / (minute)),
              document.getElementById("seconds").innerText = Math.floor((distance % (minute)) / second);

            //do something later when date is reached
            if (distance < 0) {
              let headline = document.getElementById("headline"),
                  countdown = document.getElementById("countdown"),
                  content = document.getElementById("content");

              headline.innerText = "It's my birthday!";
              countdown.style.display = "none";
              content.style.display = "block";

              clearInterval(x);
            }
            //seconds
          }, 0)
      }());



})(jQuery);