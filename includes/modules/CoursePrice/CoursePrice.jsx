import React ,{ Component, Fragment } from "react";

class CoursePrice extends Component {

    static slug = "tutor_course_price";

    static css(props) {
        const additionalCss = [];
        //selectors
        const selector = '%%order_class%% .price';

        //props
        const alignment = props.alignment;
        const is_responsive_alignment = props.alignment_last_edited && props.alignment_last_edited.startsWith("on");
        const alignment_tablet = is_responsive_alignment && props.alignment_tablet ? props.alignment_tablet : alignment;
        const alignment_phone = is_responsive_alignment && props.alignment_phone ? props.alignment_phone : alignment;

        if(alignment) {
            additionalCss.push([
                {
                    selector: selector,
                    declaration: `text-align: ${alignment};`
                }
            ]);
        }

        if(alignment_tablet) {
            additionalCss.push([
                {
                    selector: selector,
                    declaration: `text-align: ${alignment_tablet};`,
                    device: 'tablet'
                }
            ]);
        }

        if(alignment_phone) {
            additionalCss.push([
                {
                    selector: selector,
                    declaration: `text-align: ${alignment_phone};`,
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
               <div className="price">
                   { this.props.__price.price }
               </div>
            </Fragment>            
        );
    }
}
export default CoursePrice;