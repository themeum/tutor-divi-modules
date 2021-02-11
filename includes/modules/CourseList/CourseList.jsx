
import React, {Component, Fragment} from 'react';

class CourseList extends Component {

    static slug = 'tutor_course_list';

    render(){
        return (
            <Fragment>
                <h1> {this.props.tutor_course_list_heading_new} </h1>
                <p> {this.props.content()} </p>
            </Fragment>
        );
    }
}

export default CourseList;