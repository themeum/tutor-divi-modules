// External Dependencies
import React, { Component, Fragment } from 'react';

class CourseTargetAudience extends Component {

    static slug = 'tutor_course_target_audience';

    render() {
        return (
            <Fragment>
                <div
                    dangerouslySetInnerHTML={{ __html: this.props.__target_audience }} 
                />
            </Fragment>
        );
    }
}

export default CourseTargetAudience;