import React, { Component, Fragment } from 'react';

class CourseReviews extends Component {

    static slug = "tutor-course-reviews";

    static css(props) {
        const additionalCss = [];   
        const rating_right_bar_selector = '%%order_class%% .tutor-review-summary-ratings';
        if ('' !== props.review_right_star) {
            additionalCss.push([
                {
                    selector: `${rating_right_bar_selector} .tutor-ratings .tutor-ratings-stars`,
                    declaration: `color: ${props.review_right_star};`,
                }
            ]);         
        }      
        if ('' !== props.review_right_bar_height) {
            additionalCss.push([
                {
                    selector: `${rating_right_bar_selector} .tutor-ratings-progress-bar`,
                    declaration: `height: ${props.review_right_bar_height} !important;`,
                }
            ]);         
        }      
        if ('' !== props.review_right_bar_color) {
            additionalCss.push([
                {
                    selector: `${rating_right_bar_selector} .tutor-progress-bar`,
                    declaration: `background-color: ${props.review_right_bar_color};`,
                }
            ]);         
        }      
        if ('' !== props.review_right_bar_fill_color) {
            additionalCss.push([
                {
                    selector: `${rating_right_bar_selector} .tutor-ratings-progress-bar .tutor-progress-value`,
                    declaration: `background-color: ${props.review_right_bar_fill_color};`,
                }
            ]);         
        }

        //set styles end
        return additionalCss;
    }

    render() {
        if(!this.props.__reviews) {
            return '';
        }
       
        return (
            <Fragment>
                <div className='dtlms-course-reviews' dangerouslySetInnerHTML={{__html: this.props.__reviews}}></div>
            </Fragment>
        );
    }
}
export default CourseReviews;