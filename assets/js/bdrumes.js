 
jQuery(document).ready(function ($) {    

    //init carousel
    jQuery('.carouFredSel-gallery2').each(function(){
        var container = jQuery(this);
        var wcontainerclass = container.data('carousel-container'), 
        cspeed = container.data('carousel-speed'), 
        ctransition = container.data('carousel-transition'),
        cauto = container.data('carousel-auto'),
        carouselid = container.data('carousel-id'),
        ss = container.data('carousel-ss'), 
        xs = container.data('carousel-xs'),
        sm = container.data('carousel-sm'),
        md = container.data('carousel-md');
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
            //container.children().css({ width: 'auto' });
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
                prev: '#prevport-'+carouselid, 
                next: '#nextport-'+carouselid, 
                pagination: false, 
                swipe: true, 
                items: {visible: null}
            });
        }
        container.kt_imagesLoaded( function(){
            initCarousel();
        });
        wcontainer.animate({'opacity' : 1});
        jQuery(window).on("debouncedresize", function( event ) {
            container.trigger("destroy");
            //setWidths();
            initCarousel();
        });
    });
    
    jQuery('.imageGallerySlider').each(function() {
        var container = jQuery(this);
       
        cspeed = container.data('carousel-speed'), 
        ctransition = container.data('carousel-transition'),
        cauto = container.data('carousel-auto') == '0',
        carouselid = container.data('carousel-id'),
        ss = container.data('carousel-ss'), 
        xs = container.data('carousel-xs'),
        sm = container.data('carousel-sm'),
        md = container.data('carousel-md');
        
        function initCarousel() {
            container.slick({
                dots: false,
                infinite: true,
                slidesToShow: 1,
                centerMode: true,
                centerPadding: '0px',
                variableWidth: true,
                autoplay: cauto,
                autoplaySpeed: cspeed,
                speed: ctransition}
            );
        };

        container.kt_imagesLoaded( function(){
            initCarousel();
        });
        
        container.on('init', function(event, slick) {
            container.animate({'opacity' : 1});
        });

    });
        

});