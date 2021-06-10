
import React, {Component, Fragment} from 'react';
class CourseInstructor extends Component {

    static slug = 'tutor_course_instructor';

    static css(props) {
        const additionalCss = [];

        //selector
        const wrapper                   = '%%order_class%% .single-instructor-wrap';
        const tutor_instructor_right    = `${wrapper} .tutor-instructor-right`;
        const avatar_selector           = '%%order_class%% .instructor-avatar a img, %%order_class%% .instructor-avatar a span';

        //props
        const layout            = props.layout;
        const image_size        = props.image_size;

        const star_size         = props.star_size;
        const star_color        = props.star_color;

        const space_between     = props.space_between;

        const section_background    = props.section_content_back;

        //set styles

        additionalCss.push([
            {
                selector: '%%order_class%% #single-course-ratings',
                declaration: 'display: flex; flex-direction: column;'
            }
        ]);

        additionalCss.push([
            {
                selector: '%%order_class%% .single-instructor-wrap',
                declaration: 'margin-bottom: 0px;'
            }
        ]);

        if('' !== space_between) {
            additionalCss.push([
                {
                    selector: '%%order_class%% #single-course-ratings',
                    declaration: `row-gap: ${space_between};`
                }
            ]);            
        }

        additionalCss.push([
            {
                selector: '%%order_class%% .single-instructor-wrap .instructor-name',
                declaration: 'padding-left: 0px;'
            }
        ]);

        additionalCss.push([
            {
                selector: tutor_instructor_right,
                declaration: `display: flex; flex-direction: ${layout}; gap: 10px 10px;`
            }
        ]);

        //avatar 
        if('' !== image_size) {
            additionalCss.push([
                {
                    selector: avatar_selector,
                    declaration: `width: ${image_size}; height: ${image_size}; max-width: ${image_size}; line-height: ${image_size};`
                }
            ]);            
        }

        //star 
        if('' !== star_color) {
            additionalCss.push([
                {
                    selector: '%%order_class%% .rating-generated .tutor-star-rating-group i',
                    declaration: `color: ${star_color} !important;`
                }
            ]);            
        }

        if('' !== star_size) {
            additionalCss.push([
                {
                    selector: '%%order_class%% .rating-generated .tutor-star-rating-group i',
                    declaration: `font-size: ${star_size} !important;`
                }
            ]);            
        }

        if('' !== section_background) {
            additionalCss.push([
                {
                    selector: '%%order_class%% .tutor-course-instructors-wrap .single-instructor-wrap',
                    declaration: `background-color: ${section_background};`
                }
            ]);
        }

        additionalCss.push([
            {
                selector: '%%order_class%% .single-instructor-wrap .instructor-name > h3',
				declaration: 'margin-bottom: 3px;'               
            }
        ]);
        //set styles end

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
    /**
     * 
     * @param {*} profile_picture 
     * @param {*} avatar 
     * @returns avatar template if display on
     */
    avatarTemplate(profile_picture,avatar) {
        if(profile_picture === 'on') {
            return (
                <div className="instructor-avatar">
                    <a href="/" dangerouslySetInnerHTML={{__html: avatar}}>

                    </a>
                </div>
            )
        }
    }

    /**
     * 
     * @param {*} display_name 
     * @param {*} name 
     * @returns name template if display on
     */
    nameTemplate(display_name, name) {
        if(display_name === 'on') {
            return <h3><a href="/"> { name } </a> </h3>;
        }
    }

    /**
     * 
     * @param {*} show_designation 
     * @param {*} designation 
     * @returns designation template if display on
     */
    designationTemplate(show_designation, designation) {
        if(show_designation === 'on') {
            return <h4>{ designation }</h4>;
        }
    }

    instructorTemplate(props, instructors) {
        const instructor = instructors.map((instructor) => {
            return (
            <div className="single-instructor-wrap">
                <div className="single-instructor-top">

                    <div className="tutor-instructor-left">
                        { this.avatarTemplate(props.profile_picture, instructor.avatar) }
                    </div>

                    <div className="tutor-instructor-right">
                        <div className="instructor-name">
                            { this.nameTemplate(props.display_name, instructor.display_name) }
                            { this.designationTemplate(props.designation, instructor.tutor_profile_job_title) }
                        </div>
                        <div className="instructor-bio" dangerouslySetInnerHTML={{__html: instructor.tutor_profile_bio }}>
                            
                        </div>
                    </div>

                </div>
    
                <div className="single-instructor-bottom">
                    <div className="ratings">
                        <span className="rating-generated">
                            <div className="tutor-star-rating-group">
                            { this.starRatings(instructor.ratings.rating_avg) }
                            </div> 
                        </span>
    
                
                        <span className='rating-digits'> { instructor.ratings.rating_avg } </span>
                        <span className='rating-total-meta'> ({ instructor.ratings.rating_count } ratings) </span>
                    </div>
    
                    <div className="courses">
                        <p>
                            <i className='tutor-icon-mortarboard'></i>
                            <span className="tutor-text-mute"> { instructor.course_count } courses </span>
                        </p>
                    </div>
    
                    <div className="students">
                        <p>
                            <i className='tutor-icon-user'></i>
                            <span className="tutor-text-mute">  { instructor.student_count } students </span>
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
       
        return (
            <Fragment>
                <h4 className="tutor-segment-title"> { this.props.label } </h4>
                <div className="tutor-course-instructors-wrap tutor-single-course-segment" id="single-course-ratings">
                    { this.instructorTemplate(this.props, this.props.__instructor) }
                </div>
            </Fragment>
        );
    }
}

export default CourseInstructor;