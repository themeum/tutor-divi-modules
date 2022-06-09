
import React, {Component, Fragment} from 'react';
class CourseInstructor extends Component {

    static slug = 'tutor_course_instructor';

    static css(props) {
        const additionalCss = [];
        //selector
        const course_instructor_layout = props.course_instructor_layout;
        const course_instructor_section_background = props.course_instructor_section_background;
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
                    selector: '%%order_class%% .tutor-course-details-instructors',
                    declaration: `background-color: ${course_instructor_section_background};`
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