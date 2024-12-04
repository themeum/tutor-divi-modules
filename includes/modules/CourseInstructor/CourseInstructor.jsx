
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

        // instructor label margin
        if ( props.course_instructor_label_margin ) {
            const course_instructor_label_margin = props.course_instructor_label_margin.split('|');
            const course_instructor_label_margin_last_edited = props.course_instructor_label_margin_last_edited;
            const course_instructor_label_margin_responsive_active = course_instructor_label_margin_last_edited && course_instructor_label_margin_last_edited.startsWith('on');

            additionalCss.push([{
                selector: '%%order_class%% .dtlms-course-instructor-title',
                declaration: `margin-top: ${course_instructor_label_margin[0]} !important; margin-right: ${course_instructor_label_margin[1]} !important; margin-bottom: ${course_instructor_label_margin[2]} !important; margin-left: ${course_instructor_label_margin[3]} !important;`,
            }]);


            if ( props.course_instructor_label_margin_tablet && '' !==  props.course_instructor_label_margin_tablet && course_instructor_label_margin_responsive_active ) {

                const course_instructor_label_margin_tablet = props.course_instructor_label_margin_tablet.split('|');

                 additionalCss.push([{
                    selector: '%%order_class%% .dtlms-course-instructor-title',
                    declaration: `margin-top: ${course_instructor_label_margin_tablet[0]} !important; margin-right: ${course_instructor_label_margin_tablet[1]} !important; margin-bottom: ${course_instructor_label_margin_tablet[2]} !important; margin-left: ${course_instructor_label_margin_tablet[3]} !important;`,
                    device: 'tablet'
                }]);
            }

             if ( props.course_instructor_label_margin_phone && '' !==  props.course_instructor_label_margin_phone && course_instructor_label_margin_responsive_active ) {

                const course_instructor_label_margin_phone = props.course_instructor_label_margin_phone.split('|');

                 additionalCss.push([{
                    selector: '%%order_class%% .dtlms-course-instructor-title',
                    declaration: `margin-top: ${course_instructor_label_margin_phone[0]} !important; margin-right: ${course_instructor_label_margin_phone[1]} !important; margin-bottom: ${course_instructor_label_margin_phone[2]} !important; margin-left: ${course_instructor_label_margin_phone[3]} !important;`,
                    device: 'phone'
                }]);
            }

        }

        if ( props.course_instructor_avatar_margin ) {
            const course_instructor_avatar_margin = props.course_instructor_avatar_margin.split('|');
            const course_instructor_avatar_margin_last_edited = props.course_instructor_avatar_margin_last_edited;
            const course_instructor_avatar_margin_responsive_active = course_instructor_avatar_margin_last_edited && course_instructor_avatar_margin_last_edited.startsWith('on');

            additionalCss.push([{
                selector: '%%order_class%% .dtlms-course-instructor-wrapper .tutor-avatar',
                declaration: `margin-top: ${course_instructor_avatar_margin[0]} !important; margin-right: ${course_instructor_avatar_margin[1]} !important; margin-bottom: ${course_instructor_avatar_margin[2]} !important; margin-left: ${course_instructor_avatar_margin[3]} !important;`,
            }]);


            if ( props.course_instructor_avatar_margin_tablet && '' !==  props.course_instructor_avatar_margin_tablet && course_instructor_avatar_margin_responsive_active ) {

                const course_instructor_avatar_margin_tablet = props.course_instructor_avatar_margin_tablet.split('|');

                 additionalCss.push([{
                    selector: '%%order_class%% .dtlms-course-instructor-wrapper .tutor-avatar',
                    declaration: `margin-top: ${course_instructor_avatar_margin_tablet[0]} !important; margin-right: ${course_instructor_avatar_margin_tablet[1]} !important; margin-bottom: ${course_instructor_avatar_margin_tablet[2]} !important; margin-left: ${course_instructor_avatar_margin_tablet[3]} !important;`,
                    device: 'tablet'
                }]);
            }

             if ( props.course_instructor_avatar_margin_phone && '' !==  props.course_instructor_avatar_margin_phone && course_instructor_avatar_margin_responsive_active ) {

                const course_instructor_avatar_margin_phone = props.course_instructor_avatar_margin_phone.split('|');

                 additionalCss.push([{
                    selector: '%%order_class%% .dtlms-course-instructor-wrapper .tutor-avatar',
                    declaration: `margin-top: ${course_instructor_avatar_margin_phone[0]} !important; margin-right: ${course_instructor_avatar_margin_phone[1]} !important; margin-bottom: ${course_instructor_avatar_margin_phone[2]} !important; margin-left: ${course_instructor_avatar_margin_phone[3]} !important;`,
                    device: 'phone'
                }]);
            }

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