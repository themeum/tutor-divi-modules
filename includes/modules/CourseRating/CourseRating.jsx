// External Dependencies
import React, { Component, Fragment } from 'react';

class CourseRating extends Component {

    static slug = 'tutor_course_rating';

    /**
     * All component inline styling.
     *
     * @since 1.0.0
     * @return array
     */
    static css(props) {
        const additionalCss = [];
        const star_selector = '%%order_class%% .tutor-single-course-rating .tutor-star-rating-group';
        const star_icon_group = '%%order_class%% .tutor-star-rating-group';
        
        if (props.star_size) {
            additionalCss.push([{
                selector:    '%%order_class%% .tutor-star-rating-group i',
                declaration: `font-size: ${props.star_size};`,
            }]);
        }
        
        if (props.star_color) {
            additionalCss.push([{
                selector:    star_selector,
                declaration: `color: ${props.star_color};`,
            }]);
        }

        if (props.star_gap) {
            additionalCss.push([{
                selector:    star_icon_group,
                declaration: `letter-spacing: ${props.star_gap};`,
            }]);
        }

        return additionalCss;
    }

    render() {
        return (
            <Fragment>
                <div 
                    className='tutor-course-rating'
                    dangerouslySetInnerHTML={{ __html: this.props.__rating }} 
                />
            </Fragment>
        );
    }
}

export default CourseRating;