// External Dependencies
import React, { Component, Fragment } from 'react';

class CourseTotalEnroll extends Component {

    static slug = 'tutor_course_total_enroll';

    render() {
        return (
            <Fragment>
                <div
                    dangerouslySetInnerHTML={{ __html: this.props.__totalenroll }} 
                />
            </Fragment>
        );
    }
}

export default CourseTotalEnroll;