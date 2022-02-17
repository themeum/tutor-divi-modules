import React, { Component, Fragment } from 'react';

class CourseReviews extends Component {

    static slug = "tutor-course-reviews";

    static css(props) {
        const additionalCss = [];   
        if ('' !== props.review_right_star) {
            additionalCss.push([
                {
                    selector: `%%order_class%% .tutor-ratingsreviews-ratings-all .tutor-rating-stars span`,
                    declaration: `color: ${props.review_right_star};`,
                }
            ]);         
        }      
        if ('' !== props.review_right_bar_height) {
            additionalCss.push([
                {
                    selector: `%%order_class%% .tutor-ratingsreviews-ratings-all .progress-bar`,
                    declaration: `height: ${props.review_right_bar_height};`,
                }
            ]);         
        }      
        if ('' !== props.review_right_bar_color) {
            additionalCss.push([
                {
                    selector: `%%order_class%% .tutor-ratingsreviews-ratings-all .progress-bar`,
                    declaration: `background-color: ${props.review_right_bar_color};`,
                }
            ]);         
        }      
        if ('' !== props.review_right_bar_fill_color) {
            additionalCss.push([
                {
                    selector: `%%order_class%% .tutor-ratingsreviews-ratings-all .progress-value`,
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