
import React, {Component, Fragment} from 'react';
class CourseInstructor extends Component {

    static slug = 'tutor_course_instructor';

    static css(props) {
        const additionalCss = [];
        //selector
        const course_instructor_layout = props.course_instructor_layout;
        const course_instructor_section_background = props.course_instructor_section_background;
        const course_instructor_bottom_info_star_size = props['course_instructor_bottom_info_star_size'];
        const course_instructor_bottom_info_star_color = props['course_instructor_bottom_info_star_color'];
        if ( course_instructor_layout ) {
            additionalCss.push([
                {
                    selector: '%%order_class%% .tutor-instructor-right',
                    declaration: `flex-direction: ${course_instructor_layout};`
                }
            ]);
        }
        if ( course_instructor_section_background ) {
            additionalCss.push([
                {
                    selector: '%%order_class%% .tutor-instructor-info-card',
                    declaration: `background-color: ${course_instructor_section_background};`
                }
            ]);
        }
        if ( course_instructor_bottom_info_star_size ) {
            additionalCss.push([
                {
                    selector: '%%order_class%% .single-instructor-bottom .tutor-star-rating-group i',
                    declaration: `font-size: ${course_instructor_bottom_info_star_size};`
                }
            ]);
        }
        if ( course_instructor_bottom_info_star_color ) {
            additionalCss.push([
                {
                    selector: '%%order_class%% .single-instructor-bottom .tutor-star-rating-group i',
                    declaration: `color: ${course_instructor_bottom_info_star_color};`
                }
            ]);
        }        //set styles end

        return additionalCss;
    }

    render(){
        if(!this.props.__instructor){
            return '';
        }
       
        return (
            <Fragment>
                <div className="dtlms-course-instructor-wrapper" dangerouslySetInnerHTML={{__html: this.props.__instructor}}></div>
            </Fragment>
        );
    }
}

export default CourseInstructor;