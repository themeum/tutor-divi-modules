import React, { Component, Fragment } from 'react';

class CourseEnrollment extends Component {

    static slug = "tutor_course_enrollment";

    static css(props) {
        const additionalCss = [];
        //selectors
        const wrapper               = '%%order_class%% .tutor-divi-enroll-buttons-wrapper';
        const three_buttons_wrapper = '%%order_class%% .tutor-lead-info-btn-group';
        const enroll_box_selector   = '%%order_class%% .tutor-single-add-to-cart-box';

        //props
        const alignment                 = props.alignment;
        const is_responsive_alignment   = props.alignment_last_edited && props.alignment_last_edited.startsWith("on");
        const alignment_tablet          = is_responsive_alignment && '' !== alignment_tablet ? props.alignment_tablet : alignment;
        const alignment_phone           = is_responsive_alignment && '' !== alignment_phone ? props.alignment_phone : alignment;
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

        if('' !== alignment) {
            let align = 'center';
            if(alignment === 'left') {
                align = 'flex-start';
            } else if (alignment === 'right') {
                align = 'flex-end';
            }

            additionalCss.push([
                {
                    selector: three_buttons_wrapper,
                    declaration: `align-items: ${align};`
                }
            ]);
            additionalCss.push([
                {
                    selector: enroll_box_selector,
                    declaration: `display:flex; justify-content: ${align};`
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
                    selector: three_buttons_wrapper,
                    declaration: `align-items: ${align};`,
                    device: 'tablet'
                }
            ]);
            additionalCss.push([
                {
                    selector: enroll_box_selector,
                    declaration: `display:flex; justify-content: ${align};`,
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
                    selector: three_buttons_wrapper,
                    declaration: `align-items: ${align};`,
                    device: 'phone'
                }
            ]);
            additionalCss.push([
                {
                    selector: enroll_box_selector,
                    declaration: `display:flex; justify-content: ${align};`,
                    device: 'phone'
                }
            ]);
        }

        //set styles end
        return additionalCss;
    }

    render() {
        return (
           <Fragment>

               <div className="tutor-divi-enroll-buttons-wrapper">

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
                                <span>Enrolled info dummy text for style</span>
                            </p>
                        </div>

                    </div>

               </div>

           </Fragment>
        );
    }
}
export default CourseEnrollment;