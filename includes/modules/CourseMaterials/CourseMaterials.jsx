// External Dependencies
import React, { Component, Fragment } from 'react';

class CourseMaterials extends Component {

    static slug = 'tutor_course_materials';

    render() {
        const utils = window.ET_Builder.API.Utils;
        const icon = utils.processFontIcon(this.props.icon);
        return (
            <Fragment>
            <div className="tutor-single-course-segment  tutor-course-material-includes-wrap">
                <h4 className="tutor-segment-title"> Materials Includes </h4>
                <div className="tutor-course-target-audience-content">
                    <ul className="tutor-course-target-audience-items tutor-custom-list-style">

                    </ul>
                </div>
            </div>
            </Fragment>
        );
    }
}

export default CourseMaterials;