// External Dependencies
import React, { Component, Fragment } from 'react';

class CourseMaterials extends Component {

    static slug = 'tutor_course_materials';

    static css(props) {
        const additionalCss = [];
        //selectors
        const wrapper = '%%order_class%% .tutor-course-material-includes-wrap';
        const title_selector = '%%order_class%% h4.tutor-segment-title';
        const li_selector = '%%order_class%% .tutor-course-material-includes-wrap li';

        //props
        const layout = props.layout;
        const alignment = props.alignment;
        const is_responsive_alignment = props.alignment_last_edit && props.alignment_last_edit.startsWith("on");
        const alignment_tablet = is_responsive_alignment && props.alignment_tablet ? props.alignment_tablet : alignment;
        const alignment_phone = is_responsive_alignment && props.alignment_phone ? props.alignment_phone : alignment;

        //set styles
        additionalCss.push([
            {
                selector: `${li_selector}::before`,
                declaration: 'content: none;'
            }
        ]);

        if(layout) {
            additionalCss.push([
                {
                    selector: li_selector,
                    declaration: `display: ${layout};`
                }
            ])
        }
        if(alignment) {
            additionalCss.push([
                {
                    selector: wrapper,
                    declaration: `text-align: ${alignment};`
                }
            ])
        }
        if(alignment_tablet) {
            additionalCss.push([
                {
                    selector: wrapper,
                    declaration: `text-align: ${alignment_tablet};`,
                    device: 'tablet'
                }
            ])
        }
        if(alignment_phone) {
            additionalCss.push([
                {
                    selector: wrapper,
                    declaration: `text-align: ${alignment_phone};`,
                    device: 'phone'
                }
            ])
        }

        //set styles end

        return additionalCss;
    }

    materialsList(lists,icon) {
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
        if(!this.props.__materials) {
            return '';
        }
      

        return (
            <Fragment>
            <div className="tutor-single-course-segment  tutor-course-material-includes-wrap">
                <h4 className="tutor-segment-title"> { this.props.label } </h4>
                <div className="tutor-course-target-audience-content">
                    <ul className="tutor-course-target-audience-items tutor-custom-list-style">
                        { this.materialsList(this.props.__materials, this.props.icon) }
                    </ul>
                </div>
            </div>
            </Fragment>
        );
    }
}

export default CourseMaterials;