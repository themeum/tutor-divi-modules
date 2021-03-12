
import React, {Component, Fragment} from 'react';

class CourseCurriculum extends Component {

    static slug = 'tutor_course_curriculum';

    topicTemplate(curriculums,collaps_icon,expand_icon) {
        const utils = window.ET_Builder.API.Utils;
        const ex_icon = utils.processFontIcon(expand_icon);
        const col_icon = utils.processFontIcon(collaps_icon);
        let topic = curriculums.map((curriculum)=>{
            return (
            <Fragment>
                <div className="tutor-course-title has-summery">
                    <h4> <span className="et-pb-icon"> {ex_icon}</span> <span className="et-pb-icon"> {col_icon}</span> { curriculum.topic.topic_details.post_title }</h4>
                </div>
                { this.curriculumTemplate(curriculum.topic.curriculums) }
            </Fragment>
            );
        }) 
        return topic;
    }

    curriculumTemplate(curriculums) {
        
        let c = curriculums.map((curriculum) => {
            let icon = curriculum.video_info ? 'tutor-icon-youtube' : 'tutor-icon-document-alt';
            if(curriculum.post_type === 'tutor_quiz') {
                icon = 'tutor-icon-doubt';
            } else if(curriculum.post_type === 'tutor_assignments') {
                icon = 'tutor-icon-clipboard';
            }   
            return(
                <div className="tutor-course-lessons">
                    <div className="tutor-course-lesson">
                        <h5>
                            <i className={ icon }></i>
                            <a href="/">{ curriculum.post_title }</a>
                            <span className="tutor-lesson-duration">
                                { curriculum.video_info ? curriculum.video_info.playtime : '' }
                            </span>
                        </h5>
                    </div>
                </div>
            );
        })
        return c;
    }

    render(){
        if(!this.props.__curriculum) {
            return ''
        }
       
        return (
            <Fragment>
                <div className="tutor-wrap">

                    <div className="course-enrolled-nav-wrap">
                        <nav className="course-enrolled-nav">
                            <ul>
                                <li className="active">
                                    <a href="/">Course Page</a>
                                </li>
                                <li className="">
                                    <a href="/">Q&A</a>
                                </li>
                                <li className="">
                                    <a href="/">Announcements</a>
                                </li>
                                <li className="">
                                    <a href="/">Gradebook</a>
                                </li>
                                <li className="">
                                    <a href="/">Resources</a>
                                </li>
                            </ul>
                        </nav>
                    </div>

                </div>

                <div className="tutor-single-course-segment  tutor-course-topics-wrap">

                    <div className="tutor-course-topics-header">
                        <div className="tutor-course-topics-header-left">
                            <h4 className="tutor-segment-title">
                                Topics for this course
                            </h4>
                        </div>
                        <div className="tutor-course-topics-header-right">
                            <span>1 Lessons</span>
                            <span>2h 27m 3s</span>
                        </div>
                    </div>

                    <div className="tutor-course-topics-contents">
                        <div className="tutor-course-topic tutor-topics-in-single-lesson tutor-active">
                            { this.topicTemplate( Array(this.props.__curriculum),this.props.collaps_icon, this.props.expand_icon) }
                        </div>
                    </div>

                </div>

            </Fragment>
        );
    }
}

export default CourseCurriculum;