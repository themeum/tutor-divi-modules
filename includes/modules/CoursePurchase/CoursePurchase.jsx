import React, { Component, Fragment } from 'react';

class CoursePurchase extends Component {

    static slug = "tutor_course_purchase";

    static css(props) {
        const additionalCss = [];
        //selectors
        const wrapper               = '%%order_class%% .tutor-course-sidebar-card';
        const enroll_box_selector   = '%%order_class%% .tutor-course-enrollment-box';

        //props
        const alignment                 = props.alignment;
        const is_responsive_alignment   = props.alignment_last_edited && props.alignment_last_edited.startsWith("on");
        const alignment_tablet          = is_responsive_alignment && '' !== props.alignment_tablet ? props.alignment_tablet : alignment;
        const alignment_phone           = is_responsive_alignment && '' !== props.alignment_phone ? props.alignment_phone : alignment;
        const btn_width                 = props.btn_width;
        const width_px                  = props.width_px;

        const icon_size                 = props.icon_size;
        const is_responsive_icon_size   = props.icon_size && props.icon_size.startsWith("on");
        const icon_size_tablet          = is_responsive_icon_size && '' !== props.icon_size_tablet ? props.icon_size_tablet : icon_size;
        const icon_size_phone           = is_responsive_icon_size && '' !== props.icon_size_phone ? props.icon_size_phone : icon_size;
        const icon_color                = props.icon_color;
        //set styles
        /**
         * default template styling
         */
        additionalCss.push([
            {
                selector: `${wrapper} .tutor-course-sidebar-card-body.tutor-p-30`,
                declaration: 'display: flex; flex-direction: column; row-gap: 10px;'
            }
        ]);

        //alignment styles
        if('' !== alignment) {
            let align = 'center';
            if(alignment === 'left') {
                align = 'flex-start';
            } else if (alignment === 'right') {
                align = 'flex-end';
            }

            additionalCss.push([
                {
                    selector: `%%order_class%% .tutor-course-sidebar-card-body >*:not(.tutor-course-sidebar-card-pricing)`,
                    declaration: `align-items: ${align};`
                }
            ]);
        }

        if('' !== alignment_tablet) {
            let align = 'center';
            if(alignment_tablet === 'left') {
                align = 'flex-start';
            } else if (alignment_tablet === 'right') {
                align = 'flex-end';
            }

            additionalCss.push([
                {
                    selector: `%%order_class%% .tutor-course-sidebar-card-body >*:not(.tutor-course-sidebar-card-pricing)`,
                    declaration: `align-items: ${align};`,
                    device: 'tablet'
                }
            ]);
        }

        if('' !== alignment_phone) {
            let align = 'center';
            if(alignment_phone === 'left') {
                align = 'flex-start';
            } else if (alignment_phone === 'right') {
                align = 'flex-end';
            }

            additionalCss.push([
                {
                    selector: `%%order_class%% .tutor-course-sidebar-card-body >*:not(.tutor-course-sidebar-card-pricing)`,
                    declaration: `align-items: ${align};`,
                    device: 'phone'
                }
            ]);
        }
        //button width style
        //enroll & add to cart button wrapper default width
        additionalCss.push([
            {
                selector: enroll_box_selector,
                declaration: `width: 100%;`
            }
        ]);

        if('fill' === btn_width) {

        } else if('auto' === btn_width) {
            //start/continue btn not gradebook
            additionalCss.push([
                {
                    selector: `${wrapper} .tutor-btn`,
                    declaration: 'width: auto !important;'
                }
            ]);
             //enrollment (enroll/add to cart) btn default width auto so no need to style if width is fill
        } else {
            //fixed width
            additionalCss.push([
                {
                    selector:  `${wrapper} .tutor-btn`,
                    declaration: `width: ${width_px} !important; text-align:center;`
                }
            ]);
        }
        //button size 
        if('small' === props.button_size) {
            additionalCss.push([
                {
                    selector: `${wrapper} .tutor-btn`,
                    declaration: `padding: 4px 14px !important;`
                }
            ]);
        } else if ('large' === props.button_size) {
            additionalCss.push([
                {
                    selector:  `${wrapper} .tutor-btn`,
                    declaration: `padding: 18px !important;`
                }
            ]);            
        }

        //button borders default style solid
        additionalCss.push([
            {
                selector: '%%order_class%% .tutor-course-enrollment-box .tutor-btn-enroll,  %%order_class%% .tutor-course-enrollment-box .single_add_to_cart_button.tutor-button, %%order_class%% .tutor-lead-info-btn-group .tutor-button.tutor-success, %%order_class%% .tutor-course-compelte-form-wrap .course-complete-button, %%order_class%% .tutor-lead-info-btn-group .generate-course-gradebook-btn-wrap',
                declaration: 'border-style: solid;'
            }
        ]);
        //purchase icon style
        const course_info_wrapper = '%%order_class%% .tutor-course-sidebar-card-footer';
        if('' !== icon_color) {
            additionalCss.push([
                {
                    selector: `${course_info_wrapper} span.tutor-icon-24`,
                    declaration: `color: ${icon_color};`
                }
            ]);
        }
        if('' !== icon_size) {
            additionalCss.push([
                {
                    selector: `${course_info_wrapper} span.tutor-icon-24`,
                    declaration: `font-size: ${icon_size};`
                }
            ]);
        }
        if('' !== icon_size_tablet) {
            additionalCss.push([
                {
                    selector: `${course_info_wrapper} span.tutor-icon-24`,
                    declaration: `font-size: ${icon_size_tablet};`,
                    device: 'tablet'
                }
            ]);
        }
        if('' !== icon_size_phone) {
            additionalCss.push([
                {
                    selector: `${course_info_wrapper} span.tutor-icon-24`,
                    declaration: `font-size: ${icon_size_phone};`,
                    device: 'phone'
                }
            ]);
        }
        additionalCss.push([
            {
                selector: '%%order_class%% form',
                declaration: 'width: 100%;'
            }
        ]);
        // alignment for add to cart button
        if ( 'left' === props.alignment ) {
            additionalCss.push([
                {
                    selector: '%%order_class%% form',
                    declaration: 'text-align: left;'
                }
            ]);
            additionalCss.push([
                {
                    selector: '%%order_class%% form',
                    declaration: 'text-align: left;',
                    device: 'tablet',
                }
            ]);
            additionalCss.push([
                {
                    selector: '%%order_class%% form',
                    declaration: 'text-align: left;',
                    device: 'phone',
                }
            ]);
        }
        if ( 'right' === props.alignment ) {
            additionalCss.push([
                {
                    selector: '%%order_class%% form',
                    declaration: 'text-align: right;'
                }
            ]);
            additionalCss.push([
                {
                    selector: '%%order_class%% form',
                    declaration: 'text-align: right;',
                    device: 'tablet'
                }
            ]);
            additionalCss.push([
                {
                    selector: '%%order_class%% form',
                    declaration: 'text-align: right;',
                    device: 'phone'
                }
            ]);
        }
        if ( 'center' === props.alignment ) {
            additionalCss.push([
                {
                    selector: '%%order_class%% form',
                    declaration: 'text-align: center;'
                }
            ]);
            additionalCss.push([
                {
                    selector: '%%order_class%% form',
                    declaration: 'text-align: center;',
                    device: 'tablet'
                }
            ]);
            additionalCss.push([
                {
                    selector: '%%order_class%% form',
                    declaration: 'text-align: center;',
                    device: 'phone'
                }
            ]);
        }
        // course progress style start
        if ( props.bar_height ) {
            additionalCss.push([
                {
                    selector: '%%order_class%% .list-item-progress .progress-bar',
                    declaration: `height: ${props.bar_height} !important;`
                }
            ]);
		}
		if ( props.bar_radius ) {
            additionalCss.push([
                {
                    selector: '%%order_class%% .list-item-progress .progress-bar',
                    declaration: `border-radius: ${props.bar_radius};`
                }
            ]);
		}
		if ( props.bar_background ) {
            additionalCss.push([
                {
                    selector: '%%order_class%% .list-item-progress .progress-bar',
                    declaration: `background-color: ${props.bar_background};`
                }
            ]);
		}
		if ( props.bar_color ) {
            additionalCss.push([
                {
                    selector: '%%order_class%% .list-item-progress .progress-bar .progress-value',
                    declaration: `background-color: ${props.bar_color};`
                }
            ]);
		}
		if ( props.bar_gap ) {
            additionalCss.push([
                {
                    selector: '%%order_class%% .list-item-progress .progress-bar',
                    declaration: `margin-top: ${props.bar_gap};`
                }
            ]);
		}
        // course progress style end
        //set styles end
        return additionalCss;
    }

    render() {
        if(!this.props.__enrollment) {
            return '';
        }
        console.log(this.props.__enrollment)
        return (
           <Fragment>
               <div className="tutor-divi-enroll-buttons-wrapper" dangerouslySetInnerHTML={{__html: this.props.__enrollment}}>
               </div>
           </Fragment>
        );
    }
}
export default CoursePurchase;