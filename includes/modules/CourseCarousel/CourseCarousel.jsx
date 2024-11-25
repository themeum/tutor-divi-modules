
import React, {Component, Fragment} from 'react';
import "slick-carousel/slick/slick.css"; 
import "slick-carousel/slick/slick-theme.css";
import Slider from "react-slick";

import Wishlist from '../CourseList/Components/Wishlist';
import Info from '../CourseList/Components/Info';
import Level from '../CourseList/Components/Level';
import Meta from '../CourseList/Components/Meta';
import Rating from '../CourseList/Components/Rating';
import Thumbnail from '../CourseList/Components/Thumbnail';
import Title from '../CourseList/Components/Title';
import Footer from '../CourseList/Components/Footer';
class CourseCarousel extends Component {

    static slug = 'tutor_course_carousel';

    static css(props) {
        const additionalCss = [];

        //selectors
        const wrapper               = '%%order_class%% .tutor-courses-loop-wrap';
        const card_selector         = `${wrapper} .tutor-course-card`;
        const footer_selector       = `${wrapper} .tutor-card-footer:not(.tutor-no-border)`;
        const badge_selector        = `${wrapper} .tutor-course-difficulty-level`;
        const avatar_selector       = `${wrapper} .tutor-avatar`;
        const star_selector         = `${wrapper} .tutor-ratings-stars span`;
        const star_wrapper_selector = `${wrapper} .tutor-ratings-stars`;
        const cart_button_selector  = `${wrapper} .tutor-loop-cart-btn-wrap a`;
        const arrows_selector       = '%%order_class%% .slick-prev:before, %%order_class%% .slick-next:before';
        const dots_wrapper_selector = '%%order_class%% .slick-dots';
        const thumbnail_selector    = '%%order_class%% .tutor-course-thumbnail img';
        const card_body_selector    = `${wrapper} .tutor-card-body`;
        //props
        const skin                      = props.skin;
        const hover_animation           = props.hover_animation;
        const card_background_color     = props.card_background_color;

        const card_custom_padding       = props.card_custom_padding;


        const badge_background_color    = props.badge_background_color;
        const badge_text_color          = props.badge_text_color;
        const badge_margin              = props.badge_margin;
        const badge_size                = props.badge_size;

        const avatar_size               = props.avatar_size;

        const star_color                = props.star_color;
        const star_size                 = props.star_size;
        const star_gap                  = props.star_gap;

        const footer_background         = props.footer_background;
        const footer_padding            = props.footer_padding;

        let dots_alignment              = props.dots_alignment;
        const dots_space                = props.dots_space;

        const arrows_padding            = props.arrows_padding;

        //set styles
        additionalCss.push([{
            selector: 'h1,h2,h3,a',
            declaration: 'padding: 0px !important; color: inherit !important;'
        }]);

        if ( props.category_margin ) {
             const category_margin = props.category_margin.split('|');

            additionalCss.push([{
                selector: `${wrapper} .dtlms-author-category-meta`,
                declaration: `margin-top: ${category_margin[0]}; margin-right: ${category_margin[1]}; margin-bottom: ${category_margin[2]}; margin-left: ${category_margin[3]};`,
            }]);
        } 

        if (props.card_body_margin) {
            const card_body_margin = props.card_body_margin.split('|');

            additionalCss.push([{
                selector: card_body_selector,
                declaration: `margin-top: ${card_body_margin[0]}; margin-right: ${card_body_margin[1]}; margin-bottom: ${card_body_margin[2]}; margin-left: ${card_body_margin[3]};`,
            }]);
        }

        if ( props.meta_margin ) {
            const meta_margin = props.meta_margin.split('|');

            additionalCss.push([{
                selector: `${wrapper} .dtlms-course-duration-meta`,
                declaration: `margin-top: ${meta_margin[0]}; margin-right: ${meta_margin[1]}; margin-bottom: ${meta_margin[2]}; margin-left: ${meta_margin[3]};`,
            }]);
        }

        if ( props.rating_margin ) {
            const rating_margin = props.rating_margin.split('|');

            additionalCss.push([{
                selector: `${wrapper} .tutor-ratings`,
                declaration: `margin-top: ${rating_margin[0]}; margin-right: ${rating_margin[1]}; margin-bottom: ${rating_margin[2]}; margin-left: ${rating_margin[3]};`,
            }]);
        }

        if ( props.title_margin ) {
            const title_margin = props.title_margin.split('|');

            additionalCss.push([{
                selector: `${wrapper} .tutor-course-name`,
                declaration: `margin-top: ${title_margin[0]}; margin-right: ${title_margin[1]}; margin-bottom: ${title_margin[2]}; margin-left: ${title_margin[3]};`,
            }]);
        }

        additionalCss.push([
            {
                selector: thumbnail_selector,
                declaration: `height: 100% !important; max-width: 100% !important; display: block !important;`
            }
        ]);

        additionalCss.push([
            {
                selector:  `%%order_class%% .tutor-course-thumbnail .tutor-ratio-16x9`,
                declaration: `padding-top: 56.25% !important;`
            }
        ]);
        //margin for hover animation
        additionalCss.push([
            {
                selector: `%%order_class%%
                    .tutor-course-card.dtlms-has-hover-animation"`,
                declaration: `margin-top: 7px;`
            }
        ]);        
        //card hover animation
        if(hover_animation === 'on') {
            additionalCss.push([
                {
                    selector: `%%order_class%% .tutor-course-card.dtlms-has-hover-animation"`,
					declaration: `position: relative; top: 0; z-index: 99; transition: top .5s;`
                }
            ]);
            additionalCss.push([
                {
                    selector: `%%order_class%% .tutor-course-card.dtlms-has-hover-animation":hover`,
					declaration: `top: -5px;`
                }
            ]);
        }

        //card toggle style
        //prepare header for background overlay & css filters
        additionalCss.push([
            {
                selector: '%%order_class%% .tutor-course-thumbnail:before,%%order_class%% .dtlms-course-card .tutor-course-thumbnail:before, %%order_class%% .dtlms-course-card-stacked .tutor-course-thumbnail:before',
                declaration: 'width: 100%;height: 100%; position: absolute;content: "";z-index: 2;'  
            }
        ]);

        if ( '' !== props.card_gap ) {
            additionalCss.push([
                {
                    selector: '%%order_class%% .slick-slide',
                    declaration: `margin-left: ${props.card_gap} !important; margin-right: ${props.card_gap} !important;`
                }
            ]);

        }

        if('' !== card_background_color && ('classic' === skin || 'card' === skin || 'overlayed' === skin )) {
            additionalCss.push([
                {
                    selector: card_selector,
                    declaration: `background-color: ${card_background_color};`
                }
            ]);
        }
        if('' !== card_background_color && 'stacked' === skin ) {
            additionalCss.push([
                {
                    selector: '%%order_class%% .dtlms-course-list-col .dtlms-course-card-inner',
                    declaration: `background-color: ${card_background_color} !important;`
                }
            ]);
        }
        if('' !== card_custom_padding) {
            additionalCss.push([
                {
                    selector: card_body_selector,
                    declaration: `padding: ${card_custom_padding} !important;`
                }
            ]);
        }
        //make carousel item equal height
      
        if(skin === 'classic' || skin === 'card') {
            additionalCss.push([
                {
                    selector: `%%order_class%%  .slick-track`,
                    declaration: `display: -ms-flexbox;
                    display: -webkit-flex;
                    display: flex;
                    -webkit-flex-direction: row;
                    -ms-flex-direction: row;
                    flex-direction: row;
                    -webkit-flex-wrap: nowrap;
                    -ms-flex-wrap: nowrap;
                    flex-wrap: nowrap;
                    -webkit-justify-content: space-between;
                    -ms-flex-pack: justify;
                    justify-content: space-between;
                    -webkit-align-content: stretch;
                    -ms-flex-line-pack: stretch;
                    align-content: stretch;
                    -webkit-align-items: stretch;
                    -ms-flex-align: stretch;
                    align-items: stretch;`
                            
                }
            ]);             

            additionalCss.push([
                {
                    selector: '%%order_class%% .slick-slide',
                    declaration: 'height: inherit !important;'   
                }
            ]);             
             
            additionalCss.push([
                {
                    selector: '%%order_class%% .tutor-course-card',
                    declaration: 'display: flex !important; flex-direction: column !important; justify-content: space-between !important; height: 100% !important;'   
                }
            ]);  

        }
 
        //card layout styles
        //classic style
        if(skin === 'classic') {
            additionalCss.push([
                {
                    selector: `%%order_class%%  .tutor-course-card`,
                    declaration: `border-radius: 8px;
                        border: 1px solid #EBEBEB;
                        overflow: hidden;`
                }
            ]);            

            additionalCss.push([
                {
                    selector: `%%order_class%% .tutor-course-card:hover`,
                    declaration: `-webkit-box-shadow: 0px 5px 2px #ebebeb;
                        box-shadow: 0px 5px 2px #ebebeb;`
                }
            ]);
        }

        //card style
        if(skin === 'card') {
            additionalCss.push([
                {
                    selector: `%%order_class%% .dtlms-course-card.tutor-course-card`,
                    declaration: `
                        -webkit-box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.08);
                                box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.08);
                        border-radius: 8px;
                        overflow: hidden;`
                }  
            ]);

            additionalCss.push([
                {
                    selector: `%%order_class%% .dtlms-course-card.tutor-course-card:hover`,
                    declaration: `-webkit-box-shadow:0px 24px 34px -5px rgba(0, 0, 0, 0.1);
                        box-shadow:0px 24px 34px -5px rgba(0, 0, 0, 0.1);`
                }
            ]);

        }

        //stacked style
        if(skin === 'stacked') {
            additionalCss.push([
                {
                    selector: `%%order_class%% .dtlms-course-card-stacked .tutor-course-thumbnail`,
                    declaration: `border-radius: 10px;
                        overflow: hidden; z-index: 1;`                    
                }
            ]);

            additionalCss.push([
                {
                    selector: `%%order_class%% .dtlms-course-card-stacked.tutor-course-card`,
                    declaration: `overflow: visible !important;`  
                }
            ]);

            additionalCss.push([
                {
                    selector: `%%order_class%% .dtlms-course-card-stacked .tutor-card-body`,
                    declaration: `z-index: 99;
                        margin-top: -80px;
                        background: white;
                        width: 80%;
                        margin-left: auto;
                        margin-right: auto;
                        position: relative;
                        border-radius: 10px;
                        -webkit-box-shadow: 0px 34px 28px -20px rgba(0, 0, 0, 0.15);
                                box-shadow: 0px 34px 28px -20px rgba(0, 0, 0, 0.15);`                    
                }
            ]);

            additionalCss.push([
                {
                    selector: `%%order_class%% .dtlms-course-card-stacked .tutor-card-body:hover`,
                    declaration: `-webkit-box-shadow: 0px 54px 58px -20px rgba(0, 0, 0, 0.15);
                        box-shadow: 0px 54px 58px -20px rgba(0, 0, 0, 0.15);`
                }
            ]);
        }   
        //overlayed style
        if(skin === 'overlayed') {
            additionalCss.push([
                {
                    selector: `%%order_class%% .dtlms-course-card-overlay`,
                    declaration: `background-size: cover;
                        background-repeat: no-repeat;
                        border-radius: 20px;
                        position: relative;
                        height: 300px;
                        overflow: hidden;`
                }
            ]);            

            additionalCss.push([
                {
                    selector: `%%order_class%% .dtlms-course-card-overlay:before`,
                    declaration: `background-image: -o-linear-gradient(top, rgba(0, 0, 0, 0.0001) 0%, #000000 100%);
                        background-image: -webkit-gradient(linear, left top, left bottom, from(rgba(0, 0, 0, 0.0001)), to(#000000));
                        background-image: linear-gradient(180deg, rgba(0, 0, 0, 0.0001) 0%, #000000 100%) !important;
                        
                        position: absolute;
                        content: "";
                        left: 0;
                        top: 0;
                        bottom: 0;
                        right: 0;
                        z-index: 3;
                        -webkit-transition: .4s;
                        -o-transition: .4s;
                        transition: .4s;`
                }
            ]);            

            additionalCss.push([
                {
                    selector: `%%order_class%% .dtlms-course-card-overlay .tutor-course-thumbnail`,
                    declaration: `z-index: 2;
                        height: 100%;`
                }
            ]);            

            additionalCss.push([
                {
                    selector: `%%order_class%% .dtlms-course-card-overlay .tutor-card-body`,
                    declaration: `position: absolute;
                        z-index: 99;
                        width: 100%;
                        bottom:0 !important;`
                }
            ]);            

            additionalCss.push([
                {
                    selector: `%%order_class%% .tutor-course-card .tutor-rating-count,
                        %%order_class%% .tutor-course-card .tutor-course-loop-title h2 a,
                        %%order_class%% .tutor-course-card .tutor-course-loop-meta,
                        %%order_class%% .tutor-course-card .tutor-loop-author>div a,
                        %%order_class%% .tutor-course-card .etlms-loop-cart-btn-wrap a,
                        %%order_class%% .tutor-course-card .price, %%order_class%% .tutor-loop-cart-btn-wrap a, %%order_class%% .tutor-loop-cart-btn-wrap a:before`,
                    declaration: `color: #fff !important;` 
                }
            ]);            

            additionalCss.push([
                {
                    selector: `%%order_class%% .dtlms-course-card-overlay:hover`,
                    declaration: `-webkit-box-shadow: 0px 8px 28px 0px #d0d0d0;
                        box-shadow: 0px 8px 28px 0px #d0d0d0;` 
                }
            ]);            

        } 
        //card layouts style end


        //badge toggle
        if('' !== badge_background_color) {
            additionalCss.push([
                {
                    selector: badge_selector,
                    declaration: `background-color: ${badge_background_color};`
                }
            ]);
        }        

        if('' !== badge_text_color) {
            additionalCss.push([
                {
                    selector: badge_selector,
                    declaration: `color: ${badge_text_color};`
                }
            ]);
        }        

        if('' !== badge_margin) {
            additionalCss.push([
                {
                    selector: badge_selector,
                    declaration: `margin: ${badge_margin};`
                }
            ]);
        }        

        if('' !== badge_size) {
            additionalCss.push([
                {
                    selector: badge_selector,
                    declaration: `width: ${badge_size};`
                }
            ]);
        }
        if('' !== avatar_size) {
            additionalCss.push([
                {
                    selector: avatar_selector,
                    declaration: `width: ${avatar_size} !important; height: ${avatar_size} !important; line-height: ${avatar_size};`
                }
            ]);
        }
        //avatar toggle

        //rating toggle
        additionalCss.push([
            {
                selector: star_wrapper_selector,
                declaration: `display: flex;`
            }
        ]);

        if('' !== star_color) {
            additionalCss.push([
                {
                    selector: star_selector,
                    declaration: `color: ${star_color};`
                }
            ]);
        }        

        if('' !== star_size) {
            additionalCss.push([
                {
                    selector: star_selector,
                    declaration: `font-size: ${star_size};`
                }
            ]);
        }        

        if('' !== star_gap) {
            additionalCss.push([
                {
                    selector: star_selector,
                    declaration: `margin-left: ${star_gap} !important;margin-right: ${star_gap} !important;`
                }
            ]);
        }

        if ( '' !== props.bookmark_background_color) {
             additionalCss.push([
                {
                    selector: '%%order_class%% .tutor-course-bookmark',
                    declaration: `background-color: ${props.bookmark_background_color};`
                }
            ]);
        }

        if('' !== star_gap) {
            additionalCss.push([
                {
                    selector: star_wrapper_selector,
                    declaration: `margin-left: -${star_gap} !important;margin-right: -${star_gap} !important;`
                }
            ]);
        }

        //footer toggle
        if('' !== footer_background) {
            additionalCss.push([
                {
                    selector: footer_selector,
                    declaration: `background-color: ${footer_background};`
                }
            ]);
        }

        if ( footer_padding ) {
            const footer_padding = props.footer_padding.split('|');

            additionalCss.push([{
                selector: `${wrapper} .tutor-card-footer`,
                declaration: `padding-top: ${footer_padding[0]}; padding-right: ${footer_padding[1]}; padding-bottom: ${footer_padding[2]}; padding-left: ${footer_padding[3]};`,
            }]);
        }
        //cart button toggle
        additionalCss.push([
            {
                selector: cart_button_selector,
                declaration: 'border-style: solid;'
            }
        ]);

        //arrows toggle
        //arrows default color #000
        additionalCss.push([
            {
                selector: arrows_selector,
                declaration: 'color: #000;'
            }
        ]);

        if('' !== arrows_padding) {
            additionalCss.push([
                {
                    selector: arrows_selector,
                    declaration: `padding: ${arrows_padding};`
                }
            ])
        }

        //dots toggle
        if(dots_alignment === 'left') {
            dots_alignment = 'flex-start';
        } else if( dots_alignment === 'right') {
            dots_alignment = 'flex-end';
        }
        additionalCss.push([
            {
                selector: dots_wrapper_selector,
                declaration: `display:flex !important; justify-content: ${dots_alignment}; column-gap: ${dots_space};`
            }
        ]);
		//add padding if thumbnail hide
		additionalCss.push([
            {
                selector: '%%order_class%% .hide-thumbnail .tutor-card-body',
                declaration: 'padding-top: 30px;'
            },
        ]);
        // remove redundant broken content from price
        additionalCss.push([
            {
                selector: '%%order_class%% .tutor-loop-cart-btn-wrap a::before',
                declaration: 'content: "" ',
            },
        ]);

        // default wishlist style
        additionalCss.push([
            {
                selector: '%%order_class%% .tutor-course-loop-header-meta .tutor-course-wishlist a',
                declaration: 'color: #fff;',
            }
        ]);
        additionalCss.push([
            {
                selector: '%%order_class%% .tutor-course-loop-header-meta .tutor-course-wishlist',
                declaration: 'border-radius: 50%; background-color: rgba(33,35,39,0.4); padding: 10px; color:#fff; width: 40px; height: 40px;',
            }
        ]);
        additionalCss.push([
            {
                selector: '%%order_class%% .tutor-course-loop-header-meta .tutor-course-wishlist:hover',
                declaration: 'background-color: #3e64de;',
            }
        ]);

        // min height for stacked container
        additionalCss.push([
            {
                selector: '%%order_class%% .tutor-courses-layout-2.dtlms-course-card-stacked .tutor-card-body, %%order_class%% .tutor-courses-layout-3.dtlms-course-card-stacked .tutor-card-body',
                declaration: 'min-height: 320px;',
            }
        ]);
        //set styles end
        return additionalCss;
    }

