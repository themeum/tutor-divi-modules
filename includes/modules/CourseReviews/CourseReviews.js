import React, { Component, Fragment } from 'react';

class CourseReviews extends Component {

    static slug = "tutor-course-reviews";

    static css(props) {
        const additionalCss = [];

        return additionalCss;
    }

    render() {
        if(!this.props.__reviews) {
            return '';
        }
        console.log(this.props);
        return (
            <Fragment>
                <h1>Course reviews</h1>
            </Fragment>
        );
    }
}
export default CourseReviews;