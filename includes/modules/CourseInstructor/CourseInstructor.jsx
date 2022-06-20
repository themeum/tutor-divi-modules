
import React, {Component, Fragment} from 'react';
class CourseInstructor extends Component {

    static slug = 'tutor_course_instructor';

    static css(props) {
        const additionalCss = [];
        const textAvatarBackground = props.course_instructor_avatar_background_color;
		const avatarTextColor      = props.course_instructor_avatar_text_color;
        //selector
        if ( textAvatarBackground !== '' ) {
            additionalCss.push([
                {
                    selector: '%%order_class%% .tutor-avatar-text',   
                    declaration: `background-color: ${textAvatarBackground} !important;`
                }
            ]);
        }
        if ( avatarTextColor !== '' ) {
            additionalCss.push([
                {
                    selector: '%%order_class%% .tutor-avatar-text',   
                    declaration: `color: ${avatarTextColor} !important;`
                }
            ]);
        }
        //set styles end

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