    sliderTemplate(props) {
        
        const settings = {
            dots: props.dots === 'off' ? false : true,
            arrows: props.arrows === 'off' ? false : true,
            infinite: props.infinite_loop === 'off' ? false : true,
            autoplay: props.autoplay === 'off' ? false : true,
            autoplaySpeed: Number(props.autoplay_speed),
            slidesToShow: Number(props.slides_to_show),
            slidesToScroll: 1,
            useCSS: props.transition === 'off' ? false : true,
            centerMode: props.center_slides === 'off' ? false : true,
            pauseOnHover: props.pause_on_hover === 'off' ? false : true,
    
            easing: props.smooth_scrolling === 'off' ? 'linear' : 'ease',
    
    
            responsive: [
                {
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 2,

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
        };
        
        return (
        <Slider  {...settings}>
            { props.skin === 'classic' ? this.classicLayoutTemplate( props ) : '' }
            { props.skin === 'card' ? this.cardLayoutTemplate( props ) : '' }
            { props.skin === 'stacked' ? this.stackedLayoutTemplate( props ) : '' }
            { props.skin === 'overlayed' ? this.overlayLayoutTemplate( props ) : '' }
        </Slider>  
        );
    }

    classicLayoutTemplate(props) {
        const animation_class = props.hover_animation === 'on' ? 'dtlms-has-hover-animation' : '';
        const courses = props.__courses.map((course) => {
            return(

                    <div className={`tutor-card tutor-course-card tutor-loop-course-container ${animation_class}`}>
                        <Thumbnail data={{show: props.show_image, course}}/>
                        <Wishlist show={props.wish_list}/>
                        <Level data={{show: props.difficulty_label, level: course.course_level}}/>
                        <div className="tutor-card-body">
                            <Rating data={{show: props.rating, rating: course.course_rating}}/>
                            <Title title={course.post_title}/>
                            <Info data={{args: props, meta_data: props.meta_data, course: course}}/>
                            <Meta data={{avatar: props.avatar, author: props.author,category: props.show_category, course: course }}/>
                        </div>
                        <Footer data={{show: props.footer, course}}/>
                    </div>
            );
        })
        return courses;
    }
    
    cardLayoutTemplate(props) {
        const animation_class = props.hover_animation === 'on' ? 'dtlms-has-hover-animation' : '';
        const courses = props.__courses.map((course) => {
            return(
                    <div className={`tutor-card tutor-course-card tutor-loop-course-container dtlms-course-card ${animation_class}`}>
                        <Thumbnail data={{show: props.show_image, course}}/>
                        <Wishlist show={props.wish_list}/>
                        <Level data={{show: props.difficulty_label, level: course.course_level}}/>
                        <div className="tutor-card-body dtlms-tutor-card-body">
                            <Rating data={{show: props.rating, rating: course.course_rating}}/>
                            <Title title={course.post_title}/>
                            <Info data={{args: props, meta_data: props.meta_data, course: course}}/>
                            <Meta data={{avatar: props.avatar, author: props.author,course: course, category: props.show_category}}/>
                        </div>
                        <Footer data={{show: props.footer, course}}/>
                    </div>
            );
        })
        return courses;
    }

    stackedLayoutTemplate(props) {
        const animation_class = props.hover_animation === 'on' ? 'dtlms-has-hover-animation' : '';
        const courses = props.__courses.map((course) => {
            return(
                    <div className={`tutor-course-card dtlms-course-card-stacked ${animation_class}`}>
                        <Thumbnail data={{show: props.show_image, course}}/>
                        <Wishlist show={props.wish_list}/>
                        <Level data={{show: props.difficulty_label, level: course.course_level}}/>
                        <div className="tutor-card dtlms-course-card-inner">
                            <div className="tutor-card-body">
                                <Rating data={{show: props.rating, rating: course.course_rating}}/>
                                <Title title={course.post_title}/>
                                <Info data={{args: props, meta_data: props.meta_data, course: course}}/>
                                <Meta data={{avatar: props.avatar, author: props.author,course: course}}/>
                            </div>
                            <Footer data={{show: props.footer, course}}/>
                        </div>
                    </div>
            );
        })
        return courses;
    }

    overlayLayoutTemplate(props) {
        const animation_class = props.hover_animation === 'on' ? 'dtlms-has-hover-animation' : '';
        const courses = props.__courses.map((course) => {
            return(
                    <div className={`tutor-course-card dtlms-course-card-overlay ${animation_class}`}>
                        <Thumbnail data={{show: props.show_image, course}}/>
                        <div className="tutor-card tutor-loop-course-container">
                            <div className="tutor-card-body">
                                <Rating data={{show: props.rating, rating: course.course_rating}}/>
                                <Title title={course.post_title}/>
                                <Info data={{args: props, meta_data: props.meta_data, course: course}}/>
                                <Meta data={{avatar: props.avatar, author: props.author,course: course}}/>
                            </div>
                            <Footer data={{show: props.footer, course}}/>
                        </div>
                    </div>
            );
        })
        return courses;    
    }

    render(){
        if(!this.props.__courses) {
            return '';
        }
        return (
        <Fragment>

            <div className={`tutor-divi-slick-responsive dtlms-carousel-loop-wrap tutor-courses tutor-courses-loop-wrap tutor-courses-layout-${Number(this.props.slides_to_show)} dtlms-carousel-${this.props.skin} dtlms-carousel-dots-${this.props.dots_alignment}`}>
                { this.sliderTemplate( this.props) }
                <div className="tutor-divi-carousel-arrow tutor-divi-carousel-arrow-prev">
                    <i className="fa fa-angle-left" aria-hidden="true"></i>
                </div>
                <div className="tutor-divi-carousel-arrow tutor-divi-carousel-arrow-next">
                    <i className="fa fa-angle-right" aria-hidden="true"></i>
                </div>
            
            </div>

        </Fragment>
        );
    }
}

export default CourseCarousel;