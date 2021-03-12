
import React, {Component, Fragment} from 'react';

class CourseCurriculum extends Component {

    static slug = 'tutor_course_curriculum';

    render(){
        if(!this.props.__curriculum) {
            return ''
        }
        console.log(this.props.__curriculum);
        return (
            <Fragment>

            </Fragment>
        );
    }
}

export default CourseCurriculum;