// External Dependencies
import React, { Component, Fragment } from 'react';

class CourseTotalEnroll extends Component {

    static slug = 'tutor_course_total_enroll';

    render() {
        return (
            <Fragment>
                <div className="tutor-single-course-meta-total-enroll">
                    <label> {this.props.enroll_label} </label>
                    <span> {this.props.__totalenroll} </span>
                </div>
            </Fragment>
        );
    }
}

export default CourseTotalEnroll;