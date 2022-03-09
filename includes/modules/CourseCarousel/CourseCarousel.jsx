
import React, {Component, Fragment} from 'react';
import "slick-carousel/slick/slick.css"; 
import "slick-carousel/slick/slick-theme.css";
import Slider from "react-slick";

class CourseCarousel extends Component {

    static slug = 'tutor_course_carousel';

    static css(props) {
        const additionalCss = [];

        //selectors
        const wrapper               = "%%order_class%% .tutor-divi-carousel-main-wrap";
        const card_selector         = `${wrapper} .tutor-divi-card`;
        const footer_selector       = `${wrapper} .tutor-loop-course-footer`;
        const badge_selector        = `${wrapper} .tutor-course-loop-level`;
        const avatar_selector       = `%%order_class%% .tutor-single-course-avatar a img, %%order_class%% .tutor-single-course-avatar a span, %%order_class%% .tutor-single-course-avatar .tutor-text-avatar, %%order_class%% .tutor-single-course-avatar img`;
        const star_selector         = `${wrapper} .tutor-rating-stars span`;
        const star_wrapper_selector = `${wrapper} .tutor-rating-stars`;
        const cart_button_selector  = `${wrapper} .tutor-loop-cart-btn-wrap a`;
        const arrows_selector       = '%%order_class%% .slick-prev:before, %%order_class%% .slick-next:before';
        const dots_wrapper_selector = '%%order_class%% .slick-dots';

        //props
        const skin                      = props.skin;
        const hover_animation           = props.hover_animation;
        const card_background_color     = props.card_background_color;

        const footer_seperator_width    = props.footer_seperator_width
        const footer_seperator_color    = props.footer_seperator_color

        const card_custom_padding       = props.card_custom_padding;

        const image_spacing             = props.image_spacing;

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
        //mergin for hover animation
            additionalCss.push([
                {
                    selector: `%%order_class%%
                        .tutor-divi-card.hover-animation`,
                    declaration: `margin-top: 7px;`
                }
            ]);        
        //card hover animation
        if(hover_animation === 'on') {
            additionalCss.push([
                {
                    selector: `%%order_class%% .tutor-divi-card.hover-animation`,
					declaration: `position: relative; top: 0; z-index: 99; transition: top .5s;`
                }
            ]);
            additionalCss.push([
                {
                    selector: `%%order_class%% .tutor-divi-card.hover-animation:hover`,
					declaration: `top: -5px;`
                }
            ]);
        }

        //card toogle style
        //prepare header for background overlay & css filters
        additionalCss.push([
            {
                selector: '%%order_class%% .tutor-divi-carousel-classic .tutor-course-header:before,%%order_class%% .tutor-divi-carousel-card .tutor-course-header:before, %%order_class%% .tutor-divi-carousel-stacked .tutor-course-header:before',
                declaration: 'width: 100%;height: 100%; position: absolute;content: "";z-index: 2;'  
            }
        ]);
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
                    selector: '%%order_class%% .tutor-divi-carousel-course-container',
                    declaration: `background-color: ${card_background_color} !important;`
                }
            ]);
        }

        if('' !== footer_seperator_width) {
            additionalCss.push([
                {
                    selector: footer_selector,
                    declaration: `border-top: ${footer_seperator_width} solid;`
                }
            ]);
        }

        if('' !== footer_seperator_color) {
            additionalCss.push([
                {
                    selector: footer_selector,
                    declaration: `color: ${footer_seperator_color};`
                }
            ]);
        }

        if('' !== card_custom_padding) {
            additionalCss.push([
                {
                    selector: card_selector,
                    declaration: `padding: ${card_custom_padding};`
                }
            ]);
        }
        //make carousel item equal height
      
        if(skin === 'classic' || skin === 'card') {
            additionalCss.push([
                {
                     selector: `%%order_class%% .slick-track`,
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
                    selector: '%%order_class%% .tutor-divi-card',
                    declaration: 'display: flex; flex-direction: column; justify-content: space-between; height: 100%;'   
                }
            ]);  

        }
 
        //card layout styles
        //classic style
        if(skin === 'classic') {
            additionalCss.push([
                {
                    selector: `%%order_class%% .tutor-divi-carousel-classic .tutor-divi-card`,
                    declaration: `border-radius: 8px;
                        border: 1px solid #EBEBEB;
                        overflow: hidden;`
                }
            ]);            

            additionalCss.push([
                {
                    selector: `%%order_class%% .tutor-divi-carousel-classic .tutor-divi-card:hover`,
                    declaration: `-webkit-box-shadow: 0px 5px 2px #ebebeb;
                        box-shadow: 0px 5px 2px #ebebeb;`
                }
            ]);
        }

        //card style
        if(skin === 'card') {
            additionalCss.push([
                {
                    selector: `%%order_class%% .tutor-divi-carousel-card .tutor-divi-card`,
                    declaration: `
                        -webkit-box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.08);
                                box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.08);
                        border-radius: 8px;
                        overflow: hidden;`
                }  
            ]);

            additionalCss.push([
                {
                    selector: `%%order_class%% .tutor-divi-carousel-card .tutor-divi-card:hover`,
                    declaration: `-webkit-box-shadow:0px 24px 34px -5px rgba(0, 0, 0, 0.1);
                        box-shadow:0px 24px 34px -5px rgba(0, 0, 0, 0.1);`
                }
            ]);

        }

        //stacked style
        if(skin === 'stacked') {
            additionalCss.push([
                {
                    selector: `%%order_class%% .tutor-divi-carousel-stacked .tutor-course-header`,
                    declaration: `border-radius: 10px;
                        overflow: hidden; z-index: 1;`                    
                }
            ]);

            additionalCss.push([
                {
                    selector: `%%order_class%% .tutor-divi-carousel-stacked .tutor-divi-card`,
                    declaration: `overflow: visible !important;`  
                }
            ]);

            additionalCss.push([
                {
                    selector: `%%order_class%% .tutor-divi-carousel-stacked .tutor-divi-carousel-course-container`,
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
                    selector: `%%order_class%% .tutor-divi-carousel-stacked .tutor-divi-carousel-course-container:hover`,
                    declaration: `-webkit-box-shadow: 0px 54px 58px -20px rgba(0, 0, 0, 0.15);
                        box-shadow: 0px 54px 58px -20px rgba(0, 0, 0, 0.15);`
                }
            ]);
        }   
        //overlayed style
        if(skin === 'overlayed') {
            additionalCss.push([
                {
                    selector: `%%order_class%% .tutor-divi-carousel-overlayed .tutor-divi-card`,
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
                    selector: `%%order_class%% .tutor-divi-carousel-overlayed .tutor-divi-card:before`,
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
                    selector: `%%order_class%% .tutor-divi-carousel-overlayed .tutor-course-header`,
                    declaration: `z-index: 2;
                        height: 100%;`
                }
            ]);            

            additionalCss.push([
                {
                    selector: `%%order_class%% .tutor-divi-carousel-overlayed .tutor-divi-carousel-course-container`,
                    declaration: `position: absolute;
                        z-index: 99;
                        width: 100%;
                        bottom:0 !important;`
                }
            ]);            

            additionalCss.push([
                {
                    selector: `%%order_class%% .tutor-divi-card .tutor-rating-count,
                        %%order_class%% .tutor-divi-card .tutor-course-loop-title h2 a,
                        %%order_class%% .tutor-divi-card .tutor-course-loop-meta,
                        %%order_class%% .tutor-divi-card .tutor-loop-author>div a,
                        %%order_class%% .tutor-divi-card .etlms-loop-cart-btn-wrap a,
                        %%order_class%% .tutor-divi-card .price, %%order_class%% .tutor-loop-cart-btn-wrap a, %%order_class%% .tutor-loop-cart-btn-wrap a:before`,
                    declaration: `color: #fff !important;` 
                }
            ]);            

            additionalCss.push([
                {
                    selector: `%%order_class%% .tutor-divi-carousel-overlayed .tutor-divi-card:hover`,
                    declaration: `-webkit-box-shadow: 0px 8px 28px 0px #d0d0d0;
                        box-shadow: 0px 8px 28px 0px #d0d0d0;` 
                }
            ]);            

        } 
        //card layouts style end

        //image toggle
        if('' !== image_spacing) {
            additionalCss.push([
                {
                    selector: `%%order_class%% .tutor-course-header a img`,
                    declaration: `padding: ${image_spacing};`
                }
            ]);
        }

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
                    selector: star_wrapper_selector,
                    declaration: `column-gap: ${star_gap};`
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

        if('' !== footer_padding) {
            additionalCss.push([
                {
                    selector: footer_selector,
                    declaration: `padding: ${footer_padding};`
                }
            ]);
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
                selector: '%%order_class%% .hide-thumbnail .tutor-divi-carousel-course-container',
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
                selector: '%%order_class%% .tutor-courses-layout-2.tutor-divi-carousel-stacked .tutor-divi-carousel-course-container, %%order_class%% .tutor-courses-layout-3.tutor-divi-carousel-stacked .tutor-divi-carousel-course-container',
                declaration: 'min-height: 320px;',
            }
        ]);
        //set styles end
        return additionalCss;
    }
    /**
     * @return total ratings star
     * @param avg_rating
     */
    ratingStars(show,avg_rating) {
        if(show === 'off') {
            return '';
        }
        const ratings = [];
        for(let i=1; i < 6; i++) {
            if(avg_rating >= i) {
                ratings.push(<span className='tutor-icon-star-full-filled'></span>)
            } else {
                ratings.push(<span className='tutor-icon-star-line-filled'></span>)
            }
        }
        return ratings;
    }

    thumbnailTemplate(show,course) {
        if(show === 'off') {
            return '';
        }
        return (
        <a href="/">
            <img src={course.post_thumbnail} alt="thumbnail"/>
        </a> 
        );
    }

    levelTemplate(show,level) {
        if(show === 'off') {
            return ''
        }
        return (
            <span className="tutor-course-loop-level">{level}</span>
        );
    }
    metaTemplate(show,course) {
        if(show === 'off') {
            return '';
        }
        return (
            <Fragment>
                <div className="tutor-single-loop-meta">
                    <i className='meta-icon tutor-icon-user-filled tutor-color-text-hints'></i>
                    <span> {course.enroll_count} </span>
                </div>
                <div className="tutor-single-loop-meta">
                    <i className='meta-icon tutor-icon-clock-filled tutor-color-text-hints'></i> 
                    <span dangerouslySetInnerHTML={{__html: course.course_duration}}></span>
                </div>
            </Fragment>
            
        );
    }
    
    avatarTemplate(show,avatar) {
        if(show === 'off') {
            return '';
        }
        return (
            <div className="tutor-single-course-avatar" dangerouslySetInnerHTML={{__html: avatar}}>
                
            </div>
        );
    }

    wishlistTemplate(show) {
        if(show === 'off') {
            return ''
        }
        return(
        <span className="tutor-course-wishlist">
            <span className="tutor-icon-fav-line-filled tutor-course-wishlist-btn  "></span> 
        </span>
        );
    }

    categoryTemplate(show,course_cat) {
        if(show === 'off') {
            return '';
        }
        const categories = course_cat.map((category) => {
            return (
                <a href="/" dangerouslySetInnerHTML={{__html: category.name}}></a>
            );
        })
        return categories
    }

    footerButtonText(is_enrolled, course) {
        if(is_enrolled) {
            return 'Continue Course';
        } 
        if(course.loop_price.regular_price !== '' && course.loop_price.regular_price !== 'Free' ) {
            return 'Add to Cart';
        } else {
            return 'Get Enrolled';
        }
    }

    footerTemplate(show,course) {
        if(show === 'off') {
            return '';
        }
        return(
            <div class="tutor-loop-course-footer tutor-divi-carousel-footer" dangerouslySetInnerHTML={{__html: course.footer_template}}>
        </div> 
        );
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
    
            //rtl: elementorFrontend.config.is_rtl ? true : false,
    
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
            { this.courseTemplate(props) }
        </Slider>  
        );
    }
 
    /**
     * 
     * @param {*} props 
     * @returns course template
     */
    courseTemplate(props) {
        const hover_animation = props.hover_animation === 'on' ? 'hover-animation' : '';
        const courses = props.__courses.map((course) => {
           
            return (
            <div className="tutor-course-col">
                <div className={`tutor-divi-card ${hover_animation}`}>

                        <div className="tutor-course-header ">
                             { this.thumbnailTemplate(props.show_image,course) }                       
                            <div className="tutor-course-loop-header-meta">
                                    { this.levelTemplate(props.difficulty_label, course.course_level) }
                                    { this.wishlistTemplate(props.wish_list)}
                            </div> 
                        </div>
                    
                        <div className="tutor-divi-carousel-course-container">
                            <div className="tutor-loop-course-container">

                                <div className="tutor-loop-rating-wrap">
                                    <div className="tutor-ratings">
                                        <div className="tutor-rating-stars">
                                            {this.ratingStars(props.rating, course.course_rating.rating_avg)}
                                        </div>
                                    </div>
                                </div>
                            
                                <div className="tutor-course-loop-title">
                                    <h2>
                                        <a href="/" className='tutor-text-medium-h5 tutor-color-text-primary'>
                                            {course.post_title}
                                        </a>
                                    </h2>
                                </div>
                            
                                <div className="tutor-course-loop-meta">
                                    { this.metaTemplate(props.meta_data,course) }
                                </div>

                                <div className="tutor-loop-author list-item-author tutor-bs-d-flex tutor-bs-align-items-center tutor-mt-30">
                                    { this.avatarTemplate(props.avatar,course.author_avatar) }
                                    <div className='tutor-course-lising-category'>
                                        <span className="tutor-single-course-author-name tutor-course-meta-name">
                                            <a href="/">By {course.author_name}</a>
                                        </span>
                                        { course.course_category.length && props.category === 'on' ? <span className='tutor-color-text-subsued tutor-course-meta-cat tutor-pl-2 tutor-pr-2'> In </span> : '' }
                                        { this.categoryTemplate(props.category,course.course_category) }
                                    </div>
                                </div>
                            </div>
                            { this.footerTemplate(props.footer, course) }
                        </div> 

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
        const thumbnail_hide    = this.props.show_image === 'off' ? 'hide-thumbnail': '';
        return (
        <Fragment>

            <div className="tutor-courses-wrap tutor-container tutor-divi-carousel-main-wrap">

                <div className={`tutor-divi-carousel-${this.props.skin} ${thumbnail_hide}`} id="tutor-divi-slick-responsive">
                    { this.sliderTemplate( this.props) }
                </div>
           
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