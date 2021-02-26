// External Dependencies
import React, { Component, Fragment } from 'react';

class CourseLevel extends Component {

    static slug = 'tutor_course_level';
    
    template (props) {
        if(!props.__level.is_disable_level) {
            return (
                <div className="tutor-single-course-meta tutor-meta-top">
                <ul>
                    <li className="tutor-course-level">
                        <label> { props.course_level_label } </label>
                        <span>
                            { props.__level.level }
                        </span>
                    </li>
                </ul>
            </div>                
            );
        } else {
            return '';
        }
    }

    static css(props) {
        const additionalCss = [];

        const wrapper = '%%order_class%% .tutor-course-level';
        const layout = props.layout;
        const is_responsive_layout = props.layout_last_edited && props.layout_last_edited.startsWith("on");
        const layout_tablet = is_responsive_layout && props.layout_tablet ? props.layout_tablet : layout; 
        const layout_phone = is_responsive_layout && props.layout_phone ? props.layout_phone : layout; 
        const display = 'flex';
        
        let alignment = props.alignment;
        /**
         * set alignment prop as per align
         */
        if(alignment === 'left') {
            alignment = 'flex-start';
        } else if(alignment === 'center') {
            alignment = 'center';
        } else {
            alignment = 'flex-end';
        }

        const is_responsive_alignment = props.alignment_last_edited && props.alignment_last_edited.startsWith("on");
        
        let alignment_tablet = is_responsive_alignment && props.alignment_tablet ? props.alignment_tablet : alignment; 
        if(alignment_tablet === 'left') {
            alignment_tablet = 'flex-start';
        } else if(alignment_tablet === 'center') {
            alignment_tablet = 'center';
        } else if(alignment_tablet === 'right') {
            alignment_tablet = 'flex-end';
        } else {
            alignment_tablet = 'flex-start';
        }

        let alignment_phone = is_responsive_alignment && props.alignment_phone ? props.alignment_phone : alignment; 
        if(alignment_phone === 'left') {
            alignment_phone = 'flex-start';
        } else if(alignment_phone === 'center') {
            alignment_phone = 'center';
        } else if(alignment_phone === 'right'){
            alignment_phone = 'flex-end';
        } else {
            alignment_phone = 'flex-start';
        }

        const gap = props.gap;
        const is_responsive_gap = props.gap_last_edited && props.gap_last_edited.startsWith("on");
        const gap_tablet = is_responsive_gap && props.gap_tablet ? props.gap_tablet : gap;
        const gap_phone = is_responsive_gap && props.gap_phone ? props.gap_phone : gap;

        //default display flex
        additionalCss.push([
            {
                selector: wrapper,
                declaration: `display: ${display};`
            }
        ]);

        if(layout) {
            additionalCss.push([
                {
                    selector: wrapper,
                    declaration: `flex-direction: ${layout};`
                }
            ]);
        }

        if(layout_tablet) {
            additionalCss.push([
                {
                    selector: wrapper,
                    declaration: `flex-direction: ${layout_tablet};`,
                    device: 'tablet'
                }
            ]);
        }

        if(layout_phone) {
            additionalCss.push([
                {
                    selector: wrapper,
                    declaration: `flex-direction: ${layout_phone};`,
                    device: 'phone'
                }
            ]);
        }

        if(alignment) {
            additionalCss.push([
                {
                    selector: wrapper,
                    declaration: layout === 'row' ? `justify-content: ${alignment};` : `align-items: ${alignment};`
                }
            ])
        }
        if(alignment_tablet) {
            additionalCss.push([
                {
                    selector: wrapper,
                    declaration: layout_tablet === 'row' ? `justify-content: ${alignment_tablet};` : `align-items: ${alignment_tablet};`,
                    device: 'tablet'
                }
            ])
        }
        if(alignment_phone) {
            additionalCss.push([
                {
                    selector: wrapper,
                    declaration: layout_phone === 'row' ? `justify-content: ${alignment_phone};` : `align-items: ${alignment_phone};`,
                    device: 'phone'
                }
            ])
        }

        if(gap) {
            additionalCss.push([
                {
                    selector: wrapper,
                    declaration: layout === 'row' ? `column-gap: ${gap};` : `row-gap: ${gap};`
                }
            ])            
        }
        if(gap_tablet) {
            additionalCss.push([
                {
                    selector: wrapper,
                    declaration: layout_tablet === 'row' ? `column-gap: ${gap_tablet};` : `row-gap: ${gap_tablet};`,
                    device: 'tablet'
                }
            ])            
        }
        if(gap_phone) {
            additionalCss.push([
                {
                    selector: wrapper,
                    declaration: layout_phone === 'row' ? `column-gap: ${gap_phone};` : `row-gap: ${gap_phone};`,
                    device: 'phone'
                }
            ])            
        }

        return additionalCss;
    }

    render() {
        if( !this.props.__level) {
            return '';
        }
        return (
            <Fragment>
                { this.template(this.props) }
            </Fragment>
        );
    }
}

export default CourseLevel;