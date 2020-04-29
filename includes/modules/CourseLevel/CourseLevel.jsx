// External Dependencies
import React, { Component, Fragment } from 'react';

class CourseLevel extends Component {

    static slug = 'tutor_course_level';

    render() {
        return (
            <Fragment>
                <div 
                    className='tutor-course-level'
                    dangerouslySetInnerHTML={{ __html: this.props.__level }} 
                />
            </Fragment>
        );
    }
}

export default CourseLevel;