// External Dependencies
import React, { Component, Fragment } from 'react';

class CourseAbout extends Component {

    static slug = 'tutor_course_about';

    render() {
        return (
            <Fragment>
                <div
                    dangerouslySetInnerHTML={{ __html: this.props.__about }} 
                />
            </Fragment>
        );
    }
}

export default CourseAbout;