// External Dependencies
import React, { Component, Fragment } from 'react';

class CourseLevel extends Component {

    static slug = 'tutor_course_level';
    
    template (props) {
        if(!props.__level.is_disable_level) {
            return (
                <div className="tutor-single-course-meta tutor-meta-top">
                <ul>
                    <li className="tutor-course-level">
                        <label> { props.course_level_label } </label>
                        <span>
                            { props.__level.level }
                        </span>
                    </li>
                </ul>
            </div>                
            );
        } else {
            return(
            <div className="">
                Course level is disabled
            </div>                
            );
        }
    }

    render() {
        if( !this.props.__level) {
            return '';
        }
        return (
            <Fragment>
                { this.template(this.props) }
            </Fragment>
        );
    }
}

export default CourseLevel;