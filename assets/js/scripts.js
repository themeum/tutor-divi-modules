/**
 * Tutor Divi Modules
 * course curricle on click toggle icon
 * @since 1.0.0
 */

if( document.querySelector("#tutor_divi_col_icon")) {
    const collaps_icon    = document.querySelector("#tutor_divi_col_icon").value;
    const expand_icon     = document.querySelector("#tutor_divi_exp_icon").value;
    
    let divs = document.querySelectorAll(".tutor-divi-course-topic").forEach((div)=> {
            div.onclick = (e) => {
            let icon =  e.currentTarget.querySelector("#tutor_divi_topic_icon");
            let icon_type = icon.textContent;
                if( icon_type == collaps_icon) {
                    icon.textContent = expand_icon;
                
                } else if (icon_type == expand_icon) {
                    icon.textContent = collaps_icon;
                }
            }
    });
}

/**
 * Tutor Course Carousel Modules
 * course carousel settings
 * @since 1.0.0
 */
jQuery(document).ready(function($){
    var selector                    = $("#tutor_divi_carousel_settings");
    var slides_to_show               = selector.attr('slides_to_show');
    var carousel_arrows             = selector.attr('arrows');
    var carousel_dots               = selector.attr('dots');
    var carousel_transition         = selector.attr('transition');
    var carousel_center             = selector.attr('center_slides');
    var smooth_scroll               = selector.attr('smooth_scrolling');
    var carousel_autoplay           = selector.attr('autoplay');
    var carousel_autoplay_speed     = selector.attr('autoplay_speed');
    var carousel_infinite_loop      = selector.attr('infinite_loop');
    var carousel_pause_on_hover     = selector.attr('pause_on_hover');


    carousel_arrows     == 'on' ? carousel_arrows = true : carousel_arrows = false;
    carousel_dots       == 'on' ? carousel_dots = true : carousel_dots = false;
    carousel_transition = Number(carousel_transition);
    carousel_center     == 'on' ? carousel_center = true : carousel_center = false;
    carousel_autoplay   == 'on' ? carousel_autoplay = true : carousel_autoplay = false;

    Number(carousel_autoplay_speed);
    Number(slides_to_show);

    if(smooth_scroll === 'on') {
        smooth_scroll = 'ease';
    } else {
        smooth_scroll = 'linear';
    }
    carousel_infinite_loop  == 'on' ? carousel_infinite_loop = true : carousel_infinite_loop = false;
    carousel_pause_on_hover == 'on' ? carousel_pause_on_hover = true : carousel_pause_on_hover = false;

    $("#tutor-divi-slick-responsive").slick({
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

        prevArrow: ('.tutor-divi-carousel-arrow-prev'),
        nextArrow: ('.tutor-divi-carousel-arrow-next'),

        //rtl: elementorFrontend.config.is_rtl ? true : false,

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
});

