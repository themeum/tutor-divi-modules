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
        const preview_mode              = props.preview_mode;
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
        if ('enrollment' === preview_mode) {
            if('' !== alignment) {
                let align = 'center';
                if(alignment === 'left') {
                    align = 'flex-start';
                } else if (alignment === 'right') {
                    align = 'flex-end';
                }
    
                additionalCss.push([
                    {
                        selector: `%%order_class%% .dtlms-enrollment-btn-align-left .tutor-card-body, %%order_class%% .dtlms-enrollment-btn-align-center .tutor-card-body, %%order_class%% .dtlms-enrollment-btn-align-right .tutor-card-body, %%order_class%% .dtlms-enrollment-btn-align-center .dtlms-course-enroll-date`,
                        declaration: `text-align: ${align} !important;`
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
                        selector: `%%order_class%% .dtlms-enrollment-btn-align-left .tutor-card-body, %%order_class%% .dtlms-enrollment-btn-align-center .tutor-card-body, %%order_class%% .dtlms-enrollment-btn-align-right .tutor-card-body, %%order_class%% .dtlms-enrollment-btn-align-center .dtlms-course-enroll-date`,
                        declaration: `text-align: ${align} !important;`,
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
                        selector: `%%order_class%% .dtlms-enrollment-btn-align-left .tutor-card-body, %%order_class%% .dtlms-enrollment-btn-align-center .tutor-card-body, %%order_class%% .dtlms-enrollment-btn-align-right .tutor-card-body, %%order_class%% .dtlms-enrollment-btn-align-center .dtlms-course-enroll-date`,
                        declaration: `text-align: ${align} !important;`,
                        device: 'phone'
                    }
                ]);
            }
        }
        if ('enrolled' === preview_mode) {
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
                    selector: `%%order_class%% .tutor-course-sidebar-card-meta-list span.tutor-icon-24`,
                    declaration: `color: ${icon_color};`
                }
            ]);
        }
        if(icon_size) {
            additionalCss.push([
                {
                    selector: "%%order_class%% .tutor-course-sidebar-card-meta-list span.tutor-icon-24",
                    declaration: `font-size: ${icon_size};`
                }
            ]);
        }
        if(icon_size_tablet) {
            additionalCss.push([
                {
                    selector: "%%order_class%% .tutor-course-sidebar-card-meta-list span.tutor-icon-24",
                    declaration: `font-size: ${icon_size_tablet};`,
                    device: 'tablet'
                }
            ]);
        }
        if(icon_size_phone) {
            additionalCss.push([
                {
                    selector: "%%order_class%% .tutor-course-sidebar-card-meta-list span.tutor-icon-24",
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
                    selector: '%%order_class%% .etlms-enrolled-info-wrapper .tutor-icon-purchase-filled',
                    declaration: `color: ${enrolled_icon_color};`
                }
            ]);
		}
		if ( enrolled_icon_size ) {
            additionalCss.push([
                {
                    selector: '%%order_class%% .etlms-enrolled-info-wrapper .tutor-icon-purchase-filled',
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