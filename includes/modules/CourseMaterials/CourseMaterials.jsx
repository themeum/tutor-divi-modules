// External Dependencies
import React, { Component, Fragment } from 'react';

class CourseMaterials extends Component {

    static slug = 'tutor_course_materials';

    render() {
        return (
            <Fragment>
                <div
                    dangerouslySetInnerHTML={{ __html: this.props.__materials }} 
                />
            </Fragment>
        );
    }
}

export default CourseMaterials;