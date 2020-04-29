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
                    className="dtlms-course-title"
                    dangerouslySetInnerHTML={{ __html: __title }}
                />
            </Fragment>
        );
    }
}

export default CourseTitle;