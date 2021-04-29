import React ,{ Component, Fragment } from "react";

class CoursePrice extends Component {

    static slug = "tutor_course_price";

    static css(props) {
        const additionalCss = [];
        //selectors
        const selector = '%%order_class%% .price .price';

        //props
        let alignment = props.alignment;
        const is_responsive_alignment = props.alignment_last_edited && props.alignment_last_edited.startsWith("on");
        let alignment_tablet = is_responsive_alignment && props.alignment_tablet ? props.alignment_tablet : alignment;
        let alignment_phone = is_responsive_alignment && props.alignment_phone ? props.alignment_phone : alignment;

        if('left' === alignment) {
            alignment = 'flex-end';
        } else if('right' === alignment) {
            alignment = 'flex-start';
        }        

        if('left' === alignment_tablet) {
            alignment_tablet = 'flex-end';
        } else if('right' === alignment_tablet) {
            alignment_tablet = 'flex-start';
        }        

        if('left' === alignment_phone) {
            alignment_phone = 'flex-end';
        } else if('right' === alignment_phone) {
            alignment_phone = 'flex-start';
        }

        additionalCss.push([
            {
                selector: selector,
                declaration: `display: flex; flex-direction: row-reverse;`
            }
        ]);

        if(alignment) {
            additionalCss.push([
                {
                    selector: selector,
                    declaration: `justify-content: ${alignment};`
                }
            ]);
        }

        if(alignment_tablet) {
            additionalCss.push([
                {
                    selector: selector,
                    declaration: `justify-content: ${alignment_tablet};`,
                    device: 'tablet'
                }
            ]);
        }

        if(alignment_phone) {
            additionalCss.push([
                {
                    selector: selector,
                    declaration: `justify-content: ${alignment_phone};`,
                    device: 'phone'
                }
            ]);
        }

        return additionalCss;
    }
    render() {
        if(!this.props.__price) {
            return '';
        }
        
        return (
            <Fragment>
               <div className="tutor-divi-course-price">
                    <div className="price">
                        <div className="price">
                            <del>
                                <span className="woocommerce-Price-amount amount">
                                    <bdi>
                                        <span className="woocommerce-Price-currencySymbol">
                                        $
                                        </span>
                                        { this.props.__price.sale_price }
                                    </bdi>
                                </span>
                            </del>                        
                            <ins>
                                <span className="woocommerce-Price-amount amount">
                                    <bdi>
                                        <span className="woocommerce-Price-currencySymbol">
                                        $
                                        </span>
                                        { this.props.__price.regular_price }
                                    </bdi>
                                </span>
                            </ins>
                        </div>
                    </div>
               </div>
            </Fragment>            
        );
    }
}
export default CoursePrice;