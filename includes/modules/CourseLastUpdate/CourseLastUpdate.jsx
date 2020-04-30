// External Dependencies
import React, { Component, Fragment } from 'react';

class CourseLastUpdate extends Component {

    static slug = 'tutor_course_last_update';

    render() {
        return (
            <Fragment>
                <div
                    dangerouslySetInnerHTML={{ __html: this.props.__lastupdate }} 
                />
            </Fragment>
        );
    }
}

export default CourseLastUpdate;