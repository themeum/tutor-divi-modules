// External Dependencies
import React, { Component, Fragment } from 'react';

class CourseBenefits extends Component {

    static slug = 'tutor_course_benefits';

    render() {
        return (
            <Fragment>
                <div
                    dangerouslySetInnerHTML={{ __html: this.props.__benefits }} 
                />
            </Fragment>
        );
    }
}

export default CourseBenefits;