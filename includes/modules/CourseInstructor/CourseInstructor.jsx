
import React, {Component, Fragment} from 'react';
class CourseInstructor extends Component {

    static slug = 'tutor_course_instructor';

    static css(props) {
        const additionalCss = [];
        return additionalCss;
    }

    render(){
        if(!this.props.__instructor) {
            return '';
        }
        console.log(this.props.__instructor)
        return (
            <Fragment>
                <h4 class="tutor-segment-title"> LABEL </h4>

                <div class="tutor-course-instructors-wrap tutor-single-course-segment" id="single-course-ratings">

                        <div class="single-instructor-wrap">
                            <div class="single-instructor-top">
                                <div class="tutor-instructor-left">
                                    <div class="instructor-avatar">
                                        <a href="/">
                                        AVATAR
                                        </a>
                                    </div>

                                    <div class="instructor-name">
                                        <h3><a href="/"> INSTRUCTOR NAME </a> </h3>
                                        <h4> JOB TITLE </h4>
                                    </div>
                                </div>
                                <div class="instructor-bio">
                                    BIO
                                </div>
                            </div>

                            <div class="single-instructor-bottom">
                                <div class="ratings">
                                    <span class="rating-generated">
                                        RATING AVERAGE
                                    </span>

                            
                                    <span class='rating-digits'> RATING AVERAGE</span>
                                    <span class='rating-total-meta'> RATING COUNT </span>
                                </div>

                                <div class="courses">
                                    <p>
                                        <i class='tutor-icon-mortarboard'></i>
                                        <span class="tutor-text-mute"> COUNTED COURSE </span>
                                    </p>
                                </div>

                                <div class="students">
                                    <p>
                                        <i class='tutor-icon-user'></i>
                                        TOTAL STUDENT
                                        <span class="tutor-text-mute">  STUDENTS </span>
                                    </p>
                                </div>
                            </div>
                        </div>

                </div>
            </Fragment>
        );
    }
}

export default CourseInstructor;