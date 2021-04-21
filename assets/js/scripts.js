/*
 * Tutor Divi Modules srcipts
 * @since 1.0.0
 */
const params = new URLSearchParams(window.location.search);
//check if not front end builder
if(params.has('et_fb')) {

} else {
    /**
     * Tutor Divi Modules
     * course curricle on click toggle icon
     * @since 1.0.0
     */
     if(document.querySelector("#tutor_divi_col_icon") !== null){
        
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
     * Carousel cart button icon
     * set data-icon attr to show et font icon
     * @since 1.0.0
    */ 
    if(document.querySelector("#cart_button_font_icon") !== null) {
        const cart_selector = document.querySelectorAll('.tutor-loop-cart-btn-wrap a');
        const icon          = document.querySelector("#cart_button_font_icon").value;
        if(cart_selector) {
            for(let cs of cart_selector) {
                cs.setAttribute('data-icon', icon)   
            }
        }        
    }


    /**
     * Tutor Course Carousel Modules
     * course carousel settings
     * @since 1.0.0
     */
    jQuery(document).ready(function($){
        const selector                  = document.querySelector("#tutor_divi_carousel_settings");

        if(selector) {
            var slides_to_show              = selector.getAttribute('slides_to_show');
            var carousel_arrows             = selector.getAttribute('arrows');
            var carousel_dots               = selector.getAttribute('dots');
            var carousel_transition         = selector.getAttribute('transition');
            var carousel_center             = selector.getAttribute('center_slides');
            var smooth_scroll               = selector.getAttribute('smooth_scrolling');
            var carousel_autoplay           = selector.getAttribute('autoplay');
            var carousel_autoplay_speed     = selector.getAttribute('autoplay_speed');
            var carousel_infinite_loop      = selector.getAttribute('infinite_loop');
            var carousel_pause_on_hover     = selector.getAttribute('pause_on_hover');

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
            
            $(".tutor-divi-slick-responsive").slick({
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

                //prevArrow: ('.tutor-divi-carousel-arrow-prev'),
                //nextArrow: ('.tutor-divi-carousel-arrow-next'),

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
        }

    });

}


