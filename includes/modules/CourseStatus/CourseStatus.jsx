import React ,{ Component, Fragment } from "react";

class CourseStatus extends Component {

    static slug = "tutor_course_status";

    static css(props) {
        const additionalCss = [];
        //selectors
        if ( props.bar_height ) {
            additionalCss.push([
                {
                    selector: '%%order_class%% .tutor-progress-bar',
                    declaration: `height: ${props.bar_height} !important;`
                }
            ]);
		}
		if ( props.bar_radius ) {
            additionalCss.push([
                {
                    selector: '%%order_class%% .tutor-progress-bar',
                    declaration: `border-radius: ${props.bar_radius};`
                }
            ]);
		}
		if ( props.bar_background ) {
            additionalCss.push([
                {
                    selector: '%%order_class%% .tutor-progress-bar',
                    declaration: `background-color: ${props.bar_background};`
                }
            ]);
		}
		if ( props.bar_color ) {
            additionalCss.push([
                {
                    selector: '%%order_class%% .tutor-progress-value',
                    declaration: `background-color: ${props.bar_color};`
                }
            ]);
		}
		if ( props.bar_gap ) {
            additionalCss.push([
                {
                    selector: '%%order_class%% .tutor-progress-bar',
                    declaration: `margin-top: ${props.bar_gap};`
                }
            ]);
		}     

        return additionalCss;
    }

    percentTemplate(props) {
        if(props.display_percent === 'on') {
            return (            
                <span class="tutor-progress-percent">15% Complete</span>
            );   
        }
        return '';
    }
    
    render() {
        if(!this.props.__course_progress){
            return '';
        }
        return (
            <Fragment>
                <div class="tutor-course-status" dangerouslySetInnerHTML={{__html: this.props.__course_progress}}>
                </div>
            </Fragment>            
        );
    }
}
export default CourseStatus;