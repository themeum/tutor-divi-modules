/*
 * Tutor Divi Modules srcipts
 * @since 1.0.0
 */
jQuery(document).ready(function($){
    var inBuilder = typeof dtlmsData !== 'undefined' && dtlmsData.is_divi_builder;

    if (inBuilder) {
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
    }

    /**
     * Start a course carousel from the settings element rendered with its markup.
     * The Divi Visual Builder inserts that markup after document ready.
     */
    function initCourseCarousel(wrap) {
        var $wrap = $(wrap);
        var $carousel = $wrap.find('.tutor-divi-slick-responsive').first();
        var settings = $wrap.find('#tutor_divi_carousel_settings').first();

        if (!$.fn.slick || !$carousel.length || !settings.length || $carousel.hasClass('slick-initialized')) {
            return;
        }

        if ($carousel.width() < 20) {
            return;
        }

        var slidesToShow = Number(settings.attr('slides_to_show')) || 3;
        var arrows = settings.attr('arrows') !== 'off';
        var dots = settings.attr('dots') !== 'off';
        var transition = Number(settings.attr('transition')) || 600;
        var centerSlides = settings.attr('center_slides') !== 'off';
        var smoothScroll = settings.attr('smooth_scrolling') === 'off' ? 'linear' : 'ease';
        var autoplay = settings.attr('carousel_autoplay') !== 'off';
        var autoplaySpeed = Number(settings.attr('autoplay_speed')) || 5000;
        var infiniteLoop = settings.attr('infinite_loop') !== 'off';
        var pauseOnHover = settings.attr('pause_on_hover') !== 'off';

        $carousel.slick({
            dots: dots,
            arrows: arrows,
            infinite: infiniteLoop,
            autoplay: autoplay,
            autoplaySpeed: autoplaySpeed,
            slidesToShow: slidesToShow,
            slidesToScroll: 1,
            speed: transition,
            centerMode: centerSlides,
            pauseOnHover: pauseOnHover,
            cssEase: smoothScroll,
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
        });
    }

    function initCourseCarousels() {
        $('.tutor-divi-carousel-main-wrap').each(function() {
            initCourseCarousel(this);
        });
    }

    window.dtlmsInitCourseCarousels = initCourseCarousels;
    initCourseCarousels();
    document.addEventListener('dtlms-course-carousel-init', initCourseCarousels);

    if (inBuilder && window.MutationObserver && document.body) {
        var scheduled = false;
        var observer = new MutationObserver(function() {
            if (scheduled) {
                return;
            }
            scheduled = true;
            window.requestAnimationFrame(function() {
                scheduled = false;
                initCourseCarousels();
            });
        });
        observer.observe(document.body, { childList: true, subtree: true });
    }
});



