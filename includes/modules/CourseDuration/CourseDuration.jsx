// External Dependencies
import React, { Component, Fragment } from 'react';

class CourseDuration extends Component {

    static slug = 'tutor_course_duration';

    static css( props ) {
        const additionalCss = [];
        const wrapper_selector = '%%order_class%% .tutor-divi-course-duration';
        const display = 'flex';
        const layout = props.duration_layout;
        let alignment = props.duration_alignment;
        const gap = props.gap;
        const is_responsive = props.gap_last_edited && props.gap_last_edited.startsWith("on");
        const gap_tablet = is_responsive && props.gap_tablet ? props.gap_tablet : gap;
        const gap_phone = is_responsive && props.gap_phone ? props.gap_phone : gap;
        /**
         * set flex alignment as per default alignment
         * left,right,center | flext-start, fext-end, center
         */
        if(alignment === 'left') {
            alignment = 'flex-start';
        }
        else if(alignment === 'right') {
            alignment = 'flex-end';
        }
        else {
            alignment = 'center';
        }
         //set css
        if(display) {
            additionalCss.push([
                {
                    selector: wrapper_selector,
                    declaration: `display: ${display};`
                }
            ]);
        }
        if(layout) {
            additionalCss.push([
                {
                    selector: wrapper_selector,
                    declaration: `flex-direction: ${layout};`
                }
            ]);
        }
        if(layout === 'row' && alignment) {
            additionalCss.push([
                {
                    selector: wrapper_selector,
                    declaration: `justify-content: ${alignment};`
                }
            ]);
        } else {
            additionalCss.push([
                {
                    selector: wrapper_selector,
                    declaration: `align-items: ${alignment};`
                }
            ]);
        }

        if(gap) {
            additionalCss.push([
                {
                    selector: wrapper_selector,
                    declaration: layout === 'row' ? `column-gap: ${gap};` : `row-gap: ${gap}`
                }
            ])
        }

        if(gap_tablet){
            additionalCss.push([
                {
                    selector: wrapper_selector,
                    declaration: layout === 'row' ? `column-gap: ${gap_tablet};` : `row-gap: ${gap_tablet}`,
                    device: 'tablet'
                }
            ]);
        }
        if(gap_phone){
            additionalCss.push([
                {
                    selector: wrapper_selector,
                    declaration: layout === 'row' ? `column-gap: ${gap_phone};` : `row-gap: ${gap_phone}`,
                    device: 'phone'
                }
            ]);
        }

        return additionalCss;
    }

    render() {
        return (
            <Fragment>
                <div className="tutor-single-course-meta-duration tutor-divi-course-duration">
                    <label> {this.props.duration_label} </label>
                    <span> {this.props.__duration} </span>
                </div>
            </Fragment>
        );
    }
}

export default CourseDuration;