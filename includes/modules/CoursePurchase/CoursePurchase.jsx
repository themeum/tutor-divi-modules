import React, { Component, Fragment } from 'react';

class CoursePurchase extends Component {

    static slug = "tutor_course_purchase";

    static css(props) {
        const additionalCss = [];
        //selectors
        const wrapper               = '%%order_class%% .tutor-course-sidebar-card';
        const enroll_box_selector   = '%%order_class%% .tutor-course-enrollment-box';

        //props

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


        //enroll & add to cart button wrapper default width
        additionalCss.push([
            {
                selector: enroll_box_selector,
                declaration: `width: 100%;`
            }
        ]);

        //button borders default style solid
        additionalCss.push([
            {
                selector: '%%order_class%% .tutor-course-enrollment-box .tutor-btn-enroll,  %%order_class%% .tutor-course-enrollment-box .single_add_to_cart_button.tutor-button, %%order_class%% .tutor-lead-info-btn-group .tutor-button.tutor-success, %%order_class%% .tutor-course-compelte-form-wrap .course-complete-button, %%order_class%% .tutor-lead-info-btn-group .generate-course-gradebook-btn-wrap',
                declaration: 'border-style: solid;'
            }
        ]);
        //purchase icon style
        if('' !== icon_color) {
            additionalCss.push([
                {
                    selector: "%%order_class%% .dtlms-enrolled-icon",
                    declaration: `color: ${icon_color};`
                }
            ]);
        }
        if('' !== icon_size) {
            additionalCss.push([
                {
                    selector: "%%order_class%% .dtlms-enrolled-icon",
                    declaration: `font-size: ${icon_size};`
                }
            ]);
        }
        if('' !== icon_size_tablet) {
            additionalCss.push([
                {
                    selector: "%%order_class%% .dtlms-enrolled-icon",
                    declaration: `font-size: ${icon_size_tablet};`,
                    device: 'tablet'
                }
            ]);
        }
        if('' !== icon_size_phone) {
            additionalCss.push([
                {
                    selector: "%%order_class%% .dtlms-enrolled-icon",
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

        const enrolled_icon_color = props.enrolled_icon_color;
		const enrolled_icon_size  = props.enrolled_icon_size;
		if ( enrolled_icon_color ) {
            additionalCss.push([
                {
                    selector: '%%order_class%% .tutor-icon-purchase-mark',
                    declaration: `color: ${enrolled_icon_color};`
                }
            ]);
		}
		if ( enrolled_icon_size ) {
            additionalCss.push([
                {
                    selector: '%%order_class%% .tutor-icon-purchase-mark',
                    declaration: `font-size: ${enrolled_icon_size};`
                }
            ]);
		}
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