
jQuery(document).ready(function ($) {

    //init carousel
    jQuery(".carouFredSel-gallery2").each(function(){
        var container = jQuery(this);
        var wcontainerclass = container.data("carousel-container"),
        cspeed = container.data("carousel-speed"),
        ctransition = container.data("carousel-transition"),
        cauto = container.data("carousel-auto"),
        carouselid = container.data("carousel-id"),
        ss = container.data("carousel-ss"),
        xs = container.data("carousel-xs"),
        sm = container.data("carousel-sm"),
        md = container.data("carousel-md");
        var wcontainer = jQuery(wcontainerclass);
        function getUnitWidth() {
            var width;
            if(jQuery(window).width() <= 540) {
                width = wcontainer.width() / ss;
            } else if(jQuery(window).width() <= 768) {
                width = wcontainer.width() / xs;
            } else if(jQuery(window).width() <= 990) {
                width = wcontainer.width() / sm;
            } else {
                width = wcontainer.width() / md;
            }
            return width;
        }

        function setWidths() {
            var unitWidth = getUnitWidth() -1;
            //container.children().css({ width: "auto" });
        }

        //setWidths();
        function initCarousel() {
            container.carouFredSel({
                scroll: {
                    items:1,
                    easing: "swing",
                    duration: ctransition,
                    pauseOnHover : true
                },
                auto: {
                    play: cauto,
                    timeoutDuration: cspeed
                },
                prev: "#prevport-"+carouselid,
                next: "#nextport-"+carouselid,
                pagination: false,
                swipe: true,
                items: {visible: null}
            });
        }
        container.kt_imagesLoaded( function(){
            initCarousel();
        });
        wcontainer.animate({"opacity" : 1});
        jQuery(window).on("debouncedresize", function( event ) {
            container.trigger("destroy");
            //setWidths();
            initCarousel();
        });
    });

    jQuery(".imageGallerySlider").each(function() {
        var container = jQuery(this);

        var cspeed = container.data("carousel-speed");
        var ctransition = container.data("carousel-transition");
        var cauto = !container.data("carousel-auto") == "0";
        var carouselid = container.data("carousel-id");
        var ss = container.data("carousel-ss");
        var xs = container.data("carousel-xs");
        var sm = container.data("carousel-sm");
        var md = container.data("carousel-md");

        function initCarousel() {
            container.slick({
                /*
                infinite: true,
                slidesToShow: 1,
                centerMode: true,
                centerPadding: "40px",
                autoplay: cauto,
                autoplaySpeed: cspeed,
                speed: ctransition}
                */
                dots: false,
                method: {},
                autoplay: cauto,
                autoplaySpeed: cspeed,
                infinite: true,
                speed: 900,
                slidesToShow: 1,
                centerMode: false,
                variableWidth: true
            });
        };

        container.kt_imagesLoaded( function(){
            initCarousel();
        });

        container.on("init", function(event, slick) {
            container.animate({"opacity" : 1});
        });

    });

    /* authoring menu */

    jQuery('.authoring-menu').each(function() {
        var menu = jQuery('nav', this);
        var originalWrapper = jQuery('#wrapper');
        originalWrapper.wrap( "<div id='pageWrapper'></div>" );
        var wrapper = jQuery('#pageWrapper');
        wrapper.prepend(menu);
        wrapper.prepend('<div class="overlay">');

        var hamburger = $('.hamburger'),
            overlay = $('.overlay'),
            isClosed = false;

        originalWrapper.prepend(hamburger);
        hamburger.click(function () {
            hamburger_cross();
        });

        function hamburger_cross() {

            if (isClosed == true) {
              overlay.hide();
              hamburger.removeClass('is-open');
              hamburger.addClass('is-closed');
              $('body').removeClass('full-height');
              $('html').removeClass('full-height');
              isClosed = false;
            } else {
              overlay.show();
              hamburger.removeClass('is-closed');
              hamburger.addClass('is-open');
              $('body').addClass('full-height');
              $('html').addClass('full-height');
              isClosed = true;
            }
        }

        $('[data-toggle="offcanvas"]').click(function () {
              $('#pageWrapper').toggleClass('toggled');
        });
    });

    /* end of authoring menu */

    /* isotope */

    jQuery('#portfoliowrapper').each(function() {
        var grid = jQuery(this);
        var filterButtons = '<div class="btn-group filters-button-group" role="group" aria-label="Filrer la présence">' +
                '<button type="button" class="btn btn-default" data-filter="*" data-filter-name="Tous">Tous</button>' +
                '<button type="button" class="btn btn-default" data-filter=".cat-samedi" data-filter-name="Samedi">Samedi</button>' +
                '<button type="button" class="btn btn-default" data-filter=".cat-dimanche" data-filter-name="Dimanche">Dimanche</button>' +
            '</div>';

        grid.before(filterButtons).addClass('in');

        grid.isotope({
            //itemSelector: 'grid_item'
        });

        grid.imagesLoaded().progress( function() {
            grid.isotope('layout');
        });

        var hash = location.hash.match(/^#?(.*)$/)[1];
        if (hash == '')
            hash = "Tous";
        jQuery('.filters-button-group button').each(function(index, element) {
            var button = jQuery(this);
            var filter = jQuery(this).data('filter');
            var filterName = jQuery(this).data('filterName');
            button.click(function(event) {
                event.stopPropagation();

                grid.isotope({
                    filter: filter
                });
                jQuery('button', button.parent()).removeClass('btn-primary');
                button.addClass('btn-primary');
                window.location.hash = filterName;
                //return false;
            });
            if (filterName == hash) {
                button.trigger('click');
            }
        });
    });

    /* end of isotope */

    /* sponsor masonry */

    jQuery('#content #wp-sponsors').each(function() {
        var grid = jQuery(this);

        grid.masonry({
            itemSelector: '.sponsor-item',
        });

        grid.imagesLoaded().progress( function() {
            grid.masonry('layout');
        });
    });



    /* end of sponsor masonry */


});
