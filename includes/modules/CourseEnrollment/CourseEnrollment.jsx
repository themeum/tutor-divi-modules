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
                    selector: `${wrapper} .tutor-course-sidebar-card-body.tutor-p-30`,
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
                    selector: `${wrapper} .tutor-course-sidebar-card-body.tutor-p-30`,
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
                    selector: `${wrapper} .tutor-btn`,
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
        //set styles end
        return additionalCss;
    }

    // addToCartOrEnrollNow(props) {
    //     const utils         = window.ET_Builder.API.Utils;
    //     const enroll_now    = utils.processFontIcon(props.enrollment_button_icon);
    //     const add_to_cart   = utils.processFontIcon(props.add_to_cart_button_icon);

    //     if(props.__enrollment === 'yes') {
    //         return (
    //                 <div className="tutor-course-enrollment-box">
    //                     <div className="tutor-single-add-to-cart-box">
    //                         <div className="tutor-course-purchase-box">
    //                             <button className="single_add_to_cart_button tutor-button alt" data-icon={add_to_cart}>
    //                                 <i className="tutor-icon-shopping-cart"></i>  
    //                                 Add to Cart
    //                             </button>
    //                         </div>
    //                     </div>
    //                 </div>
    //         );
    //     }
    //     return (
    //         <div className="tutor-course-enrollment-box">
    //             <div className="tutor-single-add-to-cart-box">
    //                 <div className="tutor-course-enroll-wrap">
    //                     <button className="tutor-btn-enroll tutor-btn tutor-course-purchase-btn" data-icon={enroll_now}>
    //                         <span>Enroll Now</span>  
    //                     </button>
    //                 </div>
    //             </div>
    //         </div>
    //     );     
    // }
   
    // switchTemplate(props) {
    //     const utils     = window.ET_Builder.API.Utils;
    //     const start_continue_button = utils.processFontIcon(props.start_continue_button_icon);
    //     const complete_button       = utils.processFontIcon(props.complete_button_icon);
    //     const gradebook_button      = utils.processFontIcon(props.gradebook_button_icon);

    //     if('enrollment' === props.preview_mode) {
    //         return (
    //             <Fragment>
    //                 { this.addToCartOrEnrollNow(props) } 
    //             </Fragment>
    //         );
    //     } else {
    //         return (
    //             <Fragment>
    //                 <div className="tutor-course-enrollment-box">

    //                     <div className="tutor-lead-info-btn-group">
    //                         <a href="/" className="tutor-button tutor-success" data-icon={start_continue_button}>
    //                             Start Course
    //                         </a>

    //                         <div className="tutor-course-compelte-form-wrap">
    //                             <button className="course-complete-button" data-icon={complete_button}>
    //                                 Complete Course
    //                             </button>
    //                         </div>
                            
    //                         <a href="/" className="generate-course-gradebook-btn-wrap">
    //                             <button className="tutor-button tutor-button-block button-primary" data-icon={gradebook_button}>
    //                                 Generate Gradebook
    //                             </button>
    //                         </a>

    //                     </div>

    //                     <div className="tutor-single-course-segment  tutor-course-enrolled-wrap">
    //                         <p>
    //                             <i className="tutor-icon-purchase"></i>
    //                             Enrolled info dummy text for style
    //                             <span className="enroll-date"> YY/MM/DD </span>
    //                         </p>
    //                     </div>

    //                 </div>                    
    //             </Fragment>
    //         );
    //     }
 
    // }

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
export default CourseEnrollment;