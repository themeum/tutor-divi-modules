
import React, {Component, Fragment} from 'react';

class CourseCarousel extends Component {

    static slug = 'tutor_course_carousel';

    render(){
        return (
            <Fragment>
                <h1> {this.props.tutor_course_carousel_heading} </h1>
                <p> {this.props.content()} </p>
            </Fragment>
        );
    }
}

export default CourseCarousel;