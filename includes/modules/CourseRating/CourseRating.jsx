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

        const layout = props.rating_layout;

        // prepare alignment props.
        const is_responsive     = props.rating_alignment_last_edited && props.rating_alignment_last_edited.startsWith("on");
        let alignment         = props.rating_alignment ? props.rating_alignment : 'left';
        let alignment_tablet  = is_responsive && props.rating_alignment_tablet ? props.rating_alignment_tablet : alignment;
        let alignment_phone   = is_responsive && props.rating_alignment_phone ? props.rating_alignment_phone : alignment;

        alignment = alignment === 'left' ? alignment = 'flex-start' : alignment === 'right' ? alignment = 'flex-end' : 'center';

        alignment_tablet = alignment_tablet === 'left' ? alignment_tablet = 'flex-start' : alignment_tablet === 'right' ? alignment_tablet = 'flex-end' : 'center';

        alignment_phone = alignment_phone === 'left' ? alignment_phone = 'flex-start' : alignment_phone === 'right' ? alignment_phone = 'flex-end' : 'center';

        if (layout) {
            additionalCss.push([{
                selector: '%%order_class%% .tutor-single-course-rating',
                declaration: `display: flex; column-gap: 3px; flex-direction: ${layout};`,
            }]);
        }

        // alignments
        if ( 'row' === layout ) {
            if ( '' !== alignment ) {
                additionalCss.push([{
                    selector: '%%order_class%% .tutor-single-course-rating',
                    declaration: `justify-content: ${alignment};`,
                }]);
            }
            if ( '' !== alignment_tablet ) {
                additionalCss.push([{
                    selector: '%%order_class%% .tutor-single-course-rating',
                    declaration: `justify-content: ${alignment_tablet};`,
                    device: 'tablet',
                }]);
            }
            if ( '' !== alignment_phone ) {
                additionalCss.push([{
                    selector: '%%order_class%% .tutor-single-course-rating',
                    declaration: `justify-content: ${alignment_phone};`,
                    device: 'phone'
                }]);
            }
        }

        if ( 'column' === layout ) {
            if ( '' !== alignment ) {
                additionalCss.push([{
                    selector: '%%order_class%% .tutor-single-course-rating',
                    declaration: `align-items: ${alignment};`,
                }]);
            }
            if ( '' !== alignment_tablet ) {
                additionalCss.push([{
                    selector: '%%order_class%% .tutor-single-course-rating',
                    declaration: `align-items: ${alignment_tablet};`,
                    device: 'tablet'
                }]);
            }
            if ( '' !== alignment_phone ) {
                additionalCss.push([{
                    selector: '%%order_class%% .tutor-single-course-rating',
                    declaration: `align-items: ${alignment_phone};`,
                    device: 'phone'
                }]);
            }
        }
        // alignments end
        
        //default star color
        additionalCss.push([
            {
                selector: '%%order_class%% .tutor-star-rating-group i',
				declaration: 'color: #ed9700;'
            }
        ]);
    
        if (props.star_size) {
            additionalCss.push([{
                selector: `%%order_class%% .dtlms-rating-wrapper .tutor-ratings-stars i`,
                declaration: `font-size: ${props.star_size};`,
            }]);
        }
        
        if (props.star_color) {
            additionalCss.push([{
                selector: `%%order_class%% .dtlms-rating-wrapper .tutor-ratings-stars i`,
                declaration: `color: ${props.star_color};`,
            }]);
        }

        if (props.star_gap) {
            additionalCss.push([{
                selector: `%%order_class%% .dtlms-rating-wrapper .tutor-ratings-stars`,
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