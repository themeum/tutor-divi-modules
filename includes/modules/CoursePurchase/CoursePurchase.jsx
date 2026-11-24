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

        const enrollmentBoxBackground   = props.enrollment_box_background;
        //set styles
        /**
         * default template styling
         */

          // set radio appearance
        additionalCss.push([
            {
                selector: '%%order_class%% .tutor-form-check-input',
                declaration: 'appearance: none !important;',
            }
        ])

        //set button appearance
        additionalCss.push([
            {
                selector: '%%order_class%% .tutor-btn.tutor-d-none',
                declaration : 'display: none !important;'
            }
        ])
        additionalCss.push([
            {
                selector: `%%order_class%% .tutor-card-body`,
                declaration: `background-color: ${enrollmentBoxBackground} !important;`
            }
        ]);
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
                    selector: "%%order_class%% .tutor-card-footer .dtlms-enrollment-meta-label",
                    declaration: `color: ${icon_color};`
                }
            ]);
        }
        if('' !== icon_size) {
            additionalCss.push([
                {
                    selector: "%%order_class%% .tutor-card-footer .dtlms-enrollment-meta-label",
                    declaration: `font-size: ${icon_size};`
                }
            ]);
        }
        if('' !== icon_size_tablet) {
            additionalCss.push([
                {
                    selector: "%%order_class%% .tutor-card-footer .dtlms-enrollment-meta-label",
                    declaration: `font-size: ${icon_size_tablet};`,
                    device: 'tablet'
                }
            ]);
        }
        if('' !== icon_size_phone) {
            additionalCss.push([
                {
                    selector: "%%order_class%% .tutor-card-footer .dtlms-enrollment-meta-label",
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

        //subscription plans

        additionalCss.push([
            {
                selector: '%%order_class%% .tutor-subscription-plan-wrapper',
                declaration: `display: flex;flex-direction: column;`
            }
        ]);

        additionalCss.push([
            {
                selector: '%%order_class%% .tutor-plan-feature-list',
                declaration: `display: flex;flex-direction: column;`
            }
        ]);

        additionalCss.push([
            {
                selector: '%%order_class%% .tutor-plan-feature-item',
                declaration: `display: flex;align-items:center;`
            }
        ]);

        if ( '' !== props.subscription_plan_gap ){
            additionalCss.push([
                {
                    selector: '%%order_class%% .tutor-subscription-plan-wrapper',
                    declaration: `gap: ${props.subscription_plan_gap};`
                }
            ])
        }

        if ( '' !== props.plan_list_gap ){
            additionalCss.push([
                {
                    selector: '%%order_class%% .tutor-plan-feature-list',
                    declaration: `gap: ${props.plan_list_gap};`
                }
            ])
        }

        if ( '' !== props.plan_item_gap ){
            additionalCss.push([
                {
                    selector: '%%order_class%% .tutor-plan-feature-item',
                    declaration: `gap: ${props.plan_item_gap};`
                }
            ])
        }

        additionalCss.push([
            {
                selector: '%%order_class%% .tutor-course-subscription-plan',
                declaration: `display: block;`
            }
        ]);

        if ( '' !== props.subscription_plan_background_color ){
            additionalCss.push([
                {
                    selector: '%%order_class%% .tutor-course-subscription-plan',
                    declaration: `background-color: ${props.subscription_plan_background_color};`
                }
            ])
        }

        if ( '' !== props.plan_feature_icon_color ){
            additionalCss.push([
                {
                    selector: '%%order_class%% .tutor-plan-feature-item i',
                    declaration: `color: ${props.plan_feature_icon_color} !important;`
                }
            ])
        }

        // custom margin for subscription plan.
        if( props.subscription_plan_margin ){
            const subscription_plan_margin = props.subscription_plan_margin.split('|');

            additionalCss.push([{
                selector: '%%order_class%% .tutor-course-subscription-plan',
                declaration: `margin-top: ${subscription_plan_margin[0]}; margin-right: ${subscription_plan_margin[1]}; margin-bottom: ${subscription_plan_margin[2]}; margin-left: ${subscription_plan_margin[3]};`,
            }]);
        }

        if( props.subscription_plan_feature_margin ){
            const subscription_plan_feature_margin = props.subscription_plan_feature_margin.split('|');

            additionalCss.push([{
                selector: '%%order_class%% .tutor-plan-feature-list',
                declaration: `margin-top: ${subscription_plan_feature_margin[0]}; margin-right: ${subscription_plan_feature_margin[1]}; margin-bottom: ${subscription_plan_feature_margin[2]}; margin-left: ${subscription_plan_feature_margin[3]};`,
            }]);
        }

        // custom padding for subscription plan.
        if( props.subscription_plan_padding ){
            const subscription_plan_padding = props.subscription_plan_padding.split('|');

            additionalCss.push([{
                selector: '%%order_class%% .tutor-course-subscription-plan',
                declaration: `padding-top: ${subscription_plan_padding[0]}; padding-right: ${subscription_plan_padding[1]}; padding-bottom: ${subscription_plan_padding[2]}; padding-left: ${subscription_plan_padding[3]};`,
            }]);
        }
        // course progress style end
        //set styles end
        return additionalCss;
    }

    render() {
        if(!this.props.__enrollment) {
            return '';
        }
        return (
           <Fragment>
               <div className="tutor-divi-enroll-buttons-wrapper" dangerouslySetInnerHTML={{__html: this.props.__enrollment}}>
               </div>
           </Fragment>
        );
    }
}
export default CoursePurchase;