// External Dependencies
import React, { Component, Fragment } from 'react';

class CourseRequirements extends Component {

    static slug = 'tutor_course_requirements';

    static css(props) {
        const additionalCss = [];
        //selectors
        const wrapper = '%%order_class%% .tutor-course-requirements-wrap';
        const li_selector = '%%order_class%% .tutor-course-requirements-wrap li';
		const icon_selector	= "%%order_class%% .tutor-course-requirements-wrap li .et-pb-icon";

        //props
        const layout = props.layout;
        const is_responsive_layout = props.layout_last_edited && props.layout_last_edited.startsWith("on");
        const layout_tablet = is_responsive_layout && props.layout_tablet ? props.layout_tablet : layout;
        const layout_phone = is_responsive_layout && props.layout_phone ? props.layout_phone : layout;

        const alignment = props.alignment;
        const is_responsive_alignment = props.alignment_last_edited && props.alignment_last_edited.startsWith("on");
        const alignment_tablet = is_responsive_alignment && props.alignment_tablet ? props.alignment_tablet : alignment;
        const alignment_phone = is_responsive_alignment && props.alignment_phone ? props.alignment_phone : alignment;
        const size = props.size;
        const is_responsive_size = props.size_last_edited && props.size_last_edited.startsWith("on");
        const size_tablet = is_responsive_size && props.size_tablet ? props.size_tablet : size;
        const size_phone = is_responsive_size && props.size_phone ? props.size_phone : size;
        const color = props.color;

        const gap = props.gap;
        const is_responsive_gap = props.gap_last_edited && props.gap_last_edited.startsWith("on");
        const gap_tablet = is_responsive_gap && props.gap_tablet ? props.gap_tablet : gap;
        const gap_phone = is_responsive_gap && props.gap_phone ? props.gap_phone : gap;

        const padding = props.padding;

        const space_between = props.space_between;
        const is_responsive_space = props.space_between_last_edited && props.space_between_last_edited.startsWith("on");
        const space_between_tablet = is_responsive_space && props.space_between_tablet ? props.space_between_tablet : space_between;
        const space_between_phone = is_responsive_space && props.space_between_phone ? props.space_between_phone : space_between;

        //set styles
        additionalCss.push([
            {
                selector: `${li_selector}::before`,
                declaration: 'content: none;'
            }
        ]);
        //wrapper style
        additionalCss.push([
            {
                selector: wrapper,
                declaration: 'display: flex; flex-direction: column;'
            }
        ]);

        if(gap) {
            additionalCss.push([
                {
                    selector: wrapper,
                    declaration: `row-gap: ${gap};`
                }
            ]);            
        }

        if(gap_tablet) {
            additionalCss.push([
                {
                    selector: wrapper,
                    declaration: `row-gap: ${gap_tablet};`,
                    device: 'tablet'
                }
            ]);            
        }
        if(gap_phone) {
            additionalCss.push([
                {
                    selector: wrapper,
                    declaration: `row-gap: ${gap_phone};`,
                    device: 'phone'
                }
            ]);            
        }

        //icons style
        if('' !== color) {
            additionalCss.push([
                {
                    selector: icon_selector,
                    declaration: `color: ${color};`
                }
            ]);            
        }

        additionalCss.push([
            {
                selector: icon_selector,
                declaration: `font-size: ${size};`
            }
        ]);

        if(size_tablet) {
            additionalCss.push([
                {
                    selector: icon_selector,
                    declaration: `font-size: ${size_tablet};`,
                    device: 'tablet'
                }
            ]);     
        }

        if(size_phone) {
            additionalCss.push([
                {
                    selector: icon_selector,
                    declaration: `font-size: ${size_phone};`,
                    device: 'phone'
                }
            ]);     
        }

        //layout
        if(layout) {
            additionalCss.push([
                {
                    selector: li_selector,
                    declaration: `display: ${layout};`
                }
            ])
        }
        if(layout_tablet) {
            additionalCss.push([
                {
                    selector: li_selector,
                    declaration: `display: ${layout_tablet};`,
                    device: 'tablet'
                }
            ])
        }
        if(layout_phone) {
            additionalCss.push([
                {
                    selector: li_selector,
                    declaration: `display: ${layout_phone};`,
                    device: 'phone'
                }
            ])
        }

        if(alignment) {
            additionalCss.push([
                {
                    selector: `${wrapper} .tutor-segment-title, ${wrapper} .tutor-course-requirements-content`,
                    declaration: `text-align: ${alignment};`
                }
            ])
        }
        if(alignment_tablet) {
            additionalCss.push([
                {
                    selector: `${wrapper} .tutor-segment-title, ${wrapper} .tutor-course-requirements-content`,
                    declaration: `text-align: ${alignment_tablet};`,
                    device: 'tablet'
                }
            ])
        }
        if(alignment_phone) {
            additionalCss.push([
                {
                    selector: `${wrapper} .tutor-segment-title, ${wrapper} .tutor-course-requirements-content`,
                    declaration: `text-align: ${alignment_phone};`,
                    device: 'phone'
                }
            ])
        }
        //padding
        if(padding) {
            const split_padding = padding.split("|");
            additionalCss.push([
                {
                    selector: li_selector,
                    declaration: `padding: ${split_padding[0]} ${split_padding[1]} ${split_padding[2]} ${split_padding[3]};`
                }
            ])
        }
        //space 
        if(space_between) {
            additionalCss.push([
                {
                    selector: `${li_selector}:not(:last-child)`,
                    declaration: `margin-bottom: ${space_between};`
                }
            ])
        }

        if(space_between_tablet) {
            additionalCss.push([
                {
                    selector: `${li_selector}:not(:last-child)`,
                    declaration: `margin-bottom: ${space_between_tablet};`,
                    device: 'tablet'
                }
            ])
        }

        if(space_between_phone) {
            additionalCss.push([
                {
                    selector: `${li_selector}:not(:last-child)`,
                    declaration: `margin-bottom: ${space_between_phone};`,
                    device: 'phone'
                }
            ])
        }

        //set styles end

        return additionalCss;
    }

    requirementsList(lists,icon) {
        const utils = window.ET_Builder.API.Utils;
        const et_icon = utils.processFontIcon(icon);
        if(lists !== 0) {
            const list =  lists.map((list)=> {
                return <li> <span className="et-pb-icon"> {et_icon}</span> {list}</li>
            });
            return list;
        }

        return '';
    }

    render() {
        if(!this.props.__requirements) {
            return '';
        }
        return (
            <Fragment>
              	<div className="tutor-single-course-segment  tutor-course-requirements-wrap">
                    <div className="course-requirements-title">
                        <h4 className="tutor-segment-title"> { this.props.label } </h4>
                    </div>

                    <div className="tutor-course-requirements-content">
                        <ul className="tutor-course-requirements-items tutor-custom-list-style">
                            { this.requirementsList(this.props.__requirements, this.props.icon) }
                        </ul>
                    </div>
                </div>
            </Fragment>
        );
    }
}

export default CourseRequirements;