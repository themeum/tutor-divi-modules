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
                selector: `${wrapper} .tutor-card-body`,
                declaration: 'display: flex; flex-direction: column; row-gap: 10px;'
            }
        ]);

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
        if ('enrolled' === preview_mode) {
            additionalCss.push([
                {
                    selector: '.dtlms-enroll-btn-width-auto .tutor-card-body:not(.tutor-course-progress-wrapper)',
					declaration: 'display: flex; flex-direction: column;', 
                },
                {
					selector: '.dtlms-enroll-btn-align-left .tutor-card-body:not(.tutor-course-progress-wrapper)',
					declaration: 'align-items: flex-start;', 
                },
                {
					selector: '.dtlms-enroll-btn-align-center .tutor-card-body:not(.tutor-course-progress-wrapper)',
					declaration: 'align-items: center;',
                },
                {
                    selector: '.dtlms-enroll-btn-align-right .tutor-card-body:not(.tutor-course-progress-wrapper)',
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
                    selector: '%%order_class%% .tutor-card-body, %%order_class%% .tutor-card-body form',
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
                    selector:  `%%order_class%% button, %%order_class%% .tutor-btn, %%order_class%% .tutor-course-retake-button`,
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
                    selector: "%%order_class%% .tutor-card-footer .dtlms-enrolled-icon",
                    declaration: `color: ${icon_color};`
                }
            ]);
        }
        if(icon_size) {
            additionalCss.push([
                {
                    selector: "%%order_class%% .tutor-card-footer .dtlms-enrolled-icon",
                    declaration: `font-size: ${icon_size};`
                }
            ]);
        }
        if(icon_size_tablet) {
            additionalCss.push([
                {
                    selector: "%%order_class%% .tutor-card-footer .dtlms-enrolled-icon",
                    declaration: `font-size: ${icon_size_tablet};`,
                    device: 'tablet'
                }
            ]);
        }
        if(icon_size_phone) {
            additionalCss.push([
                {
                    selector: "%%order_class%% .tutor-card-footer .dtlms-enrolled-icon",
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
               <div className="tutor-course-enrollment-box" dangerouslySetInnerHTML={{__html: this.props.__enrollment}}>
               </div>
           </Fragment>
        );
    }
}
export default CourseEnrollment;