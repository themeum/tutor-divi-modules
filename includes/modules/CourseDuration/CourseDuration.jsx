// External Dependencies
import React, { Component, Fragment } from 'react';

class CourseDuration extends Component {

    static slug = 'tutor_course_duration';

    render() {
        return (
            <Fragment>
                <div
                    dangerouslySetInnerHTML={{ __html: this.props.__duration }} 
                />
            </Fragment>
        );
    }
}

export default CourseDuration;