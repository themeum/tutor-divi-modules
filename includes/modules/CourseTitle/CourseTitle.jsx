// External Dependencies
import React, { Component, Fragment } from 'react';

class CourseTitle extends Component {

    static slug = 'tutor_course_title';

    render() {
        const { header_level, __title } = this.props;
        const Header = `${header_level}`;
        return (
            <Fragment>
                <Header
                    className="dtlms-course-title tutor-course-details-title tutor-fs-4 tutor-fw-bold tutor-color-black tutor-mt-12 tutor-mb-0"
                    dangerouslySetInnerHTML={{ __html: __title }}
                />
            </Fragment>
        );
    }
}

export default CourseTitle;