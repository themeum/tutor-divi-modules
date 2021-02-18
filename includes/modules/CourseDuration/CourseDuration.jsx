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

        /**
         * set flex alignment as per default alignment
         * left,right,center | flext-start, fext-end, center
         */
        if(alignment === 'left') {
            alignment = 'flext-start';
        }
        else if(alignment === 'right') {
            alignment = 'flext-end';
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
        if(layout === 'row') {
            if(alignment) {
                additionalCss.push([
                    {
                        selector: wrapper_selector,
                        declaration: `justify-content: ${alignment};`
                    }
                ]);
            }
        } else {
            if(alignment) {
                additionalCss.push([
                    {
                        selector: wrapper_selector,
                        declaration: `align-items: ${alignment};`
                    }
                ]);
            }            
        }

        if(gap) {
            additionalCss.push([
                {
                    selector: wrapper_selector,
                    declaration: `gap: ${gap};`
                }
            ])
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