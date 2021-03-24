
import React, {Component, Fragment} from 'react';
class CourseInstructor extends Component {

    static slug = 'tutor_course_instructor';

    static css(props) {
        const additionalCss = [];
        return additionalCss;
    }

    starRatings(rating) {
        let generate_star = [];
        let avg_rating = Number(rating);
        let is_decimal = rating % 1;
        if(is_decimal) {
            //minus fractional value
            let without_decimal = avg_rating - is_decimal;
            for(let i=0; i < without_decimal; i++) {
                generate_star.push(<i className='tutor-icon-star-full'></i>);
            }
            generate_star.push(<i className='tutor-icon-star-half'></i>)
        } else {
            for(let i=0; i < avg_rating; i++) {
                generate_star.push(<i className='tutor-icon-star-full'></i>);
            } 
        }
        return generate_star;
    }

    instructorTemplate(instructors) {
        const instructor = instructors.map((instructor) => {
            return (
            <div class="single-instructor-wrap">
                <div class="single-instructor-top">
                    <div class="tutor-instructor-left">
                        <div class="instructor-avatar">
                            <a href="/" dangerouslySetInnerHTML={{__html: instructor.avatar}}>
                            
                            </a>
                        </div>
    
                        <div class="instructor-name">
                            <h3><a href="/"> { instructor.display_name } </a> </h3>
                            <h4>{ instructor.tutor_profile_job_title }</h4>
                        </div>
                    </div>
                    <div class="instructor-bio">
                        { instructor.tutor_profile_bio }
                    </div>
                </div>
    
                <div class="single-instructor-bottom">
                    <div class="ratings">
                        <span class="rating-generated">
                            { this.starRatings(instructor.ratings.rating_avg) }
                        </span>
    
                
                        <span class='rating-digits'> { instructor.ratings.rating_avg } </span>
                        <span class='rating-total-meta'> ({ instructor.ratings.rating_count } ratings) </span>
                    </div>
    
                    <div class="courses">
                        <p>
                            <i class='tutor-icon-mortarboard'></i>
                            <span class="tutor-text-mute"> { instructor.course_count } courses </span>
                        </p>
                    </div>
    
                    <div class="students">
                        <p>
                            <i class='tutor-icon-user'></i>
                            
                            <span class="tutor-text-mute">  { instructor.student_count } students </span>
                        </p>
                    </div>
                </div>
            </div>
            );
        });
        return instructor;
    }

    render(){
        if(!this.props.__instructor){
            return '';
        }
        console.log(this.props)
        return (
            <Fragment>
                <h4 class="tutor-segment-title"> LABEL </h4>

                <div class="tutor-course-instructors-wrap tutor-single-course-segment" id="single-course-ratings">
                    { this.instructorTemplate(this.props.__instructor) }
                </div>
            </Fragment>
        );
    }
}

export default CourseInstructor;