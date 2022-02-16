/*
 * Tutor Divi Modules srcipts
 * @since 1.0.0
 */
jQuery(document).ready(function($){

    //check if not front end builder
    if(dtlmsData.is_divi_builder) {
        /**
         * Tutor Divi Modules
         * course curriculum on click toggle icon
         * @since 1.0.0
         */            
        $(document).on('click', '.tutor-accordion-item-header', function() {
            $(this).toggleClass('is-active');
            var sibling = $(this).next();
            if ($(this).hasClass('is-active')) {
                sibling.css('maxHeight', sibling.prop('scrollHeight'));
            } else {
                sibling.css('maxHeight', 0);
            }
        });

    } else {
        /**
         * Tutor Course Carousel Modules
         * course carousel settings
         * @since 1.0.0
         */        
        $('.tutor-divi-carousel-main-wrap').each(function(i,obj){
            var settings                    = $(this).find("#tutor_divi_carousel_settings");
            var slides_to_show              = settings.attr('slides_to_show');

            var carousel_arrows             = settings.attr('arrows');
            var carousel_dots               = settings.attr('dots');
            var carousel_transition         = settings.attr('transition');
            var carousel_center             = settings.attr('center_slides');
            var smooth_scroll               = settings.attr('smooth_scrolling');
            var carousel_autoplay           = settings.attr('carousel_autoplay');
            var carousel_autoplay_speed     = settings.attr('autoplay_speed');
            var carousel_infinite_loop      = settings.attr('infinite_loop');
            var carousel_pause_on_hover     = settings.attr('pause_on_hover');

            carousel_arrows     == 'off' ? carousel_arrows = false : carousel_arrows = true;
            carousel_dots       == 'off' ? carousel_dots = false : carousel_dots = true;
            carousel_transition = Number(carousel_transition);
            carousel_center     == 'off' ? carousel_center = false : carousel_center = true;
            carousel_autoplay   == 'off' ? carousel_autoplay = false : carousel_autoplay = true;
            
            Number(carousel_autoplay_speed);
            slides_to_show = Number(slides_to_show);
           
            if(smooth_scroll === 'off') {
                smooth_scroll = 'linear';
            } else {
                smooth_scroll = 'ease';
            }
            carousel_infinite_loop  == 'off' ? carousel_infinite_loop = false : carousel_infinite_loop = true;
            carousel_pause_on_hover == 'off' ? carousel_pause_on_hover = false : carousel_pause_on_hover = true;
            $(this).find('.tutor-divi-slick-responsive').slick({
                dots: carousel_dots,
                arrows: carousel_arrows,
                infinite: carousel_infinite_loop,
                autoplay: carousel_autoplay,
                autoplaySpeed: carousel_autoplay_speed,             
                slidesToShow: slides_to_show,
                slidesToScroll: 1,
                speed: carousel_transition,
                centerMode: carousel_center,
                pauseOnHover: carousel_pause_on_hover,
                cssEase: smooth_scroll,
                responsive: [
                    {
                        breakpoint: 1024,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 1,
                            infinite: true,
                            dots: true
                        }
                    },
                    {
                        breakpoint: 576,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1
                        }
                    }
                ]
            })
        });
    }
});



