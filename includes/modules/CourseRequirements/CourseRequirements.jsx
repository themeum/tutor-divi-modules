// External Dependencies
import React, { Component, Fragment } from 'react';

class CourseRequirements extends Component {

    static slug = 'tutor_course_requirements';

    render() {
        return (
            <Fragment>
                <div
                    dangerouslySetInnerHTML={{ __html: this.props.__requirements }} 
                />
            </Fragment>
        );
    }
}

export default CourseRequirements;