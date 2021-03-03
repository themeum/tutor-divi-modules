// External Dependencies
import React, { Component, Fragment } from 'react';

class CourseRequirements extends Component {

    static slug = 'tutor_course_requirements';

    render() {
        return (
            <Fragment>
              	<div className="tutor-single-course-segment  tutor-course-requirements-wrap">
                    <div className="course-requirements-title">
                        <h4 className="tutor-segment-title">{ this.props.label }</h4>
                    </div>

                    <div className="tutor-course-requirements-content">
                        <ul className="tutor-course-requirements-items tutor-custom-list-style">
                            <li>List</li>
                        </ul>
                    </div>
                </div>
            </Fragment>
        );
    }
}

export default CourseRequirements;