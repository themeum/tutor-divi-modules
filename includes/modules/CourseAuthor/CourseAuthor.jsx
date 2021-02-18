// External Dependencies
import React, { Component, Fragment } from 'react';

class CourseAuthor extends Component {

    static slug = 'tutor_course_author';

    /**
     * All component inline styling.
     *
     * @since 1.0.0
     * @return array
     */
    static css(props) {
        const additionalCss = [];
        const img_selector = '%%order_class%% .tutor-single-course-avatar a span';
        if (props.image_height) {
            additionalCss.push([{
                selector:    img_selector,
                declaration: `height: ${props.image_height} !important;`,
            }]);
        }
        if (props.image_width) {
            additionalCss.push([{
                selector:    img_selector,
                declaration: `width: ${props.image_width} !important;`,
            }]);
        }

        return additionalCss;
    }

    render() {
        return (
            <Fragment>
                {console.log(this.props.__author)}
            </Fragment>
        );
    }
}

export default CourseAuthor;