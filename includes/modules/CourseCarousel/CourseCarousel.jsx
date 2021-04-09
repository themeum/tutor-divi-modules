
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

        //props
        const skin                      = props.skin;
        const hover_animation           = props.hover_animation;
        const card_background_color     = props.card_background_color;
        const footer_seperator_width    = props.footer_seperator_width
        const footer_seperator_color    = props.footer_seperator_color
        const card_custom_padding       = props.card_custom_padding;
        const image_spacing             = props.image_spacing;
        //set styles
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
        if('' !== card_background_color) {
            additionalCss.push([
                {
                    selector: card_selector,
                    declaration: `background-color: ${card_background_color};`
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
        additionalCss.push([
            {
                selector: `%%order_class%% .tutor-divi-carousel-main-wrap
                    .slick-track`,
                declaration: `display: -webkit-box !important;
                    display: -ms-flexbox !important;
                    display: flex !important;
                    /*5px for hover animation*/
                    position: relative !important;
                    top: 5px !important;`
            }
        ]);        

        additionalCss.push([
            {
                selector: `%%order_class%% .tutor-divi-carousel-main-wrap
                    .slick-slide`,
                declaration: `height: inherit !important;`
            }
        ]);

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
                    declaration: `display: -webkit-box;
                        display: -ms-flexbox;
                        display: flex;
                        -webkit-box-orient: vertical;
                        -webkit-box-direction: normal;
                            -ms-flex-direction: column;
                                flex-direction: column;
                        -webkit-box-pack: justify;
                            -ms-flex-pack: justify;
                                justify-content: space-between;
                        height: 100%;
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
                    selector: `%%order_class%% .tutor-divi-carousel-stacked 
                                        .tutor-divi-carousel-course-container`,
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
                    selector: `%%order_class%% .tutor-divi-carousel-stacked 
                                        .tutor-divi-carousel-course-container:hover`,
                    declaration: `-webkit-box-shadow: 0px 54px 58px -20px rgba(0, 0, 0, 0.15);
                        box-shadow: 0px 54px 58px -20px rgba(0, 0, 0, 0.15);`
                }
            ]);
        }   
        //overlayed style
        if(skin === 'overlayed') {
            additionalCss.push([
                {
                    selector: `%%order_class%% .tutor-divi-carousel-overlayed
                        .tutor-divi-card`,
                    declaration: `margin-top: 7px;`
                }
            ]);

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
                        background-image: linear-gradient(180deg, rgba(0, 0, 0, 0.0001) 0%, #000000 100%);;
                        
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
                    selector: `%%order_class%% .tutor-divi-carousel-overlayed
                        .tutor-divi-carousel-course-container`,
                    declaration: `position: absolute;
                        z-index: 99;
                        width: 100%;
                        bottom:0 !important;`
                }
            ]);            

            additionalCss.push([
                {
                    selector: `%%order_class%% .tutor-divi-carousel-overlayed .tutor-rating-count,
                        .%%order_class%% .tutor-divi-carousel-overlayed .tutor-course-loop-title h2 a,
                        .%%order_class%% .tutor-divi-carousel-overlayed .tutor-course-loop-meta,
                        .%%order_class%% .tutor-divi-carousel-overlayed .tutor-loop-author>div a,
                        .%%order_class%% .tutor-divi-carousel-overlayed .etlms-loop-cart-btn-wrap a,
                        .%%order_class%% .tutor-divi-carousel-overlayed .price`,
                    declaration: `color: #fff;` 
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
                ratings.push(<i className='tutor-icon-star-full'></i>)
            } else {
                ratings.push(<i className='tutor-icon-star-line'></i>)
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
            <span className="tutor-course-loop-level">Expert</span>
        );
    }
    metaTemplate(show,course) {
        if(show === 'off') {
            return '';
        }
        return (
            <Fragment>
                <div className="tutor-single-loop-meta">
                    <i className='tutor-icon-user'></i>
                    <span> {course.enroll_count} </span>
                </div>
                <div className="tutor-single-loop-meta">
                    <i className='tutor-icon-clock'></i> 
                    <span> {course.course_duration} </span>
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
            <span className="tutor-icon-fav-line tutor-course-wishlist-btn  "></span> 
        </span>
        );
    }

    categoryTemplate(show,course_cat) {
        if(show === 'off') {
            return '';
        }
        const categories = course_cat.map((category) => {
            return (
                <a href="/">{ category.name }</a>
            );
        })
        return categories
    }

    footerTemplate(show,course) {
        if(show === 'off') {
            return '';
        }
        return (
            <div className="tutor-course-loop-price">
                <div className="price">
                    { course.course_price === null ? 'Free' : course.course_price }
                    <div className="tutor-loop-cart-btn-wrap">
                        <a href="/">
                            { course.is_enrolled ? 'Continue Course' : 'Get Enrolled' }
                        </a>
                    </div>    
                </div>
            </div>
        );       
    }

    sliderTemplate(props) {
        console.log(props.dots + typeof(props.dots))
        const settings = {
            appendDots: props.dots === 'off' ? false : true,
            arrows: props.arrows === 'off' ? false : true,
            infinite: props.infinite_loop === 'off' ? false : true,
            autoplaySpeed: 3000,
            slidesToShow: 3,
            slidesToScroll: 1,
            useCSS: props.transition === 'off' ? false : true,
            centerMode: props.center_slides === 'off' ? false : true,
            pauseOnHover: props.pause_on_hover === 'off' ? false : true,
    
            easing: props.smooth_scrolling === 'off' ? 'linear' : 'ease',
    
            //rtl: elementorFrontend.config.is_rtl ? true : false,
    
            // responsive: [
            //     {
            //         breakpoint: 1024,
            //         settings: {
            //             slidesToShow: 2,
            //             slidesToScroll: 1,
            //             infinite: true,
            //             dots: true
            //         }
            //     },
            //     {
            //         breakpoint: 576,
            //         settings: {
            //             slidesToShow: 1,
            //             slidesToScroll: 1
            //         }
            //     }
            // ]
        };
        console.log(settings);
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

        const courses = props.__courses.map((course) => {
            return (
            <div className="tutor-course-col">
                <div className="tutor-divi-card">

                        <div className="tutor-course-header ">
                             { this.thumbnailTemplate(props.show_image,course) }                       
                            <div className="tutor-course-loop-header-meta">
                                    { this.levelTemplate(props.difficulty_label, 'Beginner') }
                                    { this.wishlistTemplate(props.wish_list)}
                            </div> 
                        </div>
                    
                        <div className="tutor-divi-carousel-course-container">
                            <div className="tutor-loop-course-container">

                                <div className="tutor-loop-rating-wrap">
                                    <div className="tutor-star-rating-group">
                                        {this.ratingStars(props.rating, course.course_rating.rating_avg)}
                                    </div>
                                </div>
                            
                                <div className="tutor-course-loop-title">
                                    <h2>
                                        <a href="/">
                                            {course.post_title}
                                        </a>
                                    </h2>
                                </div>
                            
                                <div className="tutor-course-loop-meta">
                                    { this.metaTemplate(props.meta_data,course) }
                                </div>

                                <div className="tutor-loop-author">
                                    { this.avatarTemplate(props.avatar,course.author_avatar) }
                                    <div className="tutor-single-course-author-name">
                                    
                                        <a href="/">By {course.author_name}</a>
                                    </div>

                                    <div className="tutor-course-lising-category">
                                        { course.course_category.length ? <span> In </span> : '' }
                                        { this.categoryTemplate(props.category,course.course_category) }
                                    </div>
                                </div>
                            </div>

                            <div className="tutor-loop-course-footer tutor-divi-carousel-footer">
                                { this.footerTemplate(props.footer, course) }
                            </div>
                        
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
        console.log(this.props)

        return (
        <Fragment>

            <div className="tutor-courses-wrap tutor-container tutor-divi-carousel-main-wrap">

                <div className={`tutor-divi-carousel-${this.props.skin}`} id="tutor-divi-slick-responsive">
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