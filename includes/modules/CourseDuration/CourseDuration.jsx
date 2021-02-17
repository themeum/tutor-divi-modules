// External Dependencies
import React, { Component, Fragment } from 'react';

class CourseDuration extends Component {

    static slug = 'tutor_course_duration';

    render() {
        return (
            <Fragment>
                <div className="tutor-single-course-meta-duration tutor-divi-course-duration">
                    <label> {this.props.duration_label} </label>
                    <span> {this.props.__duration} </span>
                </div>
            </Fragment>
        );
    }
}

export default CourseDuration;