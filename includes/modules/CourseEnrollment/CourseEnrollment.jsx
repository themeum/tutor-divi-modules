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
        const wrapper               = '%%order_class%% .tutor-divi-enroll-buttons-wrapper';
        const three_buttons_wrapper = '%%order_class%% .tutor-lead-info-btn-group';
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
                selector: wrapper,
                declaration: 'display: flex; flex-direction: column; row-gap: 10px;'
            }
        ]);

        additionalCss.push([
            {
                selector: three_buttons_wrapper,
                declaration: 'display: flex; flex-direction: column; row-gap: 5px;'
            }
        ]);
        additionalCss.push([
            {
                selector: three_buttons_wrapper,
                declaration: 'border-bottom: 0px;'
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
                    selector: '%%order_class%% .tutor-course-purchase-box, %%order_class%% .tutor-course-enroll-wrap, %%order_class%% .tutor-course-compelte-form-wrap',
                    declaration: `display: flex; justify-content: ${align};`
                }
            ]);
        
            additionalCss.push([
                {
                    selector: three_buttons_wrapper,
                    declaration: `display:flex; align-items: ${align};`
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
                    selector: '%%order_class%% .tutor-course-purchase-box, %%order_class%% .tutor-course-enroll-wrap, %%order_class%% .tutor-course-compelte-form-wrap',
                    declaration: `display: flex; justify-content: ${align};`,
                    device: 'tablet'
                }
            ]);
        
            additionalCss.push([
                {
                    selector: three_buttons_wrapper,
                    declaration: `display:flex; align-items: ${align};`,
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
                    selector: '%%order_class%% .tutor-course-purchase-box, %%order_class%% .tutor-course-enroll-wrap, %%order_class%% .tutor-course-compelte-form-wrap',
                    declaration: `display: flex; justify-content: ${align};`,
                    device: 'phone'
                }
            ]);
        
            additionalCss.push([
                {
                    selector: three_buttons_wrapper,
                    declaration: `display:flex; align-items: ${align};`,
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
            //enroll & add to cart button
            additionalCss.push([
                {
                    selector: '%%order_class%% .tutor-course-enrollment-box .tutor-single-add-to-cart-box .single_add_to_cart_button, %%order_class%% .tutor-course-enrollment-box .tutor-course-enroll-wrap .tutor-btn-enroll, %%order_class%% .generate-course-gradebook-btn-wrap',
                    declaration: `width: 100%; display: flex; justify-content: center;`
                }
            ]);

            //enrolled(start/continue not gradebook) btn default width 100% so no need to style if width is fill
        } else if('auto' === btn_width) {
            //start/continue btn not gradebook
            additionalCss.push([
                {
                    selector: `${three_buttons_wrapper} .tutor-button, ${three_buttons_wrapper} .course-complete-button`,
                    declaration: 'width: auto;'
                }
            ]);
             //enrollment (enroll/add to cart) btn default width auto so no need to style if width is fill
        } else {
            //fixed width
            additionalCss.push([
                {
                    selector: `${wrapper} .single_add_to_cart_button, ${wrapper} .tutor-course-enroll-wrap .tutor-btn, ${wrapper} .tutor-lead-info-btn-group .tutor-button, ${wrapper} .course-complete-button, ${wrapper} .generate-course-gradebook-btn-wrap .tutor-button`,
                    declaration: `width: ${width_px} !important; text-align:center;`
                }
            ]);
            additionalCss.push([
                {
                    selector: `${wrapper} .tutor-course-enroll-wrap .tutor-btn, ${wrapper} .single_add_to_cart_button.tutor-button`,
                    declaration: `display: flex; justify-content: center;`
                }
            ]);
        }
        //button size 
        if('small' === props.button_size) {
            additionalCss.push([
                {
                    selector: `${wrapper} .single_add_to_cart_button, ${wrapper} .tutor-course-enroll-wrap .tutor-btn, ${wrapper} .tutor-lead-info-btn-group .tutor-button, ${wrapper} .course-complete-button, ${wrapper} .generate-course-gradebook-btn-wrap .tutor-button`,
                    declaration: `padding: 9px 14px !important;`
                }
            ]);
        } else if ('large' === props.button_size) {
            additionalCss.push([
                {
                    selector: `${wrapper} .single_add_to_cart_button, ${wrapper} .tutor-course-enroll-wrap .tutor-btn, ${wrapper} .tutor-lead-info-btn-group .tutor-button, ${wrapper} .course-complete-button, ${wrapper} .generate-course-gradebook-btn-wrap .tutor-button`,
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
        if('' !== icon_color) {
            additionalCss.push([
                {
                    selector: '%%order_class%% .tutor-single-course-segment.tutor-course-enrolled-wrap p >i',
                    declaration: `color: ${icon_color};`
                }
            ]);
        }
        if('' !== icon_size) {
            additionalCss.push([
                {
                    selector: '%%order_class%% .tutor-single-course-segment.tutor-course-enrolled-wrap p >i',
                    declaration: `font-size: ${icon_size};`
                }
            ]);
        }
        if('' !== icon_size_tablet) {
            additionalCss.push([
                {
                    selector: '%%order_class%% .tutor-single-course-segment.tutor-course-enrolled-wrap p >i',
                    declaration: `font-size: ${icon_size_tablet};`,
                    device: 'tablet'
                }
            ]);
        }
        if('' !== icon_size_phone) {
            additionalCss.push([
                {
                    selector: '%%order_class%% .tutor-single-course-segment.tutor-course-enrolled-wrap p >i',
                    declaration: `font-size: ${icon_size_phone};`,
                    device: 'phone'
                }
            ]);
        }
        //set styles end
        return additionalCss;
    }

    switchTemplate(props) {
        if('enrollment' === props.preview_mode) {
            return (
                <Fragment>
                    <div className="tutor-course-enrollment-box">
                        <div className="tutor-single-add-to-cart-box">
                            <div className="tutor-course-purchase-box">
                                <button className="single_add_to_cart_button tutor-button alt">
                                    <i className="tutor-icon-shopping-cart"></i>  
                                    <span>Add to Cart</span>  
                                </button>
                            </div>
                        </div>
                    </div>
            
                    <div className="tutor-course-enrollment-box">
                        <div className="tutor-single-add-to-cart-box">
                            <div className="tutor-course-enroll-wrap">
                                <button className="tutor-btn-enroll tutor-btn tutor-course-purchase-btn">
                                    <span>Enroll Now</span>  
                                </button>
                            </div>
                        </div>
                    </div>  
                </Fragment>
            );
        } else {
            return (
                <Fragment>
                    <div className="tutor-course-enrollment-box">

                        <div className="tutor-lead-info-btn-group">
                            <a href="/" className="tutor-button tutor-success">
                                Start Course
                            </a>

                            <div className="tutor-course-compelte-form-wrap">
                                <button className="course-complete-button">
                                    Complete Course
                                </button>
                            </div>
                            
                            <a href="/" className="generate-course-gradebook-btn-wrap">
                                <button className="tutor-button tutor-button-block button-primary">
                                    Generate Gradebook
                                </button>
                            </a>

                        </div>

                        <div className="tutor-single-course-segment  tutor-course-enrolled-wrap">
                            <p>
                                <i className="tutor-icon-purchase"></i>
                                Enrolled info dummy text for style
                                <span className="enroll-date"> YY/MM/DD </span>
                            </p>
                        </div>

                    </div>                    
                </Fragment>
            );
        }
 
    }

    render() {
        console.log(this.props)
        return (
           <Fragment>

               <div className="tutor-divi-enroll-buttons-wrapper">
                    { this.switchTemplate(this.props) }
               </div>

           </Fragment>
        );
    }
}
export default CourseEnrollment;