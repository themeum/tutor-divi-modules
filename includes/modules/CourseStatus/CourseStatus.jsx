import React ,{ Component, Fragment } from "react";

class CourseStatus extends Component {

    static slug = "tutor_course_status";

    static css(props) {
        const additionalCss = [];

        //selectors
        const wrapper = '%%order_class%% .tutor-course-status';
        const progress_bar_wrap = '%%order_class%% .tutor-progress-bar-wrap';
        const progress_bar_selector = '%%order_class%% .tutor-progress-bar';
        const progress_fill_selector = '%%order_class%% .tutor-progress-bar .tutor-progress-filled';
        const text_selector = '%%order_class%% .tutor-progress-percent';

        //props
        const position = props.position;
        const bar_color = props.bar_color;
        const bar_background = props.bar_background;
        const bar_height = props.bar_height;
        const bar_radius = props.bar_radius;
        const gap = props.gap;
        const is_responsive_gap = props.gap_last_edited && props.gap_last_edited.startsWith("on");
        const gap_tablet = is_responsive_gap && props.gap_tablet ? props.gap_tablet : gap;
        const gap_phone = is_responsive_gap && props.gap_phone ? props.gap_phone : gap;

        //position 
        if(position === 'inside') {
            additionalCss.push([
                {
                    selector: text_selector,
                    declaration: 'position: absolute !important;left: 50% !important;'
                }
            ]);
        }

        if(position === 'on_top') {
            additionalCss.push([
                {
                    selector: progress_bar_wrap,
                    declaration: 'dislay: flex; flex-direction: column-reverse;'
                }
            ]);
            additionalCss.push([
                {
                    selector: text_selector,
                    declaration: 'align-self: flex-end;'
                }
            ]);
        }
        //remove after from bar filled 
        additionalCss.push([
            {
                selector: `${progress_fill_selector}:after`,
                declaration: 'content: none;'
            }
        ]);
        //progress bar style

        if('' !== bar_color) {
            additionalCss.push([
                {
                    selector: progress_fill_selector,
                    declaration: `background-color: ${bar_color};`
                }
            ]);            
        }

        if('' !== bar_background) {
            additionalCss.push([
                {
                    selector: progress_bar_selector,
                    declaration: `background-color: ${bar_background};`
                }
            ]);            
        }

        if('' !== bar_height) {
            additionalCss.push([
                {
                    selector: progress_bar_selector,
                    declaration: `height: ${bar_height};`
                }
            ]);            
            additionalCss.push([
                {
                    selector: progress_fill_selector,
                    declaration: `height: ${bar_height};`
                }
            ]);            
        }

        if('' !== bar_radius) {
            additionalCss.push([
                {
                    selector: progress_bar_selector,
                    declaration: `border-radius: ${bar_radius};`
                }
            ]);            
            additionalCss.push([
                {
                    selector: progress_fill_selector,
                    declaration: `border-radius: ${bar_radius};`
                }
            ]);            
        }
        //gap
        additionalCss.push([
            {
                selector: wrapper,
                declaration: 'display: flex; flex-direction: column;'
            }
        ])       
        if(gap) {
            additionalCss.push([
                {
                    selector: wrapper,
                    declaration: `row-gap: ${gap};`
                }
            ])
        }

        if(gap_tablet){
            additionalCss.push([
                {
                    selector: wrapper,
                    declaration: `row-gap: ${gap_tablet};`,
                    device: 'tablet'
                }
            ]);
        }
        if(gap_phone){
            additionalCss.push([
                {
                    selector: wrapper,
                    declaration: `row-gap: ${gap_phone};`,
                    device: 'phone'
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
        if(!this.props){
            return '';
        }
        return (
            <Fragment>
            <div class="tutor-course-status">
                <h4 class="tutor-segment-title"> { this.props.status_label }</h4>
                <div class="tutor-progress-bar-wrap">
                    <div class="tutor-progress-bar">
                        <div class="tutor-progress-filled" style={{'--tutor-progress-left': '15%'}}></div>
                    </div>
                    { this.percentTemplate(this.props) }
                </div>
            </div>
            </Fragment>            
        );
    }
}
export default CourseStatus;