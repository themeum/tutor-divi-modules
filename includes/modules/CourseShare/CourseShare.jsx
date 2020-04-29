// External Dependencies
import React, { Component, Fragment } from 'react';

class CourseShare extends Component {

    static slug = 'tutor_course_share';

    render() {
        return (
            <Fragment>
                <div
                    dangerouslySetInnerHTML={{ __html: this.props.__share }} 
                />
            </Fragment>
        );
    }
}

export default CourseShare;