// External Dependencies
import React, { Component, Fragment } from 'react';

class CourseAuthor extends Component {

    static slug = 'tutor_course_author';

    render() {
        return (
            <Fragment>
                <div 
                    className='tutor-course-author'
                    dangerouslySetInnerHTML={{ __html: this.props.__author }} 
                />
            </Fragment>
        );
    }
}

export default CourseAuthor;