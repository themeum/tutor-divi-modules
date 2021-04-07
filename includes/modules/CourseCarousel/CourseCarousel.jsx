
import React, {Component, Fragment} from 'react';
import "slick-carousel/slick/slick.css"; 
import "slick-carousel/slick/slick-theme.css";
import Slider from "react-slick";
class CourseCarousel extends Component {

    static slug = 'tutor_course_carousel';

    /**
     * @return total ratings star
     * @param avg_rating
     */
    ratingStars(avg_rating) {
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

    categoryTemplate(course_cat) {
        const categories = course_cat.map((category) => {
            return (
                <a href="/">{ category.name }</a>
            );
        })
        return categories
    }

    footerTemplate(course) {
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
        console.log(typeof(props.slides_to_show + '' + props.autoplay_speed))
        const carousel = props.__courses;
        const settings = {
            appendDots: carousel.dots === 'on' ? true : false,
            arrows: carousel.arrows === 'on' ? true : false,
            infinite: carousel.infinite_loop === 'on' ? true : false,
            autoplaySpeed: 3000,
            slidesToShow: 3,
            slidesToScroll: 1,
            useCSS: carousel.transition === 'on' ? true : false,
            centerMode: carousel.center_slides === 'on' ? true : false,
            pauseOnHover: carousel.pause_on_hover === 'on' ? true : false,
    
            easing: carousel.smooth_scrolling === 'on' ? 'ease' : 'linear',
    
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
                            <a href="/">
                                <img src={course.post_thumbnail} alt="thumbnail"/>
                            </a> 
                                                    
                            <div className="tutor-course-loop-header-meta">

                                    <span className="tutor-course-loop-level">Expert</span>
                        
                                    <span className="tutor-course-wishlist">
                                        <span className="tutor-icon-fav-line tutor-course-wishlist-btn  "></span> 
                                    </span>
                            </div> 
                        </div>
                    
                        <div className="tutor-divi-carousel-course-container">
                            <div className="tutor-loop-course-container">

                                <div className="tutor-loop-rating-wrap">
                                    <div className="tutor-star-rating-group">
                                        {this.ratingStars(course.course_rating.rating_avg)}
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

                                    <div className="tutor-single-loop-meta">
                                        <i className='tutor-icon-user'></i>
                                        <span> {course.enroll_count} </span>
                                    </div>
                                        <div className="tutor-single-loop-meta">
                                            <i className='tutor-icon-clock'></i> 
                                            <span> {course.course_duration} </span>
                                        </div>

                                </div>

                                <div className="tutor-loop-author">
                                    <div className="tutor-single-course-avatar" dangerouslySetInnerHTML={{__html: course.author_avatar}}>
                                            
                                    </div>
                                    <div className="tutor-single-course-author-name">
                                    
                                        <a href="/">By {course.author_name}</a>
                                    </div>

                                    <div className="tutor-course-lising-category">
                                        { course.course_category.length ? <span> In </span> : '' }
                                        { this.categoryTemplate(course.course_category) }
                                    </div>
                                </div>
                            </div>

                            <div className="tutor-loop-course-footer tutor-divi-carousel-footer">
                                { this.footerTemplate(course) }
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

            <div className="tutor-divi-ctutor-wrap tutor-courses-wrap tutor-container tutor-divi-carousel-main-wraparousel-main-wrap">

                <div className={`tutor-divi-coursel-${this.props.skin}`} id="tutor-divi-slick-responsive">
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