import React, { Component, Fragment } from 'react';

class CourseEnrollment extends Component {

    static slug = "tutor_course_enrollment";

    constructor(props) {
        super(props);
        this.state = {
            enroll_status: 'enrollment'
        };
    }

    static css(props) {
        const additionalCss = [];
        //selectors
        const wrapper               = '%%order_class%% .tutor-sidebar-card';
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
        const preview_mode              = props.preview_mode;
        //set styles
        /**
         * default template styling
         */
        additionalCss.push([
            {
                selector: `${wrapper} .tutor-card-body.tutor-p-30`,
                declaration: 'display: flex; flex-direction: column; row-gap: 10px;'
            }
        ]);

        // custom background color for card body.
        if( props.card_body_color ){
            additionalCss.push([{
                selector: '%%order_class%% .tutor-card .tutor-card-body',
                declaration: `background-color: ${props.card_body_color}`
            }]);
        }

        // custom margin for enrollment meta info
        if( props.course_meta_info_margin ){
            const course_meta_info_margin = props.course_meta_info_margin.split('|');

            additionalCss.push([{
                selector: '%%order_class%% .tutor-sidebar-card .tutor-card-footer li:not(:first-child)',
                declaration: `margin-top: ${course_meta_info_margin[0]}; margin-right: ${course_meta_info_margin[1]}; margin-bottom: ${course_meta_info_margin[2]}; margin-left: ${course_meta_info_margin[3]};`,
            }]);
        }

        // default margins for enrollment expire info.
        additionalCss.push([{
            selector: '%%order_class%% .enrolment-expire-info .tutor-ml-4',
            declaration: 'margin-left: 4px !important;',
        }])

        // custom margin for enrollment expire info.
        if( props.enrollment_expire_margin ){
            const enrollment_expire_margin = props.enrollment_expire_margin.split('|');

            additionalCss.push([{
                selector: '%%order_class%% .enrolment-expire-info',
                declaration: `margin-top: ${enrollment_expire_margin[0]}; margin-right: ${enrollment_expire_margin[1]}; margin-bottom: ${enrollment_expire_margin[2]}; margin-left: ${enrollment_expire_margin[3]};`,
            }]);
        }

        // custom padding for card body.
        if( props.card_body_padding ){
            const card_body_padding = props.card_body_padding.split('|');
            const card_body_padding_last_edited = props.card_body_padding_last_edited;
            const card_body_padding_response_active = card_body_padding_last_edited && card_body_padding_last_edited.startsWith('on');

            additionalCss.push([{
                selector: '%%order_class%% .tutor-card .tutor-card-body',
                declaration: `padding-top: ${card_body_padding[0]}; padding-right: ${card_body_padding[1]}; padding-bottom: ${card_body_padding[2]}; padding-left: ${card_body_padding[3]};`,
            }]);

            if( props.card_body_padding_tablet && card_body_padding_response_active && '' !== props.card_body_padding_tablet ){
                const card_body_padding_tablet = props.card_body_padding_tablet.split('|')
                 additionalCss.push([{
                    selector: '%%order_class%% .tutor-card .tutor-card-body',
                    declaration: `padding-top: ${card_body_padding_tablet[0]}; padding-right: ${card_body_padding_tablet[1]}; padding-bottom: ${card_body_padding_tablet[2]}; padding-left: ${card_body_padding_tablet[3]};`,
                    device: 'tablet',
                }]);
            }

            if( props.card_body_padding_phone && card_body_padding_response_active && '' !== props.card_body_padding_phone ){
                const card_body_padding_phone = props.card_body_padding_phone.split('|')
                 additionalCss.push([{
                    selector: '%%order_class%% .tutor-card .tutor-card-body',
                    declaration: `padding-top: ${card_body_padding_phone[0]}; padding-right: ${card_body_padding_phone[1]}; padding-bottom: ${card_body_padding_phone[2]}; padding-left: ${card_body_padding_phone[3]};`,
                    device: 'phone',
                }]);
            }

        }

        if( props.course_monetization_text_margin ){
            const course_monetization_text_margin = props.course_monetization_text_margin.split('|');

            additionalCss.push([{
                selector: '%%order_class%% .dtlms-course-monetization-text',
                declaration: `margin-top: ${course_monetization_text_margin[0]}; margin-right: ${course_monetization_text_margin[1]}; margin-bottom: ${course_monetization_text_margin[2]}; margin-left: ${course_monetization_text_margin[3]};`,
            }]);
        }


         // custom padding for card info.
        if( props.card_info_padding ){
            const card_info_padding = props.card_info_padding.split('|');
            const card_info_padding_last_edited = props.card_info_padding_last_edited;
            const card_info_padding_response_active = card_info_padding_last_edited && card_info_padding_last_edited.startsWith('on');

            additionalCss.push([{
                selector: '%%order_class%% .tutor-card .tutor-card-footer',
                declaration: `padding-top: ${card_info_padding[0]}; padding-right: ${card_info_padding[1]}; padding-bottom: ${card_info_padding[2]}; padding-left: ${card_info_padding[3]};`,
            }]);

            if( props.card_info_padding_tablet && card_info_padding_response_active && '' !== props.card_info_padding_tablet ){
                const card_info_padding_tablet = props.card_info_padding_tablet.split('|')
                 additionalCss.push([{
                    selector: '%%order_class%% .tutor-card .tutor-card-footer',
                    declaration: `padding-top: ${card_info_padding_tablet[0]}; padding-right: ${card_info_padding_tablet[1]}; padding-bottom: ${card_info_padding_tablet[2]}; padding-left: ${card_info_padding_tablet[3]};`,
                    device: 'tablet',
                }]);
            }

            if( props.card_info_padding_phone && card_info_padding_response_active && '' !== props.card_info_padding_phone ){
                const card_info_padding_phone = props.card_info_padding_phone.split('|')
                 additionalCss.push([{
                    selector: '%%order_class%% .tutor-card .tutor-card-footer',
                    declaration: `padding-top: ${card_info_padding_phone[0]}; padding-right: ${card_info_padding_phone[1]}; padding-bottom: ${card_info_padding_phone[2]}; padding-left: ${card_info_padding_phone[3]};`,
                    device: 'phone',
                }]);
            }

        }

        //card styles
        if( '' !== props.gap ){
            additionalCss.push([
                {
                    selector: '%%order_class%% .tutor-card',
                    declaration: `row-gap: ${props.gap};`
                }
            ]);
        }

        //alignment styles
        if ('enrollment' === preview_mode) {
            if('' !== alignment) {
                additionalCss.push([
                    {
                        selector: `%%order_class%% .dtlms-enroll-btn-width-auto .tutor-card-body`,
                        declaration: `text-align: ${alignment} !important;`
                    },
                    {
                        selector: `%%order_class%% .dtlms-enroll-btn-width-auto form`,
                        declaration: `display: inline-flex !important;`
                    },
                    {
                        selector: `%%order_class%% .tutor-btn`,
                        declaration: `display: inline-flex !important;`
                    }
                ]);
            }
    
            if('' !== alignment_tablet) {
    
                additionalCss.push([
                    {
                        selector: `%%order_class%% .dtlms-enroll-btn-width-auto .tutor-card-body`,
                        declaration: `text-align: ${alignment_tablet} !important;`,
                        device: 'tablet'
                    },
                    {
                        selector: `%%order_class%% .dtlms-enroll-btn-width-auto form`,
                        declaration: `display: inline-flex !important;`,
                        device: 'tablet'
                    },
                    {
                        selector: `%%order_class%% .tutor-btn`,
                        declaration: `display: inline-flex !important;`,
                        device: 'tablet'
                    }
                ]);
            }
    
            if('' !== alignment_phone) {

                additionalCss.push([
                    {
                        selector: `%%order_class%% .dtlms-enroll-btn-width-auto .tutor-card-body`,
                        declaration: `text-align: ${alignment_tablet} !important;`,
                        device: 'phone'
                    },
                    {
                        selector: `%%order_class%% .dtlms-enroll-btn-width-auto form`,
                        declaration: `display: inline-flex !important;`,
                        device: 'phone'
                    },
                    {
                        selector: `%%order_class%% .tutor-btn`,
                        declaration: `display: inline-flex !important;`,
                        device: 'phone'
                    }
                ]);
            }
        }
        console.log(preview_mode);

        // if ('enrolled' === preview_mode) {
            
        // }

        additionalCss.push([
            {
                selector: '.dtlms-enroll-btn-width-auto .tutor-course-sidebar-card-body:not(.tutor-course-progress-wrapper)',
                declaration: 'display: flex; flex-direction: column;',
            },
            {
                selector: '.dtlms-enroll-btn-align-left .tutor-course-sidebar-card-body:not(.tutor-course-progress-wrapper)',
                declaration: 'align-items: flex-start;',
            },
            {
                selector: '.dtlms-enroll-btn-align-center .tutor-course-sidebar-card-body:not(.tutor-course-progress-wrapper)',
                declaration: 'align-items: center;',
            },
            {
                selector: '.dtlms-enroll-btn-align-right .tutor-course-sidebar-card-body:not(.tutor-course-progress-wrapper)',
                declaration: 'align-items: flex-end;',
            },
            {
                selector: '%%order_class%% .dtlms-enroll-btn-width-auto form',
                declaration: 'display: flex; flex-direction: column;',
            },
            {
                selector: '%%order_class%% .dtlms-enroll-btn-align-left form, ',
                declaration: 'align-items: flex-start;',
            },
            {
                selector: '%%order_class%% .dtlms-enroll-btn-align-right form, ',
                declaration: 'align-items: flex-end;',
            },
            {
                selector: '%%order_class%% .dtlms-enroll-btn-align-center form, ',
                declaration: 'align-items: center;',
            }
        ]);

        if (props.course_progress_background) {
            additionalCss.push([{
                selector: '%%order_class%% .tutor-course-progress-wrapper .tutor-progress-bar',
                declaration: `background : ${props.course_progress_background}`,
            }]);
        }

        additionalCss.push([{
            selector: '%%order_class%% .tutor-card-body a',
            declaration: `line-height: inherit; padding-bottom: 8px !important;`
        }]);


        if (props.course_progress_margin) {
            const course_progress_margin = props.course_progress_margin.split('|');

            additionalCss.push([{
                selector: '%%order_class%% .tutor-course-progress-wrapper .tutor-progress-bar',
                declaration: `margin-top: ${course_progress_margin[0]}; margin-right: ${course_progress_margin[1]}; margin-bottom: ${course_progress_margin[2]}; margin-left: ${course_progress_margin[3]};`,
            }]);
        }

        if (props.enrolled_info_spacing) {
            additionalCss.push([{
                selector: '%%order_class%% .dtlms-course-enroll-info-wrapper',
                declaration: `column-gap: ${props.enrolled_info_spacing}`
            }]);
        }

        if (props.enrolled_info_margin) {
            const enrolled_info_margin = props.enrolled_info_margin.split('|');

            additionalCss.push([{
                selector: '%%order_class%% .dtlms-course-enroll-info-wrapper',
                declaration: `margin-top: ${enrolled_info_margin[0]}; margin-right: ${enrolled_info_margin[1]}; margin-bottom: ${enrolled_info_margin[2]}; margin-left: ${enrolled_info_margin[3]};`,
            }]);
        }

        if (props.course_progress_title_margin) {
            const course_progress_title_margin = props.course_progress_title_margin.split('|');

            additionalCss.push([{
                selector: '%%order_class%% .tutor-course-progress-wrapper h3',
                declaration: `margin-top: ${course_progress_title_margin[0]}; margin-right: ${course_progress_title_margin[1]}; margin-bottom: ${course_progress_title_margin[2]}; margin-left: ${course_progress_title_margin[3]};`,
            }]);
        }

        if (props.course_alert_background) {
            additionalCss.push([{
                selector: '%%order_class%% .tutor-alert',
                declaration: `background: ${props.course_alert_background}`
            }]);
        }

        if (props.course_alert_gap) {
            additionalCss.push([{
                selector: '%%order_class%% .tutor-alert .tutor-alert-text',
                declaration: `column-gap: ${props.course_alert_gap}`,
            }]);
        }

        if (props.course_alert_padding) {
            const course_alert_padding = props.course_alert_padding.split('|')
            additionalCss.push([{
                selector: '%%order_class%% .tutor-card .tutor-card-footer',
                declaration: `padding-top: ${course_alert_padding[0]}; padding-right: ${course_alert_padding[1]}; padding-bottom: ${course_alert_padding[2]}; padding-left: ${course_alert_padding[3]};`,
                device: 'tablet',
            }]);
        }

        if (props.course_alert_margin) {
            const course_alert_margin = props.course_alert_margin.split('|');

            additionalCss.push([{
                selector: '%%order_class%% .tutor-alert',
                declaration: `margin-top: ${course_alert_margin[0]}; margin-right: ${course_alert_margin[1]}; margin-bottom: ${course_alert_margin[2]}; margin-left: ${course_alert_margin[3]};`,
            }]);
        }

        if (props.course_alert_icon_color) {
            additionalCss.push([{
                selector: '%%order_class%% .tutor-alert-icon',
                declaration: `color: ${props.course_alert_icon_color}`
            }]);
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
            additionalCss.push([
                {
                    selector: '%%order_class%% .tutor-course-sidebar-card-btns, %%order_class%% .tutor-course-sidebar-card-body form',
					declaration: 'width: 100%;',
                }
            ]);
        } else if('auto' === btn_width) {
            //start/continue btn not gradebook
            additionalCss.push([
                {
					selector: '%%order_class%% .dtlms-enroll-btn-width-auto .tutor-btn',
					declaration: 'width: auto !important; display: inline-flex !important;',
                }
            ]);
             //enrollment (enroll/add to cart) btn default width auto so no need to style if width is fill
        } else {
            //fixed width
            additionalCss.push([
                {
                    selector:  `%%order_class%% button, %%order_class%% .tutor-button, %%order_class%% .start-continue-retake-button`,
                    declaration: `width: ${width_px} !important; text-align:center;`
                }
            ]);
        }
        //button size 
        if('small' === props.button_size) {
            additionalCss.push([
                {
					selector: '%%order_class%% .dtlms-enroll-btn-size-small .tutor-btn',
					declaration: 'font-size: 14px; padding: 5px 12px;'
                }
            ]);
        } else if ('large' === props.button_size) {
            additionalCss.push([
                {
					selector: '%%order_class%% .dtlms-enroll-btn-size-large .tutor-btn',
					declaration: 'font-size: 18px; padding: 10px 20px;',
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
        if(icon_color) {
            additionalCss.push([
                {
                    selector: "%%order_class%% .tutor-card-footer .dtlms-enrollment-meta-label",
                    declaration: `color: ${icon_color};`
                }
            ]);
        }
        if(icon_size) {
            additionalCss.push([
                {
                    selector: "%%order_class%% .tutor-card-footer .dtlms-enrollment-meta-label",
                    declaration: `font-size: ${icon_size};`
                }
            ]);
        }
        if(icon_size_tablet) {
            additionalCss.push([
                {
                    selector: "%%order_class%% .tutor-card-footer .dtlms-enrollment-meta-label",
                    declaration: `font-size: ${icon_size_tablet};`,
                    device: 'tablet'
                }
            ]);
        }
        if(icon_size_phone) {
            additionalCss.push([
                {
                    selector: "%%order_class%% .tutor-card-footer .dtlms-enrollment-meta-label",
                    declaration: `font-size: ${icon_size_phone};`,
                    device: 'phone'
                }
            ]);
        }
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
export default CourseEnrollment;