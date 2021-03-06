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


    jQuery(document).ready(function($){

        /**
         * enrollment/enrolled cart button icon
         * set data-icon attr to show et font icon
         * @since 1.0.0
        */ 
        const __enroll_button_icon     = $('#enroll_button_font_icon').val();
        if(__enroll_button_icon != undefined) {
            initialize_font_icon('.tutor-btn-enroll.tutor-btn', __enroll_button_icon)
        } 

        const __add_to_cart_button_icon     = $('#add_to_cart_button_font_icon').val();
        if(__add_to_cart_button_icon != undefined) {
            initialize_font_icon('.single_add_to_cart_button', __add_to_cart_button_icon)
        }
        const __start_continue_button_icon  = $('#start_continue_button_icon').val();
        if(__start_continue_button_icon != undefined) {
            initialize_font_icon('.tutor-lead-info-btn-group .tutor-button.tutor-success', __start_continue_button_icon)
        }    

        const __complete_button_icon     = $('#complete_button_icon').val();
        if(__complete_button_icon != '') {
           
            initialize_font_icon('.course-complete-button', __complete_button_icon)
        }    

        const __gradebook_icon     = $('#gradebook_button_icon').val();
        if(__gradebook_icon != '') {
           
            initialize_font_icon('.generate-course-gradebook-btn-wrap > .tutor-button', __gradebook_icon)
        }

        function initialize_font_icon(elem, icon) {
            if(document.querySelector(elem) != null) {
                document.querySelector(elem).setAttribute('data-icon', icon)
            }
        } 


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
    });

}